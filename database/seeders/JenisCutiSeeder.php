<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\JenisCuti;

class JenisCutiSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            [
                'nama' => 'Cuti Tahunan',
                'kuota' => 12, // Standar umum 12 hari
            ],
            [
                'nama' => 'Cuti Besar',
                'kuota' => 90, // Biasanya 3 bulan untuk masa kerja tertentu
            ],
            [
                'nama' => 'Cuti Sakit',
                'kuota' => 0, // Fleksibel, biasanya pakai surat dokter
            ],
            [
                'nama' => 'Cuti Melahirkan',
                'kuota' => 90, // 3 Bulan
            ],
            [
                'nama' => 'Cuti Karena Alasan Penting',
                'kuota' => 0, // Sesuai kebijakan (misal keluarga meninggal)
            ],
            [
                'nama' => 'Cuti Diluar Tanggungan Negara',
                'kuota' => 0, // Mengurangi jatah tahunan atau kebijakan pemerintah
            ],
        ];

        foreach ($data as $item) {
            JenisCuti::firstOrCreate(
                ['nama' => $item['nama']], // Cek berdasarkan nama
                ['kuota' => $item['kuota']] // Data yang diisi
            );
        }
    }
}
