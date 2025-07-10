{{-- resources/views/sections/galeri_kegiatan_section.blade.php --}}
<section id="galeri-kegiatan" class="section">
    <h2 class="section-title fade-in">Galeri Kegiatan Desa</h2>
    @php
        $kegiatanDesas = $kegiatanDesas ?? collect();
        if ($kegiatanDesas->isEmpty()) {
            $kegiatanDesas = collect([
                (object)['id' => 1, 'judul' => 'Perayaan HUT RI ke-79', 'gambar' => 'images/default-kegiatan.jpg'],
                (object)['id' => 2, 'judul' => 'Gotong Royong Bersih Desa', 'gambar' => 'images/default-kegiatan.jpg'],
                (object)['id' => 3, 'judul' => 'Pelatihan UMKM Digital', 'gambar' => 'images/default-kegiatan.jpg'],
                (object)['id' => 4, 'judul' => 'Kegiatan Posyandu Rutin', 'gambar' => 'images/default-kegiatan.jpg'],
            ]);
        }
    @endphp
    <div class="potret-desa-grid @if(($kegiatanDesas ?? collect())->count() == 1) single-item-grid @endif">
        @forelse($kegiatanDesas as $kegiatan)
            <x-kegiatan-potret-card :item="$kegiatan" type="kegiatan" />
        @empty
            <div class="col-12 text-center">
                <p>Belum ada kegiatan desa yang didokumentasikan.</p>
            </div>
        @endforelse
    </div>
    @if(($kegiatanDesas ?? collect())->count() > 0)
    <div class="text-center mt-5">
        <a href="{{ route('kegiatan_desa.index_public') }}" class="cta-button">Lihat Semua Kegiatan</a>
    </div>
    @endif
</section>