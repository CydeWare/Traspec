<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\PegawaiController;
use App\Http\Controllers\MasterController;

Route::post('/login', [AuthController::class, 'login']);
Route::post('/register', [AuthController::class, 'register']);

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });

Route::middleware('auth:sanctum')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::get('/me', [AuthController::class, 'me']);
    
    // Pegawai routes
    Route::apiResource('pegawai', PegawaiController::class);
    
    // Master data routes
    // Route::get('master/agama', [MasterController::class, 'agama']);
    // Route::get('master/golongan', [MasterController::class, 'golongan']);
    // Route::get('master/eselon', [MasterController::class, 'eselon']);
    // Route::get('master/jabatan', [MasterController::class, 'jabatan']);
    // Route::get('master/unit-kerja', [MasterController::class, 'unitKerja']);
    // Route::get('master/tempat', [MasterController::class, 'tempat']);
});

Route::prefix('master')->group(function () {
    Route::get('agama', [MasterController::class, 'agama']);
    Route::get('golongan', [MasterController::class, 'golongan']);
    Route::get('eselon', [MasterController::class, 'eselon']);
    Route::get('jabatan', [MasterController::class, 'jabatan']);
    Route::get('tempat', [MasterController::class, 'tempat']);
    Route::get('unit-kerja', [MasterController::class, 'unitKerja']);
});

