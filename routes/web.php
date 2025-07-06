<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Anggota\AgendaController; // Import AgendaController

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// Halaman landing page utama
Route::get('/', function () {
    return view('welcome');
});

// Rute autentikasi bawaan
Auth::routes(['verify' => true]);

// Rute pengarah setelah login
Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

/*
|--------------------------------------------------------------------------
| Grup Rute Utama (Harus Login)
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'verified'])->group(function() {

    // == HALAMAN YANG DITAMPILKAN UNTUK PENGGUNA ==
    Route::prefix('portal')->group(function() {
        // Grup Admin
        Route::middleware('role:admin')->prefix('admin')->name('admin.')->group(function () {
            Route::get('dashboard', [App\Http\Controllers\Admin\DashboardController::class, 'index'])->name('dashboard');
            Route::resource('users', App\Http\Controllers\Admin\UserController::class);
            Route::resource('kegiatans', App\Http\Controllers\Admin\KegiatanController::class);
            Route::get('laporans', [App\Http\Controllers\Admin\LaporanController::class, 'index'])->name('laporans.index');
            Route::get('laporans/{kegiatan}', [App\Http\Controllers\Admin\LaporanController::class, 'show'])->name('laporans.show');
        });

        // Grup Anggota
        Route::middleware('role:ketua,wakil ketua,sekretaris,bendahara,pengurus,anggota')
            ->prefix('anggota')
            ->name('anggota.')
            ->group(function () {
                Route::get('dashboard', [App\Http\Controllers\Anggota\DashboardController::class, 'index'])->name('dashboard');
                Route::get('agenda', [AgendaController::class, 'index'])->name('agenda.index');
            });
    });


    // == RUTE API INTERNAL (UNTUK JAVASCRIPT) ==
    // Rute ini sekarang berada di dalam middleware 'web', sehingga bisa mengakses session.
    Route::prefix('api')->name('api.')->group(function() {
        // Rute untuk mengambil detail kegiatan
        Route::get('/kegiatan/{kegiatan}', [AgendaController::class, 'show'])->name('kegiatan.show');
        // Rute untuk menyimpan absensi
        Route::post('/kegiatan/{kegiatan}/absensi', [AgendaController::class, 'storeAbsensi'])->name('kegiatan.absensi.store');
    });

});
