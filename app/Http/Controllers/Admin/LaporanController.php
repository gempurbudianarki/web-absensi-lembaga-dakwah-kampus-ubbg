<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Kegiatan;
use Illuminate\Http\Request;

class LaporanController extends Controller
{
    /**
     * Menampilkan halaman utama laporan, berisi daftar kegiatan.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $kegiatans = Kegiatan::orderBy('tanggal_kegiatan', 'desc')->get();
        return view('admin.laporans.index', compact('kegiatans'));
    }

    /**
     * Menampilkan detail laporan untuk kegiatan tertentu.
     *
     * @param  \App\Models\Kegiatan  $kegiatan
     * @return \Illuminate\View\View
     */
    public function show(Kegiatan $kegiatan)
    {
        // [MODIFIKASI KITA]
        // Eager load relasi untuk efisiensi query.
        // Kita ambil kegiatan, beserta data absensinya,
        // dan untuk setiap absensi, kita ambil juga data user dan divisi user tersebut.
        $kegiatan->load('absensi.user.divisi');

        // Kirim data kegiatan yang sudah lengkap dengan data absensi ke view
        return view('admin.laporans.show', compact('kegiatan'));
    }
}
