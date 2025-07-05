<?php

namespace App\Http\Controllers\Anggota;

use App\Http\Controllers\Controller;
use App\Models\Kegiatan;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class DashboardController extends Controller
{
    /**
     * Menampilkan dashboard untuk anggota.
     */
    public function index(): View
    {
        $user = Auth::user();

        // 1. Ambil kegiatan yang akan datang atau sedang berlangsung
        $kegiatansTersedia = Kegiatan::where('tanggal', '>=', Carbon::today()->toDateString())
            ->orderBy('tanggal', 'asc')
            ->orderBy('waktu_mulai', 'asc')
            ->get();

        // 2. Ambil riwayat absensi pengguna, diurutkan dari yang terbaru
        $riwayatAbsensi = $user->absensis()
            ->with('kegiatan') // Eager load data kegiatan
            ->latest()
            ->paginate(5); // Paginate untuk riwayat yang panjang

        return view('anggota.dashboard', compact('kegiatansTersedia', 'riwayatAbsensi'));
    }
}
