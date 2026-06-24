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
        // 1. Load data user login beserta profil pegawai dan relasi bidang kerjanya untuk sapaan teks banner
        $user = Auth::user()->load(['pegawai.bidang']); 
        $hariIni = Carbon::today()->toDateString(); // Menggunakan string tanggal murni Y-m-d agar akurat di query database
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

        // --- Tambahan B: CEK STATUS CUTI PRIBADI KASUBBAG (Untuk penanda teks Hadir / Cuti) ---
        $is_cuti = Pengajuan::where('user_id', $user->id)
            ->whereIn('status', ['Disetujui', 'Selesai']) 
            ->where('tgl_mulai', '<=', $hariIni)
            ->where('tgl_selesai', '>=', $hariIni)
            ->exists();

        // --- Logika statistik Kasubbag Umum (Global / Seluruh Bidang) ---
        
        // 1. Total antrean berstatus 'Menunggu Kasubbag Umum' di seluruh bidang
        $totalMenungguAksi = Pengajuan::where('status', 'Menunggu Kasubbag Umum')
            ->count();

        // 2. Hitung jumlah seluruh pegawai instansi yang sedang menjalani cuti HARI INI
        // PERBAIKAN BUG: Menyertakan status 'Selesai' agar cuti aktif hari ini terhitung secara global
        $pegawaiCutiHariIni = Pengajuan::whereIn('status', ['Disetujui', 'Selesai'])
            ->where('tgl_mulai', '<=', $hariIni)
            ->where('tgl_selesai', '>=', $hariIni)
            ->count();

        // 3. Hitung total akumulasi cuti seluruh pegawai yang disetujui sepanjang bulan ini
        // PERBAIKAN BUG: Menyertakan status 'Selesai' dan filter berdasarkan bulan berjalan
        $disetujuiBulanIni = Pengajuan::whereIn('status', ['Disetujui', 'Selesai'])
            ->whereYear('tgl_mulai', $tahunIni)
            ->where(function($q) use ($bulanIni) {
                $q->whereMonth('tgl_mulai', $bulanIni)
                  ->orWhereMonth('tgl_selesai', $bulanIni);
            })
            ->count();

        // Membungkus data statistik ke dalam satu array untuk dikirim ke view
        $statistik = [
            'menunggu_aksi' => $totalMenungguAksi,
            'pegawai_cuti' => $pegawaiCutiHariIni,
            'disetujui_bulan_ini' => $disetujuiBulanIni,
        ];

        // --- Ambil data antrean untuk tabel Meja Kerja (Limit 5) ---
        // Memastikan eager loading ke jenisCuti dan profil bidang sudah lengkap
        $pengajuanButuhAksi = Pengajuan::with(['user.pegawai.bidang', 'jenisCuti'])
            ->where('status', 'Menunggu Kasubbag Umum')
            ->latest()
            ->take(5)
            ->get();

        // --- Ambil data detail pegawai yang sedang cuti hari ini (untuk Sidebar Kanan) ---
        // PERBAIKAN BUG: Status dirubah ke whereIn agar memuat data cuti yang sudah 'Selesai' di sistem
        $cutiHariIni = Pengajuan::with(['user.pegawai.bidang', 'jenisCuti'])
            ->whereIn('status', ['Disetujui', 'Selesai'])
            ->where('tgl_mulai', '<=', $hariIni)
            ->where('tgl_selesai', '>=', $hariIni)
            ->get();

        // Mengirimkan semua variabel ke view blade
        return view('kasumum.dashboard', compact('user', 'sapaan', 'is_cuti', 'statistik', 'pengajuanButuhAksi', 'cutiHariIni'));
    }
}