<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\PengajuanKreditController;
use \App\Http\Controllers\KabupatenController;
use \App\Http\Controllers\KecamatanController;
use \App\Http\Controllers\DesaController;
use \App\Http\Controllers\CabangController;
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
    Route::resource('desa', DesaController::class);
    Route::resource('cabang', CabangController::class);
});

require __DIR__.'/auth.php';
