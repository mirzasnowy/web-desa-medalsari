<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail UMKM: {{ $umkm->nama }} - Desa Medalsari</title>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <link rel="stylesheet" href="{{ asset('css/desa-medalsari.css') }}">
    <style>
        /* Styling khusus untuk halaman detail, bisa digabungkan ke desa-medalsari.css jika mau */
        .detail-container {
            max-width: 900px;
            margin: 8rem auto 4rem auto; /* Sesuaikan margin atas agar tidak tertutup header */
            padding: 2rem;
            background-color: var(--card-background-color); /* Use variable for consistency */
            border-radius: 15px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
            animation: fadeIn 0.8s ease-out;
            transition: background-color 0.4s ease, box-shadow 0.4s ease; /* Add transition for dark mode */
        }

        .detail-header {
            text-align: center;
            margin-bottom: 2rem;
        }

        .detail-header h1 {
            font-size: 2.8rem;
            color: var(--primary-green); /* Use primary green for consistency */
            margin-bottom: 0.5rem;
            transition: color 0.4s ease; /* Add transition for dark mode */
        }

        .detail-header .category {
            font-size: 1.2rem;
            color: var(--accent-blue); /* Use accent blue for consistency */
            font-weight: 600;
            transition: color 0.4s ease; /* Add transition for dark mode */
        }

        .detail-image {
            width: 100%;
            height: 400px;
            overflow: hidden;
            border-radius: 10px;
            margin-bottom: 2rem;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
        }

        .detail-image img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            display: block;
        }

        .detail-content p {
            font-size: 1.1rem;
            line-height: 1.8;
            color: var(--text-color); /* Use text color variable */
            margin-bottom: 1.5rem;
            transition: color 0.4s ease; /* Add transition for dark mode */
        }

        .detail-info-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 1rem;
            margin-top: 2rem;
            padding: 1.5rem;
            background-color: var(--background-color); /* Use background color variable */
            border-radius: 10px;
            border: 1px solid var(--border-color); /* Add border for consistency */
            transition: background-color 0.4s ease, border-color 0.4s ease; /* Add transition for dark mode */
        }

        .info-item {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            font-size: 1rem;
            color: var(--secondary-text-color); /* Use secondary text color variable */
            transition: color 0.4s ease; /* Add transition for dark mode */
        }

        .info-item strong {
            color: var(--primary-green-dark); /* Use primary green dark for consistency */
            transition: color 0.4s ease; /* Add transition for dark mode */
        }

        .info-item a {
            color: var(--accent-blue); /* Ensure links are visible */
            text-decoration: none;
            transition: color 0.3s ease;
        }

        .info-item a:hover {
            text-decoration: underline;
            color: var(--primary-green);
        }

        .back-button {
            display: inline-block;
            margin-top: 3rem;
            padding: 0.8rem 1.5rem;
            background-color: var(--accent-red); /* Use accent red for consistency */
            color: white;
            text-decoration: none;
            border-radius: 50px;
            transition: all 0.3s ease;
            font-weight: 500;
        }

        .back-button:hover {
            background-color: #E64A19; /* Slightly darker red on hover */
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(255, 87, 34, 0.4); /* Use consistent shadow */
        }

        /* Dark Mode Specific Styles for Detail Page (now mostly handled by variables) */
        /* Removed explicit dark mode styles here as they are now handled by CSS variables */

        /* Animation keyframes (if not already in desa-medalsari.css) */
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }

        @media (max-width: 768px) {
            .detail-container {
                margin-top: 6rem;
                padding: 1.5rem;
            }
            .detail-header h1 {
                font-size: 2.2rem;
            }
            .detail-header .category {
                font-size: 1rem;
            }
            .detail-image {
                height: 300px;
            }
            .detail-content p {
                font-size: 1rem;
            }
            .detail-info-grid {
                grid-template-columns: 1fr;
            }
        }

        @media (max-width: 480px) {
            .detail-container {
                margin-top: 5rem;
                padding: 1rem;
            }
            .detail-header h1 {
                font-size: 1.8rem;
            }
            .detail-image {
                height: 250px;
            }
        }
    </style>
</head>
<body class="light-mode">
    {{-- Memanggil komponen header --}}
    <x-header/>

    <main class="detail-container">
        <div class="detail-header">
            <h1>{{ $umkm->nama }}</h1>
            <div class="category">{{ $umkm->kategori }}</div>
        </div>

        <div class="detail-image">
            @if($umkm->gambar)
                <img src="{{ asset('storage/' . $umkm->gambar) }}" alt="{{ $umkm->nama }}">
            @else
                <img src="{{ asset('images/placeholder-umkm.jpg') }}" alt="Gambar UMKM Default"> {{-- Ganti dengan placeholder Anda --}}
            @endif
        </div>

        <div class="detail-content">
            <p>{{ $umkm->deskripsi_lengkap ?? $umkm->deskripsi }}</p> {{-- Jika ada deskripsi_lengkap --}}
            <p>Ini adalah contoh paragraf kedua untuk detail UMKM yang lebih panjang, menjelaskan lebih jauh tentang sejarah atau keunikan produk ini. Anda bisa menambahkan informasi lebih rinci di sini dari database.</p>
        </div>

        <div class="detail-info-grid">
            <div class="info-item">
                <strong>📞 Telepon:</strong> {{ $umkm->kontak_telepon ?? '-' }}
            </div>
            <div class="info-item">
                <strong>📧 Email:</strong> {{ $umkm->kontak_email ?? '-' }}
            </div>
            <div class="info-item">
                <strong>💰 Harga:</strong> {{ $umkm->harga ? 'Rp ' . number_format($umkm->harga, 0, ',', '.') : '-' }}
            </div>
            <div class="info-item">
                <strong>📍 Alamat:</strong> {{ $umkm->alamat ?? 'Tidak Tersedia' }}
            </div>
            <div class="info-item">
                <strong>🔗 Situs Web:</strong>
                @if($umkm->website)
                    <a href="{{ $umkm->website }}" target="_blank">{{ $umkm->website }}</a>
                @else
                    -
                @endif
            </div>
            {{-- Tambahkan info lain jika ada, contoh: jam operasional, media sosial --}}
        </div>

        <a href="{{ route('desa-medalsari') }}#umkm" class="back-button">← Kembali ke UMKM</a>
    </main>

    {{-- Memanggil komponen footer --}}
    <x-footer/>

    <script src="{{ asset('js/app.js') }}"></script>
    <script src="{{ asset('js/desa-medalsari.js') }}"></script>
</body>
</html>