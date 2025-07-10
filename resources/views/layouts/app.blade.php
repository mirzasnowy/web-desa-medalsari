<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Desa Medalsari - Portal Informasi & UMKM')</title>

    {{-- Memuat CSS dan JS utama aplikasi melalui Vite --}}
    {{-- Pastikan semua gaya CSS yang sebelumnya inline sudah ada di resources/css/app.css --}}
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    {{-- Memuat CSS eksternal untuk Leaflet (peta) dan Font Awesome (ikon) --}}
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">

    {{--
        CATATAN PENTING:
        Semua gaya CSS yang sebelumnya ada di dalam tag <style> di file HTML asli Anda
        SEHARUSNYA TELAH DIPINDAHKAN ke file CSS eksternal (misalnya resources/css/app.css atau
        file CSS terpisah seperti desa-medalsari.css yang kemudian diimpor oleh app.css).
        Ini adalah praktik terbaik untuk menjaga kode tetap bersih dan modular.
        Contoh variabel CSS yang harus ada di file CSS eksternal Anda:
        :root {
            --primary-color: #4CAF50;
            --primary-color-dark: #388E3C;
            --text-color: #333333;
            --secondary-text-color: #555555;
            --background-color: #F8F9FA;
            --card-background-color: #FFFFFF;
            --border-color: #E0E0E0;
            --accent-color: #FFC107;
            --button-color-dark: #212529;
            --button-text-color-light: #FFFFFF;
            --header-height: 60px;
            --running-text-height: 40px;
        }
        body.dark-mode {
            --primary-color: #66BB6A;
            --primary-color-dark: #4CAF50;
            --text-color: #E0E0E0;
            --secondary-text-color: #A0AEC0;
            --background-color: #1A202C;
            --card-background-color: #2D3748;
            --border-color: #4A5568;
            --accent-color: #FFD54F;
            --button-color-dark: #4A5568;
            --button-text-color-light: #E0E0E0;
        }
        html, body {
            margin: 0; padding: 0; width: 100%; height: 100%; overflow-x: hidden;
        }
        body {
            display: flex; flex-direction: column; min-height: 100vh; padding-top: var(--header-height);
        }
        .detail-container { /* ... gaya lainnya ... */ }
        .umkm-card { /* ... gaya lainnya ... */ }
        /* Dan semua kelas CSS lainnya seperti .hero, .section, .aparatur-grid, dll. */
    --}}
</head>
<body class="light-mode">

    {{-- Memanggil komponen header. Pastikan Anda memiliki file resources/views/components/header.blade.php --}}
    <x-header/>

    {{-- Bagian Running Text. Ini ditempatkan di layout karena kemungkinan akan muncul di semua halaman. --}}
    <div class="running-text">
        <div class="running-text-content">
            🎉 Selamat datang di Portal Desa Medalsari • 📢 Pendaftaran UMKM baru telah dibuka • 🏛️ Pelayanan administrasi desa kini tersedia online • 🌟 Mari bersama membangun desa yang lebih maju
        </div>
    </div>

    {{-- Slot untuk konten utama dari view yang menggunakan layout ini --}}
    @yield('content')

    {{-- Memanggil komponen footer. Pastikan Anda memiliki file resources/views/components/footer.blade.php --}}
    <x-footer/>

    {{-- Script eksternal Leaflet JS (dimuat sekali di akhir body untuk performa) --}}
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>

    {{-- Script untuk Fade In on Scroll --}}
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const faders = document.querySelectorAll('.fade-in');
            const appearOptions = {
                threshold: 0.1,
                rootMargin: "0px 0px -50px 0px" // Mulai animasi 50px sebelum elemen sepenuhnya terlihat
            };
            const appearOnScroll = new IntersectionObserver(function(entries, appearOnScroll) {
                entries.forEach(entry => {
                    if (!entry.isIntersecting) {
                        return;
                    } else {
                        entry.target.classList.add('visible');
                        appearOnScroll.unobserve(entry.target);
                    }
                });
            }, appearOptions);

            faders.forEach(fader => {
                appearOnScroll.observe(fader);
            });

            // Inisialisasi peta utama untuk Batas Wilayah
            // Ini ditempatkan di app.blade.php agar hanya diinisialisasi satu kali untuk seluruh aplikasi
            const mainMapId = 'map-batas-wilayah';
            if (document.getElementById(mainMapId)) {
                // Contoh koordinat untuk Desa Medalsari. Ganti dengan koordinat yang sebenarnya.
                const mainLatitude = -6.8906; // Contoh: Latitude pusat desa
                const mainLongitude = 107.6105; // Contoh: Longitude pusat desa
                const initialZoom = 13; // Level zoom awal

                const mainMap = L.map(mainMapId).setView([mainLatitude, mainLongitude], initialZoom);

                L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                    attribution: '© OpenStreetMap contributors'
                }).addTo(mainMap);

                // Contoh menambahkan polygon batas wilayah (ganti dengan koordinat batas desa Anda yang sebenarnya)
                const batasWilayahCoords = [
                    [-6.895, 107.605],
                    [-6.885, 107.615],
                    [-6.890, 107.620],
                    [-6.900, 107.610]
                ];
                const polygon = L.polygon(batasWilayahCoords, {color: 'red', weight: 3, opacity: 0.7, fillOpacity: 0.2}).addTo(mainMap);
                mainMap.fitBounds(polygon.getBounds()); // Sesuaikan peta agar seluruh polygon terlihat

                L.marker([mainLatitude, mainLongitude]).addTo(mainMap)
                    .bindPopup("<b>Desa Medalsari</b><br>Pusat Desa").openPopup();
            }
        });
    </script>

    {{-- Stack untuk script-script tambahan yang didorong dari view lain (misalnya script peta kecil di card) --}}
    @stack('scripts')
</body>
</html>
