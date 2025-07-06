<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Jalankan migrasi.
     * Membuat tabel 'wisata_desas' dengan kolom yang diperlukan.
     */
    public function up(): void
    {
        Schema::create('wisata_desas', function (Blueprint $table) {
            $table->id();
            $table->string('nama'); // Nama tempat wisata (sebelumnya 'judul')
            $table->string('kategori')->nullable(); // Kategori wisata (misal: alam, budaya, kuliner)
            $table->text('deskripsi'); // Deskripsi tempat wisata (sebelumnya 'konten')
            $table->string('gambar')->nullable(); // Kolom untuk gambar wisata
            $table->string('alamat')->nullable(); // Kolom untuk alamat wisata (sebelumnya 'nilai_utama' atau 'harga')
            $table->string('kontak_telepon')->nullable(); // Opsional: kontak telepon wisata
            $table->string('kontak_email')->nullable(); // Opsional: kontak email wisata
            $table->timestamps();
        });
    }

    /**
     * Membalikkan migrasi.
     * Menghapus tabel 'wisata_desas'.
     */
    public function down(): void
    {
        Schema::dropIfExists('wisata_desas');
    }
};
