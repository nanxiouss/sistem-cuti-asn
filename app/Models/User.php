<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
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
        'jabatan',
        'unit_kerja',
        'masa_kerja_tahun',
        'masa_kerja_bulan',
        'role',
        'id_atasan',
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
        'masa_kerja_tahun' => 'integer',
        'masa_kerja_bulan' => 'integer',
    ];


    public function atasan()
    {
        return $this->belongsTo(User::class, 'id_atasan');
    }

    public function bawahan()
    {
        return $this->hasMany(User::class, 'id_atasan');
    }
}
