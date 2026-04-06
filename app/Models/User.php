<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'nip',
        'nama',
        'password',
        'role',
    ];

    /**
     * Atribut yang harus disembunyikan saat return JSON/Array.
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Casting tipe data otomatis.
     */
    protected $casts = [
        'password' => 'hashed',
    ];

    public function pegawai()
    {
        return $this->hasOne(Pegawai::class, 'user_id', 'id');
    }
}
