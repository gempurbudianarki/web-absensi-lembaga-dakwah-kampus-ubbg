@extends('layouts.admin')

@push('styles')
<style>
    /* CSS Kustom untuk tampilan premium */
    .poster-thumbnail {
        width: 100px;
        height: 75px;
        object-fit: cover;
        border-radius: 0.35rem;
        transition: transform 0.2s ease-in-out;
    }
    .poster-thumbnail:hover {
        transform: scale(2.5);
        z-index: 10;
    }
    .table-hover tbody tr:hover {
        background-color: #f8f9fc;
    }
    .badge-status {
        font-size: 0.8rem;
        padding: 0.5em 0.75em;
    }
    .action-icons a, .action-icons button {
        color: #858796;
        transition: color 0.2s;
        border: none;
        background: none;
        padding: 0.375rem 0.75rem;
    }
    .action-icons a:hover {
        color: #4e73df;
    }
    .action-icons button:hover {
        color: #e74a3b;
    }
</style>
@endpush

@section('content')
<div class="container-fluid">

    <!-- Header Halaman -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <div>
            <h1 class="h3 mb-0 text-gray-800">Manajemen Kegiatan</h1>
            <p class="text-muted mb-0">Di halaman ini Anda dapat mengatur semua jadwal kegiatan LDK.</p>
        </div>
        <a href="{{ route('admin.kegiatans.create') }}" class="btn btn-primary shadow-sm">
            <i class="fas fa-plus fa-sm text-white-50 mr-2"></i>Tambah Kegiatan Baru
        </a>
    </div>

    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif

    <!-- Tabel Kegiatan (Desain Baru) -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Daftar Semua Kegiatan</h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover" id="dataTable" width="100%" cellspacing="0">
                    <thead class="thead-light">
                        <tr>
                            <th>#</th>
                            <th>Poster</th>
                            <th>Nama Kegiatan</th>
                            <th>Jadwal Acara</th>
                            <th class="text-center">Status</th>
                            <th class="text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($kegiatans as $kegiatan)
                            <tr>
                                <td>{{ $loop->iteration + $kegiatans->firstItem() - 1 }}</td>
                                <td>
                                    <img src="{{ $kegiatan->poster ? asset('storage/' . $kegiatan->poster) : 'https://placehold.co/100x75/6c757d/FFFFFF?text=N/A' }}"
                                         alt="Poster" class="poster-thumbnail">
                                </td>
                                <td>
                                    <span class="font-weight-bold">{{ $kegiatan->nama_kegiatan }}</span>
                                    <p class="small text-muted mb-0">{{ Str::limit($kegiatan->deskripsi, 50) }}</p>
                                </td>
                                <td>
                                    {{ $kegiatan->tanggal->format('d M Y') }}
                                    <br>
                                    <small class="text-muted">{{ $kegiatan->waktu_mulai->format('H:i') }} - {{ $kegiatan->waktu_selesai->format('H:i') }} WIB</small>
                                </td>
                                <td class="text-center">
                                    @switch($kegiatan->status)
                                        @case('Akan Datang')
                                            <span class="badge badge-pill badge-info badge-status">
                                                <i class="fas fa-hourglass-start mr-1"></i>Akan Datang
                                            </span>
                                            @break
                                        @case('Berlangsung')
                                            <span class="badge badge-pill badge-success badge-status">
                                                <i class="fas fa-running fa-beat mr-1"></i>Berlangsung
                                            </span>
                                            @break
                                        @case('Selesai')
                                            <span class="badge badge-pill badge-secondary badge-status">
                                                <i class="fas fa-check-double mr-1"></i>Selesai
                                            </span>
                                            @break
                                    @endswitch
                                </td>
                                <td class="text-center action-icons">
                                    <a href="#" class="text-success" title="Tampilkan QR Code"><i class="fas fa-qrcode"></i></a>
                                    <a href="{{ route('admin.kegiatans.edit', $kegiatan->id) }}" title="Edit Kegiatan"><i class="fas fa-pencil-alt"></i></a>
                                    <form action="{{ route('admin.kegiatans.destroy', $kegiatan->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Apakah Anda yakin ingin menghapus kegiatan ini?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" title="Hapus Kegiatan"><i class="fas fa-trash"></i></button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center py-5">
                                    <p class="text-muted">Belum ada kegiatan yang ditambahkan.</p>
                                    <a href="{{ route('admin.kegiatans.create') }}" class="btn btn-primary">Buat Kegiatan Pertama Anda</a>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div class="d-flex justify-content-center mt-3">
                {{ $kegiatans->links() }}
            </div>
        </div>
    </div>
</div>
@endsection
