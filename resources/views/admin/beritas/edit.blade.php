{{-- resources/views/admin/beritas/edit.blade.php --}}
@extends('admin.layout')

@section('title', 'Edit Berita')

@section('content')
    <h1>Edit Berita: {{ $berita->judul }}</h1>
    <form action="{{ route('admin.beritas.update', $berita->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="form-group">
            <label for="judul">Judul Berita</label>
            <input type="text" class="form-control" id="judul" name="judul" value="{{ old('judul', $berita->judul) }}" required>
            @error('judul') <div class="text-danger">{{ $message }}</div> @enderror
        </div>

        <div class="form-group">
            <label for="tanggal_publikasi">Tanggal Publikasi</label>
            <input type="date" class="form-control" id="tanggal_publikasi" name="tanggal_publikasi" value="{{ old('tanggal_publikasi', $berita->tanggal_publikasi ? \Carbon\Carbon::parse($berita->tanggal_publikasi)->format('Y-m-d') : '') }}" required>
            @error('tanggal_publikasi') <div class="text-danger">{{ $message }}</div> @enderror
        </div>

        <div class="form-group">
            <label for="penulis">Penulis (Opsional)</label>
            <input type="text" class="form-control" id="penulis" name="penulis" value="{{ old('penulis', $berita->penulis) }}">
            @error('penulis') <div class="text-danger">{{ $message }}</div> @enderror
        </div>

        <div class="form-group">
            <label for="konten">Konten Berita</label>
            <textarea class="form-control" id="konten" name="konten" rows="10" required>{{ old('konten', $berita->konten) }}</textarea>
            @error('konten') <div class="text-danger">{{ $message }}</div> @enderror
        </div>

        <div class="form-group">
            <label for="gambar_utama">Gambar Utama (Opsional)</label>
            <input type="file" class="form-control-file" id="gambar_utama" name="gambar_utama" accept="image/*">
            <small class="form-text text-muted">Biarkan kosong jika tidak ingin mengubah gambar. Maks. 2MB, format: JPG, PNG, GIF, SVG.</small>
            @error('gambar_utama') <div class="text-danger">{{ $message }}</div> @enderror
            @if($berita->gambar_utama)
                <div class="mt-2">
                    <p>Gambar saat ini:</p>
                    <img src="{{ asset('storage/' . $berita->gambar_utama) }}" alt="Gambar Berita" style="max-width: 200px; height: auto; border-radius: 8px;">
                </div>
            @endif
        </div>

        <button type="submit" class="btn btn-primary">Update</button>
        <a href="{{ route('admin.beritas.index') }}" class="btn btn-secondary">Batal</a>
    </form>
@endsection
