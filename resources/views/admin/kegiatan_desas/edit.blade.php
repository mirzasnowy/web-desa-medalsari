{{-- resources/views/admin/kegiatan_desas/edit.blade.php --}}
@extends('admin.layout')

@section('title', 'Edit Kegiatan Desa')

@section('content')
    <h1>Edit Kegiatan Desa: {{ $kegiatanDesa->judul }}</h1>
    <form action="{{ route('admin.kegiatan_desas.update', $kegiatanDesa->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="form-group">
            <label for="judul">Judul Kegiatan</label>
            <input type="text" class="form-control" id="judul" name="judul" value="{{ old('judul', $kegiatanDesa->judul) }}" required>
            @error('judul') <div class="text-danger">{{ $message }}</div> @enderror
        </div>

        <div class="form-group">
            <label for="tanggal_kegiatan">Tanggal Kegiatan</label>
            <input type="date" class="form-control" id="tanggal_kegiatan" name="tanggal_kegiatan" value="{{ old('tanggal_kegiatan', $kegiatanDesa->tanggal_kegiatan ? \Carbon\Carbon::parse($kegiatanDesa->tanggal_kegiatan)->format('Y-m-d') : '') }}" required>
            @error('tanggal_kegiatan') <div class="text-danger">{{ $message }}</div> @enderror
        </div>

        <div class="form-group">
            <label for="deskripsi">Deskripsi</label>
            <textarea class="form-control" id="deskripsi" name="deskripsi" rows="5">{{ old('deskripsi', $kegiatanDesa->deskripsi) }}</textarea>
            @error('deskripsi') <div class="text-danger">{{ $message }}</div> @enderror
        </div>

        <div class="form-group">
            <label for="gambar">Gambar Kegiatan (Opsional)</label>
            <input type="file" class="form-control-file" id="gambar" name="gambar" accept="image/*">
            <small class="form-text text-muted">Biarkan kosong jika tidak ingin mengubah gambar. Maks. 2MB, format: JPG, PNG, GIF, SVG.</small>
            @error('gambar') <div class="text-danger">{{ $message }}</div> @enderror
            @if($kegiatanDesa->gambar)
                <div class="mt-2">
                    <p>Gambar saat ini:</p>
                    <img src="{{ asset('storage/' . $kegiatanDesa->gambar) }}" alt="Gambar Kegiatan" style="max-width: 200px; height: auto; border-radius: 8px;">
                </div>
            @endif
        </div>

        <button type="submit" class="btn btn-primary">Update</button>
        <a href="{{ route('admin.kegiatan_desas.index') }}" class="btn btn-secondary">Batal</a>
    </form>
@endsection
