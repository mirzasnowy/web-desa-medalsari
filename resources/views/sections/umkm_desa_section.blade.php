{{-- resources/views/sections/umkm_desa_section.blade.php --}}
<section id="umkm" class="section">
    <h2 class="section-title fade-in">UMKM Desa Medalsari</h2>
    @php
        $umkms = $umkms ?? collect();
        if ($umkms->isEmpty()) {
            $umkms = collect([
                (object)['id' => 1, 'nama' => 'Keripik Singkong Bu Ani', 'kategori' => 'Makanan', 'deskripsi' => 'Keripik singkong renyah dengan berbagai rasa.', 'gambar' => 'images/default-umkm.jpg', 'alamat' => 'Jl. Desa No. 1', 'harga' => 15000, 'latitude' => -6.8920, 'longitude' => 107.6080],
                (object)['id' => 2, 'nama' => 'Batik Tulis Medalsari', 'kategori' => 'Kerajinan', 'deskripsi' => 'Batik tulis tangan motif khas desa.', 'gambar' => 'images/default-umkm.jpg', 'alamat' => 'Jl. Seni No. 5', 'harga' => 250000, 'latitude' => -6.8950, 'longitude' => 107.6120],
            ]);
        }
    @endphp
    <div class="umkm-grid @if($umkms->count() == 1) single-item-grid @endif">
        @forelse($umkms as $umkm)
            <a href="{{ route('umkms.show_public', $umkm) }}" class="umkm-card-link">
                <x-umkm-wisata-card :item="$umkm" type="umkm" />
            </a>
        @empty
            <div class="col-12 text-center">
                <p>Belum ada data UMKM yang tersedia.</p>
            </div>
        @endforelse
    </div>
    @if(($umkms ?? collect())->count() > 0)
    <div class="text-center mt-5">
        <a href="{{ route('umkms.index_public') }}" class="cta-button">Lihat Semua UMKM</a>
    </div>
    @endif
</section>