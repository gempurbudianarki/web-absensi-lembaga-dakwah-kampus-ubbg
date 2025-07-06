<div class="sidebar p-3">
    <h4 class="text-center mb-4">
        <i class="fas fa-mosque me-2"></i>
        LDK Al-Kindi
    </h4>
    <ul class="nav flex-column">
        @php
            /**
             * SOLUSI FINAL: Kita definisikan fungsi helper langsung di sini.
             * Dengan membungkusnya dalam `if (!function_exists(...))`, kita memastikan
             * fungsi ini hanya akan dibuat sekali, sehingga aman dari error 'Cannot redeclare'.
             * Ini adalah cara paling stabil untuk situasi kita saat ini.
             */
            if (!function_exists('nav_item')) {
                function nav_item($routes, $icon, $text) {
                    if (!is_array($routes)) { $routes = [$routes]; }
                    $isActive = false;
                    foreach ($routes as $route) {
                        if (request()->routeIs($route)) { $isActive = true; break; }
                    }
                    $activeClass = $isActive ? 'active bg-primary text-white' : 'text-white-50';
                    $iconClass = $isActive ? 'text-white' : 'text-white-50';
                    $link = route($routes[0]);
                    return <<<HTML
                        <li class="nav-item mb-2">
                            <a class="nav-link rounded d-flex align-items-center {$activeClass}" href="{$link}">
                                <i class="fas {$icon} fa-fw me-3 {$iconClass}"></i>
                                <span>{$text}</span>
                            </a>
                        </li>
                    HTML;
                }
            }
        @endphp

        {{-- 1. Dashboard --}}
        {!! nav_item('anggota.dashboard', 'fa-tachometer-alt', 'Dashboard') !!}

        {{-- 2. Agenda & Absensi --}}
        {!! nav_item('anggota.agenda.index', 'fa-calendar-check', 'Agenda & Absensi') !!}

        {{-- 3. Anggota LDK (Belum aktif) --}}
        <li class="nav-item mb-2">
            <a class="nav-link rounded d-flex align-items-center text-white-50" href="#">
                <i class="fas fa-users fa-fw me-3 text-white-50"></i>
                <span>Anggota LDK</span>
            </a>
        </li>

        {{-- 4. Profil Saya (Belum aktif) --}}
        <li class="nav-item mb-2">
            <a class="nav-link rounded d-flex align-items-center text-white-50" href="#">
                <i class="fas fa-user-cog fa-fw me-3 text-white-50"></i>
                <span>Profil Saya</span>
            </a>
        </li>

        <hr class="text-white-50">

        {{-- 5. Keluar --}}
        <li class="nav-item">
            <a class="nav-link text-white-50" href="{{ route('logout') }}"
               onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                <i class="fas fa-sign-out-alt fa-fw me-3"></i>
                <span>Keluar</span>
            </a>
            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                @csrf
            </form>
        </li>
    </ul>
</div>

<style>
    .sidebar .nav-link.active, .sidebar .nav-link:hover {
        background-color: #3498db !important;
        color: #fff !important;
    }
    .sidebar .nav-link.active i, .sidebar .nav-link:hover i {
        color: #fff !important;
    }
</style>
