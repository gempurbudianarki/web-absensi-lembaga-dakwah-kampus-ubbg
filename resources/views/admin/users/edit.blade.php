{{-- [MODIFIKASI KITA] Menggunakan layout admin yang baru dengan sidebar --}}
@extends('layouts.admin')

@section('content')
    <h1 class="mt-4">Edit Pengguna</h1>
    <p>Ubah data pengguna di formulir bawah ini.</p>

    <div class="card mb-4">
        <div class="card-header">
            <i class="fas fa-user-edit me-1"></i>
            Formulir Edit: {{ $user->name }}
        </div>
        <div class="card-body">
            <form action="{{ route('admin.users.update', $user->id) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="mb-3">
                    <label for="name" class="form-label">Nama Lengkap</label>
                    <input type="text" class="form-control" id="name" name="name" value="{{ $user->name }}" required>
                </div>

                <div class="mb-3">
                    <label for="nim" class="form-label">NIM (Nomor Induk Mahasiswa)</label>
                    <input type="text" class="form-control" id="nim" name="nim" value="{{ $user->nim }}" required>
                </div>

                <div class="mb-3">
                    <label for="email" class="form-label">Alamat Email</label>
                    <input type="email" class="form-control" id="email" name="email" value="{{ $user->email }}" required>
                </div>

                <div class="mb-3">
                    <label for="password" class="form-label">Password Baru</label>
                    <input type="password" class="form-control" id="password" name="password">
                    <div class="form-text">Kosongkan jika tidak ingin mengubah password.</div>
                </div>

                <div class="mb-3">
                    <label for="role" class="form-label">Role</label>
                    <select class="form-select" id="role" name="role" required>
                        <option value="anggota" @if($user->role == 'anggota') selected @endif>Anggota</option>
                        <option value="pengurus" @if($user->role == 'pengurus') selected @endif>Pengurus</option>
                        <option value="ketua" @if($user->role == 'ketua') selected @endif>Ketua</option>
                        <option value="admin" @if($user->role == 'admin') selected @endif>Admin</option>
                    </select>
                </div>

                <div class="mb-3">
                    <label for="divisi_id" class="form-label">Divisi</label>
                    <select class="form-select" id="divisi_id" name="divisi_id">
                        <option value="">-- Tidak ada divisi --</option>
                        @foreach ($divisis as $divisi)
                            <option value="{{ $divisi->id }}" @if($user->divisi_id == $divisi->id) selected @endif>{{ $divisi->nama_divisi }}</option>
                        @endforeach
                    </select>
                    <div class="form-text">Kosongkan jika role adalah Admin atau Ketua.</div>
                </div>

                <button type="submit" class="btn btn-primary">Update Pengguna</button>
                <a href="{{ route('admin.users.index') }}" class="btn btn-secondary">Batal</a>
            </form>
        </div>
    </div>
@endsection
