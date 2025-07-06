@extends('layouts.anggota')

@section('content')
<div class="container">
    {{-- Kartu Sambutan Personal --}}
    <div class="card shadow-sm border-0 mb-4">
        <div class="card-body p-4">
            <h4 class="card-title">Assalamu'alaikum, {{ Auth::user()->name }}!</h4>
            <p class="card-text text-muted">Selamat datang kembali di Portal Anggota LDK Al-Kindi. Mari bersama menebar kebaikan dan memperkuat ukhuwah di jalan dakwah.</p>
        </div>
    </div>

    {{-- Kartu Visi & Misi --}}
    <div class="card shadow-sm border-0">
        <div class="card-header bg-primary text-white">
            <h5 class="mb-0"><i class="fas fa-bullseye me-2"></i> Visi & Misi Lembaga Dakwah Kampus Al-Kindi</h5>
        </div>
        <div class="card-body p-4">
            <h5 class="fw-bold">Visi</h5>
            <p class="text-muted mb-4">
                Menjadi lembaga dakwah kampus yang profesional, inspiratif, dan mampu melahirkan generasi rabbani yang berkontribusi aktif bagi peradaban Islam.
            </p>

            <h5 class="fw-bold">Misi</h5>
            <ul class="list-group list-group-flush">
                <li class="list-group-item border-0 px-0">
                    <i class="fas fa-check-circle text-success me-2"></i>
                    Menyelenggarakan pembinaan keislaman yang komprehensif dan berkesinambungan bagi mahasiswa.
                </li>
                <li class="list-group-item border-0 px-0">
                    <i class="fas fa-check-circle text-success me-2"></i>
                    Mengoptimalkan syiar Islam di lingkungan kampus melalui kegiatan yang kreatif dan inovatif.
                </li>
                <li class="list-group-item border-0 px-0">
                    <i class="fas fa-check-circle text-success me-2"></i>
                    Membangun ukhuwah islamiyah yang kokoh antar anggota dan seluruh civitas akademika.
                </li>
                <li class="list-group-item border-0 px-0">
                    <i class="fas fa-check-circle text-success me-2"></i>
                    Menjalin kerjasama strategis dengan pihak internal dan eksternal kampus untuk memperluas jangkauan dakwah.
                </li>
            </ul>
        </div>
    </div>
</div>
@endsection
