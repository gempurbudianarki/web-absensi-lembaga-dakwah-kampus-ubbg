@extends('layouts.admin')

@push('styles')
<style>
    /* CSS Kustom untuk tampilan premium */
    .user-avatar {
        width: 40px;
        height: 40px;
        border-radius: 50%;
        margin-right: 15px;
        object-fit: cover;
    }
    .table-hover tbody tr:hover {
        background-color: #f8f9fc;
    }
    .badge-role {
        font-size: 0.8rem;
        padding: 0.5em 0.75em;
        text-transform: capitalize;
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
            <h1 class="h3 mb-0 text-gray-800">Manajemen Pengguna</h1>
            <p class="text-muted mb-0">Di halaman ini Anda dapat mengatur semua akun pengguna sistem.</p>
        </div>
        <a href="{{ route('admin.users.create') }}" class="btn btn-primary shadow-sm">
            <i class="fas fa-user-plus fa-sm text-white-50 mr-2"></i>Tambahkan Pengguna Baru
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
     @if (session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            {{ session('error') }}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif

    <!-- Tabel Pengguna (Desain Baru) -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Daftar Semua Pengguna</h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover" id="dataTable" width="100%" cellspacing="0">
                    <thead class="thead-light">
                        <tr>
                            <th>#</th>
                            <th>Nama</th>
                            <th>NIM</th>
                            <th>Email</th>
                            <th class="text-center">Peran</th>
                            <th>Divisi</th>
                            <th class="text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($users as $user)
                            <tr>
                                <td>{{ $loop->iteration + $users->firstItem() - 1 }}</td>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <img src="https://ui-avatars.com/api/?name={{ urlencode($user->name) }}&background=random&color=fff" alt="{{ $user->name }}" class="user-avatar">
                                        <span class="font-weight-bold">{{ $user->name }}</span>
                                    </div>
                                </td>
                                <td>{{ $user->nim }}</td>
                                <td>{{ $user->email }}</td>
                                <td class="text-center">
                                    @php
                                        $roleClass = 'secondary'; // Warna default
                                        if ($user->role == 'admin') $roleClass = 'danger';
                                        if ($user->role == 'ketua') $roleClass = 'primary';
                                        if ($user->role == 'wakil ketua') $roleClass = 'info';
                                        if ($user->role == 'sekretaris' || $user->role == 'bendahara') $roleClass = 'warning';
                                        if ($user->role == 'pengurus') $roleClass = 'success';
                                        if ($user->role == 'anggota') $roleClass = 'dark';
                                    @endphp
                                    <span class="badge badge-pill badge-{{ $roleClass }} badge-role">{{ $user->role }}</span>
                                </td>
                                <td>{{ $user->divisi->nama_divisi ?? '-' }}</td>
                                <td class="text-center action-icons">
                                    <a href="{{ route('admin.users.edit', $user->id) }}" title="Edit Pengguna"><i class="fas fa-edit"></i></a>
                                    <form action="{{ route('admin.users.destroy', $user->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Apakah Anda yakin ingin menghapus pengguna ini?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" title="Hapus Pengguna"><i class="fas fa-trash-alt"></i></button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center py-5">
                                    <p class="text-muted">Belum ada pengguna yang ditambahkan.</p>
                                    <a href="{{ route('admin.users.create') }}" class="btn btn-primary">Buat Pengguna Pertama</a>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div class="d-flex justify-content-center mt-3">
                {{ $users->links() }}
            </div>
        </div>
    </div>
</div>
@endsection
