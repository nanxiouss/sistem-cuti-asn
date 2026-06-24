<?php

namespace App\Http\Controllers\Kabid;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Pengajuan;
use App\Models\Bidang; 
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        // 1. Ambil data user login beserta profil pegawai & bidang
        $user = Auth::user()->load(['pegawai.bidang']);
        $hariIni = Carbon::today()->toDateString(); // Format murni Y-m-d untuk akurasi DB
        $bulanIni = Carbon::now()->month;
        $tahunIni = Carbon::now()->year;

        // --- Tambahan A: LOGIKA SAPAAN DINAMIS WAKTU ---
        $jam = Carbon::now()->hour;
        if ($jam >= 5 && $jam < 11) {
            $sapaan = "Selamat Pagi";
        } elseif ($jam >= 11 && $jam < 15) {
            $sapaan = "Selamat Siang";
        } elseif ($jam >= 15 && $jam < 18) {
            $sapaan = "Selamat Sore";
        } else {
            $sapaan = "Selamat Malam";
        }

        $bidangIdKabid = $user->pegawai->bidang_id ?? null;

        // --- LOGIKA BIDANG INDUK & SEKSI BAWAHAN ---
        $daftarBidangBawahan = [];
        if ($bidangIdKabid) {
            $daftarBidangBawahan = Bidang::where('id', $bidangIdKabid)
                ->orWhere('parent_id', $bidangIdKabid)
                ->pluck('id')
                ->toArray(); 
        }

        // Query scope untuk filter berdasarkan lingkup bidang Kabid
        $queryBidangKabid = function ($query) use ($daftarBidangBawahan) {
            if (!empty($daftarBidangBawahan)) {
                $query->whereHas('user.pegawai', function ($q) use ($daftarBidangBawahan) {
                    $q->whereIn('bidang_id', $daftarBidangBawahan);
                });
            }
        };

        // --- Logika statistik Kabid (Lingkup Bidang Induk + Seksi) ---
        
        // 1. Total antrean berstatus 'Menunggu Kabid' di bidang tersebut
        $totalMenungguAksi = Pengajuan::where('status', 'Menunggu Kabid')
            ->where($queryBidangKabid)
            ->count();

        // 2. Hitung jumlah bawahan lingkup bidang yang sedang menjalani cuti HARI INI
        // PERBAIKAN BUG: Menyertakan status 'Disetujui' dan 'Selesai'
        $pegawaiCutiHariIni = Pengajuan::whereIn('status', ['Disetujui', 'Selesai'])
            ->where('tgl_mulai', '<=', $hariIni)
            ->where('tgl_selesai', '>=', $hariIni)
            ->where($queryBidangKabid)
            ->count();

        // 3. Hitung total akumulasi cuti bawahan di bidang tersebut sepanjang bulan ini
        // PERBAIKAN BUG: Menyertakan status 'Selesai' dan filter berdasarkan bulan & tahun berjalan
        $disetujuiBulanIni = Pengajuan::whereIn('status', ['Disetujui', 'Selesai'])
            ->whereYear('tgl_mulai', $tahunIni)
            ->where(function($q) use ($bulanIni) {
                $q->whereMonth('tgl_mulai', $bulanIni)
                  ->orWhereMonth('tgl_selesai', $bulanIni);
            })
            ->where($queryBidangKabid)
            ->count();

        // Membungkus data statistik ke dalam satu array untuk dikirim ke view
        $statistik = [
            'menunggu_aksi' => $totalMenungguAksi,
            'pegawai_cuti' => $pegawaiCutiHariIni,
            'disetujui_bulan_ini' => $disetujuiBulanIni,
        ];

        // --- Ambil data antrean untuk tabel (Limit 5) dengan Eager Loading relasi jenisCuti secara utuh ---
        $pengajuanButuhAksi = Pengajuan::with(['user.pegawai.bidang', 'jenisCuti'])
            ->where('status', 'Menunggu Kabid')
            ->where($queryBidangKabid)
            ->latest()
            ->take(5)
            ->get();

        return view('kabid.dashboard', compact('user', 'sapaan', 'statistik', 'pengajuanButuhAksi'));
    }
}