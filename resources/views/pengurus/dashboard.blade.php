@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header"><strong>Dashboard Pengurus</strong></div>

                <div class="card-body">
                    <p>Assalamu'alaikum, <strong>{{ Auth::user()->name }}</strong>!</p>
                    <p>Anda telah berhasil login sebagai seorang <strong>Pengurus</strong>.</p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
