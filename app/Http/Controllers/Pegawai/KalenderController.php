<?php

namespace App\Http\Controllers\Pegawai;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Pengajuan;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class KalenderController extends Controller
{
    public function index()
    {
        // 1. Dapatkan bidang_id dari pegawai yang sedang login
        $user = Auth::user();
        $bidangId = $user->pegawai->bidang_id ?? null;

        // Proteksi: Jika user belum punya bidang_id, tampilkan kalender kosong
        if (!$bidangId) {
            $events = [];
            $dailyCounts = [];
            return view('Pegawai.kalender.index', compact('events', 'dailyCounts'));
        }

        // 2. Ambil data cuti HANYA untuk rekan se-bidang yang disetujui / selesai
        $dataCuti = Pengajuan::with(['user.pegawai', 'jenisCuti'])
            ->whereIn('status', ['Disetujui', 'Selesai']) // Mengambil status yang sudah di-ACC
            ->whereHas('user.pegawai', function ($query) use ($bidangId) {
                $query->where('bidang_id', $bidangId);
            })
            ->get();

        // 3. Hitung jumlah orang cuti per hari (untuk lencana "Cuti: X" di kalender)
        $dailyCounts = [];
        foreach ($dataCuti as $cuti) {
            // Pastikan tanggalnya tidak kosong
            if ($cuti->tgl_mulai && $cuti->tgl_selesai) {
                $start = Carbon::parse($cuti->tgl_mulai);
                $end = Carbon::parse($cuti->tgl_selesai);
                
                // Looping dari tanggal mulai sampai selesai, lalu tambahkan +1
                for ($date = $start; $date->lte($end); $date->addDay()) {
                    $dateStr = $date->format('Y-m-d');
                    if (!isset($dailyCounts[$dateStr])) {
                        $dailyCounts[$dateStr] = 0;
                    }
                    $dailyCounts[$dateStr]++;
                }
            }
        }

        // 4. TRANSFORMASI DATA UNTUK MODE AGENDA (LIST)
        $events = $dataCuti->map(function ($cuti) {
            // PERBAIKAN: Gunakan ->nama sesuai tabel jenis_cutis
            $namaCuti = $cuti->jenisCuti->nama ?? 'Cuti';

            // Penentuan Warna Lencana Berdasarkan Jenis Cuti
            $warna = '#3B82F6'; // Default: Biru (Cuti Tahunan, dll)
            if (str_contains($namaCuti, 'Sakit')) {
                $warna = '#EF4444'; // Merah
            } elseif (str_contains($namaCuti, 'Melahirkan')) {
                $warna = '#EC4899'; // Pink
            } elseif (str_contains($namaCuti, 'Besar')) {
                $warna = '#F59E0B'; // Kuning/Amber
            }

            return [
                'title' => ($cuti->user->nama ?? 'Pegawai') . ' (' . $namaCuti . ')',
                'start' => $cuti->tgl_mulai,
                // Ditambah 1 hari karena sifat kalender (FullCalendar) batas akhirnya eksklusif
                'end'   => Carbon::parse($cuti->tgl_selesai)->addDay()->format('Y-m-d'), 
                'color' => $warna,
                'textColor' => '#ffffff',
                'extendedProps' => [
                    // PERBAIKAN: Gunakan ->alasan sesuai tabel pengajuans
                    'keterangan' => $cuti->alasan ?? 'Tidak ada alasan dicantumkan'
                ]
            ];
        });

        // Lempar dua variabel ke view: events (rincian list agenda) dan dailyCounts (angka rekap di kotak kalender)
        return view('Pegawai.kalender.index', compact('events', 'dailyCounts'));
    }
}