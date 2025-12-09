<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Eselon extends Model
{
    protected $table = 'eselon';
    protected $fillable = ['kode_eselon', 'nama_eselon'];
}