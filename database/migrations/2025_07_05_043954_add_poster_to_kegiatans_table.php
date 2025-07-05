<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // Kita akan mengubah tabel 'kegiatans' yang sudah ada
        Schema::table('kegiatans', function (Blueprint $table) {
            // [MODIFIKASI KITA]
            // Tambahkan kolom baru bernama 'poster'
            // Tipe datanya string untuk menyimpan nama file (contoh: kajian-akbar.jpg)
            // `nullable()` berarti kolom ini boleh kosong
            // `after('deskripsi')` menempatkan kolom ini setelah kolom deskripsi agar rapi
            $table->string('poster')->nullable()->after('deskripsi');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        // Ini adalah instruksi jika kita ingin membatalkan migrasi
        Schema::table('kegiatans', function (Blueprint $table) {
            // Hapus kolom 'poster' jika ada
            $table->dropColumn('poster');
        });
    }
};
