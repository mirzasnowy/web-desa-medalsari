<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     * Menjalankan migrasi untuk membuat tabel 'penduduks'.
     */
    public function up(): void
    {
        Schema::create('penduduks', function (Blueprint $table) {
            $table->id();
            $table->string('nama');
            $table->string('nik')->unique(); // Nomor Induk Kependudukan, harus unik
            $table->string('no_kk')->nullable(); // Nomor Kartu Keluarga
            $table->enum('jenis_kelamin', ['Laki-laki', 'Perempuan']);
            $table->string('pekerjaan')->nullable();
            $table->string('pendidikan')->nullable();
            $table->timestamps(); // Kolom created_at dan updated_at
        });
    }

    /**
     * Reverse the migrations.
     * Mengembalikan migrasi (menghapus tabel 'penduduks').
     */
    public function down(): void
    {
        Schema::dropIfExists('penduduks');
    }
};
