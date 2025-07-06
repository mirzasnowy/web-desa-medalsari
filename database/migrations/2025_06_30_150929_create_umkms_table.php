<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Jalankan migrasi.
     * Membuat tabel 'umkms' dengan semua kolom yang diperlukan.
     */
    public function up(): void
    {
        Schema::create('umkms', function (Blueprint $table) {
            $table->id(); // Kolom ID auto-increment (primary key)
            $table->string('nama'); // Kolom untuk nama UMKM (WAJIB ADA)
            $table->string('kategori'); // Kolom untuk kategori UMKM (WAJIB ADA)
            $table->text('deskripsi'); // Kolom untuk deskripsi UMKM (WAJIB ADA)
            $table->string('kontak_telepon')->nullable(); // Kolom opsional untuk nomor telepon, bisa kosong
            $table->string('kontak_email')->nullable(); // Kolom opsional untuk email, bisa kosong
            $table->string('harga')->nullable(); // Kolom opsional untuk informasi harga, bisa kosong
            $table->timestamps(); // Kolom created_at dan updated_at, otomatis diisi Laravel
        });
    }

    /**
     * Membalikkan migrasi.
     * Menghapus tabel 'umkms' jika migrasi di-rollback.
     */
    public function down(): void
    {
        Schema::dropIfExists('umkms');
    }
};
