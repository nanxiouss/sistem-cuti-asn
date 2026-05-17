<?php

namespace App\Http\Controllers\Kasi;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Pengajuan;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        $hariIni = Carbon::today();
        $bulanIni = Carbon::now()->month;
        
        // Ambil data user yang sedang login (Kasi)
        $user = Auth::user();
        
        // Asumsi: Kasi dan Pegawai punya field 'unit_kerja' di tabel pegawais
        // Kita pakai ini biar Kasi cuma liat pengajuan dari bawahan di seksinya sendiri.
        // Kalau logic lu beda, tinggal sesuaikan aja bagian 'whereHas'-nya.
        $unitKerjaKasi = $user->pegawai->unit_kerja ?? null;

        // 1. Ambil list pengajuan yang nunggu di-ACC Kasi (Ambil 5 terbaru untuk tabel)
        $pengajuanButuhAksi = Pengajuan::with(['user.pegawai', 'jenisCuti'])
            ->where('status', 'Menunggu ACC Kasi')
            ->when($unitKerjaKasi, function ($query) use ($unitKerjaKasi) {
                // Filter agar yang tampil hanya pegawai dari seksi yang sama
                $query->whereHas('user.pegawai', function ($q) use ($unitKerjaKasi) {
                    $q->where('unit_kerja', $unitKerjaKasi);
                });
            })
            ->latest()
            ->take(5)
            ->get();

        // 2. Hitung total "Menunggu ACC Kasi" untuk angka di widget
        $totalMenungguAksi = Pengajuan::where('status', 'Menunggu ACC Kasi')
            ->when($unitKerjaKasi, function ($query) use ($unitKerjaKasi) {
                $query->whereHas('user.pegawai', function ($q) use ($unitKerjaKasi) {
                    $q->where('unit_kerja', $unitKerjaKasi);
                });
            })
            ->count();

        // 3. Hitung jumlah bawahan di seksinya yang sedang cuti HARI INI
        $pegawaiCutiHariIni = Pengajuan::where('status', 'Disetujui')
            ->whereDate('tgl_mulai', '<=', $hariIni)
            ->whereDate('tgl_selesai', '>=', $hariIni)
            ->when($unitKerjaKasi, function ($query) use ($unitKerjaKasi) {
                $query->whereHas('user.pegawai', function ($q) use ($unitKerjaKasi) {
                    $q->where('unit_kerja', $unitKerjaKasi);
                });
            })
            ->count();

        // 4. Hitung total cuti bawahan yang disetujui bulan ini
        $disetujuiBulanIni = Pengajuan::where('status', 'Disetujui')
            ->whereMonth('tgl_mulai', $bulanIni)
            ->when($unitKerjaKasi, function ($query) use ($unitKerjaKasi) {
                $query->whereHas('user.pegawai', function ($q) use ($unitKerjaKasi) {
                    $q->where('unit_kerja', $unitKerjaKasi);
                });
            })
            ->count();

        // Gabungin data statistik ke dalam satu array biar rapi pas dilempar
        $statistik = [
            'menunggu_aksi' => $totalMenungguAksi,
            'pegawai_cuti' => $pegawaiCutiHariIni,
            'disetujui_bulan_ini' => $disetujuiBulanIni,
        ];

        // Lempar data ke view Kasi
        return view('kasi.dashboard', compact('statistik', 'pengajuanButuhAksi'));
    }
}