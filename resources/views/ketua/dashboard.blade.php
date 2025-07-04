{{-- Kita memberitahu file ini untuk menggunakan template utama dari layouts/app.blade.php --}}
@extends('layouts.app')

{{-- Ini adalah bagian konten utama dari halaman --}}
@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    {{-- Judul Halaman --}}
                    <strong>Dashboard Ketua Umum</strong>
                </div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    {{-- Pesan Selamat Datang --}}
                    <p>Assalamu'alaikum, <strong>{{ Auth::user()->name }}</strong>!</p>
                    <p>Anda telah berhasil login sebagai seorang <strong>Ketua Umum</strong>.</p>
                    <hr>
                    <p>Dari halaman ini, Anda memiliki akses *read-only* untuk memantau kesehatan organisasi:</p>
                    <ul>
                        <li>Melihat Laporan dan Grafik Kehadiran Keseluruhan</li>
                        <li>Memantau Tren Keaktifan Anggota</li>
                        <li>Menerima Laporan Otomatis</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
