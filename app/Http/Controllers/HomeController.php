<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        // Ambil pengguna yang sedang login
        $user = Auth::user();

        // Cek peran pengguna
        if ($user->role == 'admin') {
            // Jika admin, arahkan ke dashboard admin
            return redirect()->route('admin.dashboard');
        }

        // Untuk SEMUA peran lainnya (ketua, pengurus, anggota, dll)
        // Arahkan ke dashboard portal pengguna yang baru
        return redirect()->route('user.dashboard');
    }
}
