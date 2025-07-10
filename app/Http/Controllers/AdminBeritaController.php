<?php

namespace App\Http\Controllers;

use App\Models\Berita;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AdminBeritaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $beritas = Berita::latest()->paginate(10);
        return view('admin.beritas.index', compact('beritas'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.beritas.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'judul' => 'required|string|max:255',
            'konten' => 'required|string',
            'gambar_utama' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'tanggal_publikasi' => 'required|date',
            'penulis' => 'nullable|string|max:255',
        ]);

        $gambarPath = null;
        if ($request->hasFile('gambar_utama')) {
            $gambarPath = $request->file('gambar_utama')->store('beritas', 'public');
        }

        Berita::create([
            'judul' => $request->judul,
            'konten' => $request->konten,
            'gambar_utama' => $gambarPath,
            'tanggal_publikasi' => $request->tanggal_publikasi,
            'penulis' => $request->penulis,
        ]);

        return redirect()->route('admin.beritas.index')->with('success', 'Berita berhasil ditambahkan.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Berita $berita)
    {
        return view('admin.beritas.show', compact('berita'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Berita $berita)
    {
        return view('admin.beritas.edit', compact('berita'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Berita $berita)
    {
        $request->validate([
            'judul' => 'required|string|max:255',
            'konten' => 'required|string',
            'gambar_utama' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'tanggal_publikasi' => 'required|date',
            'penulis' => 'nullable|string|max:255',
        ]);

        $gambarPath = $berita->gambar_utama;
        if ($request->hasFile('gambar_utama')) {
            if ($gambarPath) {
                Storage::disk('public')->delete($gambarPath);
            }
            $gambarPath = $request->file('gambar_utama')->store('beritas', 'public');
        }

        $berita->update([
            'judul' => $request->judul,
            'konten' => $request->konten,
            'gambar_utama' => $gambarPath,
            'tanggal_publikasi' => $request->tanggal_publikasi,
            'penulis' => $request->penulis,
        ]);

        return redirect()->route('admin.beritas.index')->with('success', 'Berita berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Berita $berita)
    {
        if ($berita->gambar_utama) {
            Storage::disk('public')->delete($berita->gambar_utama);
        }
        $berita->delete();
        return redirect()->route('admin.beritas.index')->with('success', 'Berita berhasil dihapus.');
    }

    /**
     * Display the specified resource for public view.
     */
    public function showPublic(Berita $berita)
    {
        return view('admin.beritas.show_public', compact('berita'));
    }

    /**
     * Display a listing of the resource for public view.
     */
    public function indexPublic()
    {
        $beritas = Berita::latest()->paginate(9); // Ambil lebih banyak untuk halaman daftar
        return view('admin.beritas.index', compact('beritas'));
    }
}
