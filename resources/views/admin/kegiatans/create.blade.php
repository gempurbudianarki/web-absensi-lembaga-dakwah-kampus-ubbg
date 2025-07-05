{{-- [MODIFIKASI KITA] Menggunakan layout admin yang baru dengan sidebar --}}
@extends('layouts.admin')

@section('content')
    <h1 class="mt-4">Tambah Kegiatan Baru</h1>
    <p>Silakan isi formulir di bawah ini untuk membuat jadwal kegiatan baru.</p>

    <div class="card mb-4">
        <div class="card-header">
            <i class="fas fa-plus-circle me-1"></i>
            Formulir Kegiatan
        </div>
        <div class="card-body">
            <form action="{{ route('admin.kegiatans.store') }}" method="POST" enctype="multipart/form-data">
                @csrf

                <div class="mb-3">
                    <label for="nama_kegiatan" class="form-label">Nama Kegiatan</label>
                    <input type="text" class="form-control" id="nama_kegiatan" name="nama_kegiatan" required>
                </div>

                <div class="mb-3">
                    <label for="deskripsi" class="form-label">Deskripsi</label>
                    <textarea class="form-control" id="deskripsi" name="deskripsi" rows="3"></textarea>
                </div>

                <div class="mb-3">
                    <label for="poster" class="form-label">Poster Kegiatan</label>
                    <input class="form-control" type="file" id="poster" name="poster">
                    <div class="form-text">Opsional. Ukuran maksimal 2MB.</div>
                </div>

                <div class="mb-3">
                    <label for="tanggal_kegiatan" class="form-label">Tanggal Kegiatan</label>
                    <input type="date" class="form-control" id="tanggal_kegiatan" name="tanggal_kegiatan" required>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="waktu_mulai_absen" class="form-label">Waktu Buka Absen</label>
                            <input type="datetime-local" class="form-control" id="waktu_mulai_absen" name="waktu_mulai_absen" required>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="waktu_selesai_absen" class="form-label">Waktu Tutup Absen</label>
                            <input type="datetime-local" class="form-control" id="waktu_selesai_absen" name="waktu_selesai_absen" required>
                        </div>
                    </div>
                </div>

                <div class="mb-3">
                    <label for="kode_absensi" class="form-label">Kode Absensi</label>
                    <input type="text" class="form-control" id="kode_absensi" name="kode_absensi">
                    <div class="form-text">Boleh dikosongkan, sistem bisa generate otomatis nanti.</div>
                </div>

                <button type="submit" class="btn btn-primary">Simpan Kegiatan</button>
                <a href="{{ route('admin.kegiatans.index') }}" class="btn btn-secondary">Batal</a>
            </form>
        </div>
    </div>
@endsection
