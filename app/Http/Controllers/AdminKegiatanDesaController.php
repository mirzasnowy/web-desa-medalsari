<?php

namespace App\Http\Controllers;

use App\Models\KegiatanDesa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage; // Untuk upload gambar

class AdminKegiatanDesaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $kegiatanDesas = KegiatanDesa::latest()->paginate(10);
        return view('admin.kegiatan_desas.index', compact('kegiatanDesas'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.kegiatan_desas.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'judul' => 'required|string|max:255',
            'deskripsi' => 'nullable|string',
            'gambar' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'tanggal_kegiatan' => 'nullable|date',
        ]);

        $gambarPath = null;
        if ($request->hasFile('gambar')) {
            $gambarPath = $request->file('gambar')->store('kegiatan_desas', 'public');
        }

        KegiatanDesa::create([
            'judul' => $request->judul,
            'deskripsi' => $request->deskripsi,
            'gambar' => $gambarPath,
            'tanggal_kegiatan' => $request->tanggal_kegiatan,
        ]);

        return redirect()->route('admin.kegiatan_desas.index')->with('success', 'Kegiatan Desa berhasil ditambahkan.');
    }

    /**
     * Display the specified resource.
     */
    public function show(KegiatanDesa $kegiatanDesa)
    {
        return view('admin.kegiatan_desas.show', compact('kegiatanDesa'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(KegiatanDesa $kegiatanDesa)
    {
        return view('admin.kegiatan_desas.edit', compact('kegiatanDesa'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, KegiatanDesa $kegiatanDesa)
    {
        $request->validate([
            'judul' => 'required|string|max:255',
            'deskripsi' => 'nullable|string',
            'gambar' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'tanggal_kegiatan' => 'nullable|date',
        ]);

        $gambarPath = $kegiatanDesa->gambar;
        if ($request->hasFile('gambar')) {
            if ($gambarPath) {
                Storage::disk('public')->delete($gambarPath);
            }
            $gambarPath = $request->file('gambar')->store('kegiatan_desas', 'public');
        }

        $kegiatanDesa->update([
            'judul' => $request->judul,
            'deskripsi' => $request->deskripsi,
            'gambar' => $gambarPath,
            'tanggal_kegiatan' => $request->tanggal_kegiatan,
        ]);

        return redirect()->route('admin.kegiatan_desas.index')->with('success', 'Kegiatan Desa berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(KegiatanDesa $kegiatanDesa)
    {
        if ($kegiatanDesa->gambar) {
            Storage::disk('public')->delete($kegiatanDesa->gambar);
        }
        $kegiatanDesa->delete();
        return redirect()->route('admin.kegiatan_desas.index')->with('success', 'Kegiatan Desa berhasil dihapus.');
    }

    /**
     * Display the specified resource for public view.
     */
    public function showPublic(KegiatanDesa $kegiatanDesa)
    {
        return view('admin.kegiatan_desas.show_public', compact('kegiatanDesa'));
    }

    /**
     * Display a listing of the resource for public view.
     */
    public function indexPublic()
    {
        $kegiatanDesas = KegiatanDesa::latest()->paginate(9); // Ambil lebih banyak untuk halaman daftar
        return view('admin.kegiatan_desas.index', compact('kegiatanDesas'));
    }
}
