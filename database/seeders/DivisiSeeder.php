<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Divisi;
use Illuminate\Support\Facades\Schema;

class DivisiSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Schema::disableForeignKeyConstraints();
        Divisi::truncate();
        Schema::enableForeignKeyConstraints();

        $divisis = [
            ['nama_divisi' => 'BPSDM'],
            ['nama_divisi' => 'Infokom'],
            ['nama_divisi' => 'Syiar dan Dakwah'],
            ['nama_divisi' => 'Humas'],
        ];

        foreach ($divisis as $divisi) {
            Divisi::create($divisi);
        }
    }
}
