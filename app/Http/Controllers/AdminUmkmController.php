<?php

namespace App\Http\Controllers;

use App\Models\Umkm;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage; // Mengimpor facade Storage untuk manajemen file

class AdminUmkmController extends Controller
{
    /**
     * Menampilkan daftar semua UMKM.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $umkms = Umkm::all();
        return view('admin.umkms.index', compact('umkms'));
    }

    /**
     * Menampilkan form untuk membuat UMKM baru.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        return view('admin.umkms.create');
    }

    /**
     * Menyimpan UMKM baru ke database.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        // Validasi data yang masuk dari form, termasuk validasi gambar
        $validated = $request->validate([
            'nama' => 'required|string|max:255',
            'kategori' => 'required|string|max:255',
            'deskripsi' => 'required|string',
            'gambar' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048', // Validasi gambar
            'latitude' => 'nullable|numeric',  // Tambahkan validasi ini
            'longitude' => 'nullable|numeric', // Tambahkan validasi ini
            'alamat' => 'nullable|string|max:255', // Tambahkan validasi ini
            'kontak_telepon' => 'nullable|string|max:255',
            'kontak_email' => 'nullable|email|max:255',
            'harga' => 'nullable|string|max:255',
        ]);

        // Tangani unggah gambar jika ada
        if ($request->hasFile('gambar')) {
            $imagePath = $request->file('gambar')->store('umkms', 'public'); // Simpan di storage/app/public/umkms
            $validated['gambar'] = $imagePath; // Simpan path gambar ke database
        }

        Umkm::create($validated);
        return redirect()->route('admin.umkms.index')->with('success', 'UMKM berhasil ditambahkan!');
    }

    /**
     * Menampilkan detail UMKM tertentu.
     *
     * @param  \App\Models\Umkm  $umkm
     * @return \Illuminate\View\View
     */
    public function show(Umkm $umkm)
    {
        return view('admin.umkms.show', compact('umkm'));
    }

    /**
     * Menampilkan form untuk mengedit UMKM tertentu.
     *
     * @param  \App\Models\Umkm  $umkm
     * @return \Illuminate\View\View
     */
    public function edit(Umkm $umkm)
    {
        return view('admin.umkms.edit', compact('umkm'));
    }

    /**
     * Memperbarui UMKM tertentu di database.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Umkm  $umkm
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, Umkm $umkm)
    {
        // Validasi data yang masuk dari form, termasuk validasi gambar
        $validated = $request->validate([
            'nama' => 'required|string|max:255',
            'kategori' => 'required|string|max:255',
            'deskripsi' => 'required|string',
            'gambar' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048', // Validasi gambar
            'latitude' => 'nullable|numeric',  // Tambahkan validasi ini
            'longitude' => 'nullable|numeric', // Tambahkan validasi ini
            'alamat' => 'nullable|string|max:255', // Tambahkan validasi ini
            'kontak_telepon' => 'nullable|string|max:255',
            'kontak_email' => 'nullable|email|max:255',
            'harga' => 'nullable|string|max:255',
        ]);

        // Tangani unggah gambar jika ada
        if ($request->hasFile('gambar')) {
            // Hapus gambar lama jika ada
            if ($umkm->gambar) {
                Storage::disk('public')->delete($umkm->gambar);
            }
            $imagePath = $request->file('gambar')->store('umkms', 'public');
            $validated['gambar'] = $imagePath;
        }

        $umkm->update($validated);
        return redirect()->route('admin.umkms.index')->with('success', 'UMKM berhasil diperbarui!');
    }

    /**
     * Menghapus UMKM tertentu dari database.
     *
     * @param  \App\Models\Umkm  $umkm
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Umkm $umkm)
    {
        // Hapus file gambar terkait jika ada
        if ($umkm->gambar) {
            Storage::disk('public')->delete($umkm->gambar);
        }

        $umkm->delete();
        return redirect()->route('admin.umkms.index')->with('success', 'UMKM berhasil dihapus!');
    }
 /**
     * Menampilkan detail UMKM untuk publik.
     *
 /**
     * Menampilkan detail UMKM untuk publik.

* @param  \App\Models\Umkm  $umkm
     * @return \Illuminate\View\View
     */
    public function showPublic(Umkm $umkm)
    {
        // Menggunakan view di dalam folder admin/umkms
        return view('admin.umkms.show_public', compact('umkm'));
    }
}
