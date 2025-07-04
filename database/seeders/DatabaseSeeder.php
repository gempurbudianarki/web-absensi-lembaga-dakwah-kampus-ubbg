<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // [MODIFIKASI KITA]
        // Kita memanggil seeder yang ingin dijalankan di sini.
        // Urutan penting: Divisi dibuat dulu, baru User.
        $this->call([
            DivisiSeeder::class,
            UserSeeder::class, // <-- Tambahkan ini
        ]);
    }
}
