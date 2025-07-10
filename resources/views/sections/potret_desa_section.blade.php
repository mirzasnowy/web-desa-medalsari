{{-- resources/views/sections/potret_desa_section.blade.php --}}
<section id="potret-desa" class="section">
    <h2 class="section-title fade-in">Potret Desa Medalsari</h2>
    @php
        $viewDesas = $viewDesas ?? collect();
        if ($viewDesas->isEmpty()) {
            $viewDesas = collect([
                (object)['id' => 1, 'nama' => 'Sawah Hijau Terhampar', 'gambar' => 'images/default-viewdesa.jpg'],
                (object)['id' => 2, 'nama' => 'Rumah Adat Tradisional', 'gambar' => 'images/default-viewdesa.jpg'],
                (object)['id' => 3, 'nama' => 'Anak-anak Bermain di Lapangan', 'gambar' => 'images/default-viewdesa.jpg'],
                (object)['id' => 4, 'nama' => 'Senja di Perkebunan', 'gambar' => 'images/default-viewdesa.jpg'],
            ]);
        }
    @endphp
    <div class="potret-desa-grid @if(($viewDesas ?? collect())->count() == 1) single-item-grid @endif">
        @forelse($viewDesas as $view)
            <x-kegiatan-potret-card :item="$view" type="viewdesa" />
        @empty
            <div class="col-12 text-center">
                <p>Belum ada potret desa yang tersedia.</p>
            </div>
        @endforelse
    </div>
    @if(($viewDesas ?? collect())->count() > 0)
    <div class="text-center mt-5">
        <a href="{{ url('/potret-desa') }}" class="cta-button">Lihat Semua Potret</a>
    </div>
    @endif
</section>