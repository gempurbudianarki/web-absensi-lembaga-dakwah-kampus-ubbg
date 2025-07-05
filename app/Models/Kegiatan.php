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
    protected $fillable = [
        'nama_kegiatan',
        'tanggal',
        'waktu_mulai',
        'waktu_selesai',
        'absensi_mulai',      // <-- Tambahkan ini
        'absensi_selesai',    // <-- Tambahkan ini
        'status',             // <-- Tambahkan ini
        'lokasi',
        'deskripsi',
        'poster',
        'kode_absensi',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'tanggal' => 'date',
        'waktu_mulai' => 'datetime:H:i',
        'waktu_selesai' => 'datetime:H:i',
        'absensi_mulai' => 'datetime', // <-- Tambahkan ini
        'absensi_selesai' => 'datetime', // <-- Tambahkan ini
    ];

    /**
     * Mendefinisikan relasi "satu-ke-banyak" dengan model Absensi.
     */
    public function absensis(): HasMany
    {
        return $this->hasMany(Absensi::class);
    }
}
