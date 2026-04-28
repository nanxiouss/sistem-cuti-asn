<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Pegawai extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'atasan_id',
        'pangkat_golongan',
        'jabatan',
        'unit_kerja',
        'tmt_kerja',
        'sisa_cuti_tahunan',
        'no_hp',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function atasan()
    {
        return $this->belongsTo(User::class, 'atasan_id');
    }

    public function atasanPegawai()
    {
        return $this->belongsTo(Pegawai::class, 'atasan_id', 'user_id');
    }

    public function getMasaKerjaTahunAttribute()
    {
        if (!$this->tmt_kerja) return 0;
        return Carbon::parse($this->tmt_kerja)->diffInYears(now());
    }

    public function getMasaKerjaBulanAttribute()
    {
        if(!$this->tmt_kerja) return 0;
        $tahun = $this->masa_kerja_tahun;
        return Carbon::parse($this->tmt_kerja)->addYears($tahun)->diffInMonths(now());
    }
}
