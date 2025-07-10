<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\KegiatanDesa; // Pastikan ini diimpor

class KegiatanDesaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        KegiatanDesa::create([
            'judul' => 'Gotong Royong Bersih Desa',
            'deskripsi' => 'Kegiatan rutin gotong royong membersihkan lingkungan desa.',
            'gambar' => 'kegiatan/gotong-royong.jpg', // Sesuaikan path jika ada gambar dummy
            'tanggal_kegiatan' => '2025-06-15',
        ]);

        KegiatanDesa::create([
            'judul' => 'Perayaan HUT Kemerdekaan',
            'deskripsi' => 'Acara memeriahkan Hari Ulang Tahun Kemerdekaan RI ke-79.',
            'gambar' => 'kegiatan/hut-ri.jpg',
            'tanggal_kegiatan' => '2025-08-17',
        ]);

        // Tambahkan data lain jika perlu
    }
}