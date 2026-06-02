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
        $user = Auth::user();
        
        // Ambil data bidang Kasi untuk memfilter bawahan di seksi yang sama
        // Mendukung format bidang berupa relasi (bidang_id) maupun string teks langsung
        $bidangKasi = $user->pegawai->bidang_id ?? $user->pegawai->bidang ?? null;

        // Scope Query dasar agar tidak menuliskan kode penapis bidang berulang-ulang
        $querySeksiKasi = function ($query) use ($bidangKasi) {
            if ($bidangKasi) {
                $query->whereHas('user.pegawai', function ($q) use ($bidangKasi) {
                    if (is_numeric($bidangKasi)) {
                        $q->where('bidang_id', $bidangKasi);
                    } else {
                        $q->where('bidang', $bidangKasi);
                    }
                });
            }
        };

        // 1. Ambil list pengajuan yang sedang menunggu persetujuan Kasi (Limit 5 untuk preview tabel)
        $pengajuanButuhAksi = Pengajuan::with(['user.pegawai', 'jenisCuti'])
            ->where('status', 'Menunggu Kasi')
            ->where($querySeksiKasi)
            ->latest()
            ->take(5)
            ->get();

        // 2. Hitung total antrean "Menunggu ACC Kasi" untuk angka badge/widget angka utama
        $totalMenungguAksi = Pengajuan::where('status', 'Menunggu Kasi')
            ->where($querySeksiKasi)
            ->count();

        // 3. Hitung jumlah bawahan satu seksi yang sedang menjalani cuti HARI INI
        $pegawaiCutiHariIni = Pengajuan::where('status', 'Disetujui')
            ->whereDate('tgl_mulai', '<=', $hariIni)
            ->whereDate('tgl_selesai', '>=', $hariIni)
            ->where($querySeksiKasi)
            ->count();

        // 4. Hitung total akumulasi cuti bawahan yang disetujui sepanjang bulan ini
        $disetujuiBulanIni = Pengajuan::where('status', 'Disetujui')
            ->whereMonth('tgl_mulai', $bulanIni)
            ->where($querySeksiKasi)
            ->count();

        // Membungkus data statistik ke dalam satu array array
        $statistik = [
            'menunggu_aksi' => $totalMenungguAksi,
            'pegawai_cuti' => $pegawaiCutiHariIni,
            'disetujui_bulan_ini' => $disetujuiBulanIni,
        ];

        return view('kasi.dashboard', compact('statistik', 'pengajuanButuhAksi'));
    }
}