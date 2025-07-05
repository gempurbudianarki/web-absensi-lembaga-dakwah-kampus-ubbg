@extends('layouts.admin')

@section('content')
<div class="container-fluid">
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <div>
            <h1 class="h3 mb-0 text-gray-800">Detail Laporan: {{ $kegiatan->nama_kegiatan }}</h1>
            <p class="mb-0 text-muted">{{ $kegiatan->tanggal->format('l, d F Y') }}</p>
        </div>
        <div>
            <a href="#" class="btn btn-primary">
                <i class="fas fa-download fa-sm text-white-50"></i> Ekspor ke Excel
            </a>
        </div>
    </div>

    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Daftar Kehadiran Peserta</h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Nama Peserta</th>
                            <th>NIM</th>
                            <th>Divisi</th>
                            <th>Waktu Absen</th>
                            <th class="text-center">Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($kegiatan->absensis as $absensi)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $absensi->user->name ?? 'Pengguna tidak ditemukan' }}</td>
                                <td>{{ $absensi->user->nim ?? '-' }}</td>
                                <td>{{ $absensi->user->divisi->nama_divisi ?? 'Umum' }}</td>
                                <td>{{ $absensi->created_at->format('H:i:s') }}</td>
                                <td class="text-center">
                                    {{-- Di masa depan, kita bisa menambahkan status lain seperti Izin atau Sakit --}}
                                    <span class="badge badge-success">Hadir</span>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center">Belum ada peserta yang melakukan absensi.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
