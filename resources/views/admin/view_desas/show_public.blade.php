<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $viewDesa->nama }} - Detail Potret Desa</title>
    
    {{-- Memuat CSS dan JS utama aplikasi melalui Vite --}}
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    {{-- Memuat CSS eksternal (Font Awesome untuk ikon, Leaflet tidak diperlukan) --}}
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">

    {{-- GAYA KUSTOM INLINE (DIpertahankan dari template awal, disesuaikan untuk estetika) --}}
    <style>
        /* Variabel CSS harus didefinisikan di sini jika tidak ada di app.css/desa-medalsari.css */
        :root {
            --primary-color: #4CAF50; /* Hijau Utama (contoh) */
            --primary-color-dark: #388E3C; /* Hijau Lebih Gelap */
            --text-color: #333333; /* Warna teks gelap */
            --secondary-text-color: #555555; /* Warna teks sekunder */
            --background-color: #F8F9FA; /* Latar belakang terang */
            --card-background-color: #FFFFFF; /* Latar belakang card */
            --border-color: #E0E0E0; /* Warna border */
            --accent-color: #FFC107; /* Warna aksen (kategori) - mungkin tidak dipakai lagi di sini */
            --button-color-dark: #212529; /* Warna tombol gelap, untuk kontras di light mode */
            --button-text-color-light: #FFFFFF; /* Warna teks tombol terang */
        }

        /* Dark mode overrides */
        body.dark-mode {
            --primary-color: #66BB6A;
            --primary-color-dark: #4CAF50;
            --text-color: #E0E0E0;
            --secondary-text-color: #A0AEC0;
            --background-color: #1A202C;
            --card-background-color: #2D3748;
            --border-color: #4A5568;
            --accent-color: #FFD54F;
            --button-color-dark: #4A5568;
            --button-text-color-light: #E0E0E0;
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
            box-shadow: 0 8px 30px rgba(0, 0, 0, 0.15); /* Shadow lebih menonjol */
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
            max-height: 450px; /* Sedikit lebih tinggi */
            object-fit: cover;
            border-radius: 12px; /* Lebih rounded */
            margin-bottom: 30px; /* Jarak lebih banyak */
            box-shadow: 0 6px 20px rgba(0, 0, 0, 0.1); /* Shadow pada gambar */
        }
        .detail-title {
            font-size: 2.8em; /* Lebih besar */
            color: var(--primary-color);
            margin-bottom: 25px; /* Jarak lebih banyak */
            font-weight: 700; /* Lebih tebal */
        }
        /* .detail-category { DIHAPUS } */
        
        .detail-description {
            font-size: 1.1em;
            line-height: 1.8;
            color: var(--text-color);
            text-align: left;
            margin-bottom: 40px; /* Jarak lebih banyak */
            background-color: var(--background-color); /* Background untuk blok deskripsi */
            padding: 25px; /* Padding untuk deskripsi */
            border-radius: 10px; /* Rounded corners */
            box-shadow: inset 0 2px 5px rgba(0,0,0,0.05); /* Shadow internal */
        }

        /* --- Kontak (akan dihapus dari HTML, gaya tetap ada jika di tempat lain) --- */
        .detail-contact-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
            gap: 20px;
            margin-top: 20px;
            margin-bottom: 30px;
            justify-content: center;
        }
        @media (max-width: 600px) {
            .detail-contact-grid {
                grid-template-columns: 1fr;
            }
        }
        .detail-contact-item {
            background-color: var(--background-color);
            padding: 15px 20px;
            border-radius: 12px;
            font-size: 1em;
            color: var(--secondary-text-color);
            display: flex;
            align-items: center;
            gap: 12px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.08);
            transition: transform 0.2s ease, box-shadow 0.2s ease;
            text-align: left;
        }
        .detail-contact-item:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.15);
        }
        .detail-contact-item strong {
            color: var(--primary-color);
            font-size: 1.1em;
            white-space: nowrap;
        }
        .detail-contact-item i {
            font-size: 1.3em;
            color: var(--primary-color);
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

        /* Gaya untuk Peta di Halaman Detail (dihapus dari HTML) */
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

        /* Gaya tambahan untuk peta di dalam card (umkm-map) */
        .umkm-map {
            height: 150px;
            width: 100%;
            border-radius: 0 0 15px 15px;
            border-top: 1px solid #eee;
            margin-top: auto;
            z-index: 1;
            background-color: #e0e0e0;
        }
        .umkm-content {
            padding-bottom: 0;
            display: flex;
            flex-direction: column;
            flex-grow: 1;
        }
        .umkm-card {
            display: flex;
            flex-direction: column;
            overflow: hidden;
        }
        /* Pastikan ada ruang untuk peta di bawah info kontak di dalam card */
        .umkm-contact {
            margin-bottom: 10px;
        }

        /* Gaya untuk Horizontal Scrolling Cards */
        .umkm-grid, .potret-desa-grid {
            display: flex;
            flex-wrap: nowrap;
            overflow-x: auto;
            -webkit-overflow-scrolling: touch;
            gap: 2.5rem;
            margin-top: 4rem;
            padding-bottom: 15px;
            scroll-snap-type: x mandatory;
        }

        /* Mengatur ukuran kartu di dalam flex container */
        .umkm-grid .umkm-card-link,
        .potret-desa-grid .potret-desa-card-link {
            flex: 0 0 auto;
            width: 320px;
            scroll-snap-align: start;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        /* Mengatur ulang gaya untuk satu item jika hanya ada satu (opsional) */
        .single-item-grid .umkm-card-link,
        .single-item-grid .potret-desa-card-link {
            width: 100%;
            max-width: 400px;
            margin: 0 auto;
            scroll-snap-align: none;
        }

        /* PENTING: Gaya untuk Potret Desa (Gambar Saja) - Pastikan ini ada */
        .potret-desa-card-link {
            width: 300px; /* Atur lebar khusus untuk kartu potret desa */
        }

        .potret-desa-card {
            background-color: var(--card-background-color);
            border-radius: 18px;
            overflow: hidden;
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.1);
            position: relative;
            height: 300px; /* Fixed height for a square aesthetic */
            width: 100%;
            display: flex;
            justify-content: center;
            align-items: center;
            transition: all 0.3s ease;
        }
        .potret-desa-card:hover {
            transform: translateY(-8px);
            box-shadow: 0 15px 40px rgba(0, 0, 0, 0.2);
        }
        .potret-desa-card img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            display: block;
            transition: transform 0.4s ease;
        }
        .potret-desa-card:hover img {
            transform: scale(1.08);
        }
        
        /* --- DIHAPUS: Gaya Scrollbar Kustom (agar kembali default) --- */
        /*
        .umkm-grid::-webkit-scrollbar,
        .potret-desa-grid::-webkit-scrollbar {
            display: none;
            width: 0;
            height: 0;
        }
        .umkm-grid, .potret-desa-grid {
            scrollbar-width: none;
            -ms-overflow-style: none;
        }
        */
    </style>
</head>
<body class="light-mode">
    {{-- Memanggil komponen header --}}
    <x-header/>

    <div class="detail-container">
        @if($viewDesa->gambar)
            <img src="{{ asset('storage/' . $viewDesa->gambar) }}" alt="{{ $viewDesa->nama }}" class="detail-image">
        @else
            <img src="{{ asset('images/default-viewdesa.jpg') }}" alt="Gambar Default Potret Desa" class="detail-image">
        @endif
        <h1 class="detail-title">{{ $viewDesa->nama }}</h1>
        {{-- DIHAPUS: div.detail-category --}}
        <p class="detail-description">{{ $viewDesa->deskripsi }}</p>

        {{-- DIHAPUS: detail-contact-grid --}}
        {{-- DIHAPUS: Peta Detail --}}

        {{-- Tombol Kembali ke Daftar Potret Desa --}}
        <a href="{{ url('/') }}#potret-desa" class="back-to-list-button">
            {{-- Ikon panah kiri (SVG inline) --}}
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-arrow-left">
                <line x1="19" y1="12" x2="5" y2="12"></line>
                <polyline points="12 19 5 12 12 5"></polyline>
            </svg>
            Kembali ke Potret Desa
        </a>
    </div>

    {{-- Memanggil komponen footer --}}
    <x-footer/>

    {{-- Script eksternal Leaflet JS (dihapus karena tidak ada peta) --}}
    {{-- <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script> --}}

    {{-- Stack untuk script peta (akan kosong karena tidak ada peta) --}}
    @stack('scripts')
</body>
</html>