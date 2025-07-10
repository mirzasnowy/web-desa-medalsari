{{-- resources/views/sections/data_penduduk_section.blade.php --}}
<section id="data-penduduk" class="section">
    <h2 class="section-title fade-in">Data Penduduk Desa Medalsari</h2>
    @php
        // Dummy data untuk statistik jika tidak ada dari controller
        $totalPenduduk = $totalPenduduk ?? 5500;
        $jumlahLakiLaki = $jumlahLakiLaki ?? 2700;
        $jumlahPerempuan = $jumlahPerempuan ?? 2800;
        $jumlahKK = $jumlahKK ?? 1500;
        $mayoritasPekerjaan = $mayoritasPekerjaan ?? 'Petani & Wiraswasta';
        $mayoritasPendidikan = $mayoritasPendidikan ?? 'SMA/Sederajat';
    @endphp
    <div class="detail-contact-grid">
        <x-stat-data-item icon="fa-users" title="Total Penduduk" :value="'± ' . number_format($totalPenduduk, 0, ',', '.') . ' Jiwa'" />
        <x-stat-data-item icon="fa-male" title="Laki-laki" :value="'± ' . number_format($jumlahLakiLaki, 0, ',', '.') . ' Jiwa'" />
        <x-stat-data-item icon="fa-female" title="Perempuan" :value="'± ' . number_format($jumlahPerempuan, 0, ',', '.') . ' Jiwa'" />
        <x-stat-data-item icon="fa-handshake" title="Kepala Keluarga" :value="'± ' . number_format($jumlahKK, 0, ',', '.') . ' KK'" />
        <x-stat-data-item icon="fa-briefcase" title="Mayoritas Pekerjaan" :value="$mayoritasPekerjaan" />
        <x-stat-data-item icon="fa-graduation-cap" title="Tingkat Pendidikan" :value="$mayoritasPendidikan" />
    </div>
</section>