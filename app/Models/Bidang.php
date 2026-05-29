<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Bidang extends Model
{
    protected $fillable = ['nama_bidang'];

    public function pegawais() {
        return $this->hasMany(Pegawai::class);
    }
}
