<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\{

    homeController,
    PemasokController,
    StokBarangController,
    PemesananController,
    BarangController,
    KategoriController,
    PelangganController,
    LoginController,
};


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

Route::get('/', [LoginController::class, 'halamanlogin'])->name('login');
Route::get('/login/logout', [LoginController::class, 'logout'])->name('logout');
Route::post('/postlogin', [LoginController::class, 'postlogin'])->name('postlogin');
Route::get('/logout', [LoginController::class, 'logout'])->name('logout');

route::group(['middleware' => ['auth']], function () {
    Route::get('/home', [homeController::class, 'index'])->name('home');
});


Route::group([
    'middleware' =>  ["auth"],
    'prefix' => "pemasok"
], function ($router) {
    Route::get('/', [PemasokController::class, 'show']);
    Route::get('/show-data', [PemasokController::class, 'show_data']);
    Route::post('/', [PemasokController::class, 'store']);
    Route::post('/update/{id}', [PemasokController::class, 'update']);
    Route::get('/destroy/{id}', [PemasokController::class, 'destroy']);
});
Route::group([
    'middleware' =>  ["auth"],
    'prefix' => "stok"
], function ($router) {
    Route::get('/', [StokBarangController::class, 'show']);
    Route::get('/show-data', [StokBarangController::class, 'show_data']);
    Route::post('/update/{id}', [StokBarangController::class, 'update']);
});
Route::group([
    'middleware' =>  ["auth"],
    'prefix' => "pemesanan"
], function ($router) {
    Route::get('/', [PemesananController::class, 'show']);
    Route::get('/show-data', [PemesananController::class, 'show_data']);
    Route::post('/', [PemesananController::class, 'store']);
    Route::get('/destroy/{id}', [PemesananController::class, 'destroy']);
});
Route::group([
    'middleware' =>  ["auth"],
    'prefix' => "penjualan"
], function ($router) {
    Route::get('/', [PemesananController::class, 'data_penjualan']);
    Route::get('/show-data', [PemesananController::class, 'show_data']);

});
Route::group([
    'middleware' =>  ["auth"],
    'prefix' => "barang"
], function ($router) {
    Route::get('/', [BarangController::class, 'show']);
    Route::get('/show-data', [BarangController::class, 'show_data']);
    Route::post('/', [BarangController::class, 'store']);
    Route::post('/update/{id}', [BarangController::class, 'update']);
    Route::get('/destroy/{id}', [BarangController::class, 'destroy']);
});
Route::group([
    'middleware' =>  ["auth"],
    'prefix' => "kategori"
], function ($router) {
    Route::get('/', [KategoriController::class, 'show']);
    Route::get('/show-data', [KategoriController::class, 'show_data']);
    Route::post('/', [KategoriController::class, 'store']);
    Route::post('/update/{id}', [KategoriController::class, 'update']);
    Route::get('/destroy/{id}', [KategoriController::class, 'destroy']);
});
Route::group([
    'middleware' =>  ["auth"],
    'prefix' => "pelanggan"
], function ($router) {
    Route::get('/', [PelangganController::class, 'show']);
    Route::get('/show-data', [PelangganController::class, 'show_data']);
    Route::post('/', [PelangganController::class, 'store']);
    Route::post('/update/{id}', [PelangganController::class, 'update']);
    Route::get('/destroy/{id}', [PelangganController::class, 'destroy']);
});