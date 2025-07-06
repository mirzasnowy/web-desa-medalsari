    @extends('admin.layout')

    @section('title', 'Manajemen Wisata Desa')

    @section('content')
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h1>Daftar Wisata Desa</h1>
            <a href="{{ route('admin.wisata_desas.create') }}" class="btn btn-success">Tambah Wisata Baru</a>
        </div>

        <table class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Gambar</th>
                    <th>Nama Wisata</th>
                    <th>Kategori</th>
                    <th>Alamat</th>
                    <th>Kontak</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($wisataDesas as $wisata)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>
                            @if($wisata->gambar)
                                <img src="{{ asset('storage/' . $wisata->gambar) }}" alt="Gambar Wisata" style="max-width: 80px; height: auto; border-radius: 4px;">
                            @else
                                Tidak ada gambar
                            @endif
                        </td>
                        <td>{{ $wisata->nama }}</td>
                        <td>{{ $wisata->kategori ?? '-' }}</td>
                        <td>{{ $wisata->alamat ?? '-' }}</td>
                        <td>
                            Telp: {{ $wisata->kontak_telepon ?? '-' }}<br>
                            Email: {{ $wisata->kontak_email ?? '-' }}
                        </td>
                        <td>
                            <a href="{{ route('admin.wisata_desas.show', $wisata->id) }}" class="btn btn-info btn-sm">Detail</a>
                            <a href="{{ route('admin.wisata_desas.edit', $wisata->id) }}" class="btn btn-warning btn-sm">Edit</a>
                            <form action="{{ route('admin.wisata_desas.destroy', $wisata->id) }}" method="POST" style="display:inline-block;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Apakah Anda yakin ingin menghapus Wisata ini?')">Hapus</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="text-center">Belum ada Wisata Desa yang terdaftar.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    @endsection
    