{{-- resources/views/components/header.blade.php --}}
<header class="header">
    <nav class="nav">
        <div class="logo">
            <img src="{{ asset('photos/logo-kabupaten-karawang.png') }}" alt="Logo Kabupaten Karawang" class="header-logo-img">
            <span class="header-logo-text">Desa Medalsari</span>
        </div>
        <ul class="nav-links">
            <li><a href="#home">Beranda</a></li>
            <li><a href="#wisata">Wisata Desa</a></li>
            <li><a href="#statistik">Statistik</a></li>
            <li><a href="#umkm">UMKM</a></li>
            <li><a href="#kontak">Kontak</a></li>
            <li class="nav-admin-item"><a href="{{ route('admin.login') }}" title="Login Admin">👤 Admin</a></li>
            {{-- Dark Mode Toggle Switch --}}
            <li>
                <label class="dark-mode-switch">
                    <input type="checkbox" id="darkModeToggle">
                    <span class="slider round">
                        <span class="light-icon">☀️</span>
                        <span class="dark-icon">🌙</span>
                    </span>
                </label>
            </li>
        </ul>
        <div class="mobile-menu" onclick="toggleMenu()">
            <span></span>
            <span></span>
            <span></span>
        </div>
    </nav>
</header>