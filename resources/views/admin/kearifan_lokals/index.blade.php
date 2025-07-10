{{-- resources/views/admin/kearifan_lokals/index.blade.php --}}
@extends('admin.layout')

@section('title', 'Manajemen Kearifan Lokal')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1>Daftar Kearifan Lokal</h1>
        <a href="{{ route('admin.kearifan_lokals.create') }}" class="btn btn-success">Tambah Kearifan Lokal Baru</a>
    </div>

    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <table class="table table-bordered table-striped">
        <thead>
            <tr>
                <th>#</th>
                <th>Gambar</th>
                <th>Nama Kearifan Lokal</th>
                <th>Deskripsi Singkat</th>
                <th>Ikon</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse($kearifanLokals as $kearifan)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>
                        @if($kearifan->gambar)
                            <img src="{{ asset('storage/' . $kearifan->gambar) }}" alt="Gambar Kearifan Lokal" style="max-width: 80px; height: auto; border-radius: 4px;">
                        @else
                            Tidak ada gambar
                        @endif
                    </td>
                    <td>{{ $kearifan->nama }}</td>
                    <td>{{ Str::limit($kearifan->deskripsi, 100) }}</td>
                    <td>
                        @if($kearifan->icon)
                            <i class="fas {{ $kearifan->icon }}"></i> ({{ $kearifan->icon }})
                        @else
                            -
                        @endif
                    </td>
                    <td>
                        {{-- Link to show detail (optional, if you create show.blade.php) --}}
                        {{-- <a href="{{ route('admin.kearifan_lokals.show', $kearifan->id) }}" class="btn btn-info btn-sm">Detail</a> --}}
                        <a href="{{ route('admin.kearifan_lokals.edit', $kearifan->id) }}" class="btn btn-warning btn-sm">Edit</a>
                        <form action="{{ route('admin.kearifan_lokals.destroy', $kearifan->id) }}" method="POST" style="display:inline-block;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Apakah Anda yakin ingin menghapus Kearifan Lokal ini?')">Hapus</button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="6" class="text-center">Belum ada data Kearifan Lokal yang terdaftar.</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    {{-- Pagination Links --}}
    <div class="d-flex justify-content-center">
        {{ $kearifanLokals->links() }}
    </div>
@endsection
