@extends('admin.layout')

@section('title', 'Detail Potret Desa')

@section('head')
    {{-- Leaflet CSS dan Font Awesome tidak diperlukan lagi di sini karena tidak ada peta --}}
    {{-- <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" /> --}}
    {{-- <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css"> --}}
    <style>
        #detail-map-viewdesa { /* Gaya ini tidak lagi akan digunakan */
            height: 350px;
            width: 100%;
            border-radius: 10px;
            border: 1px solid #ddd;
            margin-top: 20px;
            margin-bottom: 20px;
        }
        .detail-info {
            background-color: #f8f9fa;
            padding: 20px;
            border-radius: 8px;
            border: 1px solid #dee2e6;
            margin-bottom: 20px;
        }
        .detail-info p {
            margin-bottom: 8px;
        }
        .detail-info strong {
            color: #343a40;
        }
        .detail-image-preview {
            max-width: 100%;
            height: auto;
            border-radius: 8px;
            margin-bottom: 20px;
            box-shadow: 0 4px 8px rgba(0,0,0,0.1);
        }
        .detail-description-block {
            background-color: #f8f9fa;
            padding: 20px;
            border-radius: 8px;
            border: 1px solid #dee2e6;
            margin-bottom: 20px;
        }
    </style>
@endsection

@section('content')
    <h1 class="mb-4">Detail Potret Desa: {{ $viewDesa->nama }}</h1>

    <div class="card mb-4">
        <div class="card-body">
            @if($viewDesa->gambar)
                <img src="{{ asset('storage/' . $viewDesa->gambar) }}" alt="{{ $viewDesa->nama }}" class="detail-image-preview">
            @else
                <p class="text-center text-muted">Tidak ada gambar untuk potret ini.</p>
            @endif

            <div class="detail-info">
                <p><strong>Nama:</strong> {{ $viewDesa->nama }}</p>
                {{-- DIHAPUS: Kategori --}}
                {{-- <p><strong>Kategori:</strong> {{ $viewDesa->kategori ?? '-' }}</p> --}}
                {{-- DIHAPUS: Alamat/Lokasi --}}
                {{-- <p><strong>Alamat/Lokasi:</strong> {{ $viewDesa->alamat ?? '-' }}</p> --}}
                {{-- DIHAPUS: Telepon --}}
                {{-- <p><strong>Telepon:</strong> {{ $viewDesa->kontak_telepon ?? '-' }}</p> --}}
                {{-- DIHAPUS: Email --}}
                {{-- <p><strong>Email:</strong> {{ $viewDesa->kontak_email ?? '-' }}</p> --}}
            </div>

            <div class="detail-description-block">
                <h5>Deskripsi:</h5>
                <p>{{ $viewDesa->deskripsi }}</p>
            </div>

            {{-- DIHAPUS: Peta --}}
            {{-- @if($viewDesa->latitude && $viewDesa->longitude)
                <h5 class="mt-4">Lokasi di Peta:</h5>
                <div id="detail-map-viewdesa"></div>
            @else
                <p class="map-not-available text-center">Lokasi peta belum tersedia untuk potret ini.</p>
            @endif --}}

            <div class="d-flex justify-content-between mt-4">
                <a href="{{ route('admin.view_desas.edit', $viewDesa->id) }}" class="btn btn-warning">Edit</a>
                <form action="{{ route('admin.view_desas.destroy', $viewDesa->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus Potret Desa ini?');" style="display:inline-block;">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger">Hapus</button>
                </form>
                <a href="{{ route('admin.view_desas.index') }}" class="btn btn-secondary">Kembali ke Daftar</a>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    {{-- Script Leaflet JS tidak diperlukan lagi di sini --}}
    {{-- @if($viewDesa->latitude && $viewDesa->longitude)
        <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                // ... script peta ...
            });
        </script>
    @endif --}}
@endsection