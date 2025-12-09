<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Pegawai;
use App\Models\DetailKepegawaian;
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
        // Make sure we have master data first
        if (Tempat::count() == 0 || Agama::count() == 0) {
            echo "❌ Master data not found. Please run MasterDataSeeder first.\n";
            return;
        }

        // Clear existing pegawai data (optional - remove if you want to keep existing)
        echo "🗑️  Clearing existing pegawai data...\n";
        \DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        DetailKepegawaian::truncate();
        Pegawai::truncate();
        \DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        // Get master data IDs
        $jakarta = Tempat::where('nama_tempat', 'Jakarta')->first();
        $bandung = Tempat::where('nama_tempat', 'Bandung')->first();
        $surabaya = Tempat::where('nama_tempat', 'Surabaya')->first();
        
        $islam = Agama::where('nama_agama', 'Islam')->first();
        $kristen = Agama::where('nama_agama', 'Kristen')->first();
        
        $golongan3c = Golongan::where('kode_golongan', 'III/c')->first();
        $golongan4a = Golongan::where('kode_golongan', 'IV/a')->first();
        $golongan3b = Golongan::where('kode_golongan', 'III/b')->first();
        
        $eselon4 = Eselon::where('kode_eselon', 'Eselon 4')->first();
        $eselon3 = Eselon::where('kode_eselon', 'Eselon 3')->first();
        
        $jabatanKepala = Jabatan::where('nama_jabatan', 'Kepala Seksi')->first();
        $jabatanStaff = Jabatan::where('nama_jabatan', 'Staff Pelaksana')->first();
        $jabatanAnalis = Jabatan::where('nama_jabatan', 'Analis')->first();
        
        $unitUmum = UnitKerja::where('kode_unit', 'UMUM')->first();
        $unitKeu = UnitKerja::where('kode_unit', 'KEU')->first();
        $unitSDM = UnitKerja::where('kode_unit', 'SDM')->first();

        // Sample Pegawai 1
        $pegawai1 = Pegawai::create([
            'nip' => '196803151234567',
            'nama' => 'Saifulloh Rifai',
            'tempat_lahir_id' => $bandung->id ?? $jakarta->id,
            'tanggal_lahir' => '1968-03-15',
            'jenis_kelamin' => 'L',
            'alamat' => 'Jl. Melon No.16 Dian Asri, Banjarnegara',
            'tempat_tugas_id' => $jakarta->id,
            'agama_id' => $islam->id,
        ]);

        DetailKepegawaian::create([
            'pegawai_id' => $pegawai1->id,
            'golongan_id' => $golongan4a->id,
            'eselon_id' => $eselon4->id ?? null,
            'jabatan_id' => $jabatanKepala->id,
            'unit_kerja_id' => $unitUmum->id,
            'no_hp' => '081234567890',
            'npwp' => '123456789012345',
        ]);

        echo "✓ Pegawai 1 created: Saifulloh Rifai (NIP: 196803151234567)\n";

        // Sample Pegawai 2
        $pegawai2 = Pegawai::create([
            'nip' => '198708071234568',
            'nama' => 'Ahmad Hidayat',
            'tempat_lahir_id' => $jakarta->id,
            'tanggal_lahir' => '1987-08-07',
            'jenis_kelamin' => 'L',
            'alamat' => 'Jl. Golf Komp Bakosurtanal No.39',
            'tempat_tugas_id' => $jakarta->id,
            'agama_id' => $islam->id,
        ]);

        DetailKepegawaian::create([
            'pegawai_id' => $pegawai2->id,
            'golongan_id' => $golongan3c->id,
            'eselon_id' => null,
            'jabatan_id' => $jabatanStaff->id ?? $jabatanKepala->id,
            'unit_kerja_id' => $unitKeu->id ?? $unitUmum->id,
            'no_hp' => '081298765432',
            'npwp' => '987654321098765',
        ]);

        echo "✓ Pegawai 2 created: Ahmad Hidayat (NIP: 198708071234568)\n";

        // Sample Pegawai 3
        $pegawai3 = Pegawai::create([
            'nip' => '198705031234569',
            'nama' => 'Siti Nurhaliza',
            'tempat_lahir_id' => $surabaya->id ?? $jakarta->id,
            'tanggal_lahir' => '1987-05-03',
            'jenis_kelamin' => 'P',
            'alamat' => 'Perum Jombor Baru',
            'tempat_tugas_id' => $jakarta->id,
            'agama_id' => $islam->id,
        ]);

        DetailKepegawaian::create([
            'pegawai_id' => $pegawai3->id,
            'golongan_id' => $golongan3c->id,
            'eselon_id' => null,
            'jabatan_id' => $jabatanAnalis->id ?? $jabatanStaff->id ?? $jabatanKepala->id,
            'unit_kerja_id' => $unitSDM->id ?? $unitUmum->id,
            'no_hp' => '081345678901',
            'npwp' => '456789012345678',
        ]);

        echo "✓ Pegawai 3 created: Siti Nurhaliza (NIP: 198705031234569)\n";

        // Sample Pegawai 4
        $pegawai4 = Pegawai::create([
            'nip' => '197408291234570',
            'nama' => 'Budi Santoso',
            'tempat_lahir_id' => $jakarta->id,
            'tanggal_lahir' => '1974-08-29',
            'jenis_kelamin' => 'L',
            'alamat' => 'Kp. Kandang',
            'tempat_tugas_id' => $jakarta->id,
            'agama_id' => $islam->id,
        ]);

        DetailKepegawaian::create([
            'pegawai_id' => $pegawai4->id,
            'golongan_id' => $golongan3b->id ?? $golongan3c->id,
            'eselon_id' => null,
            'jabatan_id' => $jabatanStaff->id ?? $jabatanKepala->id,
            'unit_kerja_id' => $unitKeu->id ?? $unitUmum->id,
            'no_hp' => '081456789012',
            'npwp' => '789012345678901',
        ]);

        echo "✓ Pegawai 4 created: Budi Santoso (NIP: 197408291234570)\n";

        // Sample Pegawai 5
        $pegawai5 = Pegawai::create([
            'nip' => '196611071234571',
            'nama' => 'Dewi Lestari',
            'tempat_lahir_id' => $bandung->id ?? $jakarta->id,
            'tanggal_lahir' => '1966-11-07',
            'jenis_kelamin' => 'P',
            'alamat' => 'Cigadung Selatan II/135',
            'tempat_tugas_id' => $jakarta->id,
            'agama_id' => $kristen->id ?? $islam->id,
        ]);

        DetailKepegawaian::create([
            'pegawai_id' => $pegawai5->id,
            'golongan_id' => $golongan4a->id,
            'eselon_id' => $eselon3->id ?? $eselon4->id ?? null,
            'jabatan_id' => $jabatanKepala->id,
            'unit_kerja_id' => $unitUmum->id,
            'no_hp' => '081567890123',
            'npwp' => '234567890123456',
        ]);

        echo "✓ Pegawai 5 created: Dewi Lestari (NIP: 196611071234571)\n";

        // Sample Pegawai 6
        $pegawai6 = Pegawai::create([
            'nip' => '198012151234572',
            'nama' => 'Eko Prasetyo',
            'tempat_lahir_id' => $jakarta->id,
            'tanggal_lahir' => '1980-12-15',
            'jenis_kelamin' => 'L',
            'alamat' => 'Jl. Raya Tegar Beriman Gg H Jairan No 116',
            'tempat_tugas_id' => $jakarta->id,
            'agama_id' => $islam->id,
        ]);

        DetailKepegawaian::create([
            'pegawai_id' => $pegawai6->id,
            'golongan_id' => $golongan3c->id,
            'eselon_id' => null,
            'jabatan_id' => $jabatanAnalis->id ?? $jabatanStaff->id ?? $jabatanKepala->id,
            'unit_kerja_id' => $unitKeu->id ?? $unitUmum->id,
            'no_hp' => '081678901234',
            'npwp' => '567890123456789',
        ]);

        echo "✓ Pegawai 6 created: Eko Prasetyo (NIP: 198012151234572)\n";

        echo "\n✅ Total Pegawai created: " . Pegawai::count() . "\n";
        echo "✅ Seeding completed successfully!\n";
    }
}