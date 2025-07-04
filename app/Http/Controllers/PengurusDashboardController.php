<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PengurusDashboardController extends Controller
{
    /**
     * Menampilkan halaman dashboard untuk pengurus.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        // Pastikan ini mengarah ke view yang benar
        return view('pengurus.dashboard');
    }
}
