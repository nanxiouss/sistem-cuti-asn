<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Pegawai;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;

class ResetCutiTahunanPegawai extends Command
{
    protected $signature = 'cuti:reset-tahunan';
    protected $description = 'Reset sisa cuti tahunan (1 Januari), Cuti Besar (5 Tahunan), dan Melahirkan (Tahunan) berdasarkan masa kerja';

    public function handle()
    {
        $this->info('Memulai proses pengecekan dan reset cuti pegawai...');
        Log::info('Proses cron job reset cuti harian/tahunan dimulai.');

        $today = Carbon::today();

        DB::beginTransaction();
        try {
            $pegawais = Pegawai::all();

            foreach ($pegawais as $pegawai) {
                // Flag penanda apakah data pegawai ini diubah hari ini
                $isUpdated = false; 

                // 1. LOGIKA CUTI TAHUNAN (Hanya jalan setiap 1 Januari)
                if ($today->format('m-d') === '01-01') {
                    $sisa_akhir_tahun = $pegawai->sisa_cuti_tahunan ?? 0;
                    $carry_over = $sisa_akhir_tahun > 12 ? 12 : $sisa_akhir_tahun;
                    $jatah_baru = 12;
                    
                    $pegawai->sisa_cuti_tahunan = $carry_over + $jatah_baru;
                    $isUpdated = true;
                }

                // 2. LOGIKA CUTI BESAR & MELAHIRKAN (Berdasarkan Masa Kerja)
                if ($pegawai->masa_kerja) {
                    $tanggalMasuk = Carbon::parse($pegawai->masa_kerja);

                    // Cek apakah HARI INI tepat jatuh pada bulan & tanggal anniversary masuk kerja
                    if ($today->isSameMonth($tanggalMasuk) && $today->isSameDay($tanggalMasuk)) {
                        
                        // A. Reset Cuti Melahirkan (Diberikan 90 hari setiap tahun di tanggal anniversary)
                        $pegawai->sisa_cuti_melahirkan = 90;
                        $isUpdated = true;

                        // B. Reset Cuti Besar (Diberikan 90 hari HANYA setiap kelipatan 5 tahun)
                        $selisihTahun = $today->diffInYears($tanggalMasuk);
                        if ($selisihTahun > 0 && $selisihTahun % 5 === 0) {
                            $pegawai->sisa_cuti_besar = 90;
                        }
                    }
                }

                if ($isUpdated) {
                    $pegawai->save();
                }
            }

            DB::commit();
            $this->info('Berhasil mengecek dan me-reset cuti pegawai yang memenuhi syarat hari ini!');
            Log::info('Proses cron job reset cuti berhasil diselesaikan.');

        } catch (\Exception $e) {
            DB::rollBack();
            $this->error('Terjadi kesalahan: ' . $e->getMessage());
            Log::error('Gagal reset cuti: ' . $e->getMessage());
        }
    }
}