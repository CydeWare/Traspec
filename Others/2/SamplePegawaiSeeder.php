<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Pegawai;
use App\Models\DetailPegawaian;
use App\Models\Agama;
use App\Models\Golongan;
use App\Models\Eselon;
use App\Models\Jabatan;
use App\Models\UnitKerja;
use App\Models\Tempat;

class SamplePegawaiSeeder extends Seeder
{
    public function run()
    {
        // Make sure master data exists
        if (Tempat::count() == 0 || Agama::count() == 0) {
            echo "❌ Master data not found. Run MasterDataSeeder first.\n";
            return;
        }

        // Fetch master data
        $jakarta = Tempat::where('nama_tempat', 'Jakarta')->first();
        $islam = Agama::where('nama_agama', 'Islam')->first();
        $golongan3c = Golongan::where('kode_golongan', 'III/c')->first();
        $golongan4a = Golongan::where('kode_golongan', 'IV/a')->first();
        $eselon4 = Eselon::where('kode_eselon', 'Eselon 4')->first();
        $jabatanKepala = Jabatan::where('nama_jabatan', 'Kepala Seksi')->first();
        $jabatanStaff = Jabatan::where('nama_jabatan', 'Staff Pelaksana')->first();
        $unitUmum = UnitKerja::where('kode_unit', 'UMUM')->first();
        $unitKeu = UnitKerja::where('kode_unit', 'KEU')->first();

        // ---------- SAMPLE PEGAWAI 1 ----------
        $pegawai1 = Pegawai::firstOrCreate(
            ['nip' => '121305690001'],
            [
                'nama' => 'Saifulloh Rifai',
                'tempat_lahir_id' => $jakarta->id,
                'tanggal_lahir' => '1968-03-15',
                'jenis_kelamin' => 'L',
                'alamat' => 'Jl. Melon No.16 Dian Asri, Banjarnegara',
                'tempat_tugas_id' => $jakarta->id,
                'agama_id' => $islam->id,
            ]
        );

        DetailPegawaian::firstOrCreate(
            ['pegawai_id' => $pegawai1->id],
            [
                'golongan_id' => $golongan4a->id,
                'eselon_id' => $eselon4->id,
                'jabatan_id' => $jabatanKepala->id,
                'unit_kerja_id' => $unitUmum->id,
                'no_hp' => '081234567890',
                'npwp' => '123456789012345',
            ]
        );

        echo "✓ Pegawai 1 OK\n";

        // ---------- SAMPLE PEGAWAI 2 ----------
        $pegawai2 = Pegawai::firstOrCreate(
            ['nip' => '198708071234'],
            [
                'nama' => 'Ahmad Hidayat',
                'tempat_lahir_id' => $jakarta->id,
                'tanggal_lahir' => '1987-08-07',
                'jenis_kelamin' => 'L',
                'alamat' => 'Jl. Golf Komp Bakosurtanal No.39',
                'tempat_tugas_id' => $jakarta->id,
                'agama_id' => $islam->id,
            ]
        );

        DetailPegawaian::firstOrCreate(
            ['pegawai_id' => $pegawai2->id],
            [
                'golongan_id' => $golongan3c->id,
                'eselon_id' => null,
                'jabatan_id' => $jabatanStaff->id,
                'unit_kerja_id' => $unitKeu->id,
                'no_hp' => '081298765432',
                'npwp' => '987654321098765',
            ]
        );

        echo "✓ Pegawai 2 OK\n";

        // ---------- SAMPLE PEGAWAI 3 ----------
        $pegawai3 = Pegawai::firstOrCreate(
            ['nip' => '198705031234'],
            [
                'nama' => 'Siti Nurhaliza',
                'tempat_lahir_id' => $jakarta->id,
                'tanggal_lahir' => '1987-05-03',
                'jenis_kelamin' => 'P',
                'alamat' => 'Perum Jombor Baru',
                'tempat_tugas_id' => $jakarta->id,
                'agama_id' => $islam->id,
            ]
        );

        DetailPegawaian::firstOrCreate(
            ['pegawai_id' => $pegawai3->id],
            [
                'golongan_id' => $golongan3c->id,
                'eselon_id' => null,
                'jabatan_id' => $jabatanStaff->id,
                'unit_kerja_id' => $unitUmum->id,
                'no_hp' => '081345678901',
                'npwp' => '456789012345678',
            ]
        );

        echo "✓ Pegawai 3 OK\n";

        // ---------- SAMPLE PEGAWAI 4 ----------
        $pegawai4 = Pegawai::firstOrCreate(
            ['nip' => '197408291234'],
            [
                'nama' => 'Budi Santoso',
                'tempat_lahir_id' => $jakarta->id,
                'tanggal_lahir' => '1974-08-29',
                'jenis_kelamin' => 'L',
                'alamat' => 'Kp. Kandang',
                'tempat_tugas_id' => $jakarta->id,
                'agama_id' => $islam->id,
            ]
        );

        DetailPegawaian::firstOrCreate(
            ['pegawai_id' => $pegawai4->id],
            [
                'golongan_id' => $golongan3c->id,
                'eselon_id' => null,
                'jabatan_id' => $jabatanStaff->id,
                'unit_kerja_id' => $unitKeu->id,
                'no_hp' => '081456789012',
                'npwp' => '789012345678901',
            ]
        );

        echo "✓ Pegawai 4 OK\n";

        // ---------- SAMPLE PEGAWAI 5 ----------
        $pegawai5 = Pegawai::firstOrCreate(
            ['nip' => '196611071234'],
            [
                'nama' => 'Dewi Lestari',
                'tempat_lahir_id' => $jakarta->id,
                'tanggal_lahir' => '1966-11-07',
                'jenis_kelamin' => 'P',
                'alamat' => 'Cigadung Selatan II/135',
                'tempat_tugas_id' => $jakarta->id,
                'agama_id' => $islam->id,
            ]
        );

        DetailPegawaian::firstOrCreate(
            ['pegawai_id' => $pegawai5->id],
            [
                'golongan_id' => $golongan4a->id,
                'eselon_id' => $eselon4->id,
                'jabatan_id' => $jabatanKepala->id,
                'unit_kerja_id' => $unitUmum->id,
                'no_hp' => '081567890123',
                'npwp' => '234567890123456',
            ]
        );

        echo "✓ Pegawai 5 OK\n";

        echo "\nDone. Total pegawai now: " . Pegawai::count() . "\n";
    }
}
