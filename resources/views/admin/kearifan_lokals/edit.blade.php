{{-- resources/views/admin/kearifan_lokals/edit.blade.php --}}
@extends('admin.layout')

@section('title', 'Edit Kearifan Lokal')

@section('content')
    <h1>Edit Kearifan Lokal: {{ $kearifanLokal->nama }}</h1>
    <form action="{{ route('admin.kearifan_lokals.update', $kearifanLokal->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="form-group">
            <label for="nama">Nama Kearifan Lokal</label>
            <input type="text" class="form-control" id="nama" name="nama" value="{{ old('nama', $kearifanLokal->nama) }}" required>
            @error('nama') <div class="text-danger">{{ $message }}</div> @enderror
        </div>

        <div class="form-group">
            <label for="deskripsi">Deskripsi</label>
            <textarea class="form-control" id="deskripsi" name="deskripsi" rows="5">{{ old('deskripsi', $kearifanLokal->deskripsi) }}</textarea>
            @error('deskripsi') <div class="text-danger">{{ $message }}</div> @enderror
        </div>

        <div class="form-group">
            <label for="icon">Ikon (Font Awesome Class, Opsional)</label>
            <input type="text" class="form-control" id="icon" name="icon" value="{{ old('icon', $kearifanLokal->icon) }}" placeholder="Contoh: fa-leaf, fa-mask">
            <small class="form-text text-muted">Gunakan kelas Font Awesome untuk ikon (misal: `fa-leaf`).</small>
            @error('icon') <div class="text-danger">{{ $message }}</div> @enderror
        </div>

        <div class="form-group">
            <label for="gambar">Gambar (Opsional)</label>
            <input type="file" class="form-control-file" id="gambar" name="gambar" accept="image/*">
            <small class="form-text text-muted">Biarkan kosong jika tidak ingin mengubah gambar. Maks. 2MB, format: JPG, PNG, GIF, SVG.</small>
            @error('gambar') <div class="text-danger">{{ $message }}</div> @enderror
            @if($kearifanLokal->gambar)
                <div class="mt-2">
                    <p>Gambar saat ini:</p>
                    <img src="{{ asset('storage/' . $kearifanLokal->gambar) }}" alt="Gambar Kearifan Lokal" style="max-width: 200px; height: auto; border-radius: 8px;">
                </div>
            @endif
        </div>

        <button type="submit" class="btn btn-primary">Update</button>
        <a href="{{ route('admin.kearifan_lokals.index') }}" class="btn btn-secondary">Batal</a>
    </form>
@endsection
