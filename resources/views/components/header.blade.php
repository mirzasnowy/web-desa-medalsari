<header class="header">
    <nav class="nav">
        <div class="logo">
            <img src="{{ asset('photos/logo-kabupaten-karawang.png') }}" alt="Logo Kabupaten Karawang" class="header-logo-img">
            <span class="header-logo-text">Desa Medalsari</span>
        </div>
        <ul class="nav-links">
            <li><a href="#home">Beranda</a></li>

            {{-- Dropdown: Tentang Desa --}}
            <li class="dropdown">
                <a href="#" class="dropbtn">Tentang Desa <i class="fas fa-caret-down"></i></a>
                <div class="dropdown-content">
                    <a href="#visi-misi">Visi & Misi</a>
                    <a href="#batas-wilayah">Batas Wilayah</a>
                    <a href="#aparatur-desa">Aparatur Desa</a>
                </div>
            </li>

            {{-- Dropdown: Informasi --}}
            <li class="dropdown">
                <a href="#" class="dropbtn">Informasi <i class="fas fa-caret-down"></i></a>
                <div class="dropdown-content">
                    <a href="#berita-pengumuman">Berita & Pengumuman</a>
                    <a href="#kearifan-lokal">Kearifan Lokal</a>
                    <a href="#galeri-kegiatan">Galeri Kegiatan</a>
                </div>
            </li>

            {{-- Dropdown: Eksplorasi --}}
            <li class="dropdown">
                <a href="#" class="dropbtn">Eksplorasi <i class="fas fa-caret-down"></i></a>
                <div class="dropdown-content">
                    <a href="#wisata">Wisata Desa</a>
                    <a href="#umkm">UMKM</a>
                    <a href="#potret-desa">Potret Desa</a>
                </div>
            </li>
            
            <li><a href="#data-penduduk">Data Penduduk</a></li>
            <li><a href="#kontak-saran">Kontak</a></li>
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