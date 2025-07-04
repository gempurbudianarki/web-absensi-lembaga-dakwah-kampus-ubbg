<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Divisi extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'nama_divisi',
    ];


    /**
     * Mendefinisikan relasi one-to-many ke model User.
     * Satu Divisi bisa memiliki banyak User.
     */
    public function users(): HasMany
    {
        return $this->hasMany(User::class);
    }
}
