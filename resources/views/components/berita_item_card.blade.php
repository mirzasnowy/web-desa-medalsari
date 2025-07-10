{{-- resources/views/components/berita_item_card.blade.php --}}
@props(['berita'])

<a href="{{ route('berita.show_public', $berita->id) }}" class="berita-item fade-in">
    <div class="berita-image-container">
        @if($berita->gambar_utama)
            <img src="{{ asset('storage/' . $berita->gambar_utama) }}" alt="{{ $berita->judul }}">
        @else
            <img src="{{ asset('images/default-berita.jpg') }}" alt="Gambar Default Berita">
        @endif
    </div>
    <div class="berita-content">
        <h4>{{ $berita->judul }}</h4>
        <p class="date"><i class="far fa-calendar-alt"></i> {{ \Carbon\Carbon::parse($berita->tanggal_publikasi)->locale('id')->isoFormat('D MMMM Y') }}</p>
        <p>{{ Str::limit($berita->konten, 150) }}</p>
    </div>
</a>