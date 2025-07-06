<?php

namespace App\Http\Controllers;

use App\Models\Umkm; // Pastikan Anda memiliki model Umkm
use Illuminate\Http\Request;

class UmkmController extends Controller
{
    /**
     * Menampilkan detail UMKM tertentu.
     *
     * @param  int  $id
     * @return \Illuminate\View\View
     */
    public function show($id)
    {
        $umkm = Umkm::findOrFail($id); // Mencari UMKM berdasarkan ID, atau 404 jika tidak ditemukan
        return view('detail.umkm', compact('umkm')); // Mengirim data UMKM ke view detail.umkm
    }
}