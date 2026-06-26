<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Pegawai;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class ResetCutiTahunanPegawai extends Command
{
    // Nama command untuk dijalankan (bisa juga via terminal: php artisan cuti:reset-tahunan)
    protected $signature = 'cuti:reset-tahunan';
    protected $description = 'Reset sisa cuti tahunan pegawai berdasarkan aturan BKN (Maks carry over 12 hari + jatah baru 12 hari)';

    public function handle()
    {
        $this->info('Memulai proses reset cuti tahunan pegawai...');
        Log::info('Proses cron job reset cuti tahunan dimulai.');

        DB::beginTransaction();
        try {
            $pegawais = Pegawai::all();

            foreach ($pegawais as $pegawai) {
                // Sisa cuti di akhir tahun berjalan
                $sisa_akhir_tahun = $pegawai->sisa_cuti_tahunan ?? 0;

                // Logika BKN (Sistem 1 Kolom): 
                // Maksimal cuti yang bisa dibawa ke tahun depan (sebagai N-1 dan N-2) adalah 12 hari (6 + 6).
                $carry_over = $sisa_akhir_tahun > 12 ? 12 : $sisa_akhir_tahun;

                // Tambahkan jatah cuti baru (N) untuk tahun berjalan
                $jatah_baru = 12;

                // Total update ke database (Maksimal akan jadi 24 hari)
                $pegawai->sisa_cuti_tahunan = $carry_over + $jatah_baru;
                $pegawai->save();
            }

            DB::commit();
            $this->info('Berhasil me-reset cuti seluruh pegawai!');
            Log::info('Proses cron job reset cuti tahunan berhasil.');

        } catch (\Exception $e) {
            DB::rollBack();
            $this->error('Terjadi kesalahan: ' . $e->getMessage());
            Log::error('Gagal reset cuti: ' . $e->getMessage());
        }
    }
}