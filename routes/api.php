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
    Route::get('/get-data-pengajuan', [PengajuanAPIController::class, 'getDataPengajuan']);
});
