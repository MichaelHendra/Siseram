<?php

use App\Http\Controllers\AgenController;
use App\Http\Controllers\Auth_Controller;
use App\Http\Controllers\Dashboard_Controller;
use App\Http\Controllers\DetailAgenController;
use App\Http\Controllers\DetailController;
use App\Http\Controllers\ParfumController;
use App\Http\Controllers\StokController;
use App\Http\Controllers\TransaksiAgen;
use App\Http\Controllers\TransaksiPusat;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
 */

Route::group(['middleware' => 'guest'], function () {
    Route::get('/register', [Auth_Controller::class, 'register'])->name('register');
    Route::post('/register', [Auth_Controller::class, 'registerPost'])->name('register');
    Route::get('/', [Auth_Controller::class, 'login'])->name('login');
    Route::post('/loginproses', [Auth_Controller::class, 'loginPost'])->name('loginProses');
});

Route::group(['middleware' => 'auth'], function () {
    Route::get('/home', [Dashboard_Controller::class, 'dashboardT']);
    Route::get('/logout', [Auth_Controller::class, 'logout'])->name('logout');
//setting->agen
    Route::get('/agen', [AgenController::class, 'index']);
    Route::get('/agen/tambah', [AgenController::class, 'create']);
    Route::post('/agen/store', [AgenController::class, 'store']);
    Route::get('/agen/edit/{id}', [AgenController::class, 'edit']);
    Route::put('/agen/update/{id}', [AgenController::class, 'update']);
    Route::get('/agen/destroy/{id}', [AgenController::class, 'destroy']);
//setting->parfum
    Route::get('/parfum', [ParfumController::class, 'index']);
    Route::get('/parfum/tambah', [ParfumController::class, 'create']);
    Route::post('/parfum/store', [ParfumController::class, 'store']);
    Route::get('/parfum/edit/{id}', [ParfumController::class, 'edit']);
    Route::put('/parfum/update/{id}', [ParfumController::class, 'update']);
    Route::get('/parfum/destroy/{id}', [ParfumController::class, 'destroy']);
    Route::get('/parfum/mess', [ParfumController::class, 'mess']); //cek view parfum ben aktif
//report->stok
    Route::get('/stok', [StokController::class, 'index']);
    Route::get('/stok/tambah', [StokController::class, 'create']);
    Route::post('/stok/store', [StokController::class, 'store']);
    Route::get('/stok/edit/', [StokController::class, 'edit']); //ganti wild card lek wis onok data e {id}
    Route::put('/stok/update/{id}', [StokController::class, 'update']);
    Route::get('/stok/destroy/{id}', [StokController::class, 'destroy']);
//transksi Pusat
    Route::get('/transaksi', [TransaksiPusat::class, 'index']);
    Route::get('/transaksi/tambah', [TransaksiPusat::class, 'create']);
    Route::post('/transaksi/store', [TransaksiPusat::class, 'store']);
    Route::get('/transaksi/detail/{id}', [DetailController::class, 'detailTapil']);
    Route::post('/transaksi/detail/tambah', [DetailController::class, 'detailProses']);

    Route::post('/transaksi/detail/masuk/{id}', [DetailController::class, 'detailmasuk']);

    // Route::get('/debug', [DetailController::class, 'debug']);
    Route::get('/transaksi/detail/hapus/{transaksiId}/{id}', [DetailController::class, 'detailDelete']);

//transaksi Agen
    Route::get('/transaksi/agen', [TransaksiAgen::class, 'index']);
    Route::get('/transaksi/agen/tambah', [TransaksiAgen::class, 'create']);
    Route::post('/transaksi/agen/store', [TransaksiAgen::class, 'store']);
    Route::get('/transaksi/agen/detail/{id}', [DetailAgenController::class, 'detailTapil']);
    Route::post('/transaksi/agen/detail/tambah', [DetailAgenController::class, 'detailProses']);

    Route::post('/transaksi/agen/detail/masuk/{id}', [DetailAgenController::class, 'detailAgenMasuk']);
    Route::get('/transaksi/agen/detail/hapus/{transaksiId}/{id}', [DetailAgenController::class, 'detailDelete']);
    Route::post('/transaksi/agen/detail/retur/{id}', [DetailAgenController::class, 'detailretur']);

// Route::get('/transaksi/edit/{id}', [TransaksiPusat::class, 'edit']);
// Route::put('/transaksi/update/{id}', [TransaksiPusat::class, 'update']);
//report
    Route::get('/lapor/stok', [StokController::class, 'stokTampil']);
    Route::post('/lapor/stok/agen', [StokController::class, 'stokAgen']);
// Route::get('/transaksi/edit/{id}', [TransaksiPusat::class, 'edit']);
// Route::put('/transaksi/update/{id}', [TransaksiPusat::class, 'update']);
//report
    Route::get('/lapor/transaksi', [TransaksiPusat::class, 'laporTampil']);
    Route::post('/lapor/transaksi', [TransaksiPusat::class, 'laporTproses']);
    Route::get('/lapor/transaksi/cetak', [TransaksiPusat::class, 'export_excel']);
    Route::get('/lapor/stok', [StokController::class, 'stokTampil']);
    Route::post('/lapor/stok/agen', [StokController::class, 'stokAgen']); //cari
    Route::get('/lapor/stok/cetak', [StokController::class, 'export_excel']);
    Route::get('/lapor/stok/cetak/semua', [StokController::class, 'export']);
});
