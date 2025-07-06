<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash; // Penting: Pastikan Hash facade diimpor

class AdminUserSeeder extends Seeder
{
    /**
     * Jalankan database seeds.
     * Membuat user admin jika belum ada atau memperbarui jika sudah ada.
     */
    public function run(): void
    {
        // Hapus user admin yang mungkin sudah ada untuk menghindari duplikasi
        // Ini memastikan kita selalu membuat ulang user admin dengan password yang benar
        DB::table('users')->where('email', 'admin@desamedalsari.com')->delete();

        // Masukkan user admin baru ke tabel 'users'
        DB::table('users')->insert([
            'name' => 'Admin Desa',
            'email' => 'admin@desamedalsari.com',
            'password' => Hash::make('123456'), // Password '123456' akan di-hash
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}
