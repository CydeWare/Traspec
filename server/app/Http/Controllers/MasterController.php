<?php

namespace App\Http\Controllers;

use App\Models\Agama;
use App\Models\Golongan;
use App\Models\Eselon;
use App\Models\Jabatan;
use App\Models\UnitKerja;
use App\Models\Tempat;
use Illuminate\Http\Request;

class MasterController extends Controller
{
    public function agama()
    {
        return response()->json(Agama::all());
    }

    public function golongan()
    {
        return response()->json(Golongan::all());
    }

    public function eselon()
    {
        return response()->json(Eselon::all());
    }

    public function jabatan()
    {
        return response()->json(Jabatan::all());
    }

    public function unitKerja()
    {
        return response()->json(UnitKerja::all());
    }

    public function tempat()
    {
        return response()->json(Tempat::all());
    }
}