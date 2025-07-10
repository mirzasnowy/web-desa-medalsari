@extends('admin.layout') {{-- Pastikan ini mengarah ke layout admin Anda --}}

@section('title', 'Dashboard Admin') {{-- Judul halaman --}}

@section('content') {{-- Bagian konten utama halaman --}}
    <h1 class="mb-4">Dashboard Admin Desa Medalsari</h1>
    <div class="row">
        {{-- Card untuk Manajemen UMKM --}}
        <div class="col-md-6 col-lg-4 mb-4"> {{-- Menggunakan col-lg-4 untuk tampilan 3 kolom di layar besar --}}
            <div class="card h-100 shadow-sm"> {{-- h-100 untuk tinggi kartu yang sama, shadow-sm untuk bayangan halus --}}
                <div class="card-body">
                    <h5 class="card-title text-primary">Manajemen UMKM</h5> {{-- text-primary untuk warna judul yang konsisten --}}
                    <p class="card-text text-muted">Kelola data Usaha Mikro, Kecil, dan Menengah yang terdaftar di Desa Medalsari.</p>
                    <a href="{{ route('admin.umkms.index') }}" class="btn btn-primary mt-3">Lihat & Kelola UMKM</a>
                </div>
            </div>
        </div>

        {{-- Card untuk Manajemen Wisata Desa --}}
        <div class="col-md-6 col-lg-4 mb-4">
            <div class="card h-100 shadow-sm">
                <div class="card-body">
                    <h5 class="card-title text-success">Manajemen Wisata Desa</h5> {{-- text-success untuk warna hijau --}}
                    <p class="card-text text-muted">Kelola informasi dan detail tempat wisata di Desa Medalsari.</p>
                    <a href="{{ route('admin.wisata_desas.index') }}" class="btn btn-success mt-3">Lihat & Kelola Wisata</a>
                </div>
            </div>
        </div>

        {{-- Card untuk Manajemen Potret Desa --}}
        <div class="col-md-6 col-lg-4 mb-4">
            <div class="card h-100 shadow-sm">
                <div class="card-body">
                    <h5 class="card-title text-info">Manajemen Potret Desa</h5> {{-- text-info untuk warna biru cerah --}}
                    <p class="card-text text-muted">Kelola koleksi foto dan informasi tentang berbagai Potret Desa Medalsari.</p>
                    <a href="{{ route('admin.view_desas.index') }}" class="btn btn-info mt-3">Lihat & Kelola Potret</a>
                </div>
            </div>
        </div>

        {{-- NEW: Card untuk Manajemen Kearifan Lokal --}}
        <div class="col-md-6 col-lg-4 mb-4">
            <div class="card h-100 shadow-sm">
                <div class="card-body">
                    <h5 class="card-title text-warning">Manajemen Kearifan Lokal</h5> {{-- Menggunakan text-warning untuk warna kuning/oranye --}}
                    <p class="card-text text-muted">Kelola data tradisi, seni, dan budaya lokal Desa Medalsari.</p>
                    <a href="{{ route('admin.kearifan_lokals.index') }}" class="btn btn-warning mt-3">Lihat & Kelola Kearifan Lokal</a>
                </div>
            </div>
        </div>

        {{-- Card untuk Manajemen Kegiatan Desa --}}
        <div class="col-md-6 col-lg-4 mb-4">
            <div class="card h-100 shadow-sm">
                <div class="card-body">
                    <h5 class="card-title text-danger">Manajemen Kegiatan Desa</h5> {{-- Menggunakan text-danger untuk warna merah --}}
                    <p class="card-text text-muted">Kelola berita, acara, dan kegiatan yang berlangsung di Desa Medalsari.</p>
                    <a href="{{ route('admin.kegiatan_desas.index') }}" class="btn btn-danger mt-3">Lihat & Kelola Kegiatan</a>
                </div>
            </div>
        </div>

        {{-- Card untuk Manajemen Berita & Pengumuman --}}
        <div class="col-md-6 col-lg-4 mb-4">
            <div class="card h-100 shadow-sm">
                <div class="card-body">
                    <h5 class="card-title text-secondary">Manajemen Berita & Pengumuman</h5> {{-- Menggunakan text-secondary untuk warna abu-abu --}}
                    <p class="card-text text-muted">Kelola artikel berita dan pengumuman penting untuk warga desa.</p>
                    <a href="{{ route('admin.beritas.index') }}" class="btn btn-secondary mt-3">Lihat & Kelola Berita</a>
                </div>
            </div>
        </div>

        {{-- Card untuk Manajemen Aparatur Desa --}}
        <div class="col-md-6 col-lg-4 mb-4">
            <div class="card h-100 shadow-sm">
                <div class="card-body">
                    <h5 class="card-title text-dark">Manajemen Aparatur Desa</h5> {{-- Menggunakan text-dark untuk warna gelap --}}
                    <p class="card-text text-muted">Kelola data profil dan jabatan aparatur pemerintahan desa.</p>
                    <a href="{{ route('admin.aparatur_desas.index') }}" class="btn btn-dark mt-3">Lihat & Kelola Aparatur</a>
                </div>
            </div>
        </div>

        {{-- Card untuk Manajemen Data Penduduk (jika ada CRUD) --}}
        {{-- Jika Anda memiliki CRUD untuk data penduduk, Anda bisa mengaktifkan ini --}}
        {{-- <div class="col-md-6 col-lg-4 mb-4">
            <div class="card h-100 shadow-sm">
                <div class="card-body">
                    <h5 class="card-title text-primary">Manajemen Data Penduduk</h5>
                    <p class="card-text text-muted">Kelola data demografi dan informasi kependudukan desa.</p>
                    <a href="{{ route('admin.penduduks.index') }}" class="btn btn-primary mt-3">Lihat & Kelola Penduduk</a>
                </div>
            </div>
        </div> --}}

        {{-- Anda bisa menambahkan kartu lain di sini jika ada manajemen lain di masa depan --}}
    </div>
@endsection
