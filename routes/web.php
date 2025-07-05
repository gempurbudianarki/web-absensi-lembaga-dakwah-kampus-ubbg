<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

// Panggil controller-controller kita
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\KegiatanController;
use App\Http\Controllers\Admin\LaporanController; // <-- [MODIFIKASI KITA #1] Panggil LaporanController
use App\Http\Controllers\Ketua\DashboardController as KetuaDashboardController;
use App\Http\Controllers\PengurusDashboardController;
use App\Http\Controllers\Anggota\DashboardController as AnggotaDashboardController;
use App\Http\Controllers\Anggota\AbsensiController;


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

Route::get('/', function () {
    return view('welcome');
});

// Route untuk login, logout, dll.
Route::get('login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('login', [LoginController::class, 'login']);
Route::post('logout', [LoginController::class, 'logout'])->name('logout');


// --- ROUTE DASHBOARD ---
Route::middleware(['auth'])->group(function () {

    // Route untuk Admin
    Route::middleware(['role:admin'])->prefix('admin')->name('admin.')->group(function () {
        Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');
        
        Route::resource('users', UserController::class);
        Route::resource('kegiatans', KegiatanController::class);

        // [MODIFIKASI KITA #2] Route untuk Laporan
        Route::get('/laporans', [LaporanController::class, 'index'])->name('laporans.index');
        Route::get('/laporans/{kegiatan}', [LaporanController::class, 'show'])->name('laporans.show');
    });

    // Route untuk Ketua
    Route::middleware(['role:ketua'])->prefix('ketua')->name('ketua.')->group(function () {
        Route::get('/dashboard', [KetuaDashboardController::class, 'index'])->name('dashboard');
    });

    // Route untuk Pengurus
    Route::middleware(['role:pengurus'])->prefix('pengurus')->name('pengurus.')->group(function () {
        Route::get('/dashboard', [PengurusDashboardController::class, 'index'])->name('dashboard');
    });

    // Route untuk Anggota
    Route::middleware(['role:anggota'])->prefix('anggota')->name('anggota.')->group(function () {
        Route::get('/dashboard', [AnggotaDashboardController::class, 'index'])->name('dashboard');
        Route::get('/absensi/{kegiatan}', [AbsensiController::class, 'show'])->name('absensi.show');
        Route::post('/absensi', [AbsensiController::class, 'store'])->name('absensi.store');
    });

});
