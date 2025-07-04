<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

// Panggil controller baru kita
use App\Http\Controllers\PengurusDashboardController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

// --- ROUTE DASHBOARD ---
Route::middleware(['auth'])->group(function () {

    Route::middleware(['role:admin'])->prefix('admin')->name('admin.')->group(function () {
        Route::get('/dashboard', [App\Http\Controllers\Admin\DashboardController::class, 'index'])->name('dashboard');
    });

    Route::middleware(['role:ketua'])->prefix('ketua')->name('ketua.')->group(function () {
        Route::get('/dashboard', [App\Http\Controllers\Ketua\DashboardController::class, 'index'])->name('dashboard');
    });

    // [MODIFIKASI KITA] Arahkan ke controller BARU
    Route::middleware(['role:pengurus'])->prefix('pengurus')->name('pengurus.')->group(function () {
        Route::get('/dashboard', [PengurusDashboardController::class, 'index'])->name('dashboard');
    });

    Route::middleware(['role:anggota'])->prefix('anggota')->name('anggota.')->group(function () {
        Route::get('/dashboard', [App\Http\Controllers\Anggota\DashboardController::class, 'index'])->name('dashboard');
    });

});
