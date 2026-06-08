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

        $statistik = [
            // 1. Antrean Utama Admin
            'menunggu_admin'   => Pengajuan::where('status', 'Menunggu Verifikasi Admin')->count(),
            
            // 2. Tracking Posisi Berkas
            'proses_kasi'      => Pengajuan::where('status', 'Menunggu Kasi')->count(),
            'proses_kabid'     => Pengajuan::where('status', 'Menunggu Kabid')->count(),
            'proses_kasubbag'  => Pengajuan::where('status', 'Menunggu Kasubbag Umum')->count(), 
            'proses_sekdin'    => Pengajuan::where('status', 'Menunggu Sekdin')->count(),
            'proses_kadin'     => Pengajuan::where('status', 'Menunggu Kadin')->count(),
            
            // 3. Status Akhir Pengajuan
            'disetujui'        => Pengajuan::whereIn('status', ['Selesai'])->count(),
            
            'total_ditolak'    => Pengajuan::where('status', 'like', 'Ditolak%')
                                            ->orWhere('status', 'Dikembalikan ke Pegawai')
                                            ->count(),
            // 4. Data Tambahan Kontrol
            'total_pegawai'    => User::where('role', '!=', 'admin')->count(),
        ];

        // AKSI ADMIN: Mengambil pengajuan yang butuh verifikasi awal admin
        $butuhAksi = Pengajuan::with(['user.pegawai.bidang', 'jenisCuti'])
            ->where('status', 'Menunggu Verifikasi Admin')
            ->latest()
            ->take(5)
            ->get();

        // MONITORING: Pegawai yang saat ini sedang menjalani cuti (Murni yang statusnya sudah 'Selesai')
        $cutiHariIni = Pengajuan::with(['user.pegawai.bidang', 'jenisCuti'])
            ->where('status', 'Selesai')
            ->whereDate('tgl_mulai', '<=', $hariIni)
            ->whereDate('tgl_selesai', '>=', $hariIni)
            ->get();

        // TOTAL BULANAN: Berdasarkan pengajuan yang sudah 'Selesai' di bulan berjalan
        $cutiBulanIni = Pengajuan::where('status', 'Selesai')
            ->whereMonth('tgl_mulai', $bulanIni)
            ->whereYear('tgl_mulai', $tahunIni)
            ->count();

        return view('admin.dashboard', compact('statistik', 'butuhAksi', 'cutiHariIni', 'cutiBulanIni'));
    }
}