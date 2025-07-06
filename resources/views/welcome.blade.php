<?php use Illuminate\Support\Str; ?> {{-- Tambahkan ini di bagian paling atas file --}}
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Desa Medalsari - Portal Informasi & UMKM</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
    <style>
        /* Gaya tambahan untuk peta di dalam card */
        .umkm-map {
            height: 150px; /* Ukuran peta yang lebih kecil */
            width: 100%;
            border-radius: 0 0 15px 15px; /* Sesuaikan border radius dengan card */
            border-top: 1px solid #eee; /* Garis pemisah dari konten lain di card */
            margin-top: 10px; /* Jarak dari deskripsi */
            z-index: 1; /* Pastikan peta muncul di atas elemen lain jika ada masalah z-index */
        }
        .umkm-content {
            padding-bottom: 0; /* Sesuaikan padding agar peta pas */
            display: flex; /* Untuk flexbox layout di dalam content */
            flex-direction: column; /* Mengatur item dalam kolom */
            flex-grow: 1; /* Memastikan konten mengisi ruang yang tersedia */
        }
        .umkm-card {
            display: flex;
            flex-direction: column;
            overflow: hidden; /* Penting untuk border-radius */
        }
        /* Pastikan ada ruang untuk peta di bawah info kontak di dalam card */
        .umkm-contact {
            margin-bottom: 10px; /* Beri sedikit ruang antara kontak dan peta */
        }
    </style>
</head>
<body class="light-mode">

    {{-- Memanggil komponen header --}}
    <x-header/>

    <section id="home" class="hero">
        <video autoplay loop muted playsinline class="background-video">
            <source src="{{ asset('videos/video-desa.MP4') }}" type="video/mp4">
            Browser Anda tidak mendukung tag video.
        </video>
        <div class="hero-content">
            <h1>Selamat Datang di Desa Medalsari</h1>
            <p>Desa modern dengan tradisi yang kuat, mendukung pertumbuhan UMKM dan kesejahteraan masyarakat</p>
            <a href="#wisata" class="cta-button">Jelajahi Wisata Kami</a>
        </div>
    </section>

    <section id="wisata" class="section">
        <h2 class="section-title fade-in">Wisata Desa</h2>
        <div class="umkm-grid @if(count($wisataDesas) == 1) single-item-grid @endif">
            @forelse($wisataDesas as $wisata)
                {{-- Bungkus card dengan tag <a> yang mengarah ke rute detail --}}
                <a href="{{ route('wisata_desas.show_public', $wisata) }}" class="umkm-card-link">
                    <div class="umkm-card fade-in">
                        <div class="umkm-image">
                            @if($wisata->gambar)
                                <img src="{{ asset('storage/' . $wisata->gambar) }}" alt="{{ $wisata->nama }}" style="width: 100%; height: 100%; object-fit: cover; border-radius: 15px 15px 0 0;">
                            @else
                                <img src="{{ asset('images/default-wisata.jpg') }}" alt="Gambar Default Wisata" style="width: 100%; height: 100%; object-fit: cover; border-radius: 15px 15px 0 0;">
                            @endif
                        </div>
                        <div class="umkm-content">
                            <h3>{{ $wisata->nama }}</h3>
                            <div class="umkm-category">{{ $wisata->kategori ?? '-' }}</div>
                            {{-- Batasi deskripsi agar tidak terlalu panjang di preview --}}
                            <p>{{ Str::limit($wisata->deskripsi, 100) }}</p>
                            <div class="umkm-contact">
                                <div class="contact-item">📍 {{ $wisata->alamat ?? '-' }}</div>
                                {{-- <div class="contact-item">📞 {{ $wisata->kontak_telepon ?? '-' }}</div> --}}
                                {{-- <div class="contact-item">📧 {{ $wisata->kontak_email ?? '-' }}</div> --}}
                            </div>

                            {{-- Div untuk Peta di dalam Card (Wisata Desa) --}}
                            @if($wisata->latitude && $wisata->longitude)
                                <div id="map-wisata-{{ $wisata->id }}" class="umkm-map"></div>
                                @push('scripts')
                                    <script>
                                        document.addEventListener('DOMContentLoaded', function() {
                                            const mapId = 'map-wisata-{{ $wisata->id }}';
                                            const latitude = parseFloat('{{ $wisata->latitude }}');
                                            const longitude = parseFloat('{{ $wisata->longitude }}');

                                            // Hanya inisialisasi jika elemen peta ada
                                            if (document.getElementById(mapId) && !isNaN(latitude) && !isNaN(longitude)) {
                                                const smallMap = L.map(mapId, {
                                                    zoomControl: false, // Sembunyikan kontrol zoom
                                                    dragging: false,    // Nonaktifkan drag
                                                    touchZoom: false,   // Nonaktifkan zoom sentuh
                                                    doubleClickZoom: false, // Nonaktifkan double click zoom
                                                    scrollWheelZoom: false, // Nonaktifkan scroll zoom
                                                    boxZoom: false,     // Nonaktifkan box zoom
                                                    keyboard: false,    // Nonaktifkan navigasi keyboard
                                                    tap: false,         // Nonaktifkan tap
                                                }).setView([latitude, longitude], 14); // Zoom level 14 untuk tampilan yang lebih dekat

                                                L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                                                    attribution: '© OpenStreetMap contributors',
                                                    maxZoom: 16, // Batasi zoom agar tidak terlalu dekat
                                                    minZoom: 10
                                                }).addTo(smallMap);

                                                L.marker([latitude, longitude], {
                                                    interactive: false // Nonaktifkan interaksi dengan marker
                                                }).addTo(smallMap);

                                                // Penting: Invalidate size setelah card dirender
                                                // Memberi sedikit waktu agar DOM card benar-benar stabil
                                                setTimeout(() => {
                                                    smallMap.invalidateSize();
                                                }, 100); 
                                                
                                            } else if (document.getElementById(mapId)) {
                                                console.warn(`Koordinat tidak valid untuk peta ID: ${mapId}`);
                                                document.getElementById(mapId).innerHTML = '<p style="text-align:center; padding-top: 20px; color:#777;">Koordinat tidak valid</p>';
                                            }
                                        });
                                    </script>
                                @endpush
                            @endif
                        </div>
                    </div>
                </a>
            @empty
                <div class="col-12 text-center">
                    <p>Belum ada data wisata desa yang tersedia.</p>
                </div>
            @endforelse
        </div>
    </section>

    <section id="statistik" class="stats section">
        <h2 class="section-title fade-in">Statistik Desa</h2>
        <div class="stats-grid">
            <div class="stat-item fade-in">
                <div class="stat-number" data-target="45">0</div>
                <div class="stat-label">UMKM Aktif</div>
            </div>
            <div class="stat-item fade-in">
                <div class="stat-number" data-target="650">0</div>
                <div class="stat-label">Kepala Keluarga</div>
            </div>
            <div class="stat-item fade-in">
                <div class="stat-number" data-target="15">0</div>
                <div class="stat-label">Produk Unggulan</div>
            </div>
            <div class="stat-item fade-in">
                <div class="stat-number" data-target="98">0</div>
                <div class="stat-label">% Tingkat Kepuasan</div>
            </div>
        </div>
    </section>

    <section id="umkm" class="section">
        <h2 class="section-title fade-in">UMKM Desa Medalsari</h2>
        <div class="umkm-grid">
            @foreach($umkms as $umkm)
                {{-- Bungkus card dengan tag <a> yang mengarah ke rute detail --}}
                <a href="{{ route('umkms.show_public', $umkm) }}" class="umkm-card-link">
                    <div class="umkm-card fade-in">
                        <div class="umkm-image">
                            @if($umkm->gambar)
                                <img src="{{ asset('storage/' . $umkm->gambar) }}" alt="{{ $umkm->nama }}" style="width: 100%; height: 100%; object-fit: cover; border-radius: 15px 15px 0 0;">
                            @else
                                <img src="{{ asset('images/default-umkm.jpg') }}" alt="Gambar Default UMKM" style="width: 100%; height: 100%; object-fit: cover; border-radius: 15px 15px 0 0;">
                            @endif
                        </div>
                        <div class="umkm-content">
                            <h3>{{ $umkm->nama }}</h3>
                            <div class="umkm-category">{{ $umkm->kategori }}</div>
                            {{-- Batasi deskripsi agar tidak terlalu panjang di preview --}}
                            <p>{{ Str::limit($umkm->deskripsi, 100) }}</p>
                            <div class="umkm-contact">
                                @if($umkm->alamat)
                                    <div class="contact-item">📍 {{ $umkm->alamat }}</div>
                                @endif
                                {{-- <div class="contact-item">📞 {{ $umkm->kontak_telepon ?? '-' }}</div> --}}
                                {{-- <div class="contact-item">📧 {{ $umkm->kontak_email ?? '-' }}</div> --}}
                                <div class="contact-item">💰 
                                    @if($umkm->harga)
                                        Rp {{ $umkm->harga }}
                                    @else
                                        -
                                    @endif
                                </div>
                            </div>
                            
                            {{-- Div untuk Peta di dalam Card (UMKM) --}}
                            @if($umkm->latitude && $umkm->longitude)
                                <div id="map-umkm-{{ $umkm->id }}" class="umkm-map"></div>
                                @push('scripts')
                                    <script>
                                        document.addEventListener('DOMContentLoaded', function() {
                                            const mapId = 'map-umkm-{{ $umkm->id }}';
                                            const latitude = parseFloat('{{ $umkm->latitude }}');
                                            const longitude = parseFloat('{{ $umkm->longitude }}');

                                            // Hanya inisialisasi jika elemen peta ada
                                            if (document.getElementById(mapId) && !isNaN(latitude) && !isNaN(longitude)) {
                                                const smallMap = L.map(mapId, {
                                                    zoomControl: false, // Sembunyikan kontrol zoom
                                                    dragging: false,    // Nonaktifkan drag
                                                    touchZoom: false,   // Nonaktifkan zoom sentuh
                                                    doubleClickZoom: false, // Nonaktifkan double click zoom
                                                    scrollWheelZoom: false, // Nonaktifkan scroll zoom
                                                    boxZoom: false,     // Nonaktifkan box zoom
                                                    keyboard: false,    // Nonaktifkan navigasi keyboard
                                                    tap: false,         // Nonaktifkan tap
                                                }).setView([latitude, longitude], 14); // Zoom level 14 untuk tampilan yang lebih dekat

                                                L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                                                    attribution: '© OpenStreetMap contributors',
                                                    maxZoom: 16, // Batasi zoom agar tidak terlalu dekat
                                                    minZoom: 10
                                                }).addTo(smallMap);

                                                L.marker([latitude, longitude], {
                                                    interactive: false // Nonaktifkan interaksi dengan marker
                                                }).addTo(smallMap);

                                                // Penting: Invalidate size setelah card dirender
                                                // Memberi sedikit waktu agar DOM card benar-benar stabil
                                                setTimeout(() => {
                                                    smallMap.invalidateSize();
                                                }, 100); 
                                                
                                            } else if (document.getElementById(mapId)) {
                                                console.warn(`Koordinat tidak valid untuk peta ID: ${mapId}`);
                                                document.getElementById(mapId).innerHTML = '<p style="text-align:center; padding-top: 20px; color:#777;">Koordinat tidak valid</p>';
                                            }
                                        });
                                    </script>
                                @endpush
                            @endif
                        </div>
                    </div>
                </a>
            @endforeach
        </div>
    </section>

    {{-- Memanggil komponen footer --}}
    <x-footer/>

    <script src="{{ asset('js/desa-medalsari.js') }}"></script>
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
    
    @stack('scripts') 
</body>
</html>