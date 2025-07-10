{{-- resources/views/admin/beritas/create.blade.php --}}
@extends('admin.layout')

@section('title', 'Tambah Berita Baru')

@section('content')
    <h1>Tambah Berita Baru</h1>
    <form action="{{ route('admin.beritas.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="form-group">
            <label for="judul">Judul Berita</label>
            <input type="text" class="form-control" id="judul" name="judul" value="{{ old('judul') }}" required>
            @error('judul') <div class="text-danger">{{ $message }}</div> @enderror
        </div>

        <div class="form-group">
            <label for="tanggal_publikasi">Tanggal Publikasi</label>
            <input type="date" class="form-control" id="tanggal_publikasi" name="tanggal_publikasi" value="{{ old('tanggal_publikasi', \Carbon\Carbon::now()->format('Y-m-d')) }}" required>
            @error('tanggal_publikasi') <div class="text-danger">{{ $message }}</div> @enderror
        </div>

        <div class="form-group">
            <label for="penulis">Penulis (Opsional)</label>
            <input type="text" class="form-control" id="penulis" name="penulis" value="{{ old('penulis') }}">
            @error('penulis') <div class="text-danger">{{ $message }}</div> @enderror
        </div>

        <div class="form-group">
            <label for="konten">Konten Berita</label>
            <textarea class="form-control" id="konten" name="konten" rows="10" required>{{ old('konten') }}</textarea>
            @error('konten') <div class="text-danger">{{ $message }}</div> @enderror
        </div>

        <div class="form-group">
            <label for="gambar_utama">Gambar Utama (Opsional)</label>
            <input type="file" class="form-control-file" id="gambar_utama" name="gambar_utama" accept="image/*">
            <small class="form-text text-muted">Maks. 2MB, format: JPG, PNG, GIF, SVG.</small>
            @error('gambar_utama') <div class="text-danger">{{ $message }}</div> @enderror
        </div>

        <button type="submit" class="btn btn-primary">Simpan</button>
        <a href="{{ route('admin.beritas.index') }}" class="btn btn-secondary">Batal</a>
    </form>
@endsection
