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
        Route::get('/get-data-pengajuan/{id}', [PengajuanAPIController::class, 'getDataPengajuan']);
        Route::get('/get-data-users/{nip}', [PengajuanAPIController::class, 'getDataUsers']);
        Route::get('/get-cabang/{kode}', [PengajuanAPIController::class, 'getCabang']);
        Route::get('/get-cabang', [PengajuanAPIController::class, 'getAllCabang']);
        Route::get('/get-count-pengajuan', [PengajuanAPIController::class, 'getCountPengajuan']);
    });
});
