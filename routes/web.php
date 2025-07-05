<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Di sini kita mendefinisikan semua rute untuk aplikasi kita.
|
*/

// Rute untuk halaman depan dan otentikasi (login, logout, dll)
Route::get('/', function () {
    return view('welcome');
})->name('welcome');

Auth::routes(['verify' => true]);

// Rute /home sebagai pengarah utama setelah login
Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');


// Grup utama untuk semua pengguna yang sudah login
Route::middleware(['auth'])->group(function () {

    // =====================================================================
    // BAGIAN KHUSUS ADMIN
    // Semua rute di sini hanya bisa diakses oleh admin.
    // URL-nya akan diawali dengan /admin/...
    // =====================================================================
    Route::middleware(['role:admin'])->prefix('admin')->name('admin.')->group(function () {
        
        // Dashboard Admin
        Route::get('dashboard', [App\Http\Controllers\Admin\DashboardController::class, 'index'])->name('dashboard');
        
        // Manajemen Pengguna
        Route::resource('users', App\Http\Controllers\Admin\UserController::class);
        
        // Manajemen Kegiatan
        Route::get('kegiatans/{kegiatan}/qr', [App\Http\Controllers\Admin\KegiatanController::class, 'showQr'])->name('kegiatans.showQr');
        Route::resource('kegiatans', App\Http\Controllers\Admin\KegiatanController::class)->except(['show']);
        
        // Laporan
        Route::get('laporans', [App\Http\Controllers\Admin\LaporanController::class, 'index'])->name('laporans.index');
        Route::get('laporans/{kegiatan}', [App\Http\Controllers\Admin\LaporanController::class, 'show'])->name('laporans.show');
    });


    // =====================================================================
    // BAGIAN KHUSUS PENGGUNA (NON-ADMIN)
    // Semua rute di sini bisa diakses oleh: Ketua, Wakil Ketua, Sekretaris,
    // Bendahara, Pengurus, dan Anggota.
    // URL-nya akan diawali dengan /portal/...
    // =====================================================================
    Route::middleware(['role:ketua,wakil ketua,sekretaris,bendahara,pengurus,anggota'])
        ->prefix('portal')
        ->name('user.')
        ->group(function () {
            
            // Untuk saat ini, kita hanya membuat satu rute untuk dashboard mereka.
            // Rute ini akan memanggil controller yang akan kita buat di langkah BERIKUTNYA.
            Route::get('dashboard', [App\Http\Controllers\User\DashboardController::class, 'index'])->name('dashboard');

    });

});
