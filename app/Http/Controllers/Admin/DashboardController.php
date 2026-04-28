<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Pegawai;
use App\Models\Pengajuan;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        $hariIni = Carbon::today();
        $bulanIni = Carbon::now()->month;

        $statistik = [
            'total_pengajuan' => Pengajuan::count(),
            'menunggu_aksi'   => Pengajuan::whereIn('status', ['Menunggu Verifikasi Admin', 'Dikembalikan ke Admin'])->count(),
            'disetujui'       => Pengajuan::where('status', 'Disetujui')->count(),
            'ditolak'         => Pengajuan::whereIn('status', ['Ditolak', 'Tidak Disetujui'])->count(),
        ];

        $butuhAksi = Pengajuan::with('user.pegawai', 'jenisCuti')
            ->whereIn('status', ['Menunggu Verifikasi Admin', 'Dikembalikan ke Admin'])
            ->latest()
            ->take(5)
            ->get();

        $cutiHariIni = Pengajuan::with('user.pegawai')
            ->where('status', 'Disetujui')
            ->whereDate('tgl_mulai', '<=', $hariIni)
            ->whereDate('tgl_selesai', '>=', $hariIni)
            ->get();

        $cutiBulanIni = Pengajuan::where('status', 'Disetujui')
            ->whereMonth('tgl_mulai', $bulanIni)
            ->count();

        return view('admin.dashboard', compact('statistik', 'butuhAksi', 'cutiHariIni', 'cutiBulanIni'));
    }
}
