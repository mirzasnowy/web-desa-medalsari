<?php

namespace App\Http\Controllers;

use App\Models\WisataDesa; // Mengimpor model WisataDesa
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage; // Untuk manajemen file gambar
use Illuminate\Support\Str; // Untuk Str::limit di index view

class AdminWisataDesaController extends Controller
{
    /**
     * Menampilkan daftar semua Wisata Desa.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $wisataDesas = WisataDesa::all();
        return view('admin.wisata_desas.index', compact('wisataDesas'));
    }

    /**
     * Menampilkan form untuk membuat Wisata Desa baru.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        return view('admin.wisata_desas.create');
    }

    /**
     * Menyimpan Wisata Desa baru ke database.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama' => 'required|string|max:255',
            'kategori' => 'nullable|string|max:255',
            'deskripsi' => 'required|string',
            'gambar' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048', // Validasi gambar
            'latitude' => 'nullable|numeric', // Tambahkan validasi ini
            'longitude' => 'nullable|numeric',
            'alamat' => 'nullable|string|max:255',
            'kontak_telepon' => 'nullable|string|max:255',
            'kontak_email' => 'nullable|email|max:255',
        ]);

        // Tangani unggah gambar jika ada
        if ($request->hasFile('gambar')) {
            $imagePath = $request->file('gambar')->store('wisata_desas', 'public'); // Simpan di storage/app/public/wisata_desas
            $validated['gambar'] = $imagePath;
        }

        WisataDesa::create($validated);
        return redirect()->route('admin.wisata_desas.index')->with('success', 'Wisata Desa berhasil ditambahkan!');
    }

    /**
     * Menampilkan detail Wisata Desa tertentu.
     *
     * @param  \App\Models\WisataDesa  $wisataDesa
     * @return \Illuminate\View\View
     */
    public function show(WisataDesa $wisataDesa)
    {
        return view('admin.wisata_desas.show', compact('wisataDesa'));
    }

    /**
     * Menampilkan form untuk mengedit Wisata Desa tertentu.
     *
     * @param  \App\Models\WisataDesa  $wisataDesa
     * @return \Illuminate\View\View
     */
    public function edit(WisataDesa $wisataDesa)
    {
        return view('admin.wisata_desas.edit', compact('wisataDesa'));
    }

    /**
     * Memperbarui Wisata Desa tertentu di database.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\WisataDesa  $wisataDesa
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, WisataDesa $wisataDesa)
    {
        $validated = $request->validate([
            'nama' => 'required|string|max:255',
            'kategori' => 'nullable|string|max:255',
            'deskripsi' => 'required|string',
            'gambar' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'latitude' => 'nullable|numeric', // Tambahkan validasi ini
            'longitude' => 'nullable|numeric',
            'alamat' => 'nullable|string|max:255',
            'kontak_telepon' => 'nullable|string|max:255',
            'kontak_email' => 'nullable|email|max:255',
        ]);

        // Tangani unggah gambar jika ada
        if ($request->hasFile('gambar')) {
            // Hapus gambar lama jika ada
            if ($wisataDesa->gambar) {
                Storage::disk('public')->delete($wisataDesa->gambar);
            }
            $imagePath = $request->file('gambar')->store('wisata_desas', 'public');
            $validated['gambar'] = $imagePath;
        }

        $wisataDesa->update($validated);
        return redirect()->route('admin.wisata_desas.index')->with('success', 'Wisata Desa berhasil diperbarui!');
    }

    /**
     * Menghapus Wisata Desa tertentu dari database.
     *
     * @param  \App\Models\WisataDesa  $wisataDesa
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(WisataDesa $wisataDesa)
    {
        // Hapus file gambar terkait jika ada
        if ($wisataDesa->gambar) {
            Storage::disk('public')->delete($wisataDesa->gambar);
        }

        $wisataDesa->delete();
        return redirect()->route('admin.wisata_desas.index')->with('success', 'Wisata Desa berhasil dihapus!');
    }

     /**
     * Menampilkan detail Wisata Desa untuk publik.
     *
     * @param  \App\Models\WisataDesa  $wisataDesa
     * @return \Illuminate\View\View
     */
    public function showPublic(WisataDesa $wisataDesa)
    {
        // Menggunakan view di dalam folder admin/wisata_desas
        return view('admin.wisata_desas.show_public', compact('wisataDesa'));
    }
    
}
