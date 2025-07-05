<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Kegiatan;
use Illuminate\Http\Request;
use Illuminate\View\View;

class LaporanController extends Controller
{
    /**
     * Menampilkan halaman daftar laporan untuk setiap kegiatan.
     */
    public function index(): View
    {
        // Mengambil kegiatan dan menghitung jumlah absensi terkait
        // untuk ditampilkan sebagai ringkasan.
        $kegiatans = Kegiatan::withCount('absensis')->latest()->paginate(10);

        return view('admin.laporans.index', compact('kegiatans'));
    }

    /**
     * Menampilkan detail laporan absensi untuk satu kegiatan spesifik.
     * Menggunakan Route Model Binding.
     */
    public function show(Kegiatan $kegiatan): View
    {
        // Menggunakan eager loading untuk mengambil data absensi
        // beserta data pengguna yang terkait untuk menghindari N+1 problem.
        $kegiatan->load('absensis.user');

        return view('admin.laporans.show', compact('kegiatan'));
    }
}
