{{-- resources/views/admin/kegiatan_desas/create.blade.php --}}
@extends('admin.layout')

@section('title', 'Tambah Kegiatan Desa Baru')

@section('content')
    <h1>Tambah Kegiatan Desa Baru</h1>
    <form action="{{ route('admin.kegiatan_desas.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="form-group">
            <label for="judul">Judul Kegiatan</label>
            <input type="text" class="form-control" id="judul" name="judul" value="{{ old('judul') }}" required>
            @error('judul') <div class="text-danger">{{ $message }}</div> @enderror
        </div>

        <div class="form-group">
            <label for="tanggal_kegiatan">Tanggal Kegiatan</label>
            <input type="date" class="form-control" id="tanggal_kegiatan" name="tanggal_kegiatan" value="{{ old('tanggal_kegiatan') }}" required>
            @error('tanggal_kegiatan') <div class="text-danger">{{ $message }}</div> @enderror
        </div>

        <div class="form-group">
            <label for="deskripsi">Deskripsi</label>
            <textarea class="form-control" id="deskripsi" name="deskripsi" rows="5">{{ old('deskripsi') }}</textarea>
            @error('deskripsi') <div class="text-danger">{{ $message }}</div> @enderror
        </div>

        <div class="form-group">
            <label for="gambar">Gambar Kegiatan (Opsional)</label>
            <input type="file" class="form-control-file" id="gambar" name="gambar" accept="image/*">
            <small class="form-text text-muted">Maks. 2MB, format: JPG, PNG, GIF, SVG.</small>
            @error('gambar') <div class="text-danger">{{ $message }}</div> @enderror
        </div>

        <button type="submit" class="btn btn-primary">Simpan</button>
        <a href="{{ route('admin.kegiatan_desas.index') }}" class="btn btn-secondary">Batal</a>
    </form>
@endsection
