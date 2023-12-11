<?php

use App\Http\Controllers\Api\Pemprov\CabangController;
use App\Http\Controllers\Api\Pemprov\DesaController;
use App\Http\Controllers\Api\Pemprov\KecamatanController;
use App\Http\Controllers\Api\Pemprov\KotaController;
use App\Http\Controllers\Api\Pemprov\PengajuanController;
use App\Http\Middleware\PemprovToken;
use Illuminate\Support\Facades\Route;

Route::prefix('/pemprov')->group(function(){
    Route::middleware([PemprovToken::class])->group(function(){
        Route::post('/store', [PengajuanController::class, 'store']);
        Route::post('/list-cabang', [CabangController::class, 'listCabang']);
        Route::post('/list-kotakab', [KotaController::class, 'listKota']);
        Route::post('/list-kecamatan', [KecamatanController::class, 'listKecamatan']);
        Route::post('/list-desa', [DesaController::class, 'listDesa']);
    });
});

