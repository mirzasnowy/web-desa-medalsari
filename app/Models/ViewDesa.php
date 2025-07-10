<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ViewDesa extends Model
{
    use HasFactory;

    protected $fillable = [
        'nama',
        'kategori',
        'deskripsi',
        'gambar',
        'alamat',
        'kontak_telepon',
        'kontak_email',
        'latitude',
        'longitude',
    ];
}