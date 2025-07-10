{{-- resources/views/components/umkm_wisata_card.blade.php --}}
@props(['item', 'type']) {{-- 'item' bisa umkm atau wisata, 'type' untuk ID peta dan gambar default --}}

<div class="umkm-card fade-in">
    <div class="umkm-image">
        @if($item->gambar)
            <img src="{{ asset('storage/' . $item->gambar) }}" alt="{{ $item->nama ?? $item->judul }}" style="width: 100%; height: 100%; object-fit: cover; border-radius: 15px 15px 0 0;">
        @else
            @php
                $defaultImage = ($type == 'wisata') ? 'images/default-wisata.jpg' : 'images/default-umkm.jpg';
                $altText = ($type == 'wisata') ? 'Gambar Default Wisata' : 'Gambar Default UMKM';
            @endphp
            <img src="{{ asset($defaultImage) }}" alt="{{ $altText }}" style="width: 100%; height: 100%; object-fit: cover; border-radius: 15px 15px 0 0;">
        @endif
    </div>
    <div class="umkm-content">
        <h3>{{ $item->nama ?? $item->judul }}</h3>
        <div class="umkm-category">{{ $item->kategori ?? '-' }}</div>
        <p>{{ Str::limit($item->deskripsi, 100) }}</p>
        <div class="umkm-contact">
            @if(isset($item->alamat) && $item->alamat)
                <div class="contact-item">📍 {{ $item->alamat }}</div>
            @endif
            @if(isset($item->harga))
                <div class="contact-item">💰
                    @if($item->harga)
                        Rp {{ number_format($item->harga, 0, ',', '.') }}
                    @else
                        -
                    @endif
                </div>
            @endif
        </div>
        @if($item->latitude && $item->longitude)
            <div id="map-{{ $type }}-{{ $item->id }}" class="umkm-map"></div>
            @push('scripts')
                <script>
                    document.addEventListener('DOMContentLoaded', function() {
                        const mapId = 'map-{{ $type }}-{{ $item->id }}';
                        const latitude = parseFloat('{{ $item->latitude }}');
                        const longitude = parseFloat('{{ $item->longitude }}');

                        if (document.getElementById(mapId) && !isNaN(latitude) && !isNaN(longitude)) {
                            const smallMap = L.map(mapId, {
                                zoomControl: false, dragging: false, touchZoom: false,
                                doubleClickZoom: false, scrollWheelZoom: false, boxZoom: false,
                                keyboard: false, tap: false
                            }).setView([latitude, longitude], 14);

                            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', { attribution: '© OpenStreetMap contributors', maxZoom: 16, minZoom: 10 }).addTo(smallMap);
                            L.marker([latitude, longitude], { interactive: false }).addTo(smallMap);
                            setTimeout(() => { smallMap.invalidateSize(); }, 100);
                        } else if (document.getElementById(mapId)) {
                            console.warn(`Koordinat tidak valid untuk peta ID: ${mapId}`);
                            document.getElementById(mapId).innerHTML = '<p style="text-align:center; padding-top: 20px; color:#777;">Koordinat tidak valid</p>';
                        }
                    });
                </script>
            @endpush
        @endif
    </div>
</div>