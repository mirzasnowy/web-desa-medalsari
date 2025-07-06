<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WisataDesa extends Model
{
    use HasFactory;

    // Opsional: Jika nama tabel di database bukan 'wisata_desas', tentukan di sini.
    // protected $table = 'nama_tabel_anda';

    /**
     * Properti $fillable menentukan atribut mana yang dapat diisi secara massal.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'nama',
        'kategori',
        'deskripsi',
        'gambar',
        'latitude', 
        'longitude',
        'alamat',
        'kontak_telepon',
        'kontak_email',
    ];
}
