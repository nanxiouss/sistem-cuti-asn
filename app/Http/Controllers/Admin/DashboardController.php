<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Pegawai;
use App\Models\Pengajuan;
use App\Models\User;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        $hariIni = Carbon::today();
        $sekarang = Carbon::now();
        $bulanIni = $sekarang->month;
        $tahunIni = $sekarang->year;

        // KATEGORI STATISTIK SESUAI ALUR FLOWCHART
        $statistik = [
            // 1. Antrean Utama Admin
            'menunggu_admin'   => Pengajuan::where('status', 'Menunggu Verifikasi Admin')->count(),
            
            // 2. Tracking Posisi Berkas di Atasan (Sesuai Tahapan Flowchart)
            'proses_kasi'      => Pengajuan::where('status', 'Menunggu Persetujuan Kasi')->count(),
            'proses_kabid'     => Pengajuan::where('status', 'Menunggu Persetujuan Kabid')->count(),
            'proses_kasubbag'  => Pengajuan::where('status', 'Menunggu Persetujuan Kasubbag Umum')->count(),
            'proses_sekdin'    => Pengajuan::where('status', 'Menunggu Persetujuan Sekdin')->count(),
            'proses_kadin'     => Pengajuan::where('status', 'Menunggu Persetujuan Kadin')->count(),
            
            // 3. Status Akhir Pengajuan
            'disetujui'        => Pengajuan::where('status', 'Disetujui')->count(),
            'total_ditolak'    => Pengajuan::where('status', 'like', 'Ditolak%')
                                            ->orWhere('status', 'Dikembalikan ke Pegawai')
                                            ->count(),
                                            
            // 4. Data Tambahan Kontrol
            'total_pegawai'    => User::where('role', '!=', 'admin')->count(),
        ];

        // AKSI ADMIN: Hanya mengambil pengajuan yang tertahan di meja Admin (Tahap 1 Flowchart)
        $butuhAksi = Pengajuan::with(['user.pegawai.bidang', 'jenisCuti'])
            ->where('status', 'Menunggu Verifikasi Admin')
            ->latest()
            ->take(5)
            ->get();

        // MONITORING: Pegawai yang saat ini sedang menjalani cuti (Status: Disetujui & Rentang Tanggal Aktif)
        $cutiHariIni = Pengajuan::with(['user.pegawai.bidang', 'jenisCuti'])
            ->where('status', 'Disetujui')
            ->whereDate('tgl_mulai', '<=', $hariIni)
            ->whereDate('tgl_selesai', '>=', $hariIni)
            ->get();

        // TOTAL BULANAN: Untuk grafik/analitik bulanan Admin
        $cutiBulanIni = Pengajuan::where('status', 'Disetujui')
            ->whereMonth('tgl_mulai', $bulanIni)
            ->whereYear('tgl_mulai', $tahunIni)
            ->count();

        return view('admin.dashboard', compact('statistik', 'butuhAksi', 'cutiHariIni', 'cutiBulanIni'));
    }
}