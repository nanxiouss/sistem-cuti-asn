<?php

namespace Database\Seeders;

use App\Models\Bidang;
use Illuminate\Database\Seeder;

class BidangSeeder extends Seeder
{
    public function run(): void
    {
        Bidang::create(['id' => 1, 'nama_bidang' => 'Sekretariat / Subbag Umum']);
        Bidang::create(['id' => 2, 'nama_bidang' => 'Bidang Ketenagalistrikan / Seksi Analisis']);
        Bidang::create(['id' => 3, 'nama_bidang' => 'Bidang UPTD LAB / Subbag Tata Usaha']);
    }
}