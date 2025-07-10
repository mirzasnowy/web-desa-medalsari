{{-- resources/views/sections/berita_pengumuman_section.blade.php --}}
<section id="berita-pengumuman" class="section">
    <h2 class="section-title fade-in">Berita & Pengumuman Terbaru</h2>
    @php
        $beritas = $beritas ?? collect();
        if ($beritas->isEmpty()) {
            $beritas = collect([
                (object)['id' => 1, 'judul' => 'Sosialisasi Program Bantuan Sosial', 'tanggal_publikasi' => '2025-07-01', 'konten' => 'Telah dilaksanakan sosialisasi program bantuan sosial bagi warga Desa Medalsari...', 'gambar_utama' => 'images/default-berita.jpg'],
                (object)['id' => 2, 'judul' => 'Gotong Royong Bersih-bersih Lingkungan', 'tanggal_publikasi' => '2025-06-25', 'konten' => 'Warga Desa Medalsari antusias mengikuti kegiatan gotong royong membersihkan lingkungan desa...', 'gambar_utama' => 'images/default-berita.jpg'],
                (object)['id' => 3, 'judul' => 'Pengumuman Penerimaan Calon Perangkat Desa', 'tanggal_publikasi' => '2025-06-20', 'konten' => 'Diberitahukan kepada seluruh warga Desa Medalsari bahwa telah dibuka pendaftaran calon perangkat desa...', 'gambar_utama' => 'images/default-berita.jpg'],
            ]);
        }
    @endphp 

    <div class="berita-list">
        @forelse($beritas as $berita)
            <x-berita-item-card :berita="$berita" />
        @empty
            <div class="col-12 text-center">
                <p>Belum ada berita atau pengumuman terbaru.</p>
            </div>
        @endforelse
    </div>
    @if(($beritas ?? collect())->count() > 0)
    <div class="text-center mt-5">
        <a href="{{ route('berita.index_public') }}" class="cta-button">Lihat Semua Berita</a>
    </div>
    @endif
</section>