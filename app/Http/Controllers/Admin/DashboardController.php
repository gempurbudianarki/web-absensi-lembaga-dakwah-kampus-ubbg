<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Kegiatan;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\View\View;

class DashboardController extends Controller
{
    /**
     * Menampilkan dashboard analitik untuk admin.
     */
    public function index(): View
    {
        // Menghitung SEMUA pengguna, bukan hanya yang berperan 'anggota'.
        $totalPengguna = User::count();
        
        $kegiatanTelahBerlalu = Kegiatan::where('tanggal', '<', Carbon::today())->count();
        $kegiatanAkanDatang = Kegiatan::where('tanggal', '>=', Carbon::today())->count();

        // Data untuk Grafik Kehadiran
        $kegiatans = Kegiatan::where('tanggal', '<', Carbon::today())
            ->withCount('absensis')
            ->orderBy('tanggal', 'asc')
            ->get();

        $chartLabels = $kegiatans->pluck('nama_kegiatan');
        $chartData = $kegiatans->pluck('absensis_count');

        // Mengemas semua data untuk dikirim ke view
        $stats = [
            'totalPengguna' => $totalPengguna,
            'kegiatanTelahBerlalu' => $kegiatanTelahBerlalu,
            'kegiatanAkanDatang' => $kegiatanAkanDatang,
        ];

        return view('admin.dashboard', compact('stats', 'chartLabels', 'chartData'));
    }
}
