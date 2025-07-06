{{-- 
    File ini adalah Tampilan (View) untuk Komponen NavItem kita.
    File ini HANYA berisi HTML. Semua logika (seperti $isActive, $link, dll)
    sudah dihitung di dalam Class NavItem.php dan dikirim ke sini.
    Ini adalah cara yang bersih dan stabil.
--}}
<li class="nav-item mb-2">
    <a {{ $attributes->merge(['class' => "nav-link rounded d-flex align-items-center {$activeClass}"]) }} href="{{ $link }}">
        <i class="fas {{ $icon }} fa-fw me-3 {{ $iconClass }}"></i>
        <span>{{ $text }}</span>
    </a>
</li>
