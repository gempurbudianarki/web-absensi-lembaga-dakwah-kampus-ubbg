<?php

namespace App\Http\Controllers\Anggota;

use App\Http\Controllers\Controller;
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
        // Perintah ini berarti: "Tolong tampilkan file view yang ada di
        // resources/views/anggota/dashboard.blade.php"
        return view('anggota.dashboard');
    }
}
