<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pegawai;
use App\Models\DetailKepegawaian;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class PegawaiController extends Controller
{
    public function index(Request $request)
    {
        $query = Pegawai::with([
            'tempatLahir',
            'tempatTugas',
            'agama',
            'detailKepegawaian.golongan',
            'detailKepegawaian.eselon',
            'detailKepegawaian.jabatan',
            'detailKepegawaian.unitKerja'
        ]);

        // Filter by unit kerja
        if ($request->has('unit_kerja_id')) {
            $query->whereHas('detailKepegawaian', function($q) use ($request) {
                $q->where('unit_kerja_id', $request->unit_kerja_id);
            });
        }

        // Search
        if ($request->has('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('nip', 'like', "%{$search}%")
                  ->orWhere('nama', 'like', "%{$search}%");
            });
        }

        $perPage = $request->get('per_page', 10);
        $pegawai = $query->paginate($perPage);

        return response()->json($pegawai);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nip' => 'required|unique:pegawai|max:18',
            'nama' => 'required|max:100',
            'tempat_lahir_id' => 'nullable|exists:tempat,id',
            'tanggal_lahir' => 'required|date',
            'jenis_kelamin' => 'required|in:L,P',
            'alamat' => 'required',
            'tempat_tugas_id' => 'nullable|exists:tempat,id',
            'agama_id' => 'required|exists:agama,id',
            'foto' => 'nullable|image|max:2048',
            'golongan_id' => 'required|exists:golongan,id',
            'eselon_id' => 'nullable|exists:eselon,id',
            'jabatan_id' => 'required|exists:jabatan,id',
            'unit_kerja_id' => 'required|exists:unit_kerja,id',
            'no_hp' => 'nullable|max:15',
            'npwp' => 'nullable|max:20'
        ]);

        DB::beginTransaction();
        try {
            $pegawaiData = [
                'nip' => $validated['nip'],
                'nama' => $validated['nama'],
                'tempat_lahir_id' => $validated['tempat_lahir_id'] ?? null,
                'tanggal_lahir' => $validated['tanggal_lahir'],
                'jenis_kelamin' => $validated['jenis_kelamin'],
                'alamat' => $validated['alamat'],
                'tempat_tugas_id' => $validated['tempat_tugas_id'] ?? null,
                'agama_id' => $validated['agama_id']
            ];

            if ($request->hasFile('foto')) {
                $path = $request->file('foto')->store('pegawai', 'public');
                $pegawaiData['foto'] = $path;
            }

            $pegawai = Pegawai::create($pegawaiData);

            DetailKepegawaian::create([
                'pegawai_id' => $pegawai->id,
                'golongan_id' => $validated['golongan_id'],
                'eselon_id' => $validated['eselon_id'] ?? null,
                'jabatan_id' => $validated['jabatan_id'],
                'unit_kerja_id' => $validated['unit_kerja_id'],
                'no_hp' => $validated['no_hp'] ?? null,
                'npwp' => $validated['npwp'] ?? null
            ]);

            DB::commit();
            return response()->json([
                'success' => true,
                'message' => 'Data pegawai berhasil ditambahkan',
                'data' => $pegawai->load('detailKepegawaian')
            ], 201);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => 'Gagal menambahkan data pegawai: ' . $e->getMessage()
            ], 500);
        }
    }

    public function show($id)
    {
        $pegawai = Pegawai::with([
            'tempatLahir',
            'tempatTugas',
            'agama',
            'detailKepegawaian.golongan',
            'detailKepegawaian.eselon',
            'detailKepegawaian.jabatan',
            'detailKepegawaian.unitKerja'
        ])->findOrFail($id);

        return response()->json($pegawai);
    }

    public function update(Request $request, $id)
    {
        $pegawai = Pegawai::findOrFail($id);
        
        $validated = $request->validate([
            'nip' => 'required|max:18|unique:pegawai,nip,' . $id,
            'nama' => 'required|max:100',
            'tempat_lahir_id' => 'nullable|exists:tempat,id',
            'tanggal_lahir' => 'required|date',
            'jenis_kelamin' => 'required|in:L,P',
            'alamat' => 'required',
            'tempat_tugas_id' => 'nullable|exists:tempat,id',
            'agama_id' => 'required|exists:agama,id',
            'foto' => 'nullable|image|max:2048',
            'golongan_id' => 'required|exists:golongan,id',
            'eselon_id' => 'nullable|exists:eselon,id',
            'jabatan_id' => 'required|exists:jabatan,id',
            'unit_kerja_id' => 'required|exists:unit_kerja,id',
            'no_hp' => 'nullable|max:15',
            'npwp' => 'nullable|max:20'
        ]);

        DB::beginTransaction();
        try {
            $pegawaiData = [
                'nip' => $validated['nip'],
                'nama' => $validated['nama'],
                'tempat_lahir_id' => $validated['tempat_lahir_id'] ?? null,
                'tanggal_lahir' => $validated['tanggal_lahir'],
                'jenis_kelamin' => $validated['jenis_kelamin'],
                'alamat' => $validated['alamat'],
                'tempat_tugas_id' => $validated['tempat_tugas_id'] ?? null,
                'agama_id' => $validated['agama_id']
            ];

            if ($request->hasFile('foto')) {
                if ($pegawai->foto) {
                    Storage::disk('public')->delete($pegawai->foto);
                }
                $path = $request->file('foto')->store('pegawai', 'public');
                $pegawaiData['foto'] = $path;
            }

            $pegawai->update($pegawaiData);

            $pegawai->detailKepegawaian()->updateOrCreate(
                ['pegawai_id' => $pegawai->id],
                [
                    'golongan_id' => $validated['golongan_id'],
                    'eselon_id' => $validated['eselon_id'] ?? null,
                    'jabatan_id' => $validated['jabatan_id'],
                    'unit_kerja_id' => $validated['unit_kerja_id'],
                    'no_hp' => $validated['no_hp'] ?? null,
                    'npwp' => $validated['npwp'] ?? null
                ]
            );

            DB::commit();
            return response()->json([
                'success' => true,
                'message' => 'Data pegawai berhasil diupdate',
                'data' => $pegawai->load('detailKepegawaian')
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => 'Gagal mengupdate data pegawai: ' . $e->getMessage()
            ], 500);
        }
    }

    public function destroy($id)
    {
        try {
            $pegawai = Pegawai::findOrFail($id);
            
            if ($pegawai->foto) {
                Storage::disk('public')->delete($pegawai->foto);
            }
            
            $pegawai->delete();
            
            return response()->json([
                'success' => true,
                'message' => 'Data pegawai berhasil dihapus'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal menghapus data pegawai: ' . $e->getMessage()
            ], 500);
        }
    }
}