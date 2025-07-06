{{-- Form Edit Wisata Desa dengan Map Location --}}
@extends('admin.layout')

@section('title', 'Edit Wisata Desa')

@section('head')
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
    <style>
        #map {
            height: 400px;
            width: 100%;
            border-radius: 8px;
            border: 1px solid #ddd;
            margin-top: 10px; /* Sedikit jarak dari search bar */
        }
        .location-info {
            background-color: #f8f9fa;
            padding: 10px;
            border-radius: 5px;
            margin-top: 10px;
        }
        .search-container {
            margin-bottom: 10px;
            display: flex; /* Menggunakan flexbox untuk tata letak yang lebih baik */
            gap: 5px; /* Memberikan sedikit celah antar elemen */
            align-items: center; /* Memastikan elemen sejajar vertikal */
        }
        .search-container input {
            flex-grow: 1; /* Input akan mengambil ruang yang tersedia */
        }
        .search-container button {
            flex-shrink: 0; /* Tombol tidak akan menyusut */
        }
    </style>
@endsection

@section('content')
    <h1>Edit Wisata Desa: {{ $wisataDesa->nama }}</h1>
    <form action="{{ route('admin.wisata_desas.update', $wisataDesa->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="form-group">
            <label for="nama">Nama Tempat Wisata</label>
            <input type="text" class="form-control" id="nama" name="nama" value="{{ old('nama', $wisataDesa->nama) }}" required>
            @error('nama') <div class="text-danger">{{ $message }}</div> @enderror
        </div>

        <div class="form-group">
            <label for="kategori">Kategori Wisata (Opsional)</label>
            <input type="text" class="form-control" id="kategori" name="kategori" value="{{ old('kategori', $wisataDesa->kategori) }}">
            @error('kategori') <div class="text-danger">{{ $message }}</div> @enderror
        </div>

        <div class="form-group">
            <label for="deskripsi">Deskripsi</label>
            <textarea class="form-control" id="deskripsi" name="deskripsi" rows="5" required>{{ old('deskripsi', $wisataDesa->deskripsi) }}</textarea>
            @error('deskripsi') <div class="text-danger">{{ $message }}</div> @enderror
        </div>

        <div class="form-group">
            <label for="gambar">Gambar Wisata (Opsional)</label>
            <input type="file" class="form-control-file" id="gambar" name="gambar" accept="image/*">
            <small class="form-text text-muted">Biarkan kosong jika tidak ingin mengubah gambar. Maks. 2MB, format: JPG, PNG, GIF, SVG.</small>
            @error('gambar') <div class="text-danger">{{ $message }}</div> @enderror
            @if($wisataDesa->gambar)
                <div class="mt-2">
                    <p>Gambar saat ini:</p>
                    <img src="{{ asset('storage/' . $wisataDesa->gambar) }}" alt="Gambar Wisata" style="max-width: 200px; height: auto; border-radius: 8px;">
                </div>
            @endif
        </div>

        {{-- Map Location Section --}}
        <div class="form-group">
            <label>Pilih Lokasi pada Peta</label>
            <div class="search-container">
                <input type="text" id="location-search" class="form-control" placeholder="Cari lokasi (cth: Green Canyon atau -6.43,107.38)">
                <button type="button" class="btn btn-info" id="search-btn">Cari</button>
            </div>
            <div id="map"></div>
            <div class="location-info">
                <small class="text-muted">Klik pada peta untuk memilih lokasi wisata atau gunakan fitur pencarian di atas (bisa nama lokasi atau koordinat Lat,Lng). Marker bisa di-drag untuk penyesuaian posisi.</small>
                <div id="selected-location" style="display: none;">
                    <strong>Lokasi Terpilih:</strong>
                    <span id="location-coordinates"></span>
                </div>
            </div>
        </div>

        {{-- Hidden inputs for coordinates --}}
        <input type="hidden" id="latitude" name="latitude" value="{{ old('latitude', $wisataDesa->latitude ?? '') }}">
        <input type="hidden" id="longitude" name="longitude" value="{{ old('longitude', $wisataDesa->longitude ?? '') }}">

        <div class="form-group">
            <label for="alamat">Alamat Wisata (Opsional)</label>
            <input type="text" class="form-control" id="alamat" name="alamat" value="{{ old('alamat', $wisataDesa->alamat) }}">
            <small class="form-text text-muted">Alamat akan terisi otomatis berdasarkan lokasi yang dipilih di peta, atau Anda dapat mengisi manual.</small>
            @error('alamat') <div class="text-danger">{{ $message }}</div> @enderror
        </div>

        <div class="form-group">
            <label for="kontak_telepon">Kontak Telepon (Opsional)</label>
            <input type="text" class="form-control" id="kontak_telepon" name="kontak_telepon" value="{{ old('kontak_telepon', $wisataDesa->kontak_telepon) }}">
            @error('kontak_telepon') <div class="text-danger">{{ $message }}</div> @enderror
        </div>

        <div class="form-group">
            <label for="kontak_email">Kontak Email (Opsional)</label>
            <input type="email" class="form-control" id="kontak_email" name="kontak_email" value="{{ old('kontak_email', $wisataDesa->kontak_email) }}">
            @error('kontak_email') <div class="text-danger">{{ $message }}</div> @enderror
        </div>

        <button type="submit" class="btn btn-primary">Update</button>
        <a href="{{ route('admin.wisata_desas.index') }}" class="btn btn-secondary">Batal</a>
    </form>
@endsection

@section('scripts')
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
    <script>
        // Deklarasikan variabel global, tapi inisialisasi di dalam DOMContentLoaded
        let map;
        let marker;

        // Fungsi pembantu untuk validasi koordinat
        function isValidCoordinates(lat, lng) {
            return typeof lat === 'number' && typeof lng === 'number' &&
                   lat >= -90 && lat <= 90 &&
                   lng >= -180 && lng <= 180;
        }

        // Fungsi untuk memperbarui info lokasi di UI dan input tersembunyi
        function updateLocationInfo(lat, lng) {
            document.getElementById('latitude').value = lat;
            document.getElementById('longitude').value = lng;
            document.getElementById('location-coordinates').textContent = `Lat: ${lat.toFixed(6)}, Lng: ${lng.toFixed(6)}`;
            document.getElementById('selected-location').style.display = 'block';

            // Reverse geocoding untuk mendapatkan alamat
            reverseGeocode(lat, lng);
        }

        // Fungsi untuk reverse geocoding (mendapatkan alamat dari koordinat)
        function reverseGeocode(lat, lng) {
            fetch(`https://nominatim.openstreetmap.org/reverse?lat=${lat}&lon=${lng}&format=json`)
                .then(response => response.json())
                .then(data => {
                    if (data.display_name) {
                        document.getElementById('alamat').value = data.display_name;
                    } else {
                        document.getElementById('alamat').value = 'Alamat tidak ditemukan';
                    }
                })
                .catch(error => {
                    console.error('Error in reverse geocoding:', error);
                    document.getElementById('alamat').value = 'Gagal mendapatkan alamat';
                });
        }

        // Fungsi utama untuk pencarian lokasi
        function searchLocation() {
            const query = document.getElementById('location-search').value.trim();
            if (query === '') {
                alert('Silakan masukkan nama lokasi atau koordinat (Lat,Lng) untuk dicari.');
                return;
            }

            // Tampilkan indikator loading
            const searchBtn = document.getElementById('search-btn');
            searchBtn.textContent = 'Mencari...';
            searchBtn.disabled = true;

            // Coba parsing input sebagai koordinat (misal: -6.43,107.38)
            const coordsMatch = query.match(/^(-?\d+\.?\d*)\s*,\s*(-?\d+\.?\d*)$/);
            let isCoordinateSearch = false;

            if (coordsMatch) {
                const lat = parseFloat(coordsMatch[1]);
                const lng = parseFloat(coordsMatch[2]);

                if (isValidCoordinates(lat, lng)) {
                    isCoordinateSearch = true;
                    map.setView([lat, lng], 15); // Zoom lebih dekat untuk koordinat
                    if (marker) {
                        map.removeLayer(marker);
                    }
                    marker = L.marker([lat, lng], { draggable: true }).addTo(map);
                    updateLocationInfo(lat, lng);
                    marker.on('dragend', function(e) {
                        updateLocationInfo(e.target.getLatLng().lat, e.target.getLatLng().lng);
                    });
                    // Reset tombol setelah selesai
                    searchBtn.textContent = 'Cari';
                    searchBtn.disabled = false;
                    return; // Berhenti di sini jika ini pencarian koordinat
                }
            }

            // Jika bukan koordinat, lakukan pencarian nama lokasi melalui Nominatim API
            fetch(`https://nominatim.openstreetmap.org/search?q=${encodeURIComponent(query)}&format=json&limit=1`)
                .then(response => {
                    if (!response.ok) {
                        throw new Error(`Network response was not ok: ${response.statusText}`);
                    }
                    return response.json();
                })
                .then(data => {
                    if (data.length > 0) {
                        const lat = parseFloat(data[0].lat);
                        const lng = parseFloat(data[0].lon);

                        map.setView([lat, lng], 15);

                        if (marker) {
                            map.removeLayer(marker);
                        }

                        marker = L.marker([lat, lng], { draggable: true }).addTo(map);
                        updateLocationInfo(lat, lng);

                        marker.on('dragend', function(e) {
                            updateLocationInfo(e.target.getLatLng().lat, e.target.getLatLng().lng);
                        });
                    } else {
                        alert('Lokasi tidak ditemukan. Coba pencarian yang lebih spesifik atau masukkan koordinat (contoh: -6.43,107.38).');
                    }
                })
                .catch(error => {
                    console.error('Error searching location:', error);
                    alert('Terjadi kesalahan saat mencari lokasi. Silakan coba lagi.');
                })
                .finally(() => {
                    // Reset tombol
                    searchBtn.textContent = 'Cari';
                    searchBtn.disabled = false;
                });
        }


        // Event listener DOMContentLoaded untuk memastikan DOM sudah siap
        document.addEventListener('DOMContentLoaded', function() {
            // Inisialisasi peta
            if (document.getElementById('map')) {
                map = L.map('map').setView([-6.2088, 106.8456], 10); // Default ke Jakarta
                L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                    attribution: '© OpenStreetMap contributors'
                }).addTo(map);
            } else {
                console.error("Elemen #map tidak ditemukan. Peta tidak dapat diinisialisasi.");
                return;
            }

            // Event listener untuk klik pada peta
            map.on('click', function(e) {
                const lat = e.latlng.lat;
                const lng = e.latlng.lng;

                if (marker) {
                    map.removeLayer(marker);
                }

                marker = L.marker([lat, lng], { draggable: true }).addTo(map);
                updateLocationInfo(lat, lng);

                marker.on('dragend', function(e) {
                    updateLocationInfo(e.target.getLatLng().lat, e.target.getLatLng().lng);
                });
            });

            // Event listener untuk tombol 'Cari'
            document.getElementById('search-btn').addEventListener('click', searchLocation);

            // Event listener untuk menekan tombol 'Enter' pada input pencarian
            document.getElementById('location-search').addEventListener('keypress', function(e) {
                if (e.key === 'Enter') {
                    e.preventDefault(); // Mencegah form disubmit
                    searchLocation();
                }
            });

            // Muat koordinat lama jika ada (mode edit) atau coba dapatkan lokasi pengguna
            const existingLat = document.getElementById('latitude').value;
            const existingLng = document.getElementById('longitude').value;

            if (existingLat && existingLng) {
                const lat = parseFloat(existingLat);
                const lng = parseFloat(existingLng);
                
                if (isValidCoordinates(lat, lng)) {
                    map.setView([lat, lng], 15); // Zoom lebih dekat ke lokasi yang ada

                    if (marker) {
                        map.removeLayer(marker);
                    }

                    marker = L.marker([lat, lng], { draggable: true }).addTo(map);
                    updateLocationInfo(lat, lng);

                    marker.on('dragend', function(e) {
                        updateLocationInfo(e.target.getLatLng().lat, e.target.getLatLng().lng);
                    });
                } else {
                    console.warn("Koordinat lama tidak valid. Menggunakan default atau lokasi pengguna.");
                    initMapDefaultOrGeolocation();
                }
            } else {
                // Jika tidak ada koordinat lama, coba dapatkan lokasi pengguna
                initMapDefaultOrGeolocation();
            }

            // Fungsi untuk inisialisasi peta default atau berdasarkan geolocation
            function initMapDefaultOrGeolocation() {
                if (navigator.geolocation) {
                    navigator.geolocation.getCurrentPosition(function(position) {
                        const lat = position.coords.latitude;
                        const lng = position.coords.longitude;
                        map.setView([lat, lng], 13);
                        // Hanya tambahkan marker jika belum ada dari koordinat lama
                        if (!marker) {
                            marker = L.marker([lat, lng], { draggable: true }).addTo(map);
                            updateLocationInfo(lat, lng);
                            marker.on('dragend', function(e) {
                                updateLocationInfo(e.target.getLatLng().lat, e.target.getLatLng().lng);
                            });
                        }
                    }, function(error) {
                        console.warn('Error mendapatkan lokasi pengguna:', error);
                        map.setView([-2.5, 118], 5); // Fallback ke tengah Indonesia
                    });
                } else {
                    console.log("Geolocation tidak didukung oleh browser.");
                    map.setView([-2.5, 118], 5); // Default view jika geolocation tidak tersedia
                }
            }

        }); // End of DOMContentLoaded
    </script>
@endsection