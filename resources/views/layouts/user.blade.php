<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'LDK UBBG') }} - Portal Anggota</title>

    <!-- Fonts & Icons -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css" />

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css">
    
    <!-- Custom CSS untuk tampilan modern -->
    <style>
        body {
            font-family: 'Inter', sans-serif;
            background-color: #f4f7f6;
        }
        #wrapper {
            display: flex;
            min-height: 100vh;
        }
        #sidebar-wrapper {
            min-height: 100vh;
            width: 250px;
            background-color: #1a252f;
            color: #adb5bd;
            transition: all 0.3s;
            position: fixed;
            height: 100%;
            overflow-y: auto;
        }
        .sidebar-heading {
            padding: 1.5rem 1.25rem;
            font-size: 1.2rem;
            font-weight: 700;
            color: #fff;
            border-bottom: 1px solid #343a40;
        }
        .list-group-item {
            background-color: #1a252f;
            color: #adb5bd;
            border: none;
            padding: 1rem 1.25rem;
            font-weight: 500;
            transition: background-color 0.2s, color 0.2s, border-left 0.2s;
            border-left: 4px solid transparent;
        }
        .list-group-item:hover {
            background-color: #2c3e50;
            color: #fff;
            text-decoration: none;
        }
        .list-group-item.active {
            background-color: #2c3e50;
            color: #fff;
            border-left: 4px solid #3498db;
        }
        .list-group-item i {
            margin-right: 10px;
            width: 20px; /* Agar ikon sejajar */
            text-align: center;
        }
        #page-content-wrapper {
            width: 100%;
            padding-left: 250px; /* Memberi ruang untuk sidebar */
        }
        .user-info {
            padding: 1rem;
            border-top: 1px solid #343a40;
        }
        .user-info img {
            width: 40px;
            height: 40px;
            border-radius: 50%;
        }
        .logout-form button {
            background: none;
            border: none;
            color: #adb5bd;
            padding: 1rem 1.25rem;
            width: 100%;
            text-align: left;
            font-weight: 500;
        }
        .logout-form button:hover {
            background-color: #c0392b;
            color: #fff;
        }
        .sidebar-menu {
            flex-grow: 1;
        }
    </style>
    @stack('styles')
</head>
<body>
    <div id="wrapper">
        <!-- Sidebar -->
        <div id="sidebar-wrapper" class="d-flex flex-column">
            <div>
                <div class="sidebar-heading">
                    <i class="fas fa-mosque"></i> LDK UBBG
                </div>
                <div class="list-group list-group-flush sidebar-menu">
                    <a href="{{ route('user.dashboard') }}" class="list-group-item list-group-item-action {{ request()->routeIs('user.dashboard') ? 'active' : '' }}">
                        <i class="fas fa-tachometer-alt fa-fw"></i>Dashboard
                    </a>
                    <a href="#" class="list-group-item list-group-item-action">
                        <i class="fas fa-calendar-check fa-fw"></i>Agenda & Absensi
                    </a>
                    <a href="#" class="list-group-item list-group-item-action">
                        <i class="fas fa-users fa-fw"></i>Anggota LDK
                    </a>
                    <a href="#" class="list-group-item list-group-item-action">
                        <i class="fas fa-user-cog fa-fw"></i>Profil Saya
                    </a>
                </div>
            </div>
            <div class="mt-auto">
                <div class="user-info">
                    <div class="d-flex align-items-center mb-2">
                         <img src="https://ui-avatars.com/api/?name={{ urlencode(Auth::user()->name) }}&background=3498db&color=fff" alt="Avatar">
                         <div class="ml-3">
                             <h6 class="font-weight-bold text-white mb-0" style="line-height: 1.2;">{{ Auth::user()->name }}</h6>
                             <small class="text-muted text-capitalize">{{ Auth::user()->role }}</small>
                         </div>
                    </div>
                </div>
                 <form class="logout-form" action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button type="submit"><i class="fas fa-sign-out-alt fa-fw"></i>Keluar</button>
                </form>
            </div>
        </div>
        <!-- /#sidebar-wrapper -->

        <!-- Page Content -->
        <div id="page-content-wrapper">
            <main class="container-fluid py-4">
                @yield('content')
            </main>
        </div>
        <!-- /#page-content-wrapper -->
    </div>

    <!-- Scripts -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>
    @stack('scripts')
</body>
</html>
