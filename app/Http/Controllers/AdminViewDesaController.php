<?php

namespace App\Http\Controllers;

use App\Models\ViewDesa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AdminViewDesaController extends Controller
{
    /**
     * Display a listing of the resource (Admin Index).
     */
    public function index()
    {
        $viewDesas = ViewDesa::all();
        return view('admin.view_desas.index', compact('viewDesas'));
    }

    /**
     * Show the form for creating a new resource (Admin Create).
     */
    public function create()
    {
        return view('admin.view_desas.create');
    }

    /**
     * Store a newly created resource in storage (Admin Store).
     */
    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'deskripsi' => 'required|string',
            'gambar' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            // Kolom-kolom berikut tidak lagi divalidasi karena dihapus dari form
            // 'kategori' => 'nullable|string|max:255',
            // 'alamat' => 'nullable|string|max:255',
            // 'kontak_telepon' => 'nullable|string|max:20',
            // 'kontak_email' => 'nullable|email|max:255',
            // 'latitude' => 'nullable|numeric',
            // 'longitude' => 'nullable|numeric',
        ]);

        $data = $request->except(['gambar', 'kategori', 'alamat', 'kontak_telepon', 'kontak_email', 'latitude', 'longitude']);
        // Menghapus kunci yang tidak relevan untuk ViewDesa dari request, untuk kejelasan
        // Meskipun sudah di-except, ini lapisan keamanan tambahan jika ada kolom yang tidak terduga

        if ($request->hasFile('gambar')) {
            $data['gambar'] = $request->file('gambar')->store('view_desas', 'public');
        }

        ViewDesa::create($data);

        return redirect()->route('admin.view_desas.index')->with('success', 'Potret Desa berhasil ditambahkan.');
    }

    /**
     * Display the specified resource (Admin Show).
     */
    public function show(ViewDesa $viewDesa)
    {
        return view('admin.view_desas.show', compact('viewDesa'));
    }

    /**
     * Show the form for editing the specified resource (Admin Edit).
     */
    public function edit(ViewDesa $viewDesa)
    {
        return view('admin.view_desas.edit', compact('viewDesa'));
    }

    /**
     * Update the specified resource in storage (Admin Update).
     */
    public function update(Request $request, ViewDesa $viewDesa)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'deskripsi' => 'required|string',
            'gambar' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            // Kolom-kolom berikut tidak lagi divalidasi
            // 'kategori' => 'nullable|string|max:255',
            // 'alamat' => 'nullable|string|max:255',
            // 'kontak_telepon' => 'nullable|string|max:20',
            // 'kontak_email' => 'nullable|email|max:255',
            // 'latitude' => 'nullable|numeric',
            // 'longitude' => 'nullable|numeric',
        ]);

        $data = $request->except(['gambar', 'kategori', 'alamat', 'kontak_telepon', 'kontak_email', 'latitude', 'longitude']);
        // Menghapus kunci yang tidak relevan untuk ViewDesa dari request

        if ($request->hasFile('gambar')) {
            // Hapus gambar lama jika ada
            if ($viewDesa->gambar) {
                Storage::disk('public')->delete($viewDesa->gambar);
            }
            $data['gambar'] = $request->file('gambar')->store('view_desas', 'public');
        }

        $viewDesa->update($data);

        return redirect()->route('admin.view_desas.index')->with('success', 'Potret Desa berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage (Admin Destroy).
     */
    public function destroy(ViewDesa $viewDesa)
    {
        if ($viewDesa->gambar) {
            Storage::disk('public')->delete($viewDesa->gambar);
        }
        $viewDesa->delete();

        return redirect()->route('admin.view_desas.index')->with('success', 'Potret Desa berhasil dihapus.');
    }

    /**
     * Menampilkan detail View Desa untuk publik (Frontend View).
     */
    public function showPublic(ViewDesa $viewDesa)
    {
        return view('admin.view_desas.show_public', compact('viewDesa'));
    }
}