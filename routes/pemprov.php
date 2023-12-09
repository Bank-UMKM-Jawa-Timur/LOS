<?php

use App\Http\Controllers\Api\Pemprov\CabangController;
use App\Http\Controllers\Api\Pemprov\PengajuanController;

Route::prefix('pemprov')->group(function() {
    Route::post('/store', [PengajuanController::class, 'store']);
    Route::get('/list-cabang', [CabangController::class, 'listCabang']);
});

