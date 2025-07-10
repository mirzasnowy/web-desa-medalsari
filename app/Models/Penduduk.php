<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Penduduk extends Model
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
        'nik',
        'no_kk',
        'jenis_kelamin',
        'pekerjaan',
        'pendidikan',
    ];
}
