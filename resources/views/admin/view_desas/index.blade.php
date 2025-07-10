@extends('admin.layout')

@section('title', 'Manajemen Potret Desa')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1>Daftar Potret Desa</h1>
        <a href="{{ route('admin.view_desas.create') }}" class="btn btn-success">Tambah Potret Desa Baru</a>
    </div>

    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif

    <table class="table table-bordered table-striped">
        <thead>
            <tr>
                <th>#</th>
                <th>Gambar</th>
                <th>Nama Potret</th>
                <th>Kategori</th>
                <th>Alamat/Lokasi</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse($viewDesas as $viewDesa)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>
                        @if($viewDesa->gambar)
                            <img src="{{ asset('storage/' . $viewDesa->gambar) }}" alt="Gambar Potret Desa" style="max-width: 80px; height: auto; border-radius: 4px;">
                        @else
                            Tidak ada gambar
                        @endif
                    </td>
                    <td>{{ $viewDesa->nama }}</td>
                    <td>{{ $viewDesa->kategori ?? '-' }}</td>
                    <td>{{ $viewDesa->alamat ?? '-' }}</td>
                    <td>
                        <a href="{{ route('admin.view_desas.show', $viewDesa->id) }}" class="btn btn-info btn-sm">Detail</a>
                        <a href="{{ route('admin.view_desas.edit', $viewDesa->id) }}" class="btn btn-warning btn-sm">Edit</a>
                        <form action="{{ route('admin.view_desas.destroy', $viewDesa->id) }}" method="POST" style="display:inline-block;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Apakah Anda yakin ingin menghapus Potret Desa ini?')">Hapus</button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="6" class="text-center">Belum ada Potret Desa yang terdaftar.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
@endsection