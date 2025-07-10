<?php

namespace App\Http\Controllers;

use App\Models\KearifanLokal;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AdminKearifanLokalController extends Controller
{
    /**
     * Display a listing of the resource.
     * Menampilkan daftar semua data kearifan lokal di admin panel.
     */
    public function index()
    {
        $kearifanLokals = KearifanLokal::latest()->paginate(10);
        return view('admin.kearifan_lokals.index', compact('kearifanLokals'));
    }

    /**
     * Show the form for creating a new resource.
     * Menampilkan formulir untuk membuat data kearifan lokal baru.
     */
    public function create()
    {
        return view('admin.kearifan_lokals.create');
    }

    /**
     * Store a newly created resource in storage.
     * Menyimpan data kearifan lokal yang baru dibuat ke database.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'deskripsi' => 'nullable|string',
            'icon' => 'nullable|string|max:255', // Contoh: 'fa-leaf'
            'gambar' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        $gambarPath = null;
        if ($request->hasFile('gambar')) {
            $gambarPath = $request->file('gambar')->store('kearifan_lokals', 'public');
        }

        KearifanLokal::create([
            'nama' => $request->nama,
            'deskripsi' => $request->deskripsi,
            'icon' => $request->icon,
            'gambar' => $gambarPath,
        ]);

        return redirect()->route('admin.kearifan_lokals.index')->with('success', 'Kearifan Lokal berhasil ditambahkan.');
    }

    /**
     * Display the specified resource.
     * Menampilkan detail kearifan lokal tertentu di admin panel.
     */
    public function show(KearifanLokal $kearifanLokal)
    {
        return view('admin.kearifan_lokals.show', compact('kearifanLokal'));
    }

    /**
     * Show the form for editing the specified resource.
     * Menampilkan formulir untuk mengedit kearifan lokal tertentu.
     */
    public function edit(KearifanLokal $kearifanLokal)
    {
        return view('admin.kearifan_lokals.edit', compact('kearifanLokal'));
    }

    /**
     * Update the specified resource in storage.
     * Memperbarui data kearifan lokal tertentu di database.
     */
    public function update(Request $request, KearifanLokal $kearifanLokal)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'deskripsi' => 'nullable|string',
            'icon' => 'nullable|string|max:255',
            'gambar' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        $gambarPath = $kearifanLokal->gambar;
        if ($request->hasFile('gambar')) {
            if ($gambarPath) {
                Storage::disk('public')->delete($gambarPath);
            }
            $gambarPath = $request->file('gambar')->store('kearifan_lokals', 'public');
        }

        $kearifanLokal->update([
            'nama' => $request->nama,
            'deskripsi' => $request->deskripsi,
            'icon' => $request->icon,
            'gambar' => $gambarPath,
        ]);

        return redirect()->route('admin.kearifan_lokals.index')->with('success', 'Kearifan Lokal berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     * Menghapus kearifan lokal tertentu dari database.
     */
    public function destroy(KearifanLokal $kearifanLokal)
    {
        if ($kearifanLokal->gambar) {
            Storage::disk('public')->delete($kearifanLokal->gambar);
        }
        $kearifanLokal->delete();
        return redirect()->route('admin.kearifan_lokals.index')->with('success', 'Kearifan Lokal berhasil dihapus.');
    }

    /**
     * Display the specified resource for public view.
     * Menampilkan detail kearifan lokal untuk tampilan publik.
     */
    public function showPublic(KearifanLokal $kearifanLokal)
    {
        return view('kearifan_lokal.show_public', compact('kearifanLokal'));
    }

    /**
     * Display a listing of the resource for public view.
     * Menampilkan daftar semua kearifan lokal untuk tampilan publik.
     */
    public function indexPublic()
    {
        $kearifanLokals = KearifanLokal::latest()->paginate(9);
        return view('kearifan_lokal.index_public', compact('kearifanLokals'));
    }
}
