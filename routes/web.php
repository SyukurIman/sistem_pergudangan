<?php
use App\Http\Controllers\DashboardAdminController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\Masterdata\BarangController;
use App\Http\Controllers\Masterdata\PegawaiController;
use App\Http\Controllers\Masterdata\UserController;
use Illuminate\Support\Facades\Route;

Route::get('/', [HomeController::class, 'index']);

Route::get('/dashboard', [DashboardController::class, 'index'])->middleware(['auth:1,2,3'])->name('dashboard');
Route::get('/admin', [DashboardAdminController::class, 'index'])->middleware(['auth:0'])->name('admin');

require __DIR__.'/auth.php';

Route::get('/phpinfo', function() {
    return phpinfo();
});

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

// Barang
Route::get('/admin/barang', [BarangController::class, 'index'])->name('barang');
Route::post('/data_barang', [BarangController::class, 'get_data'])->name('barang.get_data');
Route::post('/delete_barang', [BarangController::class, 'destroy'])->name('barang.delete');
Route::get('/admin/update_barang/{id}', [BarangController::class, 'edit'])->name('barang.edit');
Route::post('/admin/update_barang/{id}', [BarangController::class, 'update'])->name('barang.update');
Route::get('/admin/barang/add', [BarangController::class, 'create'])->name('barang.add');
Route::post('/admin/barang/add', [BarangController::class, 'store'])->name('barang.add_form');

Route::get('/admin/barang/dimensi/add', [BarangController::class, 'create_dimensi'])->name('barang.dimensi.add');
Route::post('/admin/barang/dimensi/add', [BarangController::class, 'store_dimensi'])->name('barang.dimensi.add_form');

Route::get('/admin/barang/kategori/add', [BarangController::class, 'create_kategori'])->name('barang.kategori.add');
Route::post('/admin/barang/kategori/add', [BarangController::class, 'store_kategori'])->name('barang.kategori.add_form');

Route::post('/admin/barang/genertae_qr/{data}', [BarangController::class, 'create_qr'])->name('barang.generate_qr');
Route::get('/admin/barang/list_barang/{id}', [BarangController::class, 'list_barang'])->name('barang.list');
Route::post('/data_list_barang/{id}', [BarangController::class, 'get_data_list'])->name('barang.list.get_data');
Route::get('/admin/barang/list_barang/in/{id}', [BarangController::class, 'in_barang'])->name('barang.list.in');
Route::get('/admin/barang/list_barang/out/{id}', [BarangController::class, 'out_barang'])->name('barang.list.out');




// Set Penempatan