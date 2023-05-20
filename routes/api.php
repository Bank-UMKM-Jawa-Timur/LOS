<?php

use App\Http\Controllers\Api\PengajuanAPIController;
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

Route::get('/get-data-pengajuan/{api_token}', [PengajuanAPIController::class, 'getDataPengajuan'])->middleware('api_token');
Route::get('/get-file-po/{id}/{api_token}', [PengajuanAPIController::class, 'getFilePO'])->name('get-file-po')->middleware('api_token');
Route::get('/get-file-sppk/{id}/{api_token}', [PengajuanAPIController::class, 'getFileSPPK'])->name('get-file-sppk')->middleware('api_token');
Route::get('/get-file-pk/{id}/{api_token}', [PengajuanAPIController::class, 'getFilePK'])->name('get-file-pk')->middleware('api_token');