<?php

namespace App\Http\Controllers;

use App\Models\AparaturDesa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AdminAparaturDesaController extends Controller
{
    /**
     * Display a listing of the resource.
     * Menampilkan daftar semua aparatur desa.
     */
    public function index()
    {
        $aparaturDesas = AparaturDesa::latest()->paginate(10);
        return view('admin.aparatur_desas.index', compact('aparaturDesas'));
    }

    /**
     * Show the form for creating a new resource.
     * Menampilkan formulir untuk membuat aparatur desa baru.
     */
    public function create()
    {
        return view('admin.aparatur_desas.create');
    }

    /**
     * Store a newly created resource in storage.
     * Menyimpan aparatur desa yang baru dibuat ke database.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'jabatan' => 'required|string|max:255',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048', // Validasi untuk file gambar
            'kontak' => 'nullable|string|max:255',
        ]);

        $fotoPath = null;
        if ($request->hasFile('foto')) {
            // Simpan gambar ke direktori 'aparatur_desas' di dalam storage/app/public
            $fotoPath = $request->file('foto')->store('aparatur_desas', 'public');
        }

        AparaturDesa::create([
            'nama' => $request->nama,
            'jabatan' => $request->jabatan,
            'foto' => $fotoPath,
            'kontak' => $request->kontak,
        ]);

        return redirect()->route('admin.aparatur_desas.index')->with('success', 'Data Aparatur Desa berhasil ditambahkan.');
    }

    /**
     * Display the specified resource.
     * Menampilkan detail aparatur desa tertentu.
     */
    public function show(AparaturDesa $aparaturDesa)
    {
        return view('admin.aparatur_desas.show', compact('aparaturDesa'));
    }

    /**
     * Show the form for editing the specified resource.
     * Menampilkan formulir untuk mengedit aparatur desa tertentu.
     */
    public function edit(AparaturDesa $aparaturDesa)
    {
        return view('admin.aparatur_desas.edit', compact('aparaturDesa'));
    }

    /**
     * Update the specified resource in storage.
     * Memperbarui data aparatur desa tertentu di database.
     */
    public function update(Request $request, AparaturDesa $aparaturDesa)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'jabatan' => 'required|string|max:255',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'kontak' => 'nullable|string|max:255',
        ]);

        $fotoPath = $aparaturDesa->foto; // Pertahankan foto lama jika tidak ada upload baru
        if ($request->hasFile('foto')) {
            // Hapus foto lama jika ada
            if ($fotoPath) {
                Storage::disk('public')->delete($fotoPath);
            }
            $fotoPath = $request->file('foto')->store('aparatur_desas', 'public');
        }

        $aparaturDesa->update([
            'nama' => $request->nama,
            'jabatan' => $request->jabatan,
            'foto' => $fotoPath,
            'kontak' => $request->kontak,
        ]);

        return redirect()->route('admin.aparatur_desas.index')->with('success', 'Data Aparatur Desa berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     * Menghapus aparatur desa tertentu dari database.
     */
    public function destroy(AparaturDesa $aparaturDesa)
    {
        // Hapus file foto terkait jika ada
        if ($aparaturDesa->foto) {
            Storage::disk('public')->delete($aparaturDesa->foto);
        }
        $aparaturDesa->delete();
        return redirect()->route('admin.aparatur_desas.index')->with('success', 'Data Aparatur Desa berhasil dihapus.');
    }
}
