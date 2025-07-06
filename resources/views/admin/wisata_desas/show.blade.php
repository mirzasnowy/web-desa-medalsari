{{-- Detail Wisata Desa dengan Map Display --}}
@extends('admin.layout')

@section('title', 'Detail Wisata Desa')

@section('head')
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
    <style>
        #map {
            height: 300px;
            width: 100%;
            border-radius: 8px;
            border: 1px solid #ddd;
            margin-top: 15px; /* Tambah sedikit margin agar tidak terlalu mepet */
            background-color: #e0e0e0; /* Tambah warna latar belakang untuk melihat apakah div muncul */
        }
    </style>
@endsection

@section('content')
    <h1>Detail Wisata Desa: {{ $wisataDesa->nama }}</h1>
    <div class="card">
        <div class="card-body">
            @if($wisataDesa->gambar)
                <div class="mb-3 text-center">
                    <img src="{{ asset('storage/' . $wisataDesa->gambar) }}" alt="Gambar Wisata" style="max-width: 300px; height: auto; border-radius: 8px;">
                </div>
            @else
                <p class="text-center text-muted">Tidak ada gambar untuk Wisata ini.</p>
            @endif

            <h5 class="card-title">{{ $wisataDesa->nama }}</h5>
            <h6 class="card-subtitle mb-2 text-muted">{{ $wisataDesa->kategori ?? '-' }}</h6>
            <p class="card-text">{{ $wisataDesa->deskripsi }}</p>

            {{-- Map Display --}}
            @if($wisataDesa->latitude && $wisataDesa->longitude)
                <div class="mb-3">
                    <h6>Lokasi di Peta:</h6>
                    <div id="map"></div>
                </div>
            @else
                <div class="mb-3">
                    <p class="text-muted text-center">Lokasi peta belum tersedia untuk wisata ini.</p>
                </div>
            @endif

            <ul class="list-group list-group-flush">
                <li class="list-group-item"><strong>Alamat:</strong> {{ $wisataDesa->alamat ?? '-' }}</li>
                @if($wisataDesa->latitude && $wisataDesa->longitude)
                    <li class="list-group-item"><strong>Koordinat:</strong> {{ $wisataDesa->latitude }}, {{ $wisataDesa->longitude }}</li>
                @endif
                <li class="list-group-item"><strong>Telepon:</strong> {{ $wisataDesa->kontak_telepon ?? '-' }}</li>
                <li class="list-group-item"><strong>Email:</strong> {{ $wisataDesa->kontak_email ?? '-' }}</li>
                <li class="list-group-item"><strong>Dibuat:</strong> {{ $wisataDesa->created_at->format('d M Y H:i') }}</li>
                <li class="list-group-item"><strong>Terakhir Diperbarui:</strong> {{ $wisataDesa->updated_at->format('d M Y H:i') }}</li>
            </ul>

            <div class="mt-3">
                <a href="{{ route('admin.wisata_desas.edit', $wisataDesa->id) }}" class="btn btn-warning">Edit</a>
                <form action="{{ route('admin.wisata_desas.destroy', $wisataDesa->id) }}" method="POST" style="display:inline-block;">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger" onclick="return confirm('Apakah Anda yakin ingin menghapus Wisata ini?')">Hapus</button>
                </form>
                <a href="{{ route('admin.wisata_desas.index') }}" class="btn btn-secondary">Kembali ke Daftar</a>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    @if($wisataDesa->latitude && $wisataDesa->longitude)
        <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                console.log("DOMContentLoaded terpicu untuk peta detail."); // Debugging step 1

                const latitude = parseFloat("{{ $wisataDesa->latitude }}"); // Pastikan parsing ke float
                const longitude = parseFloat("{{ $wisataDesa->longitude }}"); // Pastikan parsing ke float

                // Validasi koordinat jika perlu (optional, tapi bagus untuk robustness)
                if (isNaN(latitude) || isNaN(longitude) || latitude < -90 || latitude > 90 || longitude < -180 || longitude > 180) {
                    console.error("Koordinat latitude atau longitude tidak valid:", latitude, longitude);
                    document.getElementById('map').innerHTML = '<p class="text-danger text-center">Koordinat lokasi tidak valid.</p>';
                    return; // Hentikan jika koordinat tidak valid
                }

                const mapElement = document.getElementById('map');
                if (mapElement) {
                    console.log("Elemen #map ditemukan. Menginisialisasi peta."); // Debugging step 2

                    var map = L.map('map').setView([latitude, longitude], 15); // Zoom level 15 untuk detail

                    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                        attribution: '© OpenStreetMap contributors'
                    }).addTo(map);

                    L.marker([latitude, longitude])
                        .addTo(map)
                        .bindPopup(`<b>{{ $wisataDesa->nama }}</b><br>{{ $wisataDesa->alamat ?? "Lokasi Wisata" }}`)
                        .openPopup(); // Menampilkan popup secara otomatis

                    // Penting: Memaksa Leaflet untuk menghitung ulang ukuran petanya
                    // Ini seringkali memperbaiki masalah peta yang tidak muncul atau abu-abu
                    map.invalidateSize();
                    
                    console.log("Peta detail berhasil diinisialisasi pada", latitude, longitude); // Debugging step 3
                } else {
                    console.error("Elemen #map tidak ditemukan. Peta detail tidak dapat diinisialisasi."); // Debugging step 4
                }
            });
        </script>
    @endif
@endsection