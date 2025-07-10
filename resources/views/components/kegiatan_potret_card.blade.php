{{-- resources/views/components/kegiatan_potret_card.blade.php --}}
@props(['item', 'type']) {{-- 'item' bisa kegiatan atau viewDesa, 'type' untuk default image --}}

<a href="{{ ($type == 'kegiatan') ? route('kegiatan_desa.show_public', $item) : route('view_desas.show_public', $item) }}" class="potret-desa-card-link">
    <div class="potret-desa-card fade-in">
        @if($item->gambar)
            <img src="{{ asset('storage/' . $item->gambar) }}" alt="{{ $item->judul ?? $item->nama }}">
        @else
            @php
                $defaultImage = ($type == 'kegiatan') ? 'images/default-kegiatan.jpg' : 'images/default-viewdesa.jpg';
                $altText = ($type == 'kegiatan') ? 'Gambar Default Kegiatan' : 'Gambar Default Desa';
            @endphp
            <img src="{{ asset($defaultImage) }}" alt="{{ $altText }}">
        @endif
        <div class="card-overlay">
            <h4>{{ $item->judul ?? $item->nama }}</h4>
        </div>
    </div>
</a>