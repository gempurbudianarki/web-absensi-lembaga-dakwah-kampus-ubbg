@extends('layouts.app')

{{-- [MODIFIKASI KITA] Menambahkan Font, Ikon, dan CSS Kustom untuk tampilan premium --}}
@push('styles')
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />

<style>
    /* Mengganti font utama dan warna latar belakang untuk kesan bersih dan modern */
    body {
        background-color: #f8f9fa; /* Warna abu-abu yang sangat terang */
        font-family: 'Inter', sans-serif;
    }

    /* Banner sambutan dengan gradient biru yang elegan dan profesional */
    .welcome-banner {
        background: linear-gradient(135deg, #0d6efd, #0558d6);
        color: white;
        padding: 3rem 2rem;
        border-radius: 1rem;
        margin-bottom: 2.5rem;
    }
    .welcome-banner h1 {
        font-weight: 700;
        font-size: 2.5rem;
    }
    .welcome-banner p {
        font-size: 1.15rem;
        opacity: 0.9;
        max-width: 600px;
        margin-left: auto;
        margin-right: auto;
    }

    /* Judul seksi yang lebih tegas dan modern */
    .section-title {
        font-weight: 700;
        font-size: 1.75rem;
        margin-bottom: 1.5rem;
        color: #212529;
    }

    /* Desain kartu kegiatan yang mewah dengan efek hover */
    .kegiatan-card {
        border: none;
        border-radius: 0.75rem; /* Sedikit lebih tegas */
        box-shadow: 0 4px 6px rgba(0,0,0,0.04);
        transition: all 0.3s ease;
        overflow: hidden;
    }
    .kegiatan-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 12px 20px rgba(0,0,0,0.08);
    }

    /* Kontainer gambar dengan rasio aspek 16:9 */
    .kegiatan-card .card-img-container {
        position: relative;
        width: 100%;
        padding-top: 56.25%; /* 16:9 Aspect Ratio */
        background-color: #e9ecef;
    }
    .kegiatan-card .card-img-top {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        object-fit: cover;
    }
    
    .kegiatan-card .card-body {
        background-color: #ffffff;
        padding: 1.5rem;
    }
    .kegiatan-card .card-title {
        font-weight: 600;
        font-size: 1.1rem;
        color: #343a40;
    }
    .kegiatan-card .card-text .icon {
        color: #0d6efd;
    }

    /* Tombol absensi dengan gaya yang lebih premium */
    .btn-absen {
        font-weight: 600;
        padding: 0.75rem 1.5rem;
        border-radius: 0.5rem;
        transition: all 0.3s ease;
    }
    .btn-absen:hover {
        transform: scale(1.02);
    }
</style>
@endpush


@section('content')
<div class="container py-5">

    {{-- Notifikasi --}}
    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif
    @if (session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    {{-- Welcome Banner --}}
    <div class="welcome-banner text-center">
        <h1>Assalamu'alaikum, <strong>{{ Auth::user()->name }}</strong>!</h1>
        <p>Selamat datang di Portal Absensi LDK. Mari tingkatkan semangat dalam setiap kegiatan!</p>
    </div>

    {{-- Daftar Kegiatan --}}
    <h2 class="section-title">Jadwal Kegiatan</h2>
    <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-4">
        @forelse ($kegiatans as $kegiatan)
            <div class="col">
                <div class="kegiatan-card h-100 d-flex flex-column">
                    <div class="card-img-container">
                        @if ($kegiatan->poster)
                            <img src="{{ asset('storage/' . $kegiatan->poster) }}" class="card-img-top" alt="Poster {{ $kegiatan->nama_kegiatan }}">
                        @else
                            <img src="https://placehold.co/600x400/343a40/ffffff?text={{ urlencode($kegiatan->nama_kegiatan) }}" class="card-img-top" alt="Placeholder">
                        @endif
                    </div>
                    <div class="card-body d-flex flex-column">
                        <h5 class="card-title mb-2">{{ $kegiatan->nama_kegiatan }}</h5>
                        <p class="card-text text-muted mb-4">
                            <i class="fas fa-calendar-alt icon me-2"></i>{{ \Carbon\Carbon::parse($kegiatan->tanggal_kegiatan)->format('l, d F Y') }}
                        </p>
                        <a href="{{ route('anggota.absensi.show', $kegiatan->id) }}" class="btn btn-primary btn-absen mt-auto">
                            <i class="fas fa-sign-in-alt me-2"></i>Lakukan Absensi
                        </a>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-12">
                <div class="text-center py-5">
                    <i class="fas fa-info-circle fa-4x text-muted mb-3"></i>
                    <h4>Belum Ada Kegiatan</h4>
                    <p class="text-muted">Saat ini belum ada kegiatan yang dijadwalkan. Silakan cek kembali nanti.</p>
                </div>
            </div>
        @endforelse
    </div>
</div>
@endsection
