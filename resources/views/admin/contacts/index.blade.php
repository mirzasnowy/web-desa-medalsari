<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - Pesan Kontak</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
        body { font-family: sans-serif; background-color: #f4f7f6; margin: 0; padding: 20px; }
        .container { max-width: 1200px; margin: 0 auto; background-color: #ffffff; padding: 30px; border-radius: 8px; box-shadow: 0 4px 12px rgba(0,0,0,0.05); }
        h1 { color: #2c3e50; margin-bottom: 25px; text-align: center; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { padding: 12px 15px; text-align: left; border-bottom: 1px solid #dee2e6; }
        th { background-color: #e9ecef; color: #495057; font-weight: bold; }
        tr.unread { background-color: #fff3cd; font-weight: bold; } /* Gaya untuk pesan belum dibaca */
        .actions button {
            background-color: #007bff;
            color: white;
            border: none;
            padding: 8px 12px;
            border-radius: 5px;
            cursor: pointer;
            font-size: 0.9em;
            transition: background-color 0.2s ease;
            margin-right: 5px;
        }
        .actions button.read { background-color: #28a745; }
        .actions button.delete { background-color: #dc3545; }
        .actions button:hover { opacity: 0.9; }
        .pagination { margin-top: 20px; text-align: center; }
        .pagination a, .pagination span {
            display: inline-block;
            padding: 8px 12px;
            margin: 0 4px;
            border: 1px solid #ced4da;
            border-radius: 4px;
            text-decoration: none;
            color: #007bff;
            transition: background-color 0.2s ease, color 0.2s ease;
        }
        .pagination a:hover {
            background-color: #007bff;
            color: white;
        }
        .pagination span.current {
            background-color: #007bff;
            color: white;
            border-color: #007bff;
        }
        .message-content { max-height: 100px; overflow: auto; border: 1px solid #eee; padding: 8px; background-color: #f8f9fa; border-radius: 4px; }
        .alert { padding: 15px; margin-bottom: 20px; border-radius: 5px; }
        .alert-success { background-color: #d4edda; color: #155724; border: 1px solid #c3e6cb; }
        .alert-error { background-color: #f8d7da; color: #721c24; border: 1px solid #f5c6cb; }
    </style>
</head>
<body>
    <div class="container">
        <h1>Pesan Kontak Masuk</h1>

        @if(session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif
        @if(session('error'))
            <div class="alert alert-error">
                {{ session('error') }}
            </div>
        @endif

        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nama</th>
                    <th>Email</th>
                    <th>Subjek</th>
                    <th>Pesan</th>
                    <th>Status</th>
                    <th>Dikirim Pada</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($contacts as $contact)
                    <tr class="{{ $contact->is_read ? '' : 'unread' }}">
                        <td>{{ $contact->id }}</td>
                        <td>{{ $contact->name }}</td>
                        <td>{{ $contact->email }}</td>
                        <td>{{ $contact->subject }}</td>
                        <td><div class="message-content">{{ $contact->message }}</div></td>
                        <td>
                            @if($contact->is_read)
                                <span style="color: green;"><i class="fas fa-check-circle"></i> Sudah Dibaca</span>
                            @else
                                <span style="color: orange;"><i class="fas fa-exclamation-circle"></i> Belum Dibaca</span>
                            @endif
                        </td>
                        <td>{{ $contact->created_at->format('d M Y, H:i') }}</td>
                        <td class="actions">
                            @if(!$contact->is_read)
                                <form action="{{ route('admin.contacts.mark_as_read', $contact) }}" method="POST" style="display:inline-block;">
                                    @csrf
                                    @method('PATCH')
                                    <button type="submit" class="read"><i class="fas fa-eye"></i> Tandai Dibaca</button>
                                </form>
                            @endif
                            <form action="{{ route('admin.contacts.destroy', $contact) }}" method="POST" style="display:inline-block;" onsubmit="return confirm('Apakah Anda yakin ingin menghapus pesan ini?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="delete"><i class="fas fa-trash"></i> Hapus</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="8" style="text-align: center;">Tidak ada pesan kontak yang masuk.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>

        <div class="pagination">
            {{ $contacts->links() }}
        </div>
    </div>
</body>
</html>