<?php

namespace App\Http\Controllers\Kadin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Pengajuan;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $hariIni = Carbon::today();
        $bulanIni = Carbon::now()->month;

        // --- Logika statistik Kepala Dinas (Global / Instansi) ---
        
        // 1. Total antrean berstatus 'Menunggu Kadin'
        $totalMenungguAksi = Pengajuan::where('status', 'Menunggu Kadin')
            ->count();

        // 2. Hitung jumlah seluruh pegawai instansi yang sedang menjalani cuti HARI INI
        $pegawaiCutiHariIni = Pengajuan::where('status', 'Disetujui')
            ->whereDate('tgl_mulai', '<=', $hariIni)
            ->whereDate('tgl_selesai', '>=', $hariIni)
            ->count();

        // 3. Hitung total akumulasi cuti seluruh pegawai yang disetujui sepanjang bulan ini
        $disetujuiBulanIni = Pengajuan::where('status', 'Disetujui')
            ->whereMonth('tgl_mulai', $bulanIni)
            ->count();

        // Membungkus data statistik ke dalam satu array untuk dikirim ke view
        $statistik = [
            'menunggu_aksi' => $totalMenungguAksi,
            'pegawai_cuti' => $pegawaiCutiHariIni,
            'disetujui_bulan_ini' => $disetujuiBulanIni,
        ];

        // --- Ambil data antrean untuk tabel (Limit 5) ---
        // Kadin memproses berkas yang sudah melewati tahap Sekdin
        $pengajuanButuhAksi = Pengajuan::with(['user.pegawai.bidang', 'jenisCuti'])
            ->where('status', 'Menunggu Kadin')
            ->latest()
            ->take(5)
            ->get();

        return view('kadin.dashboard', compact('statistik', 'pengajuanButuhAksi'));
    }
}