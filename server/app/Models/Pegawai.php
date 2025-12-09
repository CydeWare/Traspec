<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pegawai extends Model
{
    protected $table = 'pegawai';
    
    protected $fillable = [
        'nip', 'nama', 'tempat_lahir_id', 'tanggal_lahir', 
        'jenis_kelamin', 'alamat', 'tempat_tugas_id', 'agama_id', 'foto'
    ];

    protected $casts = [
        'tanggal_lahir' => 'date'
    ];

    public function tempatLahir()
    {
        return $this->belongsTo(Tempat::class, 'tempat_lahir_id');
    }

    public function tempatTugas()
    {
        return $this->belongsTo(Tempat::class, 'tempat_tugas_id');
    }

    public function agama()
    {
        return $this->belongsTo(Agama::class);
    }

    public function detailKepegawaian()
    {
        return $this->hasOne(DetailKepegawaian::class);
    }
}