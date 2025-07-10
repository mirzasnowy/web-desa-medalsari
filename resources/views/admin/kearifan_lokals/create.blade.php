{{-- resources/views/admin/kearifan_lokals/create.blade.php --}}
@extends('admin.layout')

@section('title', 'Tambah Kearifan Lokal Baru')

@section('content')
    <h1>Tambah Kearifan Lokal Baru</h1>
    <form action="{{ route('admin.kearifan_lokals.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="form-group">
            <label for="nama">Nama Kearifan Lokal</label>
            <input type="text" class="form-control" id="nama" name="nama" value="{{ old('nama') }}" required>
            @error('nama') <div class="text-danger">{{ $message }}</div> @enderror
        </div>

        <div class="form-group">
            <label for="deskripsi">Deskripsi</label>
            <textarea class="form-control" id="deskripsi" name="deskripsi" rows="5">{{ old('deskripsi') }}</textarea>
            @error('deskripsi') <div class="text-danger">{{ $message }}</div> @enderror
        </div>

        <div class="form-group">
            <label for="icon">Ikon (Font Awesome Class, Opsional)</label>
            <input type="text" class="form-control" id="icon" name="icon" value="{{ old('icon') }}" placeholder="Contoh: fa-leaf, fa-mask">
            <small class="form-text text-muted">Gunakan kelas Font Awesome untuk ikon (misal: `fa-leaf`).</small>
            @error('icon') <div class="text-danger">{{ $message }}</div> @enderror
        </div>

        <div class="form-group">
            <label for="gambar">Gambar (Opsional)</label>
            <input type="file" class="form-control-file" id="gambar" name="gambar" accept="image/*">
            <small class="form-text text-muted">Maks. 2MB, format: JPG, PNG, GIF, SVG.</small>
            @error('gambar') <div class="text-danger">{{ $message }}</div> @enderror
        </div>

        <button type="submit" class="btn btn-primary">Simpan</button>
        <a href="{{ route('admin.kearifan_lokals.index') }}" class="btn btn-secondary">Batal</a>
    </form>
@endsection
