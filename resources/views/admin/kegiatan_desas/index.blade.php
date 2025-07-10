{{-- Ganti baris ini dari @extends('admin.layout') atau yang sejenis --}}
{{-- Jika ini memang halaman publik, Anda mungkin tidak perlu extend layout admin --}}
{{-- Atau Anda bisa menggunakan layout utama yang tidak memerlukan auth --}}

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Kegiatan Desa - Desa Medalsari</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    {{-- Masukkan juga style CSS dari layout yang Anda harapkan, atau include file CSS eksternal Anda --}}
    <style>
         /* Gaya CSS yang sudah Anda definisikan sebelumnya */
         /* Pastikan juga Anda memiliki variabel CSS yang relevan atau definisi gaya di app.css */
         body {
            font-family: sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f4f4;
        }
        .container {
            max-width: 1200px;
            margin: 50px auto;
            padding: 20px;
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }
        h1 {
            text-align: center;
            color: #333;
            margin-bottom: 30px;
        }
        .kegiatan-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 20px;
        }
        .kegiatan-card {
            border: 1px solid #ddd;
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 2px 5px rgba(0,0,0,0.05);
            transition: transform 0.2s;
            text-decoration: none;
            color: inherit;
        }
        .kegiatan-card:hover {
            transform: translateY(-5px);
        }
        .kegiatan-card img {
            width: 100%;
            height: 200px;
            object-fit: cover;
        }
        .kegiatan-content {
            padding: 15px;
        }
        .kegiatan-content h2 {
            font-size: 1.5em;
            margin-top: 0;
            color: #4CAF50;
        }
        .kegiatan-content p {
            font-size: 0.9em;
            color: #555;
        }
        .kegiatan-content .date {
            font-size: 0.8em;
            color: #888;
            margin-top: 10px;
            display: block;
        }
        .pagination {
            margin-top: 30px;
            display: flex;
            justify-content: center;
            gap: 10px;
        }
        .pagination a, .pagination span {
            padding: 8px 12px;
            border: 1px solid #4CAF50;
            border-radius: 4px;
            text-decoration: none;
            color: #4CAF50;
            transition: background-color 0.2s, color 0.2s;
        }
        .pagination a:hover {
            background-color: #4CAF50;
            color: #fff;
        }
        .pagination .active span {
            background-color: #4CAF50;
            color: #fff;
            border-color: #4CAF50;
        }
    </style>
</head>
<body>
    {{-- Pastikan komponen header/footer ini tidak menggunakan Auth::user() tanpa pengecekan --}}
    <x-header/>

    <div class="container">
        <h1>Daftar Kegiatan Desa</h1>

        @if ($kegiatanDesas->isEmpty())
            <p style="text-align: center;">Belum ada kegiatan desa yang tersedia.</p>
        @else
            <div class="kegiatan-grid">
                @foreach ($kegiatanDesas as $kegiatan)
                    <a href="{{ route('kegiatan_desas.show_public', $kegiatan->id) }}" class="kegiatan-card">
                        @if($kegiatan->gambar)
                            <img src="{{ asset('storage/' . $kegiatan->gambar) }}" alt="{{ $kegiatan->judul }}">
                        @else
                            <img src="{{ asset('images/default-kegiatan.jpg') }}" alt="Gambar Default Kegiatan">
                        @endif
                        <div class="kegiatan-content">
                            <h2>{{ $kegiatan->judul }}</h2>
                            <p>{{ \Illuminate\Support\Str::limit($kegiatan->deskripsi, 100) }}</p>
                            <span class="date"><i class="far fa-calendar-alt"></i> {{ \Carbon\Carbon::parse($kegiatan->tanggal_kegiatan)->locale('id')->isoFormat('D MMMM Y') }}</span>
                        </div>
                    </a>
                @endforeach
            </div>

            {{-- Pagination Links --}}
            <div class="pagination">
                {{ $kegiatanDesas->links() }}
            </div>
        @endif
    </div>

    <x-footer/>
</body>
</html>