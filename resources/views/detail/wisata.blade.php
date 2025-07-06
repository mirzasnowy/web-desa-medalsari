<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Wisata: {{ $wisata->nama }} - Desa Medalsari</title>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <link rel="stylesheet" href="{{ asset('css/desa-medalsari.css') }}">
    <style>
        /* Styling khusus untuk halaman detail, bisa digabungkan ke desa-medalsari.css jika mau */
        .detail-container {
            max-width: 900px;
            margin: 8rem auto 4rem auto; /* Sesuaikan margin atas agar tidak tertutup header */
            padding: 2rem;
            background-color: #fff;
            border-radius: 15px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
            animation: fadeIn 0.8s ease-out;
        }

        .detail-header {
            text-align: center;
            margin-bottom: 2rem;
        }

        .detail-header h1 {
            font-size: 2.8rem;
            color: #2563eb;
            margin-bottom: 0.5rem;
        }

        .detail-header .category {
            font-size: 1.2rem;
            color: #ff6b6b;
            font-weight: 600;
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
            color: #555;
            margin-bottom: 1.5rem;
        }

        .detail-info-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 1rem;
            margin-top: 2rem;
            padding: 1.5rem;
            background-color: #f8fafc;
            border-radius: 10px;
        }

        .info-item {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            font-size: 1rem;
            color: #333;
        }

        .info-item strong {
            color: #2563eb;
        }

        .back-button {
            display: inline-block;
            margin-top: 3rem;
            padding: 0.8rem 1.5rem;
            background-color: #4ecdc4;
            color: white;
            text-decoration: none;
            border-radius: 50px;
            transition: all 0.3s ease;
            font-weight: 500;
        }

        .back-button:hover {
            background-color: #38b2ac;
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(78, 205, 196, 0.4);
        }

        /* Dark Mode Specific Styles for Detail Page */
        body.dark-mode .detail-container {
            background-color: #2d3748;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.3);
        }

        body.dark-mode .detail-header h1 {
            color: #4299e1;
        }

        body.dark-mode .detail-header .category {
            color: #f6ad55;
        }

        body.dark-mode .detail-content p {
            color: #a0aec0;
        }

        body.dark-mode .detail-info-grid {
            background-color: #4a5568;
        }

        body.dark-mode .info-item {
            color: #e2e8f0;
        }

        body.dark-mode .info-item strong {
            color: #90cdf4;
        }
    </style>
</head>
<body class="light-mode">
    @include('components.header') {{-- Gunakan header yang sudah ada --}}

    <main class="detail-container">
        <div class="detail-header">
            <h1>{{ $wisata->nama }}</h1>
            <div class="category">{{ $wisata->kategori ?? 'Umum' }}</div>
        </div>

        <div class="detail-image">
            @if($wisata->gambar)
                <img src="{{ asset('storage/' . $wisata->gambar) }}" alt="{{ $wisata->nama }}">
            @else
                <img src="{{ asset('images/placeholder-wisata.jpg') }}" alt="Gambar Wisata Default"> {{-- Ganti dengan placeholder Anda --}}
            @endif
        </div>

        <div class="detail-content">
            <p>{{ $wisata->deskripsi_lengkap ?? $wisata->deskripsi }}</p> {{-- Jika ada deskripsi_lengkap --}}
            <p>Berikut adalah informasi lebih detail mengenai destinasi wisata ini, termasuk fasilitas yang tersedia, jam operasional, dan daya tarik utama lainnya. Rencanakan kunjungan Anda!</p>
        </div>

        <div class="detail-info-grid">
            <div class="info-item">
                <strong>📍 Alamat:</strong> {{ $wisata->alamat ?? '-' }}
            </div>
            <div class="info-item">
                <strong>📞 Telepon:</strong> {{ $wisata->kontak_telepon ?? '-' }}
            </div>
            <div class="info-item">
                <strong>📧 Email:</strong> {{ $wisata->kontak_email ?? '-' }}
            </div>
            {{-- Tambahkan info lain jika ada, contoh: harga tiket, jam buka, fasilitas --}}
            <div class="info-item">
                <strong>⏰ Jam Buka:</strong> 08:00 - 17:00 (contoh)
            </div>
            <div class="info-item">
                <strong>💲 Harga Tiket:</strong> Gratis / Rp 10.000 (contoh)
            </div>
        </div>

        <a href="{{ route('desa-medalsari') }}#wisata" class="back-button">← Kembali ke Wisata Desa</a>
    </main>

    @include('components.footer') {{-- Gunakan footer yang sudah ada --}}

    <script src="{{ asset('js/app.js') }}"></script>
    <script src="{{ asset('js/desa-medalsari.js') }}"></script>
</body>
</html>