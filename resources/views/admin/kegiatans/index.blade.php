{{-- [MODIFIKASI KITA] Menggunakan layout admin yang baru dengan sidebar --}}
@extends('layouts.admin')

@section('content')
    <h1 class="mt-4">Manajemen Kegiatan</h1>
    <p>Di halaman ini Anda dapat mengelola semua jadwal kegiatan LDK.</p>

    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="card mb-4">
        <div class="card-header">
            <div class="d-flex justify-content-between align-items-center">
                <span><i class="fas fa-calendar-alt me-1"></i> Daftar Semua Kegiatan</span>
                <a href="{{ route('admin.kegiatans.create') }}" class="btn btn-primary">Tambah Kegiatan Baru</a>
            </div>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-striped table-bordered align-middle">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Poster</th>
                            <th>Nama Kegiatan</th>
                            <th>Tanggal</th>
                            <th>Waktu Absen</th>
                            <th>Kode Absen</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($kegiatans as $kegiatan)
                            <tr>
                                <th>{{ $loop->iteration }}</th>
                                <td>
                                    @if ($kegiatan->poster)
                                        <img src="{{ asset('storage/' . $kegiatan->poster) }}" alt="Poster {{ $kegiatan->nama_kegiatan }}" width="100" class="img-thumbnail">
                                    @else
                                        <span class="text-muted">Tidak Ada</span>
                                    @endif
                                </td>
                                <td>{{ $kegiatan->nama_kegiatan }}</td>
                                <td>{{ \Carbon\Carbon::parse($kegiatan->tanggal_kegiatan)->format('d F Y') }}</td>
                                <td>
                                    {{ \Carbon\Carbon::parse($kegiatan->waktu_mulai_absen)->format('H:i') }} - {{ \Carbon\Carbon::parse($kegiatan->waktu_selesai_absen)->format('H:i') }}
                                </td>
                                <td>
                                    <span class="badge bg-success">{{ $kegiatan->kode_absensi ?? 'Belum Ada' }}</span>
                                </td>
                                <td class="d-flex flex-column">
                                    <a href="{{ route('admin.kegiatans.edit', $kegiatan->id) }}" class="btn btn-sm btn-warning mb-1">Edit</a>
                                    <form action="{{ route('admin.kegiatans.destroy', $kegiatan->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus kegiatan ini?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger w-100">Hapus</button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center">Belum ada data kegiatan.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
