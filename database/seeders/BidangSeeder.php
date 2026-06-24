<?php

namespace Database\Seeders;

use App\Models\Bidang;
use Illuminate\Database\Seeder;

class BidangSeeder extends Seeder
{
    public function run(): void
    {
        // === LEVEL 1: INDUK UTAMA / BIDANG ===
        Bidang::create(['id' => 1, 'nama_bidang' => 'Sekretariat', 'parent_id' => null]);
        Bidang::create(['id' => 5, 'nama_bidang' => 'Energi', 'parent_id' => null]);
        Bidang::create(['id' => 9, 'nama_bidang' => 'Ketenagalistrikan', 'parent_id' => null]);
        Bidang::create(['id' => 13, 'nama_bidang' => 'Pengusahaan Mineral dan Batubara', 'parent_id' => null]);
        Bidang::create(['id' => 18, 'nama_bidang' => 'Teknik dan Penerimaan Mineral dan Batubara', 'parent_id' => null]);

        // === LEVEL 2: PECAHAN / SUBBAGIAN / SEKSI ===
        // Di bawah Sekretariat (ID: 1)
        Bidang::create(['id' => 2, 'nama_bidang' => 'Subbagian Umum & Kepegawaian', 'parent_id' => 1]);
        Bidang::create(['id' => 3, 'nama_bidang' => 'Subbagian Keuangan', 'parent_id' => 1]);
        Bidang::create(['id' => 4, 'nama_bidang' => 'Subbagian Perencanaan, Evaluasi & Pelaporan', 'parent_id' => 1]);

        // Di bawah Bidang Energi (ID: 5)
        Bidang::create(['id' => 6, 'nama_bidang' => 'Energi Baru Terbarukan', 'parent_id' => 5]);
        Bidang::create(['id' => 7, 'nama_bidang' => 'Konservasi Energi', 'parent_id' => 5]);
        Bidang::create(['id' => 8, 'nama_bidang' => 'Minyak & Gas Bumi', 'parent_id' => 5]);

        // Di bawah Bidang Ketenagalistrikan (ID: 9)
        Bidang::create(['id' => 10, 'nama_bidang' => 'Pengembangan Ketenagalistrikan', 'parent_id' => 9]);
        Bidang::create(['id' => 11, 'nama_bidang' => 'Pengusahaan Ketenagalistrikan', 'parent_id' => 9]);
        Bidang::create(['id' => 12, 'nama_bidang' => 'Pengawasan Ketenagalistrikan', 'parent_id' => 9]);

        // Di bawah Bidang Pengusahaan Minreba (ID: 13)
        Bidang::create(['id' => 14, 'nama_bidang' => 'Penataan Wilayah', 'parent_id' => 13]);
        Bidang::create(['id' => 15, 'nama_bidang' => 'Pembinaan Pengusahaan', 'parent_id' => 13]);
        Bidang::create(['id' => 17, 'nama_bidang' => 'Bimbingan Usaha', 'parent_id' => 13]);

        // Di bawah Bidang Teknik & Penerimaan Minerba (ID: 18)
        Bidang::create(['id' => 19, 'nama_bidang' => 'Teknik dan Lingkungan', 'parent_id' => 18]);
        Bidang::create(['id' => 20, 'nama_bidang' => 'Produksi', 'parent_id' => 18]);
        Bidang::create(['id' => 21, 'nama_bidang' => 'Penerimaan', 'parent_id' => 18]);
    }
}