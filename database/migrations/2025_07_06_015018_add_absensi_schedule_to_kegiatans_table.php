<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('kegiatans', function (Blueprint $table) {
            // Menambahkan kolom baru dan membuatnya BOLEH KOSONG (nullable)
            // Ini adalah kunci perbaikannya.
            $table->dateTime('absensi_mulai')->nullable()->after('waktu_selesai');
            $table->dateTime('absensi_selesai')->nullable()->after('absensi_mulai');
            
            // Kolom status tetap sama
            $table->enum('status', ['Akan Datang', 'Berlangsung', 'Selesai'])->default('Akan Datang')->after('kode_absensi');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('kegiatans', function (Blueprint $table) {
            $table->dropColumn(['absensi_mulai', 'absensi_selesai', 'status']);
        });
    }
};
