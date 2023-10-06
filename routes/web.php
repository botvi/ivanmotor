<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\{

    homeController,
    PemasokController,
    StokBarangController,
    PemesananController,
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

Route::get('/', [homeController::class, 'index'])->name('home');


Route::group([
    'middleware' =>  ["web"],
    'prefix' => "pemasok"
], function ($router) {
    Route::get('/', [PemasokController::class, 'show']);
    Route::get('/show-data', [PemasokController::class, 'show_data']);
    Route::post('/', [PemasokController::class, 'store']);
    Route::post('/update/{id}', [PemasokController::class, 'update']);
    Route::get('/destroy/{id}', [PemasokController::class, 'destroy']);
});
Route::group([
    'middleware' =>  ["web"],
    'prefix' => "stok"
], function ($router) {
    Route::get('/', [StokBarangController::class, 'show']);
    Route::get('/show-data', [StokBarangController::class, 'show_data']);
    Route::post('/', [StokBarangController::class, 'store']);
    Route::post('/update/{id}', [StokBarangController::class, 'update']);
    Route::get('/destroy/{id}', [StokBarangController::class, 'destroy']);
});
Route::group([
    'middleware' =>  ["web"],
    'prefix' => "pemesanan"
], function ($router) {
    Route::get('/', [PemesananController::class, 'show']);
    Route::get('/show-data', [PemesananController::class, 'show_data']);
    Route::post('/', [PemesananController::class, 'store']);
    Route::get('/destroy/{id}', [PemesananController::class, 'destroy']);
});
Route::group([
    'middleware' =>  ["web"],
    'prefix' => "penjualan"
], function ($router) {
    Route::get('/', [PemesananController::class, 'data_penjualan']);
    Route::get('/show-data', [PemesananController::class, 'show_data']);

});