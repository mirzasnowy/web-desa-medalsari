@extends('admin.layout')

@section('title', 'Edit Potret Desa')

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
    <h1>Edit Potret Desa</h1>
    <form action="{{ route('admin.view_desas.update', $viewDesa->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT') {{-- PENTING: Untuk metode PUT/PATCH --}}

        <div class="form-group">
            <label for="nama">Nama Potret Desa</label>
            <input type="text" class="form-control" id="nama" name="nama" value="{{ old('nama', $viewDesa->nama) }}" required>
            @error('nama') <div class="text-danger">{{ $message }}</div> @enderror
        </div>

        {{-- DIHAPUS: Kategori Potret --}}
        {{-- <div class="form-group">
            <label for="kategori">Kategori Potret (Opsional)</label>
            <input type="text" class="form-control" id="kategori" name="kategori" value="{{ old('kategori', $viewDesa->kategori) }}">
            @error('kategori') <div class="text-danger">{{ $message }}</div> @enderror
        </div> --}}

        <div class="form-group">
            <label for="deskripsi">Deskripsi</label>
            <textarea class="form-control" id="deskripsi" name="deskripsi" rows="5" required>{{ old('deskripsi', $viewDesa->deskripsi) }}</textarea>
            @error('deskripsi') <div class="text-danger">{{ $message }}</div> @enderror
        </div>

        <div class="form-group">
            <label>Gambar Saat Ini</label>
            @if($viewDesa->gambar)
                <div class="mb-2">
                    <img src="{{ asset('storage/' . $viewDesa->gambar) }}" alt="Gambar Potret Desa" style="max-width: 200px; height: auto; border-radius: 8px;">
                </div>
            @else
                <p>Tidak ada gambar saat ini.</p>
            @endif
            <label for="gambar">Ubah Gambar (Opsional)</label>
            <input type="file" class="form-control-file" id="gambar" name="gambar" accept="image/*">
            <small class="form-text text-muted">Maks. 2MB, format: JPG, PNG, GIF, SVG. Kosongkan jika tidak ingin mengubah gambar.</small>
            @error('gambar') <div class="text-danger">{{ $message }}</div> @enderror
        </div>

        {{-- DIHAPUS: Map Location Section (seluruh div group peta dan input hiddennya) --}}
        {{-- DIHAPUS: Alamat/Lokasi --}}
        {{-- DIHAPUS: Kontak Telepon --}}
        {{-- DIHAPUS: Kontak Email --}}

        <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
        <a href="{{ route('admin.view_desas.index') }}" class="btn btn-secondary">Batal</a>
    </form>
@endsection

@section('scripts')
    {{-- Script Leaflet JS dan JS peta tidak diperlukan lagi di sini --}}
    {{-- <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script> --}}
    <script>
        // Semua fungsi JavaScript peta dihapus karena tidak ada peta lagi
    </script>
@endsectiona