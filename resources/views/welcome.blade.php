@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="jumbotron text-center">
                <h1 class="display-4">Aplikasi Absensi LDK</h1>
                <p class="lead">Sistem manajemen kehadiran untuk kegiatan Lembaga Dakwah Kampus.</p>
                <hr class="my-4">
                <p>Silakan masuk untuk melanjutkan atau mendaftar jika Anda anggota baru.</p>
                <a class="btn btn-primary btn-lg" href="{{ route('login') }}" role="button">Login</a>
                <a class="btn btn-secondary btn-lg" href="{{ route('register') }}" role="button">Register</a>
            </div>
        </div>
    </div>
</div>
@endsection
