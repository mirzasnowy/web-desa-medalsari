@extends('admin.layout')

@section('title', 'Detail UMKM')

@section('head')
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
    <style>
        #map {
            height: 300px; /* Ukuran peta, sesuaikan */
            width: 100%;
            border-radius: 8px;
            border: 1px solid #ddd;
            margin-top: 15px; /* Tambah sedikit margin agar tidak terlalu mepet */
        }
    </style>
@endsection

@section('content')
    <h1>Detail UMKM: {{ $umkm->nama }}</h1>
    <div class="card">
        <div class="card-body">
            @if($umkm->gambar)
                <div class="mb-3 text-center">
                    {{-- Menggunakan asset() helper untuk gambar dari storage/public --}}
                    <img src="{{ asset('storage/' . $umkm->gambar) }}" alt="Gambar UMKM" style="max-width: 300px; height: auto; border-radius: 8px;">
                </div>
            @else
                <p class="text-center text-muted">Tidak ada gambar untuk UMKM ini.</p>
            @endif

            <h5 class="card-title">{{ $umkm->nama }}</h5>
            <h6 class="card-subtitle mb-2 text-muted">{{ $umkm->kategori }}</h6>
            <p class="card-text">{{ $umkm->deskripsi }}</p>

            {{-- Map Display --}}
            @if($umkm->latitude && $umkm->longitude)
                <div class="mb-3">
                    <h6>Lokasi di Peta:</h6>
                    <div id="map"></div>
                </div>
            @else
                <div class="mb-3">
                    <p class="text-muted text-center">Lokasi peta belum tersedia untuk UMKM ini.</p>
                </div>
            @endif

            <ul class="list-group list-group-flush">
                @if($umkm->alamat)
                    <li class="list-group-item"><strong>Alamat:</strong> {{ $umkm->alamat }}</li>
                @endif
                @if($umkm->latitude && $umkm->longitude)
                    <li class="list-group-item"><strong>Koordinat:</strong> {{ $umkm->latitude }}, {{ $umkm->longitude }}</li>
                @endif
                <li class="list-group-item"><strong>Telepon:</strong> {{ $umkm->kontak_telepon ?? '-' }}</li>
                <li class="list-group-item"><strong>Email:</strong> {{ $umkm->kontak_email ?? '-' }}</li>
                <li class="list-group-item"><strong>Harga:</strong> {{ $umkm->harga ?? '-' }}</li>
                <li class="list-group-item"><strong>Dibuat:</strong> {{ $umkm->created_at->format('d M Y H:i') }}</li>
                <li class="list-group-item"><strong>Terakhir Diperbarui:</strong> {{ $umkm->updated_at->format('d M Y H:i') }}</li>
            </ul>
            <div class="mt-3">
                <a href="{{ route('admin.umkms.edit', $umkm->id) }}" class="btn btn-warning">Edit</a>
                <form action="{{ route('admin.umkms.destroy', $umkm->id) }}" method="POST" style="display:inline-block;">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger" onclick="return confirm('Apakah Anda yakin ingin menghapus UMKM ini?')">Hapus</button>
                </form>
                <a href="{{ route('admin.umkms.index') }}" class="btn btn-secondary">Kembali ke Daftar</a>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    @if($umkm->latitude && $umkm->longitude)
        <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                console.log("DOMContentLoaded terpicu. Menginisialisasi peta detail UMKM (Admin)."); // Debugging

                const latitude = parseFloat("{{ $umkm->latitude }}");
                const longitude = parseFloat("{{ $umkm->longitude }}");

                if (isNaN(latitude) || isNaN(longitude) || latitude < -90 || latitude > 90 || longitude < -180 || longitude > 180) {
                    console.error("Koordinat latitude atau longitude tidak valid untuk peta detail UMKM:", latitude, longitude);
                    document.getElementById('map').innerHTML = '<p class="text-danger text-center">Koordinat lokasi tidak valid.</p>';
                    return;
                }

                const mapElement = document.getElementById('map');
                if (mapElement) {
                    console.log("Elemen #map ditemukan. Menginisialisasi peta.");

                    var map = L.map('map').setView([latitude, longitude], 15); // Zoom level 15 untuk detail

                    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                        attribution: '© OpenStreetMap contributors'
                    }).addTo(map);

                    L.marker([latitude, longitude])
                        .addTo(map)
                        .bindPopup(`<b>{{ $umkm->nama }}</b><br>{{ $umkm->alamat ?? "Lokasi UMKM" }}`)
                        .openPopup(); // Menampilkan popup secara otomatis

                    map.invalidateSize(); // Penting untuk memastikan peta dirender dengan benar
                    console.log("Peta detail UMKM berhasil diinisialisasi pada", latitude, longitude);
                } else {
                    console.error("Elemen #map tidak ditemukan. Peta detail UMKM tidak dapat diinisialisasi.");
                }
            });
        </script>
    @endif
@endsection