<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class JenisCuti extends Model
{
    protected $table = 'jenis_cuti';
    protected $guarded = [];

    // Relasi: Satu jenis cuti bisa memiliki banyak pengajuan
    public function pengajuan()
    {
        return $this->hasMany(Pengajuan::class, 'jenis_cuti_id');
    }
}
