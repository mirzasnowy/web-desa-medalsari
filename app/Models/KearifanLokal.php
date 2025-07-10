<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KearifanLokal extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     * Atribut yang dapat diisi secara massal.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'nama',
        'deskripsi',
        'icon',
        'gambar',
    ];
}
