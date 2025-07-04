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
                    <strong>Dashboard Admin</strong>
                </div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    {{-- Pesan Selamat Datang --}}
                    <p>Selamat datang, <strong>{{ Auth::user()->name }}</strong>!</p>
                    <p>Anda telah berhasil login sebagai seorang <strong>Admin</strong>.</p>
                    <hr>
                    <p>Dari halaman ini, Anda akan bisa mengelola seluruh data aplikasi, termasuk:</p>
                    <ul>
                        <li>Manajemen Pengguna (Admin, Pengurus, Anggota)</li>
                        <li>Manajemen Kegiatan dan Jadwal Absensi</li>
                        <li>Melihat Laporan Kehadiran Lengkap</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
