<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
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

    /**
     * Mendefinisikan relasi "satu-ke-banyak" dengan model Absensi.
     * Satu pengguna bisa memiliki banyak data absensi.
     */
    public function absensis(): HasMany // <-- NAMA DIPERBAIKI DI SINI (absensi -> absensis)
    {
        return $this->hasMany(Absensi::class);
    }

    /**
     * Mendefinisikan relasi "milik" dengan model Divisi.
     * Satu pengguna hanya memiliki satu divisi.
     */
    public function divisi(): BelongsTo
    {
        return $this->belongsTo(Divisi::class);
    }
}
