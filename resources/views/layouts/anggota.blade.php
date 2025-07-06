<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }} - Portal Anggota</title>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=Nunito" rel="stylesheet">

    <!-- Scripts & Styles dari Vite -->
    @vite(['resources/sass/app.scss', 'resources/js/app.js'])

    <!-- LIBRARY BARU: SweetAlert2 untuk notifikasi yang lebih baik -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <!-- Ini adalah 'slot' untuk CSS tambahan dari halaman lain -->
    @stack('styles')

    <style>
        /* Styling dasar untuk layout */
        body {
            background-color: #f4f7f6;
        }
        .sidebar {
            min-width: 250px;
            max-width: 250px;
            background: #2c3e50; /* Warna biru gelap */
            color: #fff;
            transition: all 0.3s;
            min-height: 100vh;
        }
        .content {
            width: 100%;
            padding: 20px;
            transition: all 0.3s;
        }
    </style>
</head>
<body>
    <div class="d-flex" id="wrapper">
        <!-- Sidebar -->
        @include('layouts.partials.anggota-sidebar')

        <!-- Page Content -->
        <div id="page-content-wrapper" class="w-100">
            
            @include('layouts.partials.anggota-header')

            <main class="container-fluid p-4">
                @yield('content')
            </main>
        </div>
    </div>

    <!-- Ini adalah 'slot' untuk JavaScript tambahan dari halaman lain -->
    @stack('scripts')
</body>
</html>
