<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pangkat extends Model
{
    use HasFactory;

    protected $fillable = ['nama_pangkat', 'golongan', 'ruang'];

    // Accessor untuk menampilkan format gabungan di dropdown/tabel
    public function getNamaLengkapAttribute()
    {
        return "{$this->nama_pangkat} ({$this->golongan}/{$this->ruang})";
    }

    public function pegawai()
    {
        return $this->hasMany(Pegawai::class, 'pangkat_id');
    }
}