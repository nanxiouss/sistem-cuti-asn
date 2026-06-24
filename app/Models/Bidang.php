<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Bidang extends Model
{
    protected $fillable = ['nama_bidang'];

    public function pegawais() {
        return $this->hasMany(Pegawai::class);
    }

    /**
     * Mendapatkan data induk (Parent) dari bidang ini.
     */
    public function parent()
    {
        return $this->belongsTo(Bidang::class, 'parent_id', 'id');
    }

    /**
     * Mendapatkan semua sub-bidang (Children) di bawah bidang ini.
     */
    public function children()
    {
        return $this->hasMany(Bidang::class, 'parent_id', 'id');
    }
}
