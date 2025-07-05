<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    /**
     * Menampilkan halaman form login.
     */
    public function showLoginForm()
    {
        return view('auth.login');
    }

    /**
     * Meng-handle proses login secara manual.
     */
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();

            $user = Auth::user();

            switch ($user->role) {
                case 'admin':
                    return redirect()->intended('/admin/dashboard');
                case 'ketua':
                    return redirect()->intended('/ketua/dashboard');
                case 'pengurus':
                    return redirect()->intended('/pengurus/dashboard');
                case 'anggota':
                    return redirect()->intended('/anggota/dashboard');
                default:
                    Auth::logout();
                    return redirect('/login')->withErrors(['email' => 'Role tidak valid.']);
            }
        }

        return back()->withErrors([
            'email' => 'Email atau Password yang Anda masukkan salah.',
        ])->onlyInput('email');
    }

    /**
     * [MODIFIKASI KITA]
     * Meng-handle proses logout dan mengarahkan ke halaman login.
     */
    public function logout(Request $request)
    {
        // Lakukan proses logout standar
        Auth::logout();

        // Hancurkan session lama
        $request->session()->invalidate();

        // Buat ulang token keamanan
        $request->session()->regenerateToken();

        // Arahkan kembali ke halaman login
        return redirect('/login');
    }
}
