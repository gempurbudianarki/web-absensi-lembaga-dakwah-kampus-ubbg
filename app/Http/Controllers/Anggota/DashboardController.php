<?php

namespace App\Http\Controllers\Anggota;

use App\Http\Controllers\Controller;
use App\Models\Kegiatan; // <-- [MODIFIKASI KITA #1] Panggil model Kegiatan
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    /**
     * Menampilkan halaman dashboard untuk anggota.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        // [MODIFIKASI KITA #2]
        // Ambil semua data kegiatan, urutkan berdasarkan tanggal terbaru
        $kegiatans = Kegiatan::orderBy('tanggal_kegiatan', 'desc')->get();

        // Kirim data kegiatans ke halaman view dashboard anggota
        return view('anggota.dashboard', compact('kegiatans'));
    }
}
