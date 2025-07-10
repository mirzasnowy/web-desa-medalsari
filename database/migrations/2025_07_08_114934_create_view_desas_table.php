<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('view_desas', function (Blueprint $table) {
            $table->id();
            $table->string('nama'); // Nama Potret, contoh: "Sawah Emas Pagi Hari", "Jembatan Tua Medalsari"
            $table->string('kategori')->nullable(); // Kategori, contoh: "Alam", "Infrastruktur", "Budaya"
            $table->text('deskripsi'); // Deskripsi singkat
            $table->string('gambar')->nullable(); // Path gambar di storage
            $table->string('alamat')->nullable(); // Alamat/Lokasi spesifik jika ada
            $table->string('kontak_telepon')->nullable(); // Kontak jika relevan
            $table->string('kontak_email')->nullable(); // Kontak jika relevan
            $table->string('latitude')->nullable(); // Latitude untuk peta (opsional)
            $table->string('longitude')->nullable(); // Longitude untuk peta (opsional)
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('view_desas');
    }
};