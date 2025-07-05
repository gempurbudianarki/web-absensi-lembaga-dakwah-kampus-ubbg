{{-- [MODIFIKASI KITA] Menggunakan layout admin yang baru dengan sidebar --}}
@extends('layouts.admin')

@section('content')
    <h1 class="mt-4">Edit Kegiatan</h1>
    <p>Ubah data kegiatan di formulir bawah ini.</p>

    <div class="card mb-4">
        <div class="card-header">
            <i class="fas fa-edit me-1"></i>
            Formulir Edit: {{ $kegiatan->nama_kegiatan }}
        </div>
        <div class="card-body">
            <form action="{{ route('admin.kegiatans.update', $kegiatan->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div class="mb-3">
                    <label for="nama_kegiatan" class="form-label">Nama Kegiatan</label>
                    <input type="text" class="form-control" id="nama_kegiatan" name="nama_kegiatan" value="{{ $kegiatan->nama_kegiatan }}" required>
                </div>

                <div class="mb-3">
                    <label for="deskripsi" class="form-label">Deskripsi</label>
                    <textarea class="form-control" id="deskripsi" name="deskripsi" rows="3">{{ $kegiatan->deskripsi }}</textarea>
                </div>

                <div class="mb-3">
                    <label class="form-label">Poster Saat Ini</label>
                    <div>
                        @if ($kegiatan->poster)
                            <img src="{{ asset('storage/' . $kegiatan->poster) }}" alt="Poster {{ $kegiatan->nama_kegiatan }}" width="200" class="img-thumbnail">
                        @else
                            <span class="text-muted">Tidak ada poster.</span>
                        @endif
                    </div>
                </div>

                <div class="mb-3">
                    <label for="poster" class="form-label">Ganti Poster (Opsional)</label>
                    <input class="form-control" type="file" id="poster" name="poster">
                    <div class="form-text">Kosongkan jika tidak ingin mengganti poster. Ukuran maksimal 2MB.</div>
                </div>

                <div class="mb-3">
                    <label for="tanggal_kegiatan" class="form-label">Tanggal Kegiatan</label>
                    <input type="date" class="form-control" id="tanggal_kegiatan" name="tanggal_kegiatan" value="{{ $kegiatan->tanggal_kegiatan->format('Y-m-d') }}" required>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="waktu_mulai_absen" class="form-label">Waktu Buka Absen</label>
                            <input type="datetime-local" class="form-control" id="waktu_mulai_absen" name="waktu_mulai_absen" value="{{ $kegiatan->waktu_mulai_absen->format('Y-m-d\TH:i') }}" required>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="waktu_selesai_absen" class="form-label">Waktu Tutup Absen</label>
                            <input type="datetime-local" class="form-control" id="waktu_selesai_absen" name="waktu_selesai_absen" value="{{ $kegiatan->waktu_selesai_absen->format('Y-m-d\TH:i') }}" required>
                        </div>
                    </div>
                </div>

                <div class="mb-3">
                    <label for="kode_absensi" class="form-label">Kode Absensi</label>
                    <input type="text" class="form-control" id="kode_absensi" name="kode_absensi" value="{{ $kegiatan->kode_absensi }}">
                    <div class="form-text">Boleh dikosongkan, sistem bisa generate otomatis nanti.</div>
                </div>

                <button type="submit" class="btn btn-primary">Update Kegiatan</button>
                <a href="{{ route('admin.kegiatans.index') }}" class="btn btn-secondary">Batal</a>
            </form>
        </div>
    </div>
@endsection
