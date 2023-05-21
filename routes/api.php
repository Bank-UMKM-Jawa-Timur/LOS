<?php

use App\Http\Controllers\Api\PengajuanAPIController;
use App\Http\Middleware\APIToken;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::post('/login', [PengajuanAPIController::class, 'login']);

Route::group(['middleware' => ['auth:sanctum']], function(){
    Route::get('/profile', function(Request $request){
        return $request->user();
    });

    Route::post('/logout', [PengajuanAPIController::class, 'logout']);
});

Route::prefix('kkb')->group(function(){
    Route::middleware([APIToken::class])->group(function(){
        Route::get('/get-data-pengajuan', [PengajuanAPIController::class, 'getDataPengajuan']);
        Route::get('/get-file-po/{id}', [PengajuanAPIController::class, 'getFilePO'])->name('get-file-po');
        Route::get('/get-file-sppk/{id}', [PengajuanAPIController::class, 'getFileSPPK'])->name('get-file-sppk');
        Route::get('/get-file-pk/{id}', [PengajuanAPIController::class, 'getFilePK'])->name('get-file-pk');
    });
});