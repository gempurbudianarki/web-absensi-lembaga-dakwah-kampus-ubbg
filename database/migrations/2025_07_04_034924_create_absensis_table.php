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
        Schema::create('absensis', function (Blueprint $table) {
            // Primary Key
            $table->id();

            // --- KABEL PENGHUBUNG ---
            // Menghubungkan ke tabel 'users'
            // cascadeOnDelete() berarti jika user dihapus, data absensinya juga ikut terhapus
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();

            // Menghubungkan ke tabel 'kegiatans'
            $table->foreignId('kegiatan_id')->constrained('kegiatans')->cascadeOnDelete();

            // Kolom untuk status kehadiran
            $table->enum('status', ['Hadir', 'Izin', 'Sakit', 'Alpha'])->default('Hadir');

            // --- PENGAMAN PENTING ---
            // Mencegah satu user absen dua kali di kegiatan yang sama
            $table->unique(['user_id', 'kegiatan_id']);

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
        Schema::dropIfExists('absensis');
    }
};
