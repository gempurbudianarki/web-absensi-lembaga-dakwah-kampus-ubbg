{{-- [MODIFIKASI KITA] Menggunakan layout admin yang baru dengan sidebar --}}
@extends('layouts.admin')

@section('content')
    <h1 class="mt-4">Laporan Kehadiran</h1>
    <p>Pilih kegiatan di bawah ini untuk melihat detail laporan kehadiran.</p>

    <div class="card mb-4">
        <div class="card-header">
            <i class="fas fa-chart-bar me-1"></i>
            Pilih Kegiatan
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-striped table-bordered">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Nama Kegiatan</th>
                            <th>Tanggal</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($kegiatans as $kegiatan)
                            <tr>
                                <th>{{ $loop->iteration }}</th>
                                <td>{{ $kegiatan->nama_kegiatan }}</td>
                                <td>{{ \Carbon\Carbon::parse($kegiatan->tanggal_kegiatan)->format('d F Y') }}</td>
                                <td>
                                    <a href="{{ route('admin.laporans.show', $kegiatan->id) }}" class="btn btn-sm btn-info">Lihat Laporan</a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="text-center">Belum ada data kegiatan untuk ditampilkan.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
