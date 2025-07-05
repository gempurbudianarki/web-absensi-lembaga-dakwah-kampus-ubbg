@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            {{-- [MODIFIKASI KITA #1] Menambahkan notifikasi error --}}
            @if (session('error'))
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    {{ session('error') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            <div class="card">
                <div class="card-header">
                    <strong>Formulir Absensi</strong>
                </div>

                <div class="card-body">
                    <h5 class="card-title">{{ $kegiatan->nama_kegiatan }}</h5>
                    <p class="card-text"><small class="text-muted">{{ \Carbon\Carbon::parse($kegiatan->tanggal_kegiatan)->format('l, d F Y') }}</small></p>
                    <p>{{ $kegiatan->deskripsi }}</p>
                    <hr>

                    @if($sudahAbsen)
                        <div class="alert alert-success text-center">
                            <h4 class="alert-heading">Terima Kasih!</h4>
                            <p>Anda sudah berhasil melakukan absensi untuk kegiatan ini.</p>
                        </div>
                    
                    @else
                        @if($statusAbsen == 'DIBUKA')
                            <div class="alert alert-info">
                                Absensi sedang dibuka! Silakan masukkan kode untuk mencatat kehadiranmu.
                            </div>
                            {{-- [MODIFIKASI KITA #2] Mengarahkan form ke route yang benar --}}
                            <form action="{{ route('anggota.absensi.store') }}" method="POST">
                                @csrf
                                <input type="hidden" name="kegiatan_id" value="{{ $kegiatan->id }}">
                                <div class="mb-3">
                                    <label for="kode_absensi" class="form-label">Masukkan Kode Absensi</label>
                                    <input type="text" class="form-control" id="kode_absensi" name="kode_absensi" required autofocus>
                                </div>
                                <button type="submit" class="btn btn-primary w-100">Kirim Absen</button>
                            </form>

                        @elseif($statusAbsen == 'BELUM DIBUKA')
                            <div class="alert alert-warning text-center">
                                <h4 class="alert-heading">Absensi Belum Dibuka</h4>
                                <p>Absensi untuk kegiatan ini akan dibuka pada pukul <strong>{{ \Carbon\Carbon::parse($kegiatan->waktu_mulai_absen)->format('H:i') }} WIB</strong>.</p>
                            </div>

                        @else
                            <div class="alert alert-danger text-center">
                                <h4 class="alert-heading">Absensi Sudah Ditutup</h4>
                                <p>Maaf, waktu absensi untuk kegiatan ini telah berakhir.</p>
                            </div>
                        @endif
                    @endif

                    <hr>
                    <a href="{{ route('anggota.dashboard') }}" class="btn btn-secondary mt-3">Kembali ke Dashboard</a>

                </div>
            </div>
        </div>
    </div>
</div>
@endsection
