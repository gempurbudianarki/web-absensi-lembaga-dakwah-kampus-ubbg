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
     * Memeriksa peran pengguna dan mengarahkannya ke dashboard yang sesuai.
     * Ini adalah pusat pengalihan (dispatcher) setelah login.
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function index()
    {
        $user = Auth::user();

        // Cek jika user punya peran
        if (empty($user->role)) {
             Auth::logout();
             return redirect('/login')->with('error', 'Peran Anda tidak terdefinisi. Hubungi Admin.');
        }

        // Arahkan berdasarkan peran
        switch ($user->role) {
            case 'admin':
                return redirect()->route('admin.dashboard');

            case 'ketua':
            case 'wakil ketua':
            case 'sekretaris':
            case 'bendahara':
            case 'pengurus':
            case 'anggota':
                return redirect()->route('anggota.dashboard');

            default:
                Auth::logout();
                return redirect('/login')->with('error', 'Peran tidak dikenali.');
        }
    }
}
