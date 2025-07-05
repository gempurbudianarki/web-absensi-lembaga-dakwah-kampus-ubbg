@extends('layouts.admin')

@push('styles')
<style>
    /* CSS Kustom untuk tampilan premium */
    .form-group label {
        font-weight: 600;
    }
    .password-group {
        position: relative;
    }
    .toggle-password {
        position: absolute;
        right: 10px;
        top: 70%;
        transform: translateY(-50%);
        cursor: pointer;
        color: #6e707e;
    }
    .strength-meter {
        height: 5px;
        background: #e9ecef;
        border-radius: 5px;
        margin-top: 5px;
    }
    .strength-meter div {
        height: 100%;
        width: 0;
        border-radius: 5px;
        transition: width 0.3s, background-color 0.3s;
    }
</style>
@endpush

@section('content')
<div class="container-fluid">
    <h1 class="h3 mb-4 text-gray-800">Tambah Pengguna Baru</h1>

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">@foreach ($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul>
        </div>
    @endif

    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary"><i class="fas fa-user-plus mr-2"></i>Formulir Pengguna</h6>
        </div>
        <div class="card-body">
            <form action="{{ route('admin.users.store') }}" method="POST">
                @csrf
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="name">Nama Lengkap</label>
                            <input type="text" class="form-control" id="name" name="name" value="{{ old('name') }}" required>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="nim">NIM (Nomor Induk Mahasiswa)</label>
                            <input type="text" class="form-control" id="nim" name="nim" value="{{ old('nim') }}" required>
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <label for="email">Alamat Email</label>
                    <input type="email" class="form-control" id="email" name="email" value="{{ old('email') }}" required>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group password-group">
                            <label for="password">Password</label>
                            <input type="password" class="form-control" id="password" name="password" required>
                            <i class="fa fa-eye toggle-password" id="togglePassword"></i>
                            <div class="strength-meter"><div id="password-strength-bar"></div></div>
                            <small class="form-text text-muted">Minimal 8 karakter.</small>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="password_confirmation">Konfirmasi Password</label>
                            <input type="password" class="form-control" id="password_confirmation" name="password_confirmation" required>
                        </div>
                    </div>
                </div>

                <hr>

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="role">Role / Peran</label>
                            <select class="form-control" id="role" name="role" required>
                                <option value="">-- Pilih Role --</option>
                                <option value="admin" {{ old('role') == 'admin' ? 'selected' : '' }}>Admin</option>
                                <option value="ketua" {{ old('role') == 'ketua' ? 'selected' : '' }}>Ketua</option>
                                <option value="wakil ketua" {{ old('role') == 'wakil ketua' ? 'selected' : '' }}>Wakil Ketua</option>
                                <option value="sekretaris" {{ old('role') == 'sekretaris' ? 'selected' : '' }}>Sekretaris</option>
                                <option value="bendahara" {{ old('role') == 'bendahara' ? 'selected' : '' }}>Bendahara</option>
                                <option value="pengurus" {{ old('role') == 'pengurus' ? 'selected' : '' }}>Pengurus</option>
                                <option value="anggota" {{ old('role') == 'anggota' ? 'selected' : '' }}>Anggota</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-6">
                        {{-- Divisi ini akan muncul/hilang secara dinamis --}}
                        <div class="form-group" id="divisi-container" style="display: none;">
                            <label for="divisi_id">Divisi</label>
                            <select class="form-control" id="divisi_id" name="divisi_id">
                                <option value="">-- Pilih Divisi --</option>
                                @foreach($divisis as $divisi)
                                    <option value="{{ $divisi->id }}" {{ old('divisi_id') == $divisi->id ? 'selected' : '' }}>{{ $divisi->nama_divisi }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>

                <button type="submit" class="btn btn-primary btn-lg shadow-sm"><i class="fas fa-save mr-2"></i>Simpan Pengguna</button>
                <a href="{{ route('admin.users.index') }}" class="btn btn-secondary btn-lg shadow-sm">Batal</a>
            </form>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // FUNGSI UNTUK MENAMPILKAN/SEMBUNYIKAN DIVISI SECARA DINAMIS
    const roleSelect = document.getElementById('role');
    const divisiContainer = document.getElementById('divisi-container');
    const divisiSelect = document.getElementById('divisi_id');

    function toggleDivisi(selectedRole) {
        // Daftar role yang memerlukan divisi
        const rolesWithDivisi = ['pengurus', 'anggota'];
        
        if (rolesWithDivisi.includes(selectedRole)) {
            divisiContainer.style.display = 'block';
            divisiSelect.required = true;
        } else {
            divisiContainer.style.display = 'none';
            divisiSelect.required = false;
            divisiSelect.value = ''; // Reset pilihan divisi
        }
    }

    // Jalankan saat halaman dimuat
    toggleDivisi(roleSelect.value);

    // Jalankan setiap kali role diubah
    roleSelect.addEventListener('change', function() {
        toggleDivisi(this.value);
    });

    // FUNGSI UNTUK LIHAT/SEMBUNYIKAN PASSWORD
    const togglePassword = document.getElementById('togglePassword');
    const passwordInput = document.getElementById('password');

    togglePassword.addEventListener('click', function() {
        const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
        passwordInput.setAttribute('type', type);
        this.classList.toggle('fa-eye-slash');
    });

    // FUNGSI UNTUK INDIKATOR KEKUATAN PASSWORD
    const strengthBar = document.getElementById('password-strength-bar');

    passwordInput.addEventListener('input', function() {
        let score = 0;
        const value = passwordInput.value;
        if (value.length >= 8) score++;
        if (/[A-Z]/.test(value)) score++;
        if (/[0-9]/.test(value)) score++;
        if (/[^A-Za-z0-9]/.test(value)) score++;

        let width = (score / 4) * 100;
        let color = 'red';
        if (score >= 4) {
            color = 'green';
        } else if (score >= 2) {
            color = 'orange';
        }
        
        strengthBar.style.width = width + '%';
        strengthBar.style.backgroundColor = color;
    });
});
</script>
@endpush
