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
        'bidang_id', 
        'pangkat_id',
        'jabatan',
        'masa_kerja',
        'sisa_cuti_tahunan',
        'sisa_cuti_besar',
        'sisa_cuti_melahirkan',
        'no_telepon', 
        'foto_profil', 
        'foto_ttd'
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function bidang()
    {
        return $this->belongsTo(Bidang::class, 'bidang_id');
    }

    public function pangkat()
    {
        return $this->belongsTo(Pangkat::class, 'pangkat_id');
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
        if (!$this->masa_kerja) return 0;
        return Carbon::parse($this->masa_kerja)->diffInYears(now());
    }

    public function getMasaKerjaBulanAttribute()
    {
        if(!$this->masa_kerja) return 0;
        $tahun = $this->masa_kerja_tahun;
        return Carbon::parse($this->masa_kerja)->addYears($tahun)->diffInMonths(now());
    }
}