@extends('layouts.app')

@section('content')
<div class="container py-4">
    {{-- Header Sambutan --}}
    <div class="p-5 mb-4 bg-light rounded-3 shadow-sm">
        <div class="container-fluid py-3">
            <h1 class="display-5 fw-bold">Selamat Datang, {{ Auth::user()->name }}!</h1>
            <p class="col-md-8 fs-4">Jelajahi kegiatan LDK, lakukan absensi, dan tingkatkan keaktifanmu.</p>
        </div>
    </div>

    {{-- Notifikasi Sukses atau Error --}}
    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif
    @if (session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            {{ session('error') }}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif

    {{-- Daftar Kegiatan Tersedia --}}
    <div class="mb-5">
        <h2 class="pb-2 border-bottom">Kegiatan Tersedia</h2>
        <div class="row">
            @forelse ($kegiatansTersedia as $kegiatan)
                <div class="col-md-6 col-lg-4 mb-4">
                    <div class="card h-100 shadow-sm event-card">
                        {{-- MENAMPILKAN POSTER KEGIATAN --}}
                        <img src="{{ $kegiatan->poster ? asset('storage/' . $kegiatan->poster) : 'https://placehold.co/600x400/6c757d/FFFFFF?text=Poster' }}" class="card-img-top" alt="Poster {{ $kegiatan->nama_kegiatan }}">
                        <div class="card-body d-flex flex-column">
                            <h5 class="card-title">{{ $kegiatan->nama_kegiatan }}</h5>
                            <p class="card-text text-muted flex-grow-1">
                                <i class="fas fa-calendar-alt fa-fw mr-2"></i>{{ $kegiatan->tanggal->format('l, d F Y') }}<br>
                                <i class="fas fa-clock fa-fw mr-2"></i>{{ $kegiatan->waktu_mulai->format('H:i') }} - {{ $kegiatan->waktu_selesai->format('H:i') }} WIB<br>
                                <i class="fas fa-map-marker-alt fa-fw mr-2"></i>{{ $kegiatan->lokasi }}
                            </p>
                            <button class="btn btn-success mt-auto" 
                                    data-toggle="modal" 
                                    data-target="#absensiModal"
                                    data-kegiatan-id="{{ $kegiatan->id }}"
                                    data-kegiatan-nama="{{ $kegiatan->nama_kegiatan }}">
                                <i class="fas fa-check-circle mr-2"></i>Lakukan Absensi
                            </button>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col">
                    <div class="alert alert-info">Saat ini belum ada kegiatan yang tersedia.</div>
                </div>
            @endforelse
        </div>
    </div>

    {{-- Riwayat Absensi --}}
    <div class="mt-4">
        <h2 class="pb-2 border-bottom">Riwayat Absensi Saya</h2>
        <div class="table-responsive">
            <table class="table table-striped table-hover">
                <thead class="thead-light">
                    <tr>
                        <th>No</th>
                        <th>Nama Kegiatan</th>
                        <th>Tanggal Kegiatan</th>
                        <th>Waktu Absen</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($riwayatAbsensi as $absensi)
                        <tr>
                            <td>{{ $loop->iteration + $riwayatAbsensi->firstItem() - 1 }}</td>
                            <td>{{ $absensi->kegiatan->nama_kegiatan ?? 'Kegiatan tidak ditemukan' }}</td>
                            <td>{{ $absensi->kegiatan->tanggal->format('d F Y') ?? '-' }}</td>
                            <td>{{ $absensi->created_at->format('d F Y, H:i:s') }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="text-center">Anda belum pernah melakukan absensi.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
            <div class="d-flex justify-content-center">
                {{ $riwayatAbsensi->links() }}
            </div>
        </div>
    </div>
</div>

<!-- Modal Absensi (Tidak ada perubahan di sini, hanya memastikannya ada) -->
<div class="modal fade" id="absensiModal" tabindex="-1" role="dialog" aria-labelledby="absensiModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="absensiModalLabel">Form Absensi</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="{{ route('anggota.absensi.store') }}" method="POST">
                @csrf
                <div class="modal-body">
                    <p>Anda akan melakukan absensi untuk kegiatan: <strong id="namaKegiatanModal"></strong></p>
                    <input type="hidden" name="kegiatan_id" id="kegiatan_id">
                    <div class="form-group">
                        <label for="kode_absensi">Masukkan Kode Absensi</label>
                        <input type="text" class="form-control" id="kode_absensi" name="kode_absensi" placeholder="Ketik kode di sini..." required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">Kirim Absensi</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@push('scripts')
{{-- Script ini tetap sama, memastikan modal berfungsi --}}
<script>
$(document).ready(function() {
    $('#absensiModal').on('show.bs.modal', function (event) {
        var button = $(event.relatedTarget);
        var kegiatanId = button.data('kegiatan-id');
        var kegiatanNama = button.data('kegiatan-nama');
        var modal = $(this);
        modal.find('.modal-title').text('Form Absensi: ' + kegiatanNama);
        modal.find('#namaKegiatanModal').text(kegiatanNama);
        modal.find('#kegiatan_id').val(kegiatanId);
    });
});
</script>
@endpush
