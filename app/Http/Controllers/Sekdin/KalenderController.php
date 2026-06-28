<?php

namespace App\Http\Controllers\Sekdin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Pengajuan;
use Carbon\Carbon;

class KalenderController extends Controller
{
    public function index()
    {
        // 1. AMBIL DATA CUTI PEGAWAI SECARA GLOBAL (SEMUA BIDANG)
        $dataCuti = Pengajuan::with(['user.pegawai.bidang', 'jenisCuti'])
            ->whereIn('status', ['Selesai']) 
            ->get();

        // 2. HITUNG JUMLAH REKAP PEGAWAI YANG CUTI PER HARI
        $dailyCounts = [];
        foreach ($dataCuti as $cuti) {
            if ($cuti->tgl_mulai && $cuti->tgl_selesai) {
                $start = Carbon::parse($cuti->tgl_mulai);
                $end = Carbon::parse($cuti->tgl_selesai);
                
                for ($date = $start; $date->lte($end); $date->addDay()) {
                    $dateStr = $date->format('Y-m-d');
                    if (!isset($dailyCounts[$dateStr])) {
                        $dailyCounts[$dateStr] = 0;
                    }
                    $dailyCounts[$dateStr]++;
                }
            }
        }

        // 3. TRANSFORMASI DATA UNTUK FORMAT FULLCALENDAR (MENAMPILKAN NAMA BIDANG SECARA GLOBAL)
        $events = $dataCuti->map(function ($cuti) {
            $namaCuti = $cuti->jenisCuti->nama ?? 'Cuti';
            $namaPegawai = $cuti->user->nama ?? 'Pegawai';
            $namaBidang = $cuti->user->pegawai->bidang->nama ?? $cuti->user->pegawai->bidang->nama_bidang ?? 'Tanpa Bidang';

            // Pewarnaan Lencana Kalender Berdasarkan Jenis Cuti
            $warna = '#3B82F6'; // Default: Biru
            if (str_contains(strtolower($namaCuti), 'sakit')) {
                $warna = '#EF4444'; // Merah
            } elseif (str_contains(strtolower($namaCuti), 'melahirkan')) {
                $warna = '#EC4899'; // Pink
            } elseif (str_contains(strtolower($namaCuti), 'besar')) {
                $warna = '#F59E0B'; // Kuning
            } elseif (str_contains(strtolower($namaCuti), 'penting')) {
                $warna = '#10B981'; // Hijau
            }

            return [
                // Format judul: "Nama Pegawai - Nama Bidang (Jenis Cuti)"
                'title' => $namaPegawai . ' - ' . $namaBidang . ' (' . $namaCuti . ')',
                'start' => $cuti->tgl_mulai,
                'end'   => Carbon::parse($cuti->tgl_selesai)->addDay()->format('Y-m-d'), 
                'color' => $warna,
                'textColor' => '#ffffff',
                'extendedProps' => [
                    'keterangan' => $cuti->alasan ?? 'Tidak ada alasan dicantumkan',
                    'nama_pegawai' => $namaPegawai, 
                    'nama_bidang' => $namaBidang
                ]
            ];
        });

        // 4. Lempar data ke view kalender global (misal di dalam folder admin/kepegawaian)
        return view('kasumum.kalender.index', compact('events', 'dailyCounts'));
    }
}