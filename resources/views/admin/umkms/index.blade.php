@extends('admin.layout')

@section('title', 'Manajemen UMKM')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1>Daftar UMKM</h1>
        <a href="{{ route('admin.umkms.create') }}" class="btn btn-success">Tambah UMKM Baru</a>
    </div>

    <table class="table table-bordered table-striped">
        <thead>
            <tr>
                <th>#</th>
                <th>Gambar</th> {{-- Kolom baru untuk gambar --}}
                <th>Nama UMKM</th>
                <th>Kategori</th>
                <th>Kontak</th>
                <th>Harga</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse($umkms as $umkm)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>
                        @if($umkm->gambar)
                            {{-- Menggunakan asset() helper untuk gambar dari storage/public --}}
                            <img src="{{ asset('storage/' . $umkm->gambar) }}" alt="Gambar UMKM" style="max-width: 80px; height: auto; border-radius: 4px;">
                        @else
                            Tidak ada gambar
                        @endif
                    </td>
                    <td>{{ $umkm->nama }}</td>
                    <td>{{ $umkm->kategori }}</td>
                    <td>
                        Telp: {{ $umkm->kontak_telepon ?? '-' }}<br>
                        Email: {{ $umkm->kontak_email ?? '-' }}
                    </td>
                    <td>{{ $umkm->harga ?? '-' }}</td>
                    <td>
                        <a href="{{ route('admin.umkms.show', $umkm->id) }}" class="btn btn-info btn-sm">Detail</a>
                        <a href="{{ route('admin.umkms.edit', $umkm->id) }}" class="btn btn-warning btn-sm">Edit</a>
                        <form action="{{ route('admin.umkms.destroy', $umkm->id) }}" method="POST" style="display:inline-block;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Apakah Anda yakin ingin menghapus UMKM ini?')">Hapus</button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="7" class="text-center">Belum ada UMKM yang terdaftar.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
@endsection