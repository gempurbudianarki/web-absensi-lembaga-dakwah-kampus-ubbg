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
        Schema::create('kegiatans', function (Blueprint $table) {
            // Primary Key
            $table->id();

            // Informasi dasar kegiatan
            $table->string('nama_kegiatan');
            $table->text('deskripsi')->nullable(); // Boleh kosong
            $table->date('tanggal_kegiatan');

            // --- JANTUNG FITUR ABSENSI ---
            // Waktu spesifik kapan absensi mulai bisa diisi
            $table->dateTime('waktu_mulai_absen');
            // Waktu spesifik kapan absensi ditutup
            $table->dateTime('waktu_selesai_absen');
            // Kode unik untuk absen mandiri
            $table->string('kode_absensi')->unique()->nullable(); // Boleh kosong saat dibuat

            // Kolom created_at dan updated_at
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('kegiatans');
    }
};
