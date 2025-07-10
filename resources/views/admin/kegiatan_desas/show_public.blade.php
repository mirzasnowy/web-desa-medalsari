<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $kegiatanDesa->judul ?? 'Detail Kegiatan Desa' }} - Desa Medalsari</title>

    {{-- Memuat CSS dan JS utama aplikasi melalui Vite --}}
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    {{-- Memuat CSS eksternal Font Awesome untuk ikon --}}
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">

    <style>
        /* Variabel CSS untuk tema terang dan gelap */
        :root {
            --primary-color: #4CAF50; /* Hijau Utama (contoh) */
            --primary-color-dark: #388E3C; /* Hijau Lebih Gelap */
            --text-color: #333333; /* Warna teks gelap */
            --secondary-text-color: #555555; /* Warna teks sekunder */
            --background-color: #F8F9FA; /* Latar belakang terang */
            --card-background-color: #FFFFFF; /* Latar belakang card */
            --border-color: #E0E0E0; /* Warna border */
            --accent-color: #FFC107; /* Warna aksen */
            --button-text-color-light: #FFFFFF; /* Warna teks tombol terang */
        }

        body.dark-mode {
            --primary-color: #66BB6A;
            --primary-color-dark: #4CAF50;
            --text-color: #E0E0E0;
            --secondary-text-color: #A0AEC0;
            --background-color: #1A202C;
            --card-background-color: #2D3748;
            --border-color: #4A5568;
            --accent-color: #FFD54F;
            --button-text-color-light: #E0E0E0;
        }

        /* Styling umum */
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            margin: 0;
            padding: 0;
            background-color: var(--background-color);
            color: var(--text-color);
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            line-height: 1.6;
        }

        .container {
            max-width: 900px;
            margin: 50px auto;
            padding: 0 20px;
            flex-grow: 1; /* Memastikan konten mengisi ruang yang tersedia */
        }

        .detail-card {
            background-color: var(--card-background-color);
            border-radius: 15px;
            box-shadow: 0 8px 30px rgba(0, 0, 0, 0.1);
            padding: 30px;
            text-align: center;
            overflow: hidden; /* Penting untuk gambar */
        }

        .detail-image-container {
            width: 100%;
            height: 450px; /* Tinggi gambar yang konsisten */
            overflow: hidden;
            border-radius: 10px;
            margin-bottom: 25px;
            background-color: #eee; /* Placeholder background */
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .detail-image-container img {
            width: 100%;
            height: 100%;
            object-fit: cover; /* Memastikan gambar mengisi container */
            display: block;
        }

        .detail-title {
            font-size: 2.8em;
            color: var(--primary-color-dark);
            margin-bottom: 15px;
            line-height: 1.2;
        }

        .detail-meta {
            font-size: 1.0em;
            color: var(--secondary-text-color);
            margin-bottom: 25px;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
        }

        .detail-meta i {
            color: var(--primary-color);
        }

        .detail-description {
            font-size: 1.1em;
            color: var(--text-color);
            text-align: justify;
            margin-bottom: 30px;
            line-height: 1.8;
        }

        .back-button {
            display: inline-flex;
            align-items: center;
            gap: 8px;
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
            margin-top: 20px;
        }

        .back-button:hover {
            background-color: var(--primary-color-dark);
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(0, 0, 0, 0.15);
        }

        .back-button:active {
            transform: translateY(0);
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }

        .back-button svg {
            width: 20px;
            height: 20px;
            fill: currentColor;
        }

        /* Responsif */
        @media (max-width: 768px) {
            .container {
                margin: 20px auto;
                padding: 0 15px;
            }
            .detail-card {
                padding: 20px;
            }
            .detail-image-container {
                height: 250px;
            }
            .detail-title {
                font-size: 2em;
            }
            .detail-meta {
                font-size: 0.9em;
                flex-direction: column;
                gap: 5px;
            }
            .detail-description {
                font-size: 1em;
            }
            .back-button {
                padding: 10px 20px;
                font-size: 1em;
            }
        }
    </style>
</head>
<body class="light-mode">
    {{-- Memanggil komponen header --}}
    <x-header/>

    <main class="container">
        @if ($kegiatanDesa)
            <div class="detail-card">
                <div class="detail-image-container">
                    @if($kegiatanDesa->gambar)
                        <img src="{{ asset('storage/' . $kegiatanDesa->gambar) }}" alt="{{ $kegiatanDesa->judul }}">
                    @else
                        <img src="{{ asset('images/default-kegiatan.jpg') }}" alt="Gambar Default Kegiatan">
                    @endif
                </div>

                <h1 class="detail-title">{{ $kegiatanDesa->judul ?? 'Judul Kegiatan Tidak Tersedia' }}</h1>

                <div class="detail-meta">
                    <span title="Tanggal Kegiatan"><i class="far fa-calendar-alt"></i> {{ \Carbon\Carbon::parse($kegiatanDesa->tanggal_kegiatan)->locale('id')->isoFormat('D MMMM Y') }}</span>
                    {{-- Anda bisa menambahkan informasi lain di sini, misalnya kategori kegiatan jika ada --}}
                </div>

                <div class="detail-description">
                    <p>{{ $kegiatanDesa->deskripsi ?? 'Deskripsi kegiatan tidak tersedia.' }}</p>
                </div>

                <a href="{{ route('kegiatan_desas.index_public') }}" class="back-button">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24" height="24"><path d="M12.707 19.707a1 1 0 0 1-1.414 0l-7-7a1 1 0 0 1 0-1.414l7-7a1 1 0 0 1 1.414 1.414L7.414 11H20a1 1 0 0 1 0 2H7.414l5.293 5.293a1 1 0 0 1 0 1.414z"/></svg>
                    Kembali ke Daftar Kegiatan
                </a>
            </div>
        @else
            <div class="detail-card">
                <h1 class="detail-title">Kegiatan Tidak Ditemukan</h1>
                <p class="detail-description">Maaf, kegiatan yang Anda cari tidak dapat ditemukan.</p>
                <a href="{{ route('kegiatan_desas.index_public') }}" class="back-button">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24" height="24"><path d="M12.707 19.707a1 1 0 0 1-1.414 0l-7-7a1 1 0 0 1 0-1.414l7-7a1 1 0 0 1 1.414 1.414L7.414 11H20a1 1 0 0 1 0 2H7.414l5.293 5.293a1 1 0 0 1 0 1.414z"/></svg>
                    Kembali ke Daftar Kegiatan
                </a>
            </div>
        @endif
    </main>

    {{-- Memanggil komponen footer --}}
    <x-footer/>

    {{-- Script untuk toggle dark mode jika ada --}}
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Contoh sederhana untuk dark mode toggle, sesuaikan dengan implementasi Anda
            const darkModeToggle = document.querySelector('.dark-mode-toggle'); // Misal ada tombol ini di header
            if (darkModeToggle) {
                darkModeToggle.addEventListener('click', () => {
                    document.body.classList.toggle('dark-mode');
                    // Simpan preferensi pengguna ke localStorage
                    if (document.body.classList.contains('dark-mode')) {
                        localStorage.setItem('theme', 'dark');
                    } else {
                        localStorage.setItem('theme', 'light');
                    }
                });
            }

            // Muat preferensi tema saat halaman dimuat
            if (localStorage.getItem('theme') === 'dark') {
                document.body.classList.add('dark-mode');
            } else {
                document.body.classList.remove('dark-mode');
            }
        });
    </script>
</body>
</html>