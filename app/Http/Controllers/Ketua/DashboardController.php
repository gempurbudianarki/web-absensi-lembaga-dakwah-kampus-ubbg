<?php

namespace App\Http\Controllers\Ketua;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    /**
     * Menampilkan halaman dashboard untuk ketua.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        // Perintah ini berarti: "Tolong tampilkan file view yang ada di
        // resources/views/ketua/dashboard.blade.php"
        return view('ketua.dashboard');
    }
}
