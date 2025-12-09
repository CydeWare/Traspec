<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        // Tabel Agama
        Schema::create('agama', function (Blueprint $table) {
            $table->id();
            $table->string('nama_agama', 20);
            $table->timestamps();
        });

        // Tabel Golongan
        Schema::create('golongan', function (Blueprint $table) {
            $table->id();
            $table->string('kode_golongan', 10)->unique();
            $table->string('nama_golongan', 50);
            $table->timestamps();
        });

        // Tabel Eselon
        Schema::create('eselon', function (Blueprint $table) {
            $table->id();
            $table->string('kode_eselon', 10)->unique();
            $table->string('nama_eselon', 50);
            $table->timestamps();
        });

        // Tabel Jabatan
        Schema::create('jabatan', function (Blueprint $table) {
            $table->id();
            $table->string('nama_jabatan', 100);
            $table->timestamps();
        });

        // Tabel Unit Kerja
        Schema::create('unit_kerja', function (Blueprint $table) {
            $table->id();
            $table->string('kode_unit', 10)->unique();
            $table->string('nama_unit', 100);
            $table->timestamps();
        });

        // Tabel Tempat
        Schema::create('tempat', function (Blueprint $table) {
            $table->id();
            $table->string('nama_tempat', 100);
            $table->timestamps();
        });

        // Tabel Pegawai
        Schema::create('pegawai', function (Blueprint $table) {
            $table->id();
            $table->string('nip', 18)->unique();
            $table->string('nama', 100);
            $table->foreignId('tempat_lahir_id')->nullable()->constrained('tempat')->onDelete('set null');
            $table->date('tanggal_lahir');
            $table->enum('jenis_kelamin', ['L', 'P']);
            $table->text('alamat');
            $table->foreignId('tempat_tugas_id')->nullable()->constrained('tempat')->onDelete('set null');
            $table->foreignId('agama_id')->constrained('agama')->onDelete('restrict');
            $table->string('foto', 255)->nullable();
            $table->timestamps();
        });

        // Tabel Detail Kepegawaian
        Schema::create('detail_kepegawaian', function (Blueprint $table) {
            $table->id();
            $table->foreignId('pegawai_id')->unique()->constrained('pegawai')->onDelete('cascade');
            $table->foreignId('golongan_id')->constrained('golongan')->onDelete('restrict');
            $table->foreignId('eselon_id')->nullable()->constrained('eselon')->onDelete('set null');
            $table->foreignId('jabatan_id')->constrained('jabatan')->onDelete('restrict');
            $table->foreignId('unit_kerja_id')->constrained('unit_kerja')->onDelete('restrict');
            $table->string('no_hp', 15)->nullable();
            $table->string('npwp', 20)->nullable();
            $table->timestamps();
        });

        // Tabel Users
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('username', 50)->unique();
            $table->string('password');
            $table->string('email', 100)->unique();
            $table->string('nama_lengkap', 100);
            $table->enum('role', ['admin', 'user'])->default('user');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('detail_kepegawaian');
        Schema::dropIfExists('pegawai');
        Schema::dropIfExists('tempat');
        Schema::dropIfExists('unit_kerja');
        Schema::dropIfExists('jabatan');
        Schema::dropIfExists('eselon');
        Schema::dropIfExists('golongan');
        Schema::dropIfExists('agama');
        Schema::dropIfExists('users');
    }
};