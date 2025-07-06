<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $wisataDesa->nama }} - Detail Wisata Desa</title>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <link rel="stylesheet" href="{{ asset('css/desa-medalsari.css') }}">

    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
    
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">

    <style>
        /* Variabel CSS harus didefinisikan di sini jika tidak ada di app.css/desa-medalsari.css
           Jika sudah ada di file CSS lain, ini bisa dihapus */
        :root {
            --primary-color: #4CAF50; /* Hijau Utama (contoh) */
            --primary-color-dark: #388E3C; /* Hijau Lebih Gelap */
            --text-color: #333333; /* Warna teks gelap */
            --secondary-text-color: #555555; /* Warna teks sekunder */
            --background-color: #F8F9FA; /* Latar belakang terang */
            --card-background-color: #FFFFFF; /* Latar belakang card */
            --border-color: #E0E0E0; /* Warna border */
            --accent-color: #FFC107; /* Warna aksen (kategori) */
            --button-color-dark: #212529; /* Warna tombol gelap, untuk kontras di light mode */
            --button-text-color-light: #FFFFFF; /* Warna teks tombol terang */
        }

        /* Dark mode overrides (pastikan terdefinisi di desa-medalsari.css atau app.css juga) */
        body.dark-mode {
            --primary-color: #66BB6A; /* Hijau Utama untuk Dark Mode */
            --primary-color-dark: #4CAF50; /* Hijau Lebih Gelap untuk Dark Mode */
            --text-color: #E0E0E0; /* Warna teks terang */
            --secondary-text-color: #A0AEC0; /* Warna teks sekunder terang */
            --background-color: #1A202C; /* Latar belakang gelap */
            --card-background-color: #2D3748; /* Latar belakang card gelap */
            --border-color: #4A5568; /* Warna border gelap */
            --accent-color: #FFD54F; /* Warna aksen untuk Dark Mode */
            --button-color-dark: #4A5568; /* Warna tombol gelap untuk dark mode */
            --button-text-color-light: #E0E0E0; /* Warna teks tombol gelap */
        }


        body {
            display: flex;
            flex-direction: column;
            min-height: 100vh;
        }

        .detail-container {
            max-width: 800px;
            margin: 50px auto;
            padding: 30px;
            background-color: var(--card-background-color);
            border-radius: 15px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
            text-align: center;
            flex-grow: 1;
            padding-left: 15px;
            padding-right: 15px;
        }
        @media (max-width: 768px) {
            .detail-container {
                margin: 20px auto;
                padding: 15px;
            }
        }

        .detail-image {
            width: 100%;
            max-height: 400px;
            object-fit: cover;
            border-radius: 10px;
            margin-bottom: 25px;
        }
        .detail-title {
            font-size: 2.5em;
            color: var(--primary-color);
            margin-bottom: 15px;
        }
        .detail-category {
            font-size: 1.2em;
            color: var(--text-color);
            background-color: var(--accent-color);
            display: inline-block;
            padding: 8px 15px;
            border-radius: 20px;
            margin-bottom: 20px;
            font-weight: bold;
        }
        .detail-description {
            font-size: 1.1em;
            line-height: 1.8;
            color: var(--text-color);
            text-align: left;
            margin-bottom: 30px;
        }

        /* --- Perbaikan Styling Kontak --- */
        .detail-contact-grid { /* Ganti nama class dari .detail-contact menjadi .detail-contact-grid */
            display: grid; /* Menggunakan Grid Layout */
            grid-template-columns: repeat(auto-fit, minmax(280px, 1fr)); /* Auto-fit untuk responsif */
            gap: 20px; /* Jarak antar item */
            margin-top: 20px;
            margin-bottom: 30px;
            justify-content: center; /* Memusatkan grid jika ada sisa ruang */
        }
        @media (max-width: 600px) {
            .detail-contact-grid {
                grid-template-columns: 1fr; /* Di layar kecil, jadi satu kolom */
            }
        }

        .detail-contact-item {
            background-color: var(--background-color);
            padding: 15px 20px; /* Perbesar padding */
            border-radius: 12px; /* Lebih rounded */
            font-size: 1em;
            color: var(--secondary-text-color);
            display: flex;
            align-items: center;
            gap: 12px; /* Jarak antara ikon dan teks */
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.08); /* Shadow yang lebih menonjol */
            transition: transform 0.2s ease, box-shadow 0.2s ease;
            text-align: left; /* Pastikan teks rata kiri di dalam item */
        }
        .detail-contact-item:hover {
            transform: translateY(-5px); /* Efek lift saat hover */
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.15); /* Shadow lebih kuat saat hover */
        }
        .detail-contact-item strong {
            color: var(--primary-color);
            font-size: 1.1em; /* Buat label lebih besar */
            white-space: nowrap; /* Cegah label patah baris */
        }
        /* Gaya untuk ikon (Font Awesome atau inline SVG) */
        .detail-contact-item i {
            font-size: 1.3em; /* Ukuran ikon */
            color: var(--primary-color); /* Warna ikon sesuai tema */
        }
        /* --- Akhir Perbaikan Styling Kontak --- */

        .back-to-list-button {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            margin-top: 30px;
            padding: 12px 25px;
            background-color: var(--primary-color);
            color: var(--button-text-color-light);
            border-radius: 8px;
            text-decoration: none;
            font-size: 1.1em;
            font-weight: 600;
            transition: background-color 0.3s ease, transform 0.2s ease, box-shadow 0.3s ease;
            border: none;
            cursor: pointer;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
        }
        .back-to-list-button:hover {
            background-color: var(--primary-color-dark);
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(0, 0, 0, 0.15);
        }
        .back-to-list-button:active {
            transform: translateY(0);
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }
        .back-to-list-button svg {
            width: 20px;
            height: 20px;
            fill: currentColor;
        }

        /* Gaya untuk Peta di Halaman Detail */
        #detail-map {
            height: 350px;
            width: 100%;
            border-radius: 10px;
            border: 1px solid var(--border-color);
            margin-top: 30px;
            margin-bottom: 25px;
            background-color: #e0e0e0;
        }
        @media (max-width: 576px) {
            #detail-map {
                height: 250px;
            }
        }
        /* Styling untuk pesan jika peta tidak tersedia */
        .map-not-available {
            margin-top: 30px;
            padding: 20px;
            border: 1px dashed var(--border-color);
            border-radius: 8px;
            color: var(--secondary-text-color);
            text-align: center;
            background-color: var(--background-color);
        }
    </style>
</head>
<body class="light-mode">
    {{-- Memanggil komponen header --}}
    <x-header/>

    <div class="detail-container">
        @if($wisataDesa->gambar)
            <img src="{{ asset('storage/' . $wisataDesa->gambar) }}" alt="{{ $wisataDesa->nama }}" class="detail-image">
        @else
            <img src="{{ asset('images/default-wisata.jpg') }}" alt="Gambar Default Wisata" class="detail-image">
        @endif
        <h1 class="detail-title">{{ $wisataDesa->nama }}</h1>
        <div class="detail-category">{{ $wisataDesa->kategori ?? 'Tidak Berkategori' }}</div>
        <p class="detail-description">{{ $wisataDesa->deskripsi }}</p>

        {{-- Menggunakan class detail-contact-grid --}}
        <div class="detail-contact-grid">
            @if($wisataDesa->alamat)
                <div class="detail-contact-item">
                    <i class="fas fa-map-marker-alt"></i> <div><strong>Alamat:</strong> {{ $wisataDesa->alamat }}</div>
                </div>
            @endif
            @if($wisataDesa->kontak_telepon)
                <div class="detail-contact-item">
                    <i class="fas fa-phone"></i> <div><strong>Telepon:</strong> {{ $wisataDesa->kontak_telepon }}</div>
                </div>
            @endif
            @if($wisataDesa->kontak_email)
                <div class="detail-contact-item">
                    <i class="fas fa-envelope"></i> <div><strong>Email:</strong> {{ $wisataDesa->kontak_email }}</div>
                </div>
            @endif
        </div>

        {{-- Div untuk Peta Detail --}}
        @if($wisataDesa->latitude && $wisataDesa->longitude)
            <div id="detail-map"></div>
        @else
            <p class="map-not-available">Lokasi peta belum tersedia untuk wisata ini.</p>
        @endif

        {{-- Tombol Kembali ke Daftar Wisata yang diperbaiki --}}
        <a href="{{ url('/') }}#wisata" class="back-to-list-button">
            {{-- Ikon panah kiri (SVG inline) --}}
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-arrow-left">
                <line x1="19" y1="12" x2="5" y2="12"></line>
                <polyline points="12 19 5 12 12 5"></polyline>
            </svg>
            Kembali ke Daftar Wisata
        </a>
    </div>

    {{-- Memanggil komponen footer --}}
    <x-footer/>

    <script src="{{ asset('js/app.js') }}"></script>
    <script src="{{ asset('js/desa-medalsari.js') }}"></script>
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>

    {{-- Script untuk inisialisasi peta --}}
    @if($wisataDesa->latitude && $wisataDesa->longitude)
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                console.log("DOMContentLoaded terpicu untuk peta detail publik.");

                const latitude = parseFloat("{{ $wisataDesa->latitude }}");
                const longitude = parseFloat("{{ $wisataDesa->longitude }}");

                if (isNaN(latitude) || isNaN(longitude) || latitude < -90 || latitude > 90 || longitude < -180 || longitude > 180) {
                    console.error("Koordinat latitude atau longitude tidak valid untuk peta detail:", latitude, longitude);
                    document.getElementById('detail-map').innerHTML = '<p class="text-danger text-center">Koordinat lokasi tidak valid.</p>';
                    return;
                }

                const mapElement = document.getElementById('detail-map');
                if (mapElement) {
                    console.log("Elemen #detail-map ditemukan. Menginisialisasi peta.");

                    var map = L.map('detail-map').setView([latitude, longitude], 15); // Zoom level 15

                    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                        attribution: '© OpenStreetMap contributors'
                    }).addTo(map);

                    L.marker([latitude, longitude])
                        .addTo(map)
                        .bindPopup(`<b>{{ $wisataDesa->nama }}</b><br>{{ $wisataDesa->alamat ?? "Lokasi Wisata" }}`)
                        .openPopup();

                    map.invalidateSize(); // Penting untuk memastikan peta dirender dengan benar
                    console.log("Peta detail berhasil diinisialisasi pada", latitude, longitude);
                } else {
                    console.error("Elemen #detail-map tidak ditemukan. Peta tidak dapat diinisialisasi.");
                }
            });
        </script>
    @endif
</body>
</html>