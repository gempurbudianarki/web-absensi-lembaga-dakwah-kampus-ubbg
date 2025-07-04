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
                    <strong>Dashboard Anggota</strong>
                </div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    {{-- Pesan Selamat Datang --}}
                    <p>Assalamu'alaikum, <strong>{{ Auth::user()->name }}</strong>!</p>
                    <p>Selamat datang di sistem absensi LDK.</p>
                    <hr>
                    <p>Fitur yang tersedia untuk Anda:</p>
                    <ul>
                        <li>Melihat Jadwal Kegiatan</li>
                        <li>Melakukan Absensi Mandiri</li>
                        <li>Melihat Rekap Kehadiran Pribadi</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
