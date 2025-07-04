<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Divisi;

class DivisiSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(): void
    {
        // Kode ini dijamin bersih dari karakter aneh
        Divisi::create(['nama_divisi' => 'Badan Pengurus Harian (BPH)']);
        Divisi::create(['nama_divisi' => 'Syiar']);
        Divisi::create(['nama_divisi' => 'Kaderisasi']);
        Divisi::create(['nama_divisi' => 'Media dan Informasi']);
        Divisi::create(['nama_divisi' => 'Kemuslimahan']);
    }
}
