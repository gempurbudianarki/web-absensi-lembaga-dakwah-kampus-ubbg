<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    /**
     * Menampilkan halaman dashboard untuk admin.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        // Perintah ini berarti: "Tolong tampilkan file view yang ada di
        // resources/views/admin/dashboard.blade.php"
        return view('admin.dashboard');
    }
}
