<?php
use App\Http\Controllers\DashboardAdminController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\HomeController;
use Illuminate\Support\Facades\Route;

Route::get('/', [HomeController::class, 'index']);

Route::get('/dashboard', [DashboardController::class, 'index'])->middleware(['auth:1,2,3'])->name('dashboard');
Route::get('/admin', [DashboardAdminController::class, 'index'])->middleware(['auth:0'])->name('admin');

require __DIR__.'/auth.php';

Route::get('/phpinfo', function() {
    return phpinfo();
});
