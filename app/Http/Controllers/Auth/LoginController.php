<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request; // <-- Butuh ini
use Illuminate\Support\Facades\Auth; // <-- Butuh ini

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
     * [MESIN BARU KITA]
     * Meng-handle proses login secara manual.
     */
    public function login(Request $request)
    {
        // 1. Validasi input dari form
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        // 2. Coba untuk login
        if (Auth::attempt($credentials)) {
            // Jika berhasil login...
            $request->session()->regenerate();

            // 3. Ambil role user
            $user = Auth::user();

            // 4. Redirect paksa berdasarkan role
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
                    // Jika role aneh, logout dan kembali ke login
                    Auth::logout();
                    return redirect('/login')->withErrors(['email' => 'Role tidak valid.']);
            }
        }

        // 5. Jika email atau password salah
        return back()->withErrors([
            'email' => 'Email atau Password yang Anda masukkan salah.',
        ])->onlyInput('email');
    }

    /**
     * Meng-handle proses logout.
     */
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/');
    }
}
