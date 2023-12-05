<?php

use App\Http\Controllers\Api\Pemprov\PengajuanController;

Route::prefix('pemprov')->group(function() {
    Route::post('/store', [PengajuanController::class, 'store']);
});

