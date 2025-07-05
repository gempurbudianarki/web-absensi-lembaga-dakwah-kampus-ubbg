{{-- [MODIFIKASI KITA] Menggunakan layout admin yang baru dengan sidebar --}}
@extends('layouts.admin')

@section('content')
    <h1 class="mt-4">Detail Laporan Kehadiran</h1>
    <p>Kegiatan: <strong>{{ $kegiatan->nama_kegiatan }}</strong></p>

    <div class="card mb-4">
        <div class="card-header">
            <i class="fas fa-table me-1"></i>
            Daftar Kehadiran
        </div>
        <div class="card-body">
            <p>
                <strong>Tanggal:</strong> {{ \Carbon\Carbon::parse($kegiatan->tanggal_kegiatan)->format('d F Y') }} <br>
                <strong>Total Peserta Hadir:</strong> {{ $kegiatan->absensi->count() }} orang
            </p>
            <hr>
            <div class="table-responsive">
                <table class="table table-striped table-bordered">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Nama Peserta</th>
                            <th>NIM</th>
                            <th>Divisi</th>
                            <th>Status</th>
                            <th>Waktu Absen</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($kegiatan->absensi as $absen)
                            <tr>
                                <th>{{ $loop->iteration }}</th>
                                <td>{{ $absen->user->name ?? 'Data User Dihapus' }}</td>
                                <td>{{ $absen->user->nim ?? '-' }}</td>
                                <td>{{ $absen->user->divisi->nama_divisi ?? '-' }}</td>
                                <td>
                                    <span class="badge bg-primary">{{ $absen->status }}</span>
                                </td>
                                <td>
                                    {{ \Carbon\Carbon::parse($absen->created_at)->format('H:i:s') }} WIB
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center">Belum ada data kehadiran untuk kegiatan ini.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <a href="{{ route('admin.laporans.index') }}" class="btn btn-secondary mt-3">Kembali ke Daftar Laporan</a>
        </div>
    </div>
@endsection
