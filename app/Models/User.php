<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    // [MODIFIKASI KITA #1] Menambahkan nim, role, dan divisi_id
    protected $fillable = [
        'name',
        'nim',
        'email',
        'password',
        'role',
        'divisi_id',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];


    // [MODIFIKASI KITA #2] Relasi ke Divisi
    /**
     * Mendefinisikan relasi bahwa satu User milik satu Divisi.
     */
    public function divisi(): BelongsTo
    {
        return $this->belongsTo(Divisi::class, 'divisi_id');
    }


    // [MODIFIKASI KITA #3] Relasi ke Absensi
    /**
     * Mendefinisikan relasi bahwa satu User bisa memiliki banyak data Absensi.
     */
    public function absensi(): HasMany
    {
        return $this->hasMany(Absensi::class);
    }
}
