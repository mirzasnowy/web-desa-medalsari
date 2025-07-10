@extends('admin.layout')

@section('title', 'Tambah Potret Desa Baru')

@section('head')
    {{-- Leaflet CSS dan Font Awesome tidak diperlukan lagi di sini karena tidak ada peta --}}
    {{-- <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" /> --}}
    {{-- <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css"> --}}
    <style>
        /* Gaya peta dan terkait pencarian tidak lagi dibutuhkan di sini */
        /* #map { height: 400px; width: 100%; border-radius: 8px; border: 1px solid #ddd; margin-top: 10px; } */
        /* .location-info { background-color: #f8f9fa; padding: 10px; border-radius: 5px; margin-top: 10px; border: 1px solid #dee2e6; } */
        /* .search-container { margin-bottom: 15px; display: flex; gap: 5px; align-items: center; } */
        /* .search-container input { flex-grow: 1; } */
        /* .search-container button { flex-shrink: 0; } */
    </style>
@endsection

@section('content')
    <h1>Tambah Potret Desa Baru</h1>
    <form action="{{ route('admin.view_desas.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="form-group">
            <label for="nama">Nama Potret Desa</label>
            <input type="text" class="form-control" id="nama" name="nama" value="{{ old('nama') }}" required>
            @error('nama') <div class="text-danger">{{ $message }}</div> @enderror
        </div>

        {{-- DIHAPUS: Kategori Potret --}}
        {{-- <div class="form-group">
            <label for="kategori">Kategori Potret (Opsional)</label>
            <input type="text" class="form-control" id="kategori" name="kategori" value="{{ old('kategori') }}">
            @error('kategori') <div class="text-danger">{{ $message }}</div> @enderror
        </div> --}}

        <div class="form-group">
            <label for="deskripsi">Deskripsi</label>
            <textarea class="form-control" id="deskripsi" name="deskripsi" rows="5" required>{{ old('deskripsi') }}</textarea>
            @error('deskripsi') <div class="text-danger">{{ $message }}</div> @enderror
        </div>

        <div class="form-group">
            <label for="gambar">Gambar Potret (Opsional)</label>
            <input type="file" class="form-control-file" id="gambar" name="gambar" accept="image/*">
            <small class="form-text text-muted">Maks. 2MB, format: JPG, PNG, GIF, SVG.</small>
            @error('gambar') <div class="text-danger">{{ $message }}</div> @enderror
        </div>

        {{-- DIHAPUS: Map Location Section (seluruh div group peta dan input hiddennya) --}}
        {{-- <div class="form-group"> ... seluruh kode peta ... </div> --}}
        {{-- <input type="hidden" id="latitude" name="latitude" value="{{ old('latitude') }}"> --}}
        {{-- <input type="hidden" id="longitude" name="longitude" value="{{ old('longitude') }}"> --}}

        {{-- DIHAPUS: Alamat/Lokasi --}}
        {{-- <div class="form-group">
            <label for="alamat">Alamat/Lokasi (Opsional)</label>
            <input type="text" class="form-control" id="alamat" name="alamat" value="{{ old('alamat') }}">
            <small class="form-text text-muted">Alamat akan terisi otomatis berdasarkan lokasi yang dipilih di peta, atau Anda dapat mengisi manual.</small>
            @error('alamat') <div class="text-danger">{{ $message }}</div> @enderror
        </div> --}}

        {{-- DIHAPUS: Kontak Telepon --}}
        {{-- <div class="form-group">
            <label for="kontak_telepon">Kontak Telepon (Opsional)</label>
            <input type="text" class="form-control" id="kontak_telepon" name="kontak_telepon" value="{{ old('kontak_telepon') }}">
            @error('kontak_telepon') <div class="text-danger">{{ $message }}</div> @enderror
        </div> --}}

        {{-- DIHAPUS: Kontak Email --}}
        {{-- <div class="form-group">
            <label for="kontak_email">Kontak Email (Opsional)</label>
            <input type="email" class="form-control" id="kontak_email" name="kontak_email" value="{{ old('kontak_email') }}">
            @error('kontak_email') <div class="text-danger">{{ $message }}</div> @enderror
        </div> --}}

        <button type="submit" class="btn btn-primary">Simpan</button>
        <a href="{{ route('admin.view_desas.index') }}" class="btn btn-secondary">Batal</a>
    </form>
@endsection

@section('scripts')
    {{-- Script Leaflet JS dan JS peta tidak diperlukan lagi di sini --}}
    {{-- <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script> --}}
    <script>
        // Semua fungsi JavaScript peta dihapus karena tidak ada peta lagi
        // let map; ...
        // function isValidCoordinates ...
        // document.addEventListener('DOMContentLoaded', function() { ... });
    </script>
@endsectione