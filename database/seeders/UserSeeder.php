<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Divisi;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Schema;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Ambil ID divisi berdasarkan nama baru
        $divisiSyiar = Divisi::where('nama_divisi', 'Syiar dan Dakwah')->first();
        $divisiBpsdm = Divisi::where('nama_divisi', 'BPSDM')->first();

        if (!$divisiSyiar || !$divisiBpsdm) {
            $this->command->error('Divisi tidak ditemukan. Pastikan DivisiSeeder sudah benar.');
            return;
        }

        // Matikan constraint untuk truncate
        Schema::disableForeignKeyConstraints();
        User::truncate();
        Schema::enableForeignKeyConstraints();

        // Buat data user baru
        User::create([
            'name' => 'Admin LDK', 'nim' => '101010', 'email' => 'admin@ldk.com',
            'password' => Hash::make('password'), 'role' => 'admin', 'divisi_id' => null,
        ]);
        User::create([
            'name' => 'Ketua LDK', 'nim' => '111111', 'email' => 'ketua@ldk.com',
            'password' => Hash::make('password'), 'role' => 'ketua', 'divisi_id' => null,
        ]);
        User::create([
            'name' => 'Pengurus Syiar', 'nim' => '333333', 'email' => 'pengurus.syiar@ldk.com',
            'password' => Hash::make('password'), 'role' => 'pengurus', 'divisi_id' => $divisiSyiar->id,
        ]);
        User::create([
            'name' => 'Anggota BPSDM', 'nim' => '444444', 'email' => 'anggota.bpsdm@ldk.com',
            'password' => Hash::make('password'), 'role' => 'anggota', 'divisi_id' => $divisiBpsdm->id,
        ]);
    }
}
