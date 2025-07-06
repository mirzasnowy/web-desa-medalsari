<?php

namespace App\Http\Controllers;

use App\Models\WisataDesa; // Pastikan Anda memiliki model WisataDesa
use Illuminate\Http\Request;

class WisataDesaController extends Controller
{
    /**
     * Menampilkan detail Wisata Desa tertentu.
     *
     * @param  int  $id
     * @return \Illuminate\View\View
     */
    public function show($id)
    {
        $wisata = WisataDesa::findOrFail($id); // Mencari Wisata Desa berdasarkan ID, atau 404 jika tidak ditemukan
        return view('detail.wisata', compact('wisata')); // Mengirim data Wisata ke view detail.wisata
    }
}