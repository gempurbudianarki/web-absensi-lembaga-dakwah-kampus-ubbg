<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Kegiatan extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    // [MODIFIKASI KITA #1] Daftar izin kolom yang boleh diisi
    protected $fillable = [
        'nama_kegiatan',
        'deskripsi',
        'tanggal_kegiatan',
        'waktu_mulai_absen',
        'waktu_selesai_absen',
        'kode_absensi',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    // [MODIFIKASI KITA #2] Mengubah tipe data kolom agar lebih pintar
    protected $casts = [
        'tanggal_kegiatan' => 'date',
        'waktu_mulai_absen' => 'datetime',
        'waktu_selesai_absen' => 'datetime',
    ];


    // [MODIFIKASI KITA #3] Relasi ke Absensi
    /**
     * Mendefinisikan relasi bahwa satu Kegiatan bisa memiliki banyak data Absensi.
     */
    public function absensi(): HasMany
    {
        return $this->hasMany(Absensi::class);
    }
}
