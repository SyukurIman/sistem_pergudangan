<?php
use App\Http\Controllers\DashboardAdminController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\Masterdata\BarangController;
use App\Http\Controllers\Masterdata\PegawaiController;
use App\Http\Controllers\Masterdata\UserController;
use App\Http\Controllers\Masterdata\RakController;
use App\Http\Controllers\Transaksi\BarangTransaksiController;
use App\Http\Controllers\Transaksi\PenempatanController;
use App\Http\Controllers\Transaksi\PemindahanController;
use Illuminate\Support\Facades\Route;

Route::get('/', [HomeController::class, 'index']);

Route::get('/dashboard', [DashboardController::class, 'index'])->middleware(['auth:1,2,3'])->name('dashboard');
Route::get('/admin', [DashboardAdminController::class, 'index'])->middleware(['auth:0'])->name('admin');

require __DIR__.'/auth.php';

Route::get('/phpinfo', function() {
    return phpinfo();
});

Route::middleware(['auth:0'])->group(function () {
    // User
    Route::get('/admin/user', [UserController::class, 'index'])->name('user');
    Route::post('/data_user', [UserController::class, 'get_data'])->name('user.get_data');
    Route::post('/delete_user', [UserController::class, 'destroy'])->name('user.delete');
    Route::get('/admin/update_user/{id}', [UserController::class, 'edit'])->name('user.edit');
    Route::post('/admin/update_user/{id}', [UserController::class, 'update'])->name('user.update');
    Route::get('/admin/user/add', [UserController::class, 'create'])->name('user.add');
    Route::post('/admin/user/add', [UserController::class, 'store'])->name('user.add_form');

    // Pegawai
    Route::get('/admin/pegawai', [PegawaiController::class, 'index'])->name('pegawai');
    Route::post('/data_pegawai', [PegawaiController::class, 'get_data'])->name('pegawai.get_data');
    Route::post('/delete_pegawai', [PegawaiController::class, 'destroy'])->name('pegawai.delete');
    Route::get('/admin/update_pegawai/{id}', [PegawaiController::class, 'edit'])->name('pegawai.edit');
    Route::post('/admin/update_pegawai/{id}', [PegawaiController::class, 'update'])->name('pegawai.update');
    Route::get('/admin/pegawai/add', [PegawaiController::class, 'create'])->name('pegawai.add');
    Route::post('/admin/pegawai/add', [PegawaiController::class, 'store'])->name('pegawai.add_form');

});

Route::middleware(['auth:0,1'])->group(function () {
    // Barang
    Route::get('/admin/barang', [BarangController::class, 'index'])->name('barang');
    Route::post('/data_barang', [BarangController::class, 'get_data'])->name('barang.get_data');
    Route::post('/delete_barang', [BarangController::class, 'destroy'])->name('barang.delete');
    Route::get('/admin/update_barang/{id}', [BarangController::class, 'edit'])->name('barang.edit');
    Route::post('/admin/update_barang/{id}', [BarangController::class, 'update'])->name('barang.update');
    Route::get('/admin/barang/add', [BarangController::class, 'create'])->name('barang.add');
    Route::post('/admin/barang/add', [BarangController::class, 'store'])->name('barang.add_form');

    // Dimensi Barang
    Route::get('/admin/barang/dimensi', [BarangController::class, 'index_dimensi_barang'])->name('barang');
    Route::post('/data_dimensi_barang', [BarangController::class, 'get_data_dimensi'])->name('barang.get_data');
    Route::get('/admin/barang/dimensi/add', [BarangController::class, 'create_dimensi'])->name('barang.dimensi.add');
    Route::post('/admin/barang/dimensi/add', [BarangController::class, 'store_dimensi'])->name('barang.dimensi.add_form');
    Route::get('/admin/barang/dimensi/edit/{id}', [BarangController::class, 'edit_dimensi'])->name('barang.dimensi.edit');
    Route::post('/admin/barang/dimensi/edit/{id}', [BarangController::class, 'update_dimensi'])->name('barang.dimensi.update');
    Route::post('/delete_dimensi_barang', [BarangController::class, 'destroy_dimensi'])->name('barang.dimensi.delete');

    // Kategori Barang
    Route::get('/admin/barang/kategori', [BarangController::class, 'index_kategori_barang'])->name('barang');
    Route::post('/data_kategori_barang', [BarangController::class, 'get_data_kategori'])->name('barang.get_data');
    Route::get('/admin/barang/kategori/add', [BarangController::class, 'create_kategori'])->name('barang.kategori.add');
    Route::post('/admin/barang/kategori/add', [BarangController::class, 'store_kategori'])->name('barang.kategori.add_form');
    Route::get('/admin/barang/kategori/edit/{id}', [BarangController::class, 'edit_kategori'])->name('barang.kategori.edit');
    Route::post('/admin/barang/kategori/edit/{id}', [BarangController::class, 'update_kategori'])->name('barang.kategori.update');
    Route::post('/delete_kategori_barang', [BarangController::class, 'destroy_kategori'])->name('barang.kategori.delete');

    // Generate Qr Code
    Route::post('/admin/barang/genertae_qr/{data}', [BarangController::class, 'create_qr'])->name('barang.generate_qr');

    // List Barang
    Route::get('/admin/barang/list_barang/{id}', [BarangTransaksiController::class, 'list_barang'])->name('barang.list');
    Route::post('/data_list_barang/{id}', [BarangTransaksiController::class, 'get_data_list'])->name('barang.list.get_data');
    Route::post('/data_list_barang_trash/{id}', [BarangTransaksiController::class, 'get_data_list_trash'])->name('barang.list.get_data_trash');
    Route::post('/delete_list_barang', [BarangTransaksiController::class, 'destroy'])->name('barang.list.delete');
    Route::post('/restore_list_barang_one', [BarangTransaksiController::class, 'restore_one'])->name('barang.list.restore_one');
    Route::post('/restore_list_barang_all/{id}', [BarangTransaksiController::class, 'restore_all'])->name('barang.list.restore_all');

    // Barang Masuk
    Route::get('/admin/barang/in', [BarangTransaksiController::class, 'in_barang'])->name('barang.list.in');
    Route::post('/in_barang/{data}', [BarangTransaksiController::class, 'in_barang_save'])->name('barang.list.in_save');

    // Barang Keluar
    Route::get('/admin/barang/out', [BarangTransaksiController::class, 'out_barang'])->name('barang.list.out');
    Route::post('/out_barang/{data}', [BarangTransaksiController::class, 'out_barang_save'])->name('barang.list.out_save');

    // Get data Barang Masuk Dan Keluar
    Route::post('/data_list_barang_in', [BarangTransaksiController::class, 'get_list_in_barang'])->name('barang.list.out_save');
    Route::post('/data_list_barang_out', [BarangTransaksiController::class, 'get_list_out_barang'])->name('barang.list.out_save');

});


Route::middleware(['auth:0'])->group(function () {
  //rak
  Route::get('/rak', [RakController::class, 'rak'])->name('masterdata.rak');
  Route::get('/rak/create', [RakController::class, 'create'])->name('masterdata.rak.create');
  Route::post('/rak/table', [RakController::class, 'table'])->name('masterdata.rak.table');
  Route::post('/rak/table_qrcode', [RakController::class, 'data_rak'])->name('masterdata.rak.table_qrcode');
  Route::get('/rak/lihat/{id}', [RakController::class, 'lihat'])->name('masterdata.rak.lihat');
  Route::get('/rak/update/{id}', [RakController::class, 'update'])->name('masterdata.rak.update');
  Route::post('/rak/createform', [RakController::class, 'createform'])->name('masterdata.rak.createform');
  Route::post('/rak/createdimensi', [RakController::class, 'createdimensi'])->name('masterdata.rak.createdimensi');
  Route::post('/rak/updateform', [RakController::class, 'updateform'])->name('masterdata.rak.updateform');
  Route::post('/rak/deleteform', [RakController::class, 'deleteform'])->name('masterdata.rak.deleteform');

  //penempatan 
  Route::get('/penempatan', [PenempatanController::class, 'penempatan'])->name('masterdata.penempatan');
  Route::get('/penempatan/create', [PenempatanController::class, 'create'])->name('masterdata.penempatan.create');
  Route::post('/penempatan/table', [PenempatanController::class, 'table'])->name('masterdata.penempatan.table');
  Route::get('/penempatan/lihat/{id}', [PenempatanController::class, 'lihat'])->name('masterdata.penempatan.lihat');
  Route::post('/penempatan/createform', [PenempatanController::class, 'createform'])->name('masterdata.penempatan.createform');
  Route::post('/penempatan/deleteform', [PenempatanController::class, 'deleteform'])->name('masterdata.penempatan.deleteform');

  Route::get('/pemindahan', [PemindahanController::class, 'pemindahan'])->name('masterdata.pemindahan');
  Route::get('/pemindahan/create', [PemindahanController::class, 'create'])->name('masterdata.pemindahan.create');
  Route::post('/pemindahan/table', [PemindahanController::class, 'table'])->name('masterdata.pemindahan.table');
  Route::get('/pemindahan/lihat/{id}', [PemindahanController::class, 'lihat'])->name('masterdata.pemindahan.lihat');
  Route::post('/pemindahan/createform', [PemindahanController::class, 'createform'])->name('masterdata.pemindahan.createform');
  Route::post('/pemindahan/deleteform', [PemindahanController::class, 'deleteform'])->name('masterdata.pemindahan.deleteform');
});
// Set Penempatan