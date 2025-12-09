<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Agama;
use App\Models\Golongan;
use App\Models\Eselon;
use App\Models\Jabatan;
use App\Models\UnitKerja;
use App\Models\Tempat;
use App\Models\User;
use Illuminate\Support\Facades\Hash;


class MasterDataSeeder extends Seeder
{
    
    public function run()
    {
        // Disable FK checks so we can truncate
        \Illuminate\Support\Facades\DB::statement('SET FOREIGN_KEY_CHECKS=0;');

        Tempat::truncate();
        Jabatan::truncate();
        UnitKerja::truncate();
        Agama::truncate();
        Golongan::truncate();
        Eselon::truncate();

        // Re-enable FK checks
        \Illuminate\Support\Facades\DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        // Tempat
        $tempat = ['Jakarta', 'Bandung', 'Surabaya', 'Medan', 'Semarang', 'Makassar', 'Palembang', 'Yogyakarta', 'Malang', 'Denpasar'];
        foreach ($tempat as $t) {
            Tempat::create(['nama_tempat' => $t]);
        }

        // Jabatan
        $jabatan = [
            'Kepala Sekretariat Utama', 
            'Kepala Biro', 
            'Kepala Bagian', 
            'Kepala Sub Bagian', 
            'Staff Pelaksana', 
            'Analis', 
            'Surveyor',
            'Kepala Seksi',
            'Peneliti'
        ];
        foreach ($jabatan as $j) {
            Jabatan::create(['nama_jabatan' => $j]);
        }

        // Unit Kerja
        $units = [
            ['UMUM', 'Bagian Umum'],
            ['KEU', 'Bagian Keuangan'],
            ['SDM', 'Bagian SDM'],
            ['HUMAS', 'Bagian Humas'],
            ['IT', 'Bagian IT'],
            ['LEGAL', 'Bagian Hukum']
        ];
        foreach ($units as $u) {
            UnitKerja::create(['kode_unit' => $u[0], 'nama_unit' => $u[1]]);
        }

        // Agama
        $agama = ['Islam', 'Kristen', 'Katolik', 'Hindu', 'Buddha', 'Konghucu'];
        foreach ($agama as $a) {
            Agama::create(['nama_agama' => $a]);
        }

        // Golongan
        $golongan = [
            ['I/a', 'Golongan I/a'], ['I/b', 'Golongan I/b'], ['I/c', 'Golongan I/c'], ['I/d', 'Golongan I/d'],
            ['II/a', 'Golongan II/a'], ['II/b', 'Golongan II/b'], ['II/c', 'Golongan II/c'], ['II/d', 'Golongan II/d'],
            ['III/a', 'Golongan III/a'], ['III/b', 'Golongan III/b'], ['III/c', 'Golongan III/c'], ['III/d', 'Golongan III/d'],
            ['IV/a', 'Golongan IV/a'], ['IV/b', 'Golongan IV/b'], ['IV/c', 'Golongan IV/c'], ['IV/d', 'Golongan IV/d'], ['IV/e', 'Golongan IV/e']
        ];
        foreach ($golongan as $g) {
            Golongan::create(['kode_golongan' => $g[0], 'nama_golongan' => $g[1]]);
        }

        // Eselon
        for ($i = 1; $i <= 5; $i++) {
            Eselon::create(['kode_eselon' => "Eselon $i", 'nama_eselon' => "Eselon $i"]);
        }

        // Admin user
        if (!User::where('username', 'admin')->exists()) {
            User::create([
                'username' => 'admin',
                'password' => Hash::make('password'),
                'email' => 'admin@pns.go.id',
                'nama_lengkap' => 'Administrator',
                'role' => 'admin'
            ]);
        }
    }

}