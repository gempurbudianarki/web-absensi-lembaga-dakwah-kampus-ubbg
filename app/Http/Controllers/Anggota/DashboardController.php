<?php

namespace App\Http\Controllers\Anggota;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    /**
     * Menampilkan halaman dashboard utama untuk anggota.
     * Halaman ini berisi Visi & Misi LDK.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        // Cukup kembalikan view. Data dinamis akan kita tambahkan nanti.
        return view('anggota.dashboard');
    }
}
