<?php

/**
 * File ini akan berisi semua fungsi pembantu (helper functions)
 * untuk aplikasi kita. Fungsi yang didefinisikan di sini akan
 * tersedia secara global di seluruh aplikasi.
 */

if (!function_exists('nav_item')) {
    /**
     * Membuat item navigasi HTML untuk sidebar dengan state aktif.
     *
     * @param string|array $routes Nama rute atau array nama rute yang dianggap aktif.
     * @param string $icon Kelas ikon dari Font Awesome (e.g., 'fa-tachometer-alt').
     * @param string $text Teks yang akan ditampilkan pada menu.
     * @return string Mengembalikan string HTML untuk list item navigasi.
     */
    function nav_item($routes, $icon, $text)
    {
        // Pastikan $routes selalu dalam bentuk array agar mudah diproses
        if (!is_array($routes)) {
            $routes = [$routes];
        }

        $isActive = false;
        // Periksa apakah rute yang sedang diakses saat ini cocok dengan salah satu rute di dalam array
        foreach ($routes as $route) {
            if (request()->routeIs($route)) {
                $isActive = true;
                break; // Hentikan loop jika sudah ditemukan yang cocok
            }
        }
        
        // Tentukan kelas CSS berdasarkan status aktif atau tidak
        $activeClass = $isActive ? 'active bg-primary text-white' : 'text-white-50';
        $iconClass = $isActive ? 'text-white' : 'text-white-50';
        // Ambil URL dari nama rute pertama di dalam array
        $link = route($routes[0]);

        // Kembalikan string HTML lengkap untuk item menu
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
