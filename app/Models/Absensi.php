<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Absensi extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    // [MODIFIKASI KITA #1] Daftar izin kolom yang boleh diisi
    protected $fillable = [
        'user_id',
        'kegiatan_id',
        'status',
    ];


    // [MODIFIKASI KITA #2] Relasi ke User
    /**
     * Mendefinisikan relasi bahwa satu data Absensi milik satu User.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }


    // [MODIFIKASI KITA #3] Relasi ke Kegiatan
    /**
     * Mendefinisikan relasi bahwa satu data Absensi milik satu Kegiatan.
     */
    public function kegiatan(): BelongsTo
    {
        return $this->belongsTo(Kegiatan::class);
    }
}
