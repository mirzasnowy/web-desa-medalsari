<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Umkm extends Model
{
    use HasFactory;

    /**
     * Properti $fillable menentukan atribut mana yang dapat diisi secara massal.
     * Menambahkan 'gambar' ke daftar ini.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'nama',
        'kategori',
        'deskripsi',
        'gambar',           // Kolom baru untuk gambar
        'latitude',   // Tambahkan ini
        'longitude',  // Tambahkan ini
        'alamat',     // Tambahkan ini
        'kontak_telepon',
        'kontak_email',
        'harga',
    ];

    /**
     * Opsional: Jika nama tabel di database Anda bukan 'umkms',
     * Anda bisa menimpanya di sini.
     *
     * protected $table = 'nama_tabel_umkm_anda';
     */
}
