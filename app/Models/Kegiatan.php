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
    // [MODIFIKASI KITA] Menambahkan 'poster' ke dalam daftar izin
    protected $fillable = [
        'nama_kegiatan',
        'deskripsi',
        'poster', // <-- INI YANG TERLEWAT
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
    protected $casts = [
        'tanggal_kegiatan' => 'date',
        'waktu_mulai_absen' => 'datetime',
        'waktu_selesai_absen' => 'datetime',
    ];


    /**
     * Mendefinisikan relasi bahwa satu Kegiatan bisa memiliki banyak data Absensi.
     */
    public function absensi(): HasMany
    {
        return $this->hasMany(Absensi::class);
    }
}
