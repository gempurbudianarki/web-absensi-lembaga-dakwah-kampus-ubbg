<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Divisi;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Ambil ID dari setiap divisi
        $divisiBph = Divisi::where('nama_divisi', 'Badan Pengurus Harian (BPH)')->first();
        $divisiSyiar = Divisi::where('nama_divisi', 'Syiar')->first();
        $divisiKaderisasi = Divisi::where('nama_divisi', 'Kaderisasi')->first();
        $divisiMedia = Divisi::where('nama_divisi', 'Media dan Informasi')->first();

        // Buat Admin (role: admin)
        User::create([
            'name' => 'Admin LDK',
            'nim' => '101010',
            'email' => 'admin@ldk.com',
            'password' => Hash::make('password'),
            'role' => 'admin',
            'divisi_id' => null,
        ]);

        // Buat Ketua (role: ketua)
        User::create([
            'name' => 'Ketua Umum',
            'nim' => '111111',
            'email' => 'ketua@ldk.com',
            'password' => Hash::make('password'),
            'role' => 'ketua',
            'divisi_id' => null,
        ]);

        // Buat Pengurus (role: pengurus)
        User::create([
            'name' => 'Pengurus Syiar',
            'nim' => '333333',
            'email' => 'pengurus.syiar@ldk.com',
            'password' => Hash::make('password'),
            'role' => 'pengurus',
            'divisi_id' => $divisiSyiar->id,
        ]);

        // Buat Anggota (role: anggota)
        User::create([
            'name' => 'Anggota Kaderisasi 1',
            'nim' => '444444',
            'email' => 'anggota.kaderisasi1@ldk.com',
            'password' => Hash::make('password'),
            'role' => 'anggota',
            'divisi_id' => $divisiKaderisasi->id,
        ]);
    }
}
