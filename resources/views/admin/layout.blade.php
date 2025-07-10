<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Desa Medalsari - @yield('title')</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    {{-- Anda perlu menambahkan @yield('head') di sini jika Anda ingin CSS khusus halaman (seperti Leaflet CSS) --}}
    @yield('head') 
    <style>
        body { background-color: #f8f9fa; }
        .wrapper { display: flex; min-height: 100vh; }
        .sidebar { width: 250px; background-color: #343a40; color: white; padding: 20px; }
        .sidebar a { color: white; display: block; padding: 10px 0; text-decoration: none; }
        .sidebar a:hover { background-color: #495057; border-radius: 5px; }
        .content { flex-grow: 1; padding: 20px; }
        .navbar-admin { margin-bottom: 20px; }
    </style>
</head>
<body>
    <div class="wrapper">
        <nav class="sidebar">
            <h4 class="text-white mb-4">Admin Panel</h4>
            <ul class="list-unstyled">
                <li><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                <li><a href="{{ route('admin.umkms.index') }}">Manajemen UMKM</a></li>
                <li><a href="{{ route('admin.view_desas.index') }}">Manajemen Potret Desa</a></li> {{-- Menggunakan nama yang lebih konsisten --}}
                <li><a href="{{ route('admin.wisata_desas.index') }}">Manajemen Wisata Desa</a></li>
                {{-- NEW: Tambahan untuk Kegiatan Desa --}}
                <li><a href="{{ route('admin.kegiatan_desas.index') }}">Manajemen Kegiatan Desa</a></li>
                {{-- NEW: Tambahan untuk Berita & Pengumuman --}}
                <li><a href="{{ route('admin.beritas.index') }}">Manajemen Berita & Pengumuman</a></li>
                {{-- NEW: Tambahan untuk Kearifan Lokal --}}
                <li><a href="{{ route('admin.kearifan_lokals.index') }}">Manajemen Kearifan Lokal</a></li>
                {{-- Anda bisa menambahkan link lain di sini jika ada manajemen lain di masa depan --}}
            </ul>
            <hr class="border-secondary">
            <form action="{{ route('admin.logout') }}" method="POST">
                @csrf
                <button type="submit" class="btn btn-danger btn-block">Logout</button>
            </form>
        </nav>

        <div class="content">
            <nav class="navbar navbar-expand-lg navbar-light bg-light rounded shadow-sm navbar-admin">
                <a class="navbar-brand" href="#">@yield('title')</a>
                <div class="collapse navbar-collapse" id="navbarNav">
                    <ul class="navbar-nav ml-auto">
                        <li class="nav-item">
                            <span class="navbar-text">
                                Selamat datang, {{ Auth::user()->name }}!
                            </span>
                        </li>
                    </ul>
                </div>
            </nav>

            @if (session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
            @endif
            @if (session('error'))
                <div class="alert alert-danger">
                    {{ session('error') }}
                </div>
            @endif

            @yield('content')
        </div>
    </div>

    {{-- Script Bootstrap dan dependensi lainnya harus dimuat duluan --}}
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

    {{-- INI ADALAH BAGIAN KRUSIAL YANG HILANG! --}}
    {{-- Semua kode JavaScript dari @section('scripts') di file Blade form Anda akan dirender di sini. --}}
    @yield('scripts') 

</body>
</html>
