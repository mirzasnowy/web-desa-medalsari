<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     * Membuat tabel 'kearifan_lokals' untuk menyimpan data kearifan lokal.
     */
    public function up(): void
    {
        Schema::create('kearifan_lokals', function (Blueprint $table) {
            $table->id();
            $table->string('nama');
            $table->text('deskripsi')->nullable();
            $table->string('icon')->nullable(); // Contoh: 'fa-leaf' untuk Font Awesome icon
            $table->string('gambar')->nullable(); // Jika ada gambar terkait kearifan lokal
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     * Mengembalikan migrasi (menghapus tabel 'kearifan_lokals').
     */
    public function down(): void
    {
        Schema::dropIfExists('kearifan_lokals');
    }
};
