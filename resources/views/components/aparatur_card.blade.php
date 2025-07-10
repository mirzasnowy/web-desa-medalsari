{{-- resources/views/components/aparatur_card.blade.php --}}
@props(['aparatur'])

<div class="aparatur-card fade-in">
    <div class="aparatur-photo">
        @if($aparatur->foto)
            <img src="{{ asset('storage/' . $aparatur->foto) }}" alt="{{ $aparatur->nama }}">
        @else
            <img src="{{ asset('images/default-avatar.png') }}" alt="Foto Default">
        @endif
    </div>
    <div class="aparatur-info">
        <h4>{{ $aparatur->jabatan }}</h4> {{-- Ubah dari nama ke jabatan agar lebih relevan di sini --}}
        <p>{{ $aparatur->nama }}</p> {{-- Nama di bawah jabatan --}}
        @if($aparatur->kontak)
        <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $aparatur->kontak) }}" target="_blank" class="whatsapp-link">
            <i class="fab fa-whatsapp"></i> {{ $aparatur->kontak }}
        </a>
        @endif
    </div>
</div>