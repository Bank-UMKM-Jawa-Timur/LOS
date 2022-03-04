<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\PengajuanKreditController;
use \App\Http\Controllers\KabupatenController;
use \App\Http\Controllers\KecamatanController;
use \App\Http\Controllers\DesaController;
use \App\Http\Controllers\CabangController;
use \App\Http\Controllers\UserController;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// Route::get('/', function () {
//     return view('welcome');
// });


// Route::get('/dashboard', function () {
    //     return view('dashboard');
    // })->middleware(['auth'])->name('dashboard');
    
Route::middleware(['auth','verified'])->group(function () {
    Route::get('/dashboard', [DashboardController::class,'index']);
    Route::resource('pengajuan-kredit', PengajuanKreditController::class);
    Route::resource('kabupaten', KabupatenController::class);
    Route::resource('kecamatan', KecamatanController::class);
    Route::get('get-kecamatan-by-kabupaten-id/{id}', [KecamatanController::class, 'getKecamatanByKabupatenId']);
    Route::resource('desa', DesaController::class);
    Route::get('get-desa-by-kecamatan-id/{id}', [DesaController::class, 'getDesaByKecamatanId']);
    Route::resource('cabang', CabangController::class);
    Route::resource('user', UserController::class);
    Route::get('change-password', [UserController::class, 'changePassword'])->name('change_password');
    Route::put('change-password/{id}', [UserController::class, 'updatePassword'])->name('update_password');
});

require __DIR__.'/auth.php';
