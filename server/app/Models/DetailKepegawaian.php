<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DetailKepegawaian extends Model
{
    protected $table = 'detail_kepegawaian';
    
    protected $fillable = [
        'pegawai_id', 'golongan_id', 'eselon_id', 
        'jabatan_id', 'unit_kerja_id', 'no_hp', 'npwp'
    ];

    public function pegawai()
    {
        return $this->belongsTo(Pegawai::class);
    }

    public function golongan()
    {
        return $this->belongsTo(Golongan::class);
    }

    public function eselon()
    {
        return $this->belongsTo(Eselon::class);
    }

    public function jabatan()
    {
        return $this->belongsTo(Jabatan::class);
    }

    public function unitKerja()
    {
        return $this->belongsTo(UnitKerja::class);
    }
}