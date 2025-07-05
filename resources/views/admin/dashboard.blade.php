{{-- [MODIFIKASI KITA] Menggunakan layout admin yang baru dengan sidebar --}}
@extends('layouts.admin')

{{-- Bagian ini akan disuntikkan ke dalam @yield('content') di layout admin --}}
@section('content')
    <h1 class="mt-4">Dashboard</h1>
    <p>Selamat datang di Panel Kontrol Admin LDK Absensi.</p>

    <div class="card">
        <div class="card-header">
            <strong>Status Aplikasi</strong>
        </div>
        <div class="card-body">
            <p>Selamat datang, <strong>{{ Auth::user()->name }}</strong>!</p>
            <p>Anda telah berhasil login sebagai seorang <strong>Admin</strong>.</p>
            <p>Gunakan menu navigasi di sebelah kiri untuk mengelola aplikasi.</p>
        </div>
    </div>
@endsection
