<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Jalankan migrasi.
     * Menambahkan kolom 'gambar' ke tabel 'umkms'.
     */
    public function up(): void
    {
        Schema::table('umkms', function (Blueprint $table) {
            // Menambahkan kolom 'gambar' setelah kolom 'deskripsi'
            // Kolom ini nullable, artinya bisa kosong.
            $table->string('gambar')->nullable()->after('deskripsi');
        });
    }

    /**
     * Membalikkan migrasi.
     * Menghapus kolom 'gambar' dari tabel 'umkms' jika migrasi di-rollback.
     */
    public function down(): void
    {
        Schema::table('umkms', function (Blueprint $table) {
            $table->dropColumn('gambar');
        });
    }
};
