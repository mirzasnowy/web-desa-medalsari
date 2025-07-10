{{-- resources/views/components/kearifan_item_card.blade.php --}}
@props(['kearifan'])

<div class="kearifan-card fade-in">
    <div class="kearifan-image">
        @if(!empty($kearifan->gambar))
            <img src="{{ asset('storage/' . $kearifan->gambar) }}"
                 alt="{{ $kearifan->nama }}"
                 style="width: 100%; height: 200px; object-fit: cover; border-radius: 15px 15px 0 0;">
        @else
            <img src="{{ asset('images/default-kearifan.jpg') }}"
                 alt="Gambar Default"
                 style="width: 100%; height: 200px; object-fit: cover; border-radius: 15px 15px 0 0;">
        @endif
    </div>

    <div class="kearifan-content" style="padding: 15px;">
        <div class="icon"><i class="fas {{ $kearifan->icon ?? 'fa-star' }}"></i></div>
        <h4>{{ $kearifan->nama }}</h4>
        <p>{{ Str::limit($kearifan->deskripsi, 180) }}</p>
        {{-- Jika ada peta kecil di sini, Anda bisa masukkan logika Leaflet di sini juga dengan @push('scripts') --}}
    </div>
</div>