<?php

namespace App\Http\Controllers\Kasumum;

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

        // --- Logika statistik Kasubbag Umum (Global / Seluruh Bidang) ---
        
        // 1. Total antrean berstatus 'Menunggu Kasubbag Umum' di seluruh bidang
        $totalMenungguAksi = Pengajuan::where('status', 'Menunggu Kasubbag Umum')
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
        // Tanpa query penapis bidang karena Kasubbag Umum memproses seluruh berkas masuk
        $pengajuanButuhAksi = Pengajuan::with(['user.pegawai.bidang', 'jenisCuti'])
            ->where('status', 'Menunggu Kasubbag Umum')
            ->latest()
            ->take(5)
            ->get();

        return view('kasumum.dashboard', compact('statistik', 'pengajuanButuhAksi'));
    }
}