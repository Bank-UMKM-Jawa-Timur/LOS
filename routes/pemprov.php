<?php

use App\Http\Controllers\Api\Pemprov\CabangController;
use App\Http\Controllers\Api\Pemprov\KotaController;
use App\Http\Controllers\Api\Pemprov\PengajuanController;

Route::prefix('pemprov')->group(function() {
    Route::post('/store', [PengajuanController::class, 'store']);
    Route::get('/list-cabang', [CabangController::class, 'listCabang']);
    Route::get('/get-cabang-by-id', [CabangController::class, 'getCabangById']);
    Route::get('/list-kotakab', [KotaController::class, 'listKota']);
    Route::get('/get-kotakab-by-id', [KotaController::class, 'getKotaById']);
});

