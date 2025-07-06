<header class="header">
    <nav class="nav">
        <div class="logo">Desa Medalsari</div>
        <ul class="nav-links">
            <li><a href="{{ url('/') }}#home">Beranda</a></li>
            <li><a href="{{ url('/') }}#wisata">Wisata Desa</a></li>
            <li><a href="{{ url('/') }}#umkm">UMKM</a></li>
            <li><a href="{{ url('/') }}#statistik">Statistik</a></li>
            <li><a href="{{ url('/') }}#kontak">Kontak</a></li>
            <li class="nav-admin-item"><a href="{{ route('admin.login') }}" title="Login Admin">👤 Admin</a></li>
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