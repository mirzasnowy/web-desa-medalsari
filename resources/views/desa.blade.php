<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Desa Medalsari - Portal Informasi & UMKM</title>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <link rel="stylesheet" href="{{ asset('css/desa-medalsari.css') }}">
</head>
<body>
    <header class="header">
        <nav class="nav">
            <div class="logo">Desa Medalsari</div>
            <ul class="nav-links">
                <li><a href="#home">Beranda</a></li>
                <li><a href="#info">Info Desa</a></li>
                <li><a href="#umkm">UMKM</a></li>
                <li><a href="#statistik">Statistik</a></li>
                <li><a href="#kontak">Kontak</a></li>
            </ul>
            <div class="mobile-menu" onclick="toggleMenu()">
                <span></span>
                <span></span>
                <span></span>
            </div>
        </nav>
    </header>

    <section id="home" class="hero">
        <div class="hero-content">
            <h1>Selamat Datang di Desa Medalsari</h1>
            <p>Desa modern dengan tradisi yang kuat, mendukung pertumbuhan UMKM dan kesejahteraan masyarakat</p>
            <a href="#info" class="cta-button">Jelajahi Desa Kami</a>
        </div>
    </section>

    <section id="info" class="section">
        <h2 class="section-title fade-in">Informasi Desa</h2>
        <div class="info-grid">
            <div class="info-card fade-in">
                <h3>📍 Lokasi & Geografis</h3>
                <p>Desa Medalsari terletak di dataran tinggi dengan ketinggian 800 meter di atas permukaan laut. Memiliki akses yang mudah ke kota kabupaten dengan jarak tempuh 15 km.</p>
                <div class="info-value">800 mdpl</div>
            </div>
            <div class="info-card fade-in">
                <h3>👥 Kependudukan</h3>
                <p>Jumlah penduduk sebanyak 2,450 jiwa yang terdiri dari 650 kepala keluarga. Mayoritas penduduk berusia produktif dengan mata pencaharian utama pertanian dan UMKM.</p>
                <div class="info-value">2,450 jiwa</div>
            </div>
            <div class="info-card fade-in">
                <h3>🌾 Sektor Unggulan</h3>
                <p>Pertanian organik, perkebunan kopi, dan industri kerajinan tangan menjadi sektor unggulan desa. Produk unggulan meliputi beras organik, kopi arabika, dan kerajinan bambu.</p>
                <div class="info-value">3 Sektor</div>
            </div>
            <div class="info-card fade-in">
                <h3>🏫 Fasilitas Umum</h3>
                <p>Tersedia fasilitas lengkap meliputi sekolah dasar, puskesmas pembantu, balai desa, dan pasar tradisional. Akses internet dan listrik sudah menjangkau 100% wilayah.</p>
                <div class="info-value">100%</div>
            </div>
            <div class="info-card fade-in">
                <h3>🛣️ Infrastruktur</h3>
                <p>Jalan desa sudah diaspal 85%, sistem drainase baik, dan akses air bersih tersedia untuk seluruh warga. Sedang dalam tahap pembangunan jalan penghubung antar dusun.</p>
                <div class="info-value">85%</div>
            </div>
            <div class="info-card fade-in">
                <h3>🎯 Program Unggulan</h3>
                <p>Program desa digital, pengembangan wisata alam, dan pemberdayaan UMKM menjadi fokus utama. Target menjadi desa mandiri dan sejahtera pada tahun 2026.</p>
                <div class="info-value">2026</div>
            </div>
        </div>
    </section>

    <section id="statistik" class="stats section">
        <h2 class="section-title">Statistik Desa</h2>
        <div class="stats-grid">
            <div class="stat-item fade-in">
                <div class="stat-number" data-target="45">0</div>
                <div class="stat-label">UMKM Aktif</div>
            </div>
            <div class="stat-item fade-in">
                <div class="stat-number" data-target="650">0</div>
                <div class="stat-label">Kepala Keluarga</div>
            </div>
            <div class="stat-item fade-in">
                <div class="stat-number" data-target="15">0</div>
                <div class="stat-label">Produk Unggulan</div>
            </div>
            <div class="stat-item fade-in">
                <div class="stat-number" data-target="98">0</div>
                <div class="stat-label">% Tingkat Kepuasan</div>
            </div>
        </div>
    </section>

    <section id="umkm" class="section">
        <h2 class="section-title fade-in">UMKM Desa Medalsari</h2>
        <div class="umkm-grid">
            <div class="umkm-card fade-in">
                <div class="umkm-image">☕</div>
                <div class="umkm-content">
                    <h3>Kopi Arabika Sejahtera</h3>
                    <div class="umkm-category">Perkebunan & Pengolahan</div>
                    <p>Memproduksi kopi arabika premium dengan cita rasa khas dataran tinggi. Menggunakan metode pengolahan tradisional dan modern.</p>
                    <div class="umkm-contact">
                        <div class="contact-item">📞 0821-1234-5678</div>
                        <div class="contact-item">📧 kopisejahtera@email.com</div>
                        <div class="contact-item">💰 Rp 45.000/kg</div>
                    </div>
                </div>
            </div>
            <div class="umkm-card fade-in">
                <div class="umkm-image">🎋</div>
                <div class="umkm-content">
                    <h3>Kerajinan Bambu Kreatif</h3>
                    <div class="umkm-category">Kerajinan Tangan</div>
                    <p>Menghasilkan berbagai produk kerajinan bambu seperti tas, tempat pensil, dan dekorasi rumah dengan desain modern.</p>
                    <div class="umkm-contact">
                        <div class="contact-item">📞 0822-9876-5432</div>
                        <div class="contact-item">📧 bambukreatif@email.com</div>
                        <div class="contact-item">💰 Rp 25.000 - 150.000</div>
                    </div>
                </div>
            </div>
            <div class="umkm-card fade-in">
                <div class="umkm-image">🌾</div>
                <div class="umkm-content">
                    <h3>Beras Organik Premium</h3>
                    <div class="umkm-category">Pertanian Organik</div>
                    <p>Memproduksi beras organik tanpa pestisida dengan kualitas premium. Sudah tersertifikasi organik dan dipasarkan hingga Jakarta.</p>
                    <div class="umkm-contact">
                        <div class="contact-item">📞 0823-1111-2222</div>
                        <div class="contact-item">📧 berasorganik@email.com</div>
                        <div class="contact-item">💰 Rp 18.000/kg</div>
                    </div>
                </div>
            </div>
            <div class="umkm-card fade-in">
                <div class="umkm-image">🍯</div>
                <div class="umkm-content">
                    <h3>Madu Hutan Asli</h3>
                    <div class="umkm-category">Produk Alam</div>
                    <p>Madu murni dari hutan sekitar desa dengan kualitas terjamin. Dipanen langsung dari sarang lebah liar dengan metode tradisional.</p>
                    <div class="umkm-contact">
                        <div class="contact-item">📞 0824-3333-4444</div>
                        <div class="contact-item">📧 maduhutan@email.com</div>
                        <div class="contact-item">💰 Rp 80.000/botol</div>
                    </div>
                </div>
            </div>
            <div class="umkm-card fade-in">
                <div class="umkm-image">🧺</div>
                <div class="umkm-content">
                    <h3>Anyaman Pandan Wangi</h3>
                    <div class="umkm-category">Kerajinan Tradisional</div>
                    <p>Menghasilkan tas, topi, dan peralatan rumah tangga dari anyaman pandan. Produk ramah lingkungan dengan kualitas ekspor.</p>
                    <div class="umkm-contact">
                        <div class="contact-item">📞 0825-5555-6666</div>
                        <div class="contact-item">📧 pandanwangi@email.com</div>
                        <div class="contact-item">💰 Rp 35.000 - 200.000</div>
                    </div>
                </div>
            </div>
            <div class="umkm-card fade-in">
                <div class="umkm-image">🥜</div>
                <div class="umkm-content">
                    <h3>Camilan Kacang Sehat</h3>
                    <div class="umkm-category">Makanan Ringan</div>
                    <p>Memproduksi berbagai camilan sehat dari kacang tanah lokal. Tersedia rasa original, pedas, dan balado tanpa pengawet.</p>
                    <div class="umkm-contact">
                        <div class="contact-item">📞 0826-7777-8888</div>
                        <div class="contact-item">📧 kacangsehat@email.com</div>
                        <div class="contact-item">💰 Rp 15.000/bungkus</div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <footer id="kontak" class="footer">
        <div class="footer-content">
            <h3>Kantor Desa Medalsari</h3>
            <p>Jl. Desa Raya No. 123, Kecamatan Sejahtera<br>
            Kabupaten Makmur, Provinsi Maju 12345</p>

            <div class="footer-links">
                <a href="tel:+621234567890">📞 (0123) 456-7890</a>
                <a href="mailto:info@desasejahtera.id">📧 info@desasejahtera.id</a>
                <a href="#">🌐 www.desasejahtera.id</a>
                <a href="#">📱 @desasejahtera</a>
            </div>

            <p style="margin-top: 2rem; opacity: 0.7;">
                &copy; 2025 Desa Medalsari. Semua hak cipta dilindungi.<br>
                Website ini dibuat untuk kemajuan desa dan pemberdayaan UMKM lokal.
            </p>
        </div>
    </footer>

    <script src="{{ asset('js/app.js') }}"></script>
    <script src="{{ asset('js/desa-medalsari.js') }}"></script>
</body>
</html>