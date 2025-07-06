<?php

namespace Database\Seeders;

// Penting: Pastikan Anda mengimpor AdminUserSeeder di sini
use Database\Seeders\AdminUserSeeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run(): void
    {
        // Panggil seeder-seeder lain yang Anda miliki di sini
        // Misalnya, untuk menjalankan AdminUserSeeder:
        $this->call(AdminUserSeeder::class);

        // Jika Anda memiliki seeder lain di masa mendatang, tambahkan di sini:
        // $this->call([
        //     AnotherSeeder::class,
        //     YetAnotherSeeder::class,
        // ]);
    }
}
