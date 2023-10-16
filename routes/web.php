<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\KeranjangController;

use App\Http\Controllers\{

    homeController,
    PemasokController,
    StokBarangController,
    PemesananController,
    BarangController,
    KategoriController,
    PelangganController,
    LoginController,
    WebsiteController,
    PemesananOnlineController,
    LaporanController,
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
Route::get('/', [\App\Http\Controllers\WebsiteController::class, "index"]);
Route::get('/about', [\App\Http\Controllers\WebsiteController::class, 'about']);
Route::get('/kontak', [\App\Http\Controllers\WebsiteController::class, 'kontak']);

// LOGIN CUSTOMER

Route::post('/daftar', [WebsiteController::class, 'register']);
Route::get('/daftar', [\App\Http\Controllers\WebsiteController::class, 'daftar'])->name('daftar');



// LOGIN ADMIN

Route::get('/login', [LoginController::class, 'halamanlogin'])->name('login');
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


Route::post('/keranjang/tambah/{id}', [KeranjangController::class, 'tambah'])->name('keranjang.tambah');
Route::put('/keranjang/perbarui/{id}',  [KeranjangController::class, 'update']);
Route::delete('/keranjang/hapus/{id}', [KeranjangController::class, 'hapus']);
Route::get('/jumlah-item-keranjang', [KeranjangController::class, 'jumlahItemKeranjang']);
Route::get('/history', [PemesananOnlineController::class, 'riwayatpesanan']);


Route::get('/checkout', [KeranjangController::class, 'checkout'])->name('checkout');
Route::get('/pemesananonline', [PemesananOnlineController::class,'index'])->name('pemesanan');

Route::put('/pemesanan/{id}/terima', [PemesananOnlineController::class,'terimaPemesanan']);

Route::put('/pemesanan/{id}/update-status',  [PemesananOnlineController::class,'updateStatus']);




Route::group([
    'middleware' =>  ["auth"],
    'prefix' => "keranjang"
], function ($router) {
    Route::get('/', [KeranjangController::class, 'index']);

});


Route::get('/laporan/pemasok', [LaporanController::class, 'laporanPemasok']);
Route::get('/laporan/barang', [LaporanController::class, 'laporanBarang']);
Route::get('/laporan/penjualan', 'App\Http\Controllers\LaporanController@laporanPenjualan')->name('laporan.penjualan');

Route::get('/laporan/print', 'App\Http\Controllers\LaporanController@print')->name('laporan.print');
