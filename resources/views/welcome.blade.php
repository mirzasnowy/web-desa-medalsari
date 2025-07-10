<?php use Illuminate\Support\Str; ?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Desa Medalsari - Portal Informasi & UMKM</title>

    {{-- Memuat CSS dan JS utama aplikasi melalui Vite --}}
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    {{-- Memuat CSS eksternal yang tidak dibundel oleh Vite --}}
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">

    {{-- GAYA KUSTOM INLINE --}}
    <style>
        /* Variabel CSS yang mungkin juga didefinisikan di desa-medalsari.css */
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

            /* NEW: Variabel untuk tinggi header dan running text */
            /* Sesuaikan nilai ini jika tinggi header atau running text Anda berbeda */
            --header-height: 60px; /* Estimasi tinggi komponen <x-header/> */
            --running-text-height: 40px; /* Estimasi tinggi div running-text (padding 10px atas/bawah + font size) */
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

        /* NEW: Pastikan html dan body mengambil lebar dan tinggi penuh */
        html, body {
            margin: 0;
            padding: 0;
            width: 100%;
            height: 100%; /* Penting untuk perhitungan tinggi berbasis persentase */
            overflow-x: hidden; /* Mencegah scrollbar horizontal yang tidak diinginkan */
        }

        body {
            display: flex;
            flex-direction: column;
            min-height: 100vh;
            /* NEW: Tambahkan padding-top untuk mengimbangi tinggi header */
            padding-top: var(--header-height);
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
        /* Tambahan untuk kategori di dark mode */
        body.dark-mode .detail-category {
            background-color: var(--primary-color); /* Gunakan primary-color dari dark mode override */
            color: white;
            text-shadow: 1px 1px 2px rgba(0,0,0,0.3);
        }

        .detail-description {
            font-size: 1.1em;
            line-height: 1.8;
            color: var(--text-color);
            text-align: left;
            margin-bottom: 30px;
        }

        /* --- Perbaikan Styling Kontak --- */
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
            background-color: var(--card-background-color); /* Ubah ke card background */
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
        /* Gaya baru untuk tautan WhatsApp */
        .whatsapp-link {
            display: flex;
            align-items: center;
            gap: 8px;
            text-decoration: none;
            color: inherit; /* Mewarisi warna teks dari parent */
            font-weight: bold;
            transition: color 0.3s ease;
        }

        .whatsapp-link:hover {
            color: #25D366; /* Warna hijau WhatsApp saat hover */
        }

        .whatsapp-link i {
            color: #25D366; /* Warna ikon WhatsApp */
            font-size: 1.5em; /* Ukuran ikon lebih besar */
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

        /* Gaya tambahan untuk peta di dalam card (umkm-map) */
        .umkm-map {
            height: 150px; /* Ukuran peta yang lebih kecil */
            width: 100%;
            border-radius: 0 0 15px 15px; /* Sesuaikan border radius dengan card */
            border-top: 1px solid #eee; /* Garis pemisah dari konten lain di card */
            margin-top: auto; /* Dorong peta ke bawah dalam flex column */
            z-index: 1; /* Pastikan peta muncul di atas elemen lain jika ada masalah z-index */
            background-color: #e0e0e0; /* Warna fallback jika peta belum dimuat */
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

        /* Gaya untuk Horizontal Scrolling Cards */
        .umkm-grid {
            display: flex; /* Mengubah dari grid menjadi flexbox */
            flex-wrap: nowrap; /* Mencegah kartu membungkus ke baris baru */
            overflow-x: auto; /* Mengaktifkan scrolling horizontal */
            -webkit-overflow-scrolling: touch; /* Untuk scrolling yang lebih halus di perangkat sentuh */
            gap: 2.5rem; /* Jarak antar kartu */
            margin-top: 4rem;
            padding-bottom: 15px; /* Beri sedikit padding untuk scrollbar */
            scroll-snap-type: x mandatory; /* Opsional: membuat scrolling berhenti tepat di kartu */
        }

        /* Mengatur ukuran kartu di dalam flex container */
        .umkm-grid .umkm-card-link {
            flex: 0 0 auto; /* Kartu tidak akan membesar atau menyusut, ambil ukuran konten */
            width: 320px; /* Lebar tetap untuk setiap kartu. Sesuaikan ini sesuai keinginan Anda */
            scroll-snap-align: start; /* Opsional: membuat scroll snap ke awal setiap kartu */
        }

        /* Mengatur ulang gaya untuk satu item jika hanya ada satu (opsional, tergantung tampilan yang diinginkan) */
        /* Jika Anda ingin satu item tetap lebar penuh dan tidak di tengah saat hanya satu, Anda bisa hapus single-item-grid */
        .single-item-grid .umkm-card-link {
            width: 100%; /* Jika hanya satu item, ambil lebar penuh */
            max-width: 400px; /* Batasi lebar agar tidak terlalu besar di desktop */
            margin: 0 auto; /* Pusatkan jika hanya satu */
            scroll-snap-align: none; /* Nonaktifkan snap jika hanya satu */
        }

        /* --- NEW STYLES FOR POTRET DESA (GAMBAR SAJA) --- */
        .potret-desa-grid {
            display: flex; /* Flexbox for horizontal scrolling */
            flex-wrap: nowrap;
            overflow-x: auto;
            -webkit-overflow-scrolling: touch;
            gap: 2.5rem;
            margin-top: 4rem;
            padding-bottom: 15px;
            scroll-snap-type: x mandatory;
            justify-content: flex-start; /* Ensure items start from left */
        }

        .potret-desa-card-link {
            text-decoration: none;
            color: inherit;
            display: block;
            flex: 0 0 auto; /* No grow, no shrink, width defined */
            width: 300px; /* Lebar tetap untuk setiap kartu gambar */
            scroll-snap-align: start;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }
        /* Style for single item in potret-desa-grid (optional, makes it centered) */
        .potret-desa-grid.single-item-grid .potret-desa-card-link {
            width: 100%;
            max-width: 400px;
            margin: 0 auto;
            scroll-snap-align: none;
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
            object-fit: cover; /* Crop image to fill */
            display: block;
            transition: transform 0.4s ease;
        }

        .potret-desa-card:hover img {
            transform: scale(1.08); /* Slight zoom on hover */
        }

        /* NEW STYLES FOR RUNNING TEXT - FIXED VERSION */
        .running-text {
            background-color: var(--primary-color-dark);
            color: var(--button-text-color-light);
            padding: 10px 0;
            overflow: hidden;
            white-space: nowrap;
            /* Ubah posisi menjadi fixed agar selalu di bawah header */
            position: fixed;
            top: var(--header-height); /* Posisikan tepat di bawah header */
            left: 0;
            width: 100%; /* Lebar penuh */
            box-shadow: 0 2px 5px rgba(0,0,0,0.2);
            z-index: 10; /* Pastikan di atas konten lain, tapi di bawah header */
        }

        .running-text-content {
            display: inline-block;
            animation: marquee 25s linear infinite;
            font-weight: 500;
            font-size: 1.1em;
            will-change: transform;
        }

        @keyframes marquee {
            0%   {
                transform: translateX(100vw);
            }
            100% {
                transform: translateX(-100%);
            }
        }

        /* Pause marquee on hover */
        .running-text:hover .running-text-content {
            animation-play-state: paused;
        }

        /* Dark mode for running text */
        body.dark-mode .running-text {
            background-color: #1a202c; /* Background gelap */
            color: #e0e0e0; /* Teks terang */
        }

        /* Media query untuk mobile - perlambat sedikit animasi */
        @media (max-width: 768px) {
            .running-text-content {
                animation-duration: 20s;
                font-size: 1em;
            }
        }
        /* NEW STYLES FOR OVERLAYS (Galeri Kegiatan) */
        .card-overlay {
            position: absolute;
            bottom: 0;
            left: 0;
            right: 0;
            background: linear-gradient(to top, rgba(0,0,0,0.7), rgba(0,0,0,0));
            color: white;
            padding: 15px;
            font-size: 1.1em;
            font-weight: bold;
            text-align: left;
            transform: translateY(100%);
            transition: transform 0.3s ease-out;
            border-radius: 0 0 18px 18px; /* Match card radius */
        }
        .potret-desa-card:hover .card-overlay {
            transform: translateY(0);
        }
        .potret-desa-card h4 {
            margin: 0;
            padding: 0;
            color: white; /* Ensure text is white */
            word-break: break-word; /* Prevent long words from overflowing */
        }
        /* Social Icons in Footer */
        .social-icons {
            margin-top: 20px;
            text-align: center;
        }
        .social-icons a {
            color: var(--text-color);
            font-size: 1.8em;
            margin: 0 10px;
            transition: color 0.3s ease;
        }
        .social-icons a:hover {
            color: var(--primary-color);
        }

        /* PENYESUAIAN PENTING UNTUK HERO SECTION */
        .hero {
            /* Tinggi minimum hero akan disesuaikan agar running text terlihat */
            min-height: calc(100vh - var(--header-height) - var(--running-text-height));
            /* Pastikan tidak ada margin-top negatif atau posisi absolut yang mengganggu */
            margin-top: var(--running-text-height); /* Dorong hero ke bawah setelah running text */
            position: relative; /* Pastikan posisinya relatif terhadap alur dokumen */
            width: 100vw; /* Force full viewport width */
            /* NEW: Tambahkan margin-left negatif untuk mengimbangi potensi margin default */
            margin-left: calc(50% - 50vw);
            box-sizing: border-box; /* Pastikan padding/border tidak menyebabkan overflow */
        }
        /* Pastikan video mengisi hero dengan benar */
        .hero .background-video {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            object-fit: cover;
            z-index: -1; /* Pastikan video di belakang konten */
            display: block; /* Pastikan video berperilaku sebagai block element */
            /* NEW: Pastikan tidak ada transformasi yang mengganggu */
            transform: none;
        }
        .hero-content {
            position: relative; /* Pastikan konten hero di atas video */
            z-index: 1;
            /* Tambahkan atau sesuaikan padding-top jika konten hero terlalu dekat ke atas */
            padding-top: 20px; /* Contoh, sesuaikan jika perlu */
        }

        /* --- Gaya Baru untuk Visi Misi, Batas Wilayah, Kearifan Lokal --- */
        /* Perubahan besar pada .info-block */
        .info-block {
            background-color: var(--card-background-color);
            border-radius: 20px; /* Lebih bulat */
            box-shadow: 0 8px 30px rgba(0, 0, 0, 0.1);
            padding: 40px; /* Lebih banyak padding */
            margin-bottom: 4rem; /* Jarak antar blok */
            text-align: left;
            transition: all 0.4s ease-in-out;
            position: relative;
            overflow: hidden;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            border: 1px solid var(--border-color); /* Subtle border */
        }

        .info-block::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 8px; /* Lebih tebal */
            background: linear-gradient(90deg, var(--primary-color-dark), var(--primary-color), var(--accent-color)); /* Gradient lebih kompleks */
            border-radius: 20px 20px 0 0;
            transform: translateY(-100%); /* Hidden initially */
            transition: transform 0.5s ease-out;
        }

        .info-block:hover::before {
            transform: translateY(0); /* Slide down on hover */
        }

        .info-block h3 {
            color: var(--primary-color-dark);
            font-size: 2.2em; /* Lebih besar */
            margin-bottom: 20px; /* Lebih banyak ruang */
            text-align: center;
            position: relative;
            padding-bottom: 15px; /* Untuk garis bawah */
        }

        .info-block h3::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 50%;
            transform: translateX(-50%);
            width: 100px; /* Lebih panjang */
            height: 4px; /* Lebih tebal */
            background-color: var(--accent-color);
            border-radius: 2px;
        }

        .info-block p, .info-block ul {
            color: var(--text-color);
            line-height: 1.8; /* Lebih nyaman dibaca */
            margin-bottom: 1.5em; /* Jarak antar paragraf/list */
            font-size: 1.1em; /* Ukuran teks lebih besar */
            text-align: justify; /* Justify text for neatness */
            max-width: 900px; /* Batasi lebar teks */
        }
        .info-block ul {
            list-style: none; /* Hapus bullet default */
            padding-left: 0; /* Hapus padding default */
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr)); /* 2 kolom di desktop, 1 di mobile */
            gap: 1.5rem;
            margin-top: 1.5em;
        }
        .info-block ul li {
            margin-bottom: 10px;
            position: relative;
            padding-left: 30px; /* Ruang untuk ikon */
            font-size: 1.05em;
            color: var(--secondary-text-color);
            background-color: var(--background-color); /* Latar belakang untuk setiap item misi */
            padding: 15px 20px;
            border-radius: 10px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.05);
            transition: transform 0.2s ease, box-shadow 0.2s ease;
            text-align: left;
        }
        .info-block ul li:hover {
            transform: translateY(-3px);
            box-shadow: 0 5px 15px rgba(0,0,0,0.1);
        }
        .info-block ul li::before {
            content: "\f00c"; /* FontAwesome check icon */
            font-family: "Font Awesome 5 Free";
            font-weight: 900;
            position: absolute;
            left: 0;
            top: 50%;
            transform: translateY(-50%);
            color: var(--primary-color);
            font-size: 1.3em;
            margin-left: 10px;
        }

        /* Responsive for Visi Misi List */
        @media (max-width: 768px) {
            .info-block ul {
                grid-template-columns: 1fr; /* Satu kolom di mobile */
            }
        }


        #map-batas-wilayah {
            height: 450px;
            width: 100%;
            border-radius: 10px;
            border: 2px solid var(--primary-color);
            margin-top: 20px;
            box-shadow: 0 4px 15px rgba(0,0,0,0.1);
        }
        @media (max-width: 768px) {
            #map-batas-wilayah {
                height: 300px;
            }
        }

        /* Aparatur Desa - Kartu Vertikal dengan Foto Bulat */
        .aparatur-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 2rem;
            margin-top: 3rem;
            justify-content: center;
        }

        .aparatur-card {
            background: var(--card-background-color);
            border-radius: 15px;
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.1);
            transition: all 0.3s ease;
            padding: 20px;
            text-align: center;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: space-between;
        }

        .aparatur-card:hover {
            transform: translateY(-8px);
            box-shadow: 0 15px 40px rgba(0, 0, 0, 0.2);
        }

        .aparatur-photo {
            width: 120px;
            height: 120px;
            border-radius: 50%;
            overflow: hidden;
            border: 4px solid var(--primary-color);
            margin-bottom: 15px;
            flex-shrink: 0;
        }

        .aparatur-photo img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .aparatur-info h4 {
            color: var(--primary-color-dark);
            margin-bottom: 5px;
            font-size: 1.3em;
        }

        .aparatur-info p {
            color: var(--secondary-text-color);
            font-size: 0.95em;
            margin-bottom: 10px;
        }
        .aparatur-info .whatsapp-link {
            font-size: 0.9em;
            justify-content: center;
        }
/* Container for horizontal scrolling */
.berita-list-container {
    overflow-x: auto; /* Enables horizontal scrolling */
    -webkit-overflow-scrolling: touch; /* Improves scrolling on iOS */
    white-space: nowrap; /* Prevents items from wrapping to the next line */
    padding-bottom: 20px; /* Add some padding for scrollbar visibility */
    margin-top: 3rem; /* Keep the margin from your original .berita-list */

    /* Scrollbar styling for Webkit (Chrome, Safari) */
    &::-webkit-scrollbar {
        height: 8px;
    }

    &::-webkit-scrollbar-thumb {
        background-color: #888;
        border-radius: 10px;
    }

    &::-webkit-scrollbar-track {
        background: #f1f1f1;
    }

    /* Scrollbar styling for Firefox */
    scrollbar-width: thin;
    scrollbar-color: #888 #f1f1f1;
}

/* Main list wrapper inside the scroll container */
.berita-list {
    display: flex; /* Arranges items in a row */
    gap: 20px; /* Space between cards */
    padding: 0 20px; /* Add horizontal padding inside the scrollable area */
}

/* Individual news card */
.berita-item {
    display: flex; /* Use flexbox for internal card layout */
    flex-direction: column; /* Stack image and content vertically within the card */
    width: 280px; /* Fixed width for each card */
    min-width: 280px; /* Ensures cards don't shrink */
    background-color: var(--card-background-color);
    border-radius: 15px;
    box-shadow: 0 6px 20px rgba(0, 0, 0, 0.08);
    overflow: hidden; /* Ensures rounded corners are respected */
    text-decoration: none;
    color: inherit;
    transition: all 0.3s ease; /* Use all for comprehensive transition */
    flex-shrink: 0; /* Prevents cards from shrinking when space is limited */
    text-align: center; /* Center content within the card */
    padding: 0; /* Remove padding from .berita-item itself, content will have padding */
}

.berita-item:hover {
    transform: translateY(-5px);
    box-shadow: 0 10px 30px rgba(0, 0, 0, 0.15);
}

/* Image container within the card */
.berita-image-container {
    width: 100%; /* Image container fills card width */
    height: 180px; /* Fixed height for consistent image size */
    flex-shrink: 0; /* Prevent image from shrinking */
    border-radius: 15px 15px 0 0; /* Match card radius on top, straight on bottom */
    overflow: hidden;
    /* margin-right: 20px; -- REMOVED: not needed for vertical stack */
    /* margin-bottom: 15px; -- REMOVED: content padding will handle spacing */
    background-color: #eee;
    display: flex; /* Use flexbox to center the image */
    align-items: center; /* Vertically center the image */
    justify-content: center; /* Horizontally center the image */
}

.berita-image-container img {
    width: 100%;
    height: 100%;
    object-fit: cover; /* Crops image to cover the area without distortion */
    display: block; /* Removes any extra space below the image */
}

/* Content area within the card */
.berita-content {
    flex-grow: 1; /* Content takes remaining space */
    padding: 15px 20px 20px; /* Add padding inside the content area */
    text-align: left; /* Align text within content area to left (or center if you prefer global center) */
}

.berita-content h4 {
    color: var(--primary-color-dark);
    font-size: 1.2em; /* Slightly smaller for card view */
    margin-top: 0;
    margin-bottom: 8px; /* Adjusted margin */
    white-space: normal; /* Allow text wrapping */
    overflow: hidden;
    text-overflow: ellipsis;
    display: -webkit-box;
    -webkit-line-clamp: 2; /* Limit title to 2 lines */
    -webkit-box-orient: vertical;
    text-align: center; /* Center title within the card */
}

.berita-content .date {
    color: var(--secondary-text-color);
    font-size: 0.85em; /* Slightly smaller */
    margin-bottom: 10px;
    display: flex; /* Use flex to align icon and text */
    align-items: center;
    justify-content: center; /* Center date and icon */
    gap: 5px; /* Space between icon and text */
}

.berita-content .date i {
    color: var(--secondary-text-color);
}
/* Dropdown container */
.dropdown {
    position: relative;
    display: inline-block;
}

/* Dropdown button (the main link) */
.dropbtn {
    display: block; /* Make sure it takes full space for hover */
    padding: 10px 15px; /* Adjust as per your nav-links styling */
    text-decoration: none;
    color: var(--text-color); /* Inherit from your header's nav-links */
    font-weight: 500;
    transition: background-color 0.3s ease, color 0.3s ease;
}

.dropbtn:hover {
    background-color: var(--primary-color-dark); /* Or any hover effect you like */
    color: var(--button-text-color-light);
    border-radius: 5px; /* Optional: adds rounded corners on hover */
}

/* Dropdown content (the actual links) */
.dropdown-content {
    display: none; /* Hidden by default */
    position: absolute;
    background-color: var(--card-background-color); /* Background for dropdown */
    min-width: 160px;
    box-shadow: 0px 8px 16px 0px rgba(0,0,0,0.2);
    z-index: 100; /* Ensure it appears above other content */
    border-radius: 8px;
    padding: 10px 0; /* Vertical padding */
    left: 50%; /* Center dropdown horizontally */
    transform: translateX(-50%); /* Adjust for centering */
    top: 100%; /* Position right below the dropdown button */
    margin-top: 5px; /* Small space between button and dropdown */
    border: 1px solid var(--border-color); /* Subtle border */
}

.dropdown-content a {
    color: var(--text-color); /* Link text color */
    padding: 12px 16px;
    text-decoration: none;
    display: block; /* Each link takes full width */
    text-align: left; /* Align text to the left */
    transition: background-color 0.2s ease, color 0.2s ease;
    white-space: nowrap; /* Prevent text wrapping in dropdown links */
}

.dropdown-content a:hover {
    background-color: var(--primary-color); /* Hover effect for dropdown links */
    color: white;
}

/* Show the dropdown menu on hover */
.dropdown:hover .dropdown-content {
    display: block;
}

/* Dark mode adjustments for dropdowns */
body.dark-mode .dropdown-content {
    background-color: var(--card-background-color);
    box-shadow: 0px 8px 16px 0px rgba(0,0,0,0.4); /* Darker shadow */
    border: 1px solid var(--border-color);
}

body.dark-mode .dropdown-content a {
    color: var(--text-color);
}

body.dark-mode .dropdown-content a:hover {
    background-color: var(--primary-color);
    color: white;
}

/* Mobile Menu Specifics (adjust based on your existing mobile menu CSS) */
/* You might need to disable hover effects for mobile and rely on click */
@media (max-width: 768px) {
    .nav-links {
        /* Ensure nav-links is set to column for mobile menu */
        flex-direction: column;
        align-items: center; /* Center items in column */
    }

    .dropdown .dropbtn {
        width: 100%; /* Full width for the button */
        text-align: center; /* Center text in the button */
    }

    .dropdown-content {
        position: static; /* Stack dropdown content normally in mobile menu */
        transform: none;
        width: 100%;
        box-shadow: none; /* No shadow in mobile */
        border: none; /* No border in mobile */
        border-radius: 0;
        background-color: rgba(var(--card-background-color-rgb), 0.95); /* Slightly transparent background */
        padding: 0;
    }

    .dropdown-content a {
        padding-left: 30px; /* Indent sub-links */
        background-color: var(--background-color); /* Different background for sub-links */
        border-bottom: 1px solid var(--border-color); /* Separator */
    }

    /* JavaScript will handle showing/hiding dropdowns on mobile click */
    .dropdown:hover .dropdown-content {
        display: none; /* Disable hover on mobile, JS will control */
    }
}
.berita-content p {
    color: var(--text-color);
    font-size: 0.95em; /* Slightly smaller */
    line-height: 1.5;
    white-space: normal; /* Allow text wrapping */
    overflow: hidden;
    text-overflow: ellipsis;
    display: -webkit-box;
    -webkit-line-clamp: 3; /* Limit content to 3 lines */
    -webkit-box-orient: vertical;
    text-align: justify; /* Justify paragraph text */
}

        /* Kearifan Lokal - Card dengan Border Unik */
        .kearifan-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
            gap: 2rem;
            margin-top: 3rem;
        }

        .kearifan-card {
            background-color: var(--card-background-color);
            border-radius: 15px;
            padding: 25px;
            box-shadow: 0 6px 20px rgba(0, 0, 0, 0.08);
            position: relative;
            overflow: hidden;
            transition: all 0.3s ease;
            border: 2px solid transparent; /* Default transparent border */
        }
        .kearifan-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.15);
            border-color: var(--accent-color); /* Highlight on hover */
        }
        .kearifan-card::before {
            content: '';
            position: absolute;
            top: -10px;
            right: -10px;
            width: 50px;
            height: 50px;
            background-color: var(--primary-color);
            border-radius: 0 0 0 15px;
            transform: rotate(45deg);
            opacity: 0.8;
            transition: all 0.3s ease;
        }
        .kearifan-card:hover::before {
            transform: rotate(0deg);
            width: 60px;
            height: 60px;
            background-color: var(--accent-color);
        }

        .kearifan-card h4 {
            color: var(--primary-color-dark);
            margin-bottom: 10px;
            font-size: 1.4em;
        }
        .kearifan-card p {
            color: var(--text-color);
            line-height: 1.6;
        }
        .kearifan-card .icon {
            font-size: 2.5em;
            color: var(--accent-color);
            margin-bottom: 15px;
            display: block;
            text-align: center;
        }

    </style>
</head>
<body class="light-mode">

    {{-- Memanggil komponen header --}}
    <x-header/>

    <div class="running-text">
        <div class="running-text-content">
            🎉 Selamat datang di Portal Desa Medalsari • 📢 Pendaftaran UMKM baru telah dibuka • 🏛️ Pelayanan administrasi desa kini tersedia online • 🌟 Mari bersama membangun desa yang lebih maju
        </div>
    </div>

    <section id="home" class="hero">
        <video autoplay loop muted playsinline class="background-video">
            <source src="{{ asset('videos/video-desa.MP4') }}" type="video/mp4">
            Browser Anda tidak mendukung tag video.
        </video>
        <div class="hero-content">
            <h1>Selamat Datang di Desa Medalsari</h1>
            <p>Desa modern dengan tradisi yang kuat, mendukung pertumbuhan UMKM dan kesejahteraan masyarakat</p>
            <a href="#visi-misi" class="cta-button">Pelajari Lebih Lanjut</a>
        </div>
    </section>

    <main>
        {{-- BAGIAN BARU: VISI & MISI (DIKEMBANGKAN) --}}
        <section id="visi-misi" class="section">
            <h2 class="section-title fade-in">Visi & Misi Desa Medalsari</h2>
            <div class="info-block fade-in">
                <div class="visi-misi-card" style="background-color: var(--background-color); border-radius: 15px; padding: 30px; box-shadow: 0 4px 15px rgba(0,0,0,0.05); margin-bottom: 30px;">
                    <h3><i class="fas fa-eye" style="color: var(--primary-color);"></i> Visi Kami</h3>
                    <p><strong>Visi adalah suatu gambaran yang menantang tentang keadaan masa depan yang 
                    diinginkan dengan melihat potensi dan kebutuhan desa. Penyusunan Visi Desa Medalsari 
                    ini dilakukan dengan pendekatan partisipatif, melibatkan pihak-pihak yang 
                    berkepentingan di Desa Medalsari seperti pemerintah Desa, BPD, Tokoh Masyarakat, 
                    tokoh agama, lembaga masyarakat desa dan masyarakat desa pada 
                    umumnya.Pertimbangan kondisi eksternal di desa seperti satuan kerja wilayah 
                    pembangunan di Kecamatan. Maka berdasarkan pertimbangan di atas Visi Desa 
                    Medalsari adalah:</strong></p>
                    <p style="text-align: center; font-style: italic; color: var(--secondary-text-color);">"Membangun Masyarakat Desa Medalsari yang adil dan Relijius"</p>
                </div>
                
                <div class="visi-misi-card" style="background-color: var(--background-color); border-radius: 15px; padding: 30px; box-shadow: 0 4px 15px rgba(0,0,0,0.05);">
                    <h3><i class="fas fa-lightbulb" style="color: var(--accent-color);"></i> Misi Kami</h3>
                    <ul class="misi-list">
                        <li>
                            <i class="fas fa-graduation-cap" style="color: var(--primary-color-dark);"></i>
                            Menciptakan  Kebijakan  pemerintah  Desa  yang  berpihak  kepada   
                          kepentingan masyarakat. 
                        </li>
                        <li>
                            <i class="fas fa-leaf" style="color: var(--primary-color-dark);"></i>
                             Mendukung segala upaya terhadap pembangunan di bidang pertanian dan perekonomian sebagai sector unggulan Desa
                        </li>
                        <li>
                            <i class="fas fa-city" style="color: var(--primary-color-dark);"></i>
                             Meningkatkan kualitas kehidupan bermasyarakat yang harmonis dan  
                           Beragam.
                        </li>
                        <li>
                            <i class="fas fa-heartbeat" style="color: var(--primary-color-dark);"></i>
                            Meningkatkan kualitas pendidikan dan kesehatan yang merata dan  
                           terjangkau bagi masyarakat.  
                        </li>
                        <li>
                            <i class="fas fa-gavel" style="color: var(--primary-color-dark);"></i>
                            Meningkatkan Pembangunan sarana dasar yang mendukung terhadap 
                          kehidupan masyarakat.
                        </li>

                    </ul>
                </div>
            </div>
        </section>

        {{-- BAGIAN BARU: BATAS WILAYAH (PETA) --}}
        <section id="batas-wilayah" class="section">
            <h2 class="section-title fade-in">Batas Wilayah Desa Medalsari</h2>
            <div class="info-block fade-in">
                <h3>Peta Desa Medalsari</h3>
                <img src="{{ asset('photos/peta-medalsari.jpg') }}" alt="Peta Desa Medalsari" class="static-map-image" onerror="this.onerror=null;this.src='https://placehold.co/800x450/E0E0E0/333333?text=Peta+Tidak+Ditemukan';" loading="lazy">
                <p style="text-align: center; margin-top: 20px; font-style: italic; color: var(--secondary-text-color);">Gambar ini menunjukkan batas-batas administrasi Desa Medalsari.</p>
            </div>
        </section>

        {{-- Script eksternal Leaflet JS (dihapus karena tidak lagi menggunakan peta interaktif) --}}
        {{-- <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script> --}}

        {{-- Script untuk Fade In on Scroll --}}
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                const faders = document.querySelectorAll('.fade-in');
                const appearOptions = {
                    threshold: 0.1,
                    rootMargin: "0px 0px -50px 0px" // Start animation 50px before element is fully in view
                };
                const appearOnScroll = new IntersectionObserver(function(entries, appearOnScroll) {
                    entries.forEach(entry => {
                        if (!entry.isIntersecting) {
                            return;
                        } else {
                            entry.target.classList.add('visible');
                            appearOnScroll.unobserve(entry.target);
                        }
                    });
                }, appearOptions);

                faders.forEach(fader => {
                    appearOnScroll.observe(fader);
                });

                // Kode inisialisasi peta Leaflet dihapus karena diganti gambar statis
                /*
                const mainMapId = 'map-batas-wilayah';
                if (document.getElementById(mainMapId)) {
                    const mainLatitude = -6.8906;
                    const mainLongitude = 107.6105;
                    const initialZoom = 13;

                    const mainMap = L.map(mainMapId).setView([mainLatitude, mainLongitude], initialZoom);

                    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                        attribution: '© OpenStreetMap contributors'
                    }).addTo(mainMap);

                    const batasWilayahCoords = [
                        [-6.895, 107.605],
                        [-6.885, 107.615],
                        [-6.890, 107.620],
                        [-6.900, 107.610]
                    ];
                    const polygon = L.polygon(batasWilayahCoords, {color: 'red', weight: 3, opacity: 0.7, fillOpacity: 0.2}).addTo(mainMap);
                    mainMap.fitBounds(polygon.getBounds());

                    L.marker([mainLatitude, mainLongitude]).addTo(mainMap)
                        .bindPopup("<b>Desa Medalsari</b><br>Pusat Desa").openPopup();
                }
                */
            });
        </script>

        {{-- BAGIAN BARU: APARATUR DESA (HIERARKI) --}}
        <section id="aparatur-desa" class="section">
            <h2 class="section-title fade-in">Aparatur Desa Medalsari</h2>
            {{-- Hierarki Aparatur Desa --}}
            @php
                $aparaturDesas = $aparaturDesas ?? []; // Pastikan variabel ada
                // Contoh dummy data jika $aparaturDesas kosong atau tidak didefinisikan
                if (empty($aparaturDesas)) {
                    $aparaturDesas = [
                        (object)['nama' => 'Kepala Desa', 'jabatan' => 'Kepala Desa', 'foto' => 'images/default-avatar.png', 'kontak' => '6281234567890'],
                        (object)['nama' => 'Sekretaris Desa', 'jabatan' => 'Sekretaris Desa', 'foto' => 'images/default-avatar.png', 'kontak' => '6281234567891'],
                        (object)['nama' => 'Kaur Keuangan', 'jabatan' => 'Kepala Urusan Keuangan', 'foto' => 'images/default-avatar.png', 'kontak' => '6281234567892'],
                        (object)['nama' => 'Kasi Pemerintahan', 'jabatan' => 'Kepala Seksi Pemerintahan', 'foto' => 'images/default-avatar.png', 'kontak' => '6281234567893'],
                        (object)['nama' => 'Kadus I', 'jabatan' => 'Kepala Dusun I', 'foto' => 'images/default-avatar.png', 'kontak' => '6281234567894'],
                        (object)['nama' => 'Kadus II', 'jabatan' => 'Kepala Dusun II', 'foto' => 'images/default-avatar.png', 'kontak' => '6281234567895'],
                    ];
                }
            @endphp 

            <div class="aparatur-grid">
                @forelse($aparaturDesas as $aparatur)
                    <div class="aparatur-card fade-in">
                        <div class="aparatur-photo">
                            @if($aparatur->foto)
                                <img src="{{ asset('storage/' . $aparatur->foto) }}" alt="{{ $aparatur->nama }}">
                            @else
                                <img src="{{ asset('images/default-avatar.png') }}" alt="Foto Default">
                            @endif
                        </div>
                        <div class="aparatur-info">
                            <h4>{{ $aparatur->nama }}</h4>
                            <p>{{ $aparatur->jabatan }}</p>
                            @if($aparatur->kontak)
                            <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $aparatur->kontak) }}" target="_blank" class="whatsapp-link">
                                <i class="fab fa-whatsapp"></i> {{ $aparatur->kontak }}
                            </a>
                            @endif
                        </div>
                    </div>
                @empty
                    <div class="col-12 text-center">
                        <p>Belum ada data aparatur desa.</p>
                    </div>
                @endforelse
            </div>
            @if(count($aparaturDesas) > 0)
            <div class="text-center mt-5">
                <a href="{{ url('/aparatur-desa') }}" class="cta-button">Lihat Struktur Lengkap</a> {{-- Ganti dengan route yang sesuai --}}
            </div>
            @endif
        </section>

        {{-- BAGIAN BARU: GALERI KEGIATAN DESA --}}
        <section id="galeri-kegiatan" class="section">
            <h2 class="section-title fade-in">Galeri Kegiatan Desa</h2>
            <div class="potret-desa-grid @if(($kegiatanDesas ?? collect())->count() == 1) single-item-grid @endif">
                @forelse($kegiatanDesas as $kegiatan)
                    <a href="{{ route('kegiatan_desas.show_public', $kegiatan) }}" class="potret-desa-card-link">
                        <div class="potret-desa-card fade-in">
                            @if($kegiatan->gambar)
                                <img src="{{ asset('storage/' . $kegiatan->gambar) }}" alt="{{ $kegiatan->judul }}">
                            @else
                                <img src="{{ asset('images/default-kegiatan.jpg') }}" alt="Gambar Default Kegiatan">
                            @endif
                            <div class="card-overlay">
                                <h4>{{ $kegiatan->judul }}</h4>
                            </div>
                        </div>
                    </a>
                @empty
                    <div class="col-12 text-center">
                        <p>Belum ada kegiatan desa yang didokumentasikan.</p>
                    </div>
                @endforelse
            </div>
            @if(($kegiatanDesas ?? collect())->count() > 0)
            <div class="text-center mt-5">
                <a href="{{ route('kegiatan_desas.index_public') }}" class="cta-button">Lihat Semua Kegiatan</a>
            </div>
            @endif
        </section>

       {{-- BAGIAN BARU: BERITA & PENGUMUMAN TERBARU --}}
<section id="berita-pengumuman" class="section">
    <h2 class="section-title fade-in">Berita & Pengumuman Terbaru</h2>

    {{-- KUNCI UTAMA: Ini adalah container yang akan discroll secara horizontal --}}
    <div class="berita-list-container">
        {{-- KUNCI UTAMA: Ini adalah flex container yang menampung kartu-kartu secara horizontal --}}
        <div class="berita-list">
            @php
                $beritas = $beritas ?? collect();
                if ($beritas->isEmpty()) {
                    $beritas = collect([
                        (object)['id' => 1, 'judul' => 'Sosialisasi Program Bantuan Sosial', 'tanggal_publikasi' => '2025-07-01', 'konten' => 'Pemerintah desa baru saja mengadakan sosialisasi penting mengenai program bantuan sosial terbaru yang bertujuan untuk meningkatkan kesejahteraan warga Desa Medalsari. Acara ini dihadiri oleh banyak kepala keluarga dan perwakilan dari berbagai dusun, menunjukkan antusiasme masyarakat terhadap inisiatif ini.', 'gambar_utama' => 'images/default-berita.jpg'],
                        (object)['id' => 2, 'judul' => 'Gotong Royong Bersih Lingkungan Desa', 'tanggal_publikasi' => '2025-06-25', 'konten' => 'Dalam semangat kebersamaan, warga Desa Medalsari bersama-sama melaksanakan kegiatan gotong royong membersihkan lingkungan desa. Fokus utama kegiatan ini adalah membersihkan saluran air dan area publik, memastikan desa tetap asri dan sehat bagi seluruh penghuni.', 'gambar_utama' => 'images/default-berita.jpg'],
                        (object)['id' => 3, 'judul' => 'Pengumuman Penerimaan Calon Perangkat Desa', 'tanggal_publikasi' => '2025-06-20', 'konten' => 'Kesempatan emas bagi warga Desa Medalsari yang ingin berkontribusi langsung dalam pembangunan desa! Kami dengan bangga mengumumkan pembukaan pendaftaran calon perangkat desa untuk beberapa posisi strategis. Informasi lengkap mengenai persyaratan dan prosedur pendaftaran dapat diakses di kantor desa atau melalui website resmi.', 'gambar_utama' => 'images/default-berita.jpg'],
                        (object)['id' => 4, 'judul' => 'Peresmian Balai Warga Baru', 'tanggal_publikasi' => '2025-06-15', 'konten' => 'Desa Medalsari kini memiliki balai warga baru yang representatif, diresmikan dalam sebuah upacara sederhana namun penuh makna. Balai ini diharapkan menjadi pusat kegiatan komunitas, tempat berkumpul, bermusyawarah, dan mengembangkan potensi bersama.', 'gambar_utama' => 'images/default-berita.jpg'],
                        (object)['id' => 5, 'judul' => 'Pelatihan UMKM untuk Ibu-ibu PKK', 'tanggal_publikasi' => '2025-06-10', 'konten' => 'Untuk meningkatkan kemandirian ekonomi keluarga, ibu-ibu PKK Desa Medalsari mengikuti pelatihan UMKM yang diselenggarakan oleh dinas terkait. Pelatihan ini fokus pada pengembangan produk lokal dan strategi pemasaran digital, membuka peluang baru bagi usaha rumahan.', 'gambar_utama' => 'images/default-berita.jpg'],
                    ]);
                }
            @endphp

            @forelse($beritas as $berita)
                {{-- Setiap item berita adalah tautan, yang juga bertindak sebagai kartu --}}
                <a href="{{ route('berita.show_public', $berita->id) }}" class="berita-item fade-in">
                    <div class="berita-image-container">
                        @if($berita->gambar_utama)
                            <img src="{{ asset('storage/' . $berita->gambar_utama) }}" alt="{{ $berita->judul }}">
                        @else
                            <img src="{{ asset('images/default-berita.jpg') }}" alt="Gambar Default Berita">
                        @endif
                    </div>
                    <div class="berita-content">
                        <h4>{{ $berita->judul }}</h4>
                        <p class="date"><i class="far fa-calendar-alt"></i> {{ \Carbon\Carbon::parse($berita->tanggal_publikasi)->locale('id')->isoFormat('D MMMM Y') }}</p>
                        {{-- Batasi konten agar tidak terlalu panjang --}}
                        <p>{{ Str::limit($berita->konten, 120) }}</p>
                    </div>
                </a>
            @empty
                <div class="col-12 text-center">
                    <p>Belum ada berita atau pengumuman terbaru.</p>
                </div>
            @endforelse
        </div>
    </div>
    @if(($beritas ?? collect())->count() > 0)
        <div class="text-center mt-5">
            <a href="{{ route('berita.index_public') }}" class="cta-button">Lihat Semua Berita</a>
        </div>
    @endif
</section>

        {{-- BAGIAN BARU: KEARIFAN LOKAL --}}
<section id="kearifan-lokal" class="section">
    <h2 class="section-title fade-in">Kearifan Lokal Desa Medalsari</h2>

    <div class="kearifan-grid">
        @forelse($kearifanLokals as $kearifan)
            <div class="kearifan-card fade-in">

                {{-- Gambar --}}
                <div class="kearifan-image">
                    @if(!empty($kearifan->gambar))
                        <img src="{{ asset('storage/' . $kearifan->gambar) }}"
                             alt="{{ $kearifan->nama }}"
                             style="width: 100%; height: 200px; object-fit: cover; border-radius: 15px 15px 0 0;">
                    @else
                        <img src="{{ asset('images/default-kearifan.jpg') }}"
                             alt="Gambar Default"
                             style="width: 100%; height: 200px; object-fit: cover; border-radius: 15px 15px 0 0;">
                    @endif
                </div>

                {{-- Konten --}}
                <div class="kearifan-content" style="padding: 15px;">
                    <div class="icon"><i class="fas {{ $kearifan->icon ?? 'fa-star' }}"></i></div>
                    <h4>{{ $kearifan->nama }}</h4>
                    <p>{{ Str::limit($kearifan->deskripsi, 180) }}</p>

                    {{-- Link detail jika ingin --}}
                    {{-- <div class="text-right mt-3">
                        <a href="{{ url('/kearifan-lokal/' . $kearifan->id) }}" class="text-primary-color">
                            Baca Selengkapnya <i class="fas fa-arrow-right"></i>
                        </a>
                    </div> --}}

                    {{-- Jika ada latitude dan longitude bisa aktifkan ini --}}
                    {{-- 
                    @if($kearifan->latitude && $kearifan->longitude)
                        <div id="map-kearifan-{{ $kearifan->id }}" class="umkm-map"></div>
                        @push('scripts')
                            <script>
                                document.addEventListener('DOMContentLoaded', function() {
                                    const mapId = 'map-kearifan-{{ $kearifan->id }}';
                                    const lat = parseFloat('{{ $kearifan->latitude }}');
                                    const lng = parseFloat('{{ $kearifan->longitude }}');
                                    if (document.getElementById(mapId) && !isNaN(lat) && !isNaN(lng)) {
                                        const map = L.map(mapId, {
                                            zoomControl: false, dragging: false, touchZoom: false,
                                            doubleClickZoom: false, scrollWheelZoom: false
                                        }).setView([lat, lng], 14);
                                        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                                            attribution: '© OpenStreetMap contributors',
                                            maxZoom: 16, minZoom: 10
                                        }).addTo(map);
                                        L.marker([lat, lng], { interactive: false }).addTo(map);
                                        setTimeout(() => { map.invalidateSize(); }, 100);
                                    }
                                });
                            </script>
                        @endpush
                    @endif
                    --}}
                </div>
            </div>
        @empty
            <div class="col-12 text-center">
                <p>Belum ada data kearifan lokal yang tersedia.</p>
            </div>
        @endforelse
    </div>

    @if(($kearifanLokals ?? collect())->count() > 0)
        <div class="text-center mt-5">
            <a href="{{ url('/kearifan-lokal') }}" class="cta-button">Jelajahi Kearifan Lokal Lainnya</a>
        </div>
    @endif
</section>

        {{-- BAGIAN POTRET DESA --}}
        <section id="potret-desa" class="section">
            <h2 class="section-title fade-in">Potret Desa Medalsari</h2>
            <div class="potret-desa-grid @if($viewDesas->count() == 1) single-item-grid @endif">
                @forelse($viewDesas as $view)
                    <a href="{{ route('view_desas.show_public', $view) }}" class="potret-desa-card-link">
                        <div class="potret-desa-card fade-in">
                            @if($view->gambar)
                                <img src="{{ asset('storage/' . $view->gambar) }}" alt="{{ $view->nama }}">
                            @else
                                <img src="{{ asset('images/default-viewdesa.jpg') }}" alt="Gambar Default Desa">
                            @endif
                            <div class="card-overlay">
                                <h4>{{ $view->nama }}</h4>
                            </div>
                        </div>
                    </a>
                @empty
                    <div class="col-12 text-center">
                        <p>Belum ada potret desa yang tersedia.</p>
                    </div>
                @endforelse
            </div>
        </section>

        {{-- BAGIAN WISATA DESA --}}
        <section id="wisata" class="section">
            <h2 class="section-title fade-in">Wisata Desa</h2>
            <div class="umkm-grid @if($wisataDesas->count() == 1) single-item-grid @endif">
                @forelse($wisataDesas as $wisata)
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
                                <p>{{ Str::limit($wisata->deskripsi, 100) }}</p>
                                <div class="umkm-contact">
                                    <div class="contact-item">📍 {{ $wisata->alamat ?? '-' }}</div>
                                </div>
                                @if($wisata->latitude && $wisata->longitude)
                                    <div id="map-wisata-{{ $wisata->id }}" class="umkm-map"></div>
                                    @push('scripts')
                                        <script>
                                            document.addEventListener('DOMContentLoaded', function() {
                                                const mapId = 'map-wisata-{{ $wisata->id }}';
                                                const latitude = parseFloat('{{ $wisata->latitude }}');
                                                const longitude = parseFloat('{{ $wisata->longitude }}');

                                                if (document.getElementById(mapId) && !isNaN(latitude) && !isNaN(longitude)) {
                                                    const smallMap = L.map(mapId, {
                                                        zoomControl: false, dragging: false, touchZoom: false,
                                                        doubleClickZoom: false, scrollWheelZoom: false, boxZoom: false,
                                                        keyboard: false, tap: false
                                                    }).setView([latitude, longitude], 14);

                                                    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                                                        attribution: '© OpenStreetMap contributors', maxZoom: 16, minZoom: 10
                                                    }).addTo(smallMap);

                                                    L.marker([latitude, longitude], { interactive: false }).addTo(smallMap);
                                                    
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

        {{-- BAGIAN UMKM DESA --}}
        <section id="umkm" class="section">
            <h2 class="section-title fade-in">UMKM Desa Medalsari</h2>
            <div class="umkm-grid @if($umkms->count() == 1) single-item-grid @endif">
                @forelse($umkms as $umkm)
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
                                <p>{{ Str::limit($umkm->deskripsi, 100) }}</p>
                                <div class="umkm-contact">
                                    @if($umkm->alamat)
                                        <div class="contact-item">📍 {{ $umkm->alamat }}</div>
                                    @endif
                                    <div class="contact-item">💰
                                        @if($umkm->harga)
                                            Rp {{ number_format($umkm->harga, 0, ',', '.') }}
                                        @else
                                            -
                                        @endif
                                    </div>
                                </div>
                                @if($umkm->latitude && $umkm->longitude)
                                    <div id="map-umkm-{{ $umkm->id }}" class="umkm-map"></div>
                                    @push('scripts')
                                        <script>
                                            document.addEventListener('DOMContentLoaded', function() {
                                                const mapId = 'map-umkm-{{ $umkm->id }}';
                                                const latitude = parseFloat('{{ $umkm->latitude }}');
                                                const longitude = parseFloat('{{ $umkm->longitude }}');
                                                if (document.getElementById(mapId) && !isNaN(latitude) && !isNaN(longitude)) {
                                                    const smallMap = L.map(mapId, {
                                                        zoomControl: false, dragging: false, touchZoom: false,
                                                        doubleClickZoom: false, scrollWheelZoom: false, boxZoom: false,
                                                        keyboard: false, tap: false
                                                    }).setView([latitude, longitude], 14);
                                                    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', { attribution: '© OpenStreetMap contributors', maxZoom: 16, minZoom: 10 }).addTo(smallMap);
                                                    L.marker([latitude, longitude], { interactive: false }).addTo(smallMap);
                                                    setTimeout(() => { smallMap.invalidateSize(); }, 100);
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
                        <p>Belum ada data UMKM yang tersedia.</p>
                    </div>
                @endforelse
            </div>
        </section>

        {{-- BAGIAN BARU: DATA PENDUDUK (Ringkasan Statistik) --}}
        <section id="data-penduduk" class="section">
            <h2 class="section-title fade-in">Data Penduduk Desa Medalsari</h2>
            <div class="detail-contact-grid"> {{-- Reuse gaya grid untuk item detail --}}
                <div class="detail-contact-item fade-in">
                    <i class="fas fa-users"></i>
                <div>
                    <strong>Total Penduduk</strong>
                    <p>± 3.897 Jiwa</p> {{-- Sudah diperbarui --}}
                </div>
                </div>
                <div class="detail-contact-item fade-in">
                    <i class="fas fa-male"></i>
                    <div>
                        <strong>Laki-laki</strong>
                        <p>± 1.935 Jiwa</p> {{-- Sudah diperbarui --}}
                    </div>
                </div>
                <div class="detail-contact-item fade-in">
                    <i class="fas fa-female"></i>
                    <div>
                        <strong>Perempuan</strong>
                        <p>± 1.962 Jiwa</p> {{-- Sudah diperbarui --}}
                    </div>
                </div>
                <div class="detail-contact-item fade-in">
                    <i class="fas fa-handshake"></i>
                    <div>
                        <strong>Kepala Keluarga</strong>
                        <p>± 1.422 Jiwa</p> {{-- Sudah diperbarui --}}
                    </div>
                </div>
                <div class="detail-contact-item fade-in">
                    <i class="fas fa-briefcase"></i>
                    <div>
                        <strong>Mayoritas Pekerjaan</strong>
                        <p>Petani</p> {{-- Sudah diperbarui --}}
                    </div>
                </div>
                <div class="detail-contact-item fade-in">
                    <i class="fas fa-graduation-cap"></i>
                    <div>
                        <strong>Tingkat Pendidikan</strong>
                        <p>SMA</p> {{-- Sudah diperbarui --}}
                    </div>
                </div>
            </div>
        </section>

        {{-- BAGIAN BARU: FORMULIR KONTAK / SARAN --}}
        <section id="kontak-saran" class="section">
            <h2 class="section-title fade-in">Hubungi Kami / Beri Saran</h2>
            <div class="detail-container" style="text-align: left;">
                <p class="detail-description" style="text-align: center;">Punya pertanyaan atau saran untuk Desa Medalsari? Silakan isi formulir di bawah ini.</p>
                <form action="{{ route('kontak.submit') }}" method="POST">
                    @csrf
                    <div style="margin-bottom: 20px;">
                        <label for="nama" style="display: block; font-weight: bold; margin-bottom: 8px; color: var(--text-color);">Nama Lengkap:</label>
                        <input type="text" id="nama" name="nama" class="form-control" required style="width: 100%; padding: 12px; border: 1px solid var(--border-color); border-radius: 8px; background-color: var(--background-color); color: var(--text-color);">
                    </div>
                    <div style="margin-bottom: 20px;">
                        <label for="email" style="display: block; font-weight: bold; margin-bottom: 8px; color: var(--text-color);">Email:</label>
                        <input type="email" id="email" name="email" class="form-control" required style="width: 100%; padding: 12px; border: 1px solid var(--border-color); border-radius: 8px; background-color: var(--background-color); color: var(--text-color);">
                    </div>
                    <div style="margin-bottom: 20px;">
                        <label for="subjek" style="display: block; font-weight: bold; margin-bottom: 8px; color: var(--text-color);">Subjek:</label>
                        <input type="text" id="subjek" name="subjek" class="form-control" required style="width: 100%; padding: 12px; border: 1px solid var(--border-color); border-radius: 8px; background-color: var(--background-color); color: var(--text-color);">
                    </div>
                    <div style="margin-bottom: 30px;">
                        <label for="pesan" style="display: block; font-weight: bold; margin-bottom: 8px; color: var(--text-color);">Pesan / Saran Anda:</label>
                        <textarea id="pesan" name="pesan" rows="6" class="form-control" required style="width: 100%; padding: 12px; border: 1px solid var(--border-color); border-radius: 8px; background-color: var(--background-color); color: var(--text-color); resize: vertical;"></textarea>
                    </div>
                    <button type="submit" class="cta-button" style="width: 100%; padding: 15px; font-size: 1.2em;">Kirim Pesan</button>
                </form>
            </div>
        </section>
    </main>

    {{-- Memanggil komponen footer --}}
    <x-footer/>

    {{-- Script eksternal Leaflet JS (dimuat sekali di akhir body) --}}
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {

        // --- Fade In on Scroll Effect ---
        const faders = document.querySelectorAll('.fade-in');
        const appearOptions = {
            threshold: 0.1,
            rootMargin: "0px 0px -50px 0px" // Start animation 50px before element is fully in view
        };
        const appearOnScroll = new IntersectionObserver(function(entries, appearOnScroll) {
            entries.forEach(entry => {
                if (!entry.isIntersecting) {
                    return;
                } else {
                    entry.target.classList.add('visible');
                    appearOnScroll.unobserve(entry.target);
                }
            });
        }, appearOptions);

        faders.forEach(fader => {
            appearOnScroll.observe(fader);
        });

        // --- Dropdown Functionality and Smooth Scrolling ---
        const dropdowns = document.querySelectorAll('.dropdown');
        const header = document.querySelector('.header');
        const runningText = document.querySelector('.running-text');

        // Function to calculate dynamic offset for smooth scrolling
        function getScrollOffset() {
            const headerHeight = header ? header.offsetHeight : 60; // Default 60px if header not found
            const runningTextHeight = runningText ? runningText.offsetHeight : 0; // 0 if running text not found
            return headerHeight + runningTextHeight + 10; // Add a little extra margin
        }

        // Smooth scroll function
        function smoothScroll(targetId) {
            const targetElement = document.querySelector(targetId);
            if (targetElement) {
                const offset = getScrollOffset();
                window.scrollTo({
                    top: targetElement.offsetTop - offset,
                    behavior: 'smooth'
                });
            }
        }

        dropdowns.forEach(dropdown => {
            const dropbtn = dropdown.querySelector('.dropbtn');
            const dropdownContent = dropdown.querySelector('.dropdown-content');

            // Toggle dropdown on click for the main button
            dropbtn.addEventListener('click', function(event) {
                event.preventDefault(); // Prevent default link behavior (jumping to #)
                dropdownContent.classList.toggle('show'); // Toggle the 'show' class
            });

            // Close dropdown when a sub-link inside is clicked
            dropdownContent.querySelectorAll('a').forEach(link => {
                link.addEventListener('click', function(event) {
                    // event.preventDefault(); // Remove this if you want default anchor behavior first, then smooth scroll
                    smoothScroll(this.getAttribute('href')); // Use the smooth scroll function
                    dropdownContent.classList.remove('show'); // Close dropdown after clicking a link
                });
            });

            // Close dropdown if the mouse leaves the dropdown area (for desktop hover)
            // This is important because we use 'click' for mobile, but 'hover' still works on desktop
            dropdown.addEventListener('mouseleave', function() {
                // Only hide on mouseleave if it's not a mobile view (e.g., check for mobile menu active or screen width)
                // A more robust check might involve checking for `window.innerWidth > 768`
                if (window.innerWidth > 768) { // Assuming 768px is your mobile breakpoint
                    dropdownContent.classList.remove('show');
                }
            });
        });

        // Close all dropdowns when clicking anywhere else on the document
        document.addEventListener('click', function(event) {
            dropdowns.forEach(dropdown => {
                const dropdownContent = dropdown.querySelector('.dropdown-content');
                if (!dropdown.contains(event.target)) {
                    dropdownContent.classList.remove('show');
                }
            });
        });

        // Handle smooth scrolling for non-dropdown internal links (e.g., "Pelajari Lebih Lanjut" button)
        document.querySelectorAll('a[href^="#"]:not(.dropbtn)').forEach(anchor => {
            // Exclude dropdown buttons as they are handled by the dropdown logic
            if (!anchor.closest('.dropdown-content') && !anchor.classList.contains('dropbtn')) {
                anchor.addEventListener('click', function (e) {
                    e.preventDefault();
                    smoothScroll(this.getAttribute('href'));
                });
            }
        });


        // --- Leaflet Map Initialization for Batas Wilayah ---
        const mainMapId = 'map-batas-wilayah';
        if (document.getElementById(mainMapId)) {
            // Contoh koordinat untuk Desa Medalsari. Ganti dengan koordinat yang sebenarnya.
            const mainLatitude = -6.8906; // Contoh: Latitude pusat desa
            const mainLongitude = 107.6105; // Contoh: Longitude pusat desa
            const initialZoom = 13; // Zoom level

            const mainMap = L.map(mainMapId).setView([mainLatitude, mainLongitude], initialZoom);

            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                attribution: '© OpenStreetMap contributors'
            }).addTo(mainMap);

            // Contoh menambahkan polygon batas wilayah (ganti dengan koordinat batas desa Anda)
            const batasWilayahCoords = [
                [-6.895, 107.605],
                [-6.885, 107.615],
                [-6.890, 107.620],
                [-6.900, 107.610]
            ];
            const polygon = L.polygon(batasWilayahCoords, {color: 'red', weight: 3, opacity: 0.7, fillOpacity: 0.2}).addTo(mainMap);
            mainMap.fitBounds(polygon.getBounds()); // Sesuaikan peta agar seluruh polygon terlihat

            L.marker([mainLatitude, mainLongitude]).addTo(mainMap)
                .bindPopup("<b>Desa Medalsari</b><br>Pusat Desa").openPopup();
        }

        // --- Dark Mode Toggle (assuming you have a function called toggleDarkMode in app.js or similar) ---
        const darkModeToggle = document.getElementById('darkModeToggle');
        if (darkModeToggle) {
            // Load preferred mode from localStorage or default to light
            const currentMode = localStorage.getItem('theme') || 'light-mode';
            document.body.classList.add(currentMode);
            darkModeToggle.checked = (currentMode === 'dark-mode');

            darkModeToggle.addEventListener('change', function() {
                if (this.checked) {
                    document.body.classList.remove('light-mode');
                    document.body.classList.add('dark-mode');
                    localStorage.setItem('theme', 'dark-mode');
                } else {
                    document.body.classList.remove('dark-mode');
                    document.body.classList.add('light-mode');
                    localStorage.setItem('theme', 'light-mode');
                }
            });
        }

        // --- Mobile Menu Toggle Function ---
        // Ensure this function is globally accessible or defined within DOMContentLoaded
        window.toggleMenu = function() {
            const navLinks = document.querySelector('.nav-links');
            const mobileMenu = document.querySelector('.mobile-menu');
            navLinks.classList.toggle('active');
            mobileMenu.classList.toggle('active');

            // Close any open dropdowns when mobile menu is toggled
            dropdowns.forEach(dropdown => {
                const dropdownContent = dropdown.querySelector('.dropdown-content');
                dropdownContent.classList.remove('show');
            });
        };

    });
</script>

{{-- Stack for script peta (akan merender semua push('scripts') di sini) --}}
@stack('scripts')
</body>
</html>
