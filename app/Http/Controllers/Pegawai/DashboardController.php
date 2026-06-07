<?php

namespace App\Http\Controllers\Pegawai;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use App\Models\Pengajuan;

class DashboardController extends Controller
{
    public function index()
    {
        // Load data user login beserta profil pegawai dan relasi bidang kerjanya
        $user = Auth::user()->load(['pegawai.bidang']); 

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

        $tahun_skrg = date('Y');

        // --- LOGIKA TAMPILAN SISA CUTI (Sinkron Database Riil) ---
        $sisa_total = $user->pegawai->sisa_cuti_tahunan ?? 0;

        // Pecahan otomatis untuk visualisasi kartu informasi dashboard (Maksimal N=12, N-1=6, sisa N-2)
        $sisa_n = $sisa_total > 12 ? 12 : $sisa_total;
        $sisa_n1 = ($sisa_total - $sisa_n) > 6 ? 6 : ($sisa_total - $sisa_n);
        $sisa_n2 = ($sisa_total - $sisa_n - $sisa_n1) > 0 ? ($sisa_total - $sisa_n - $sisa_n1) : 0;

        // Menghitung persentase ketersediaan jatah cuti
        $kuota_maksimal = 12 + $sisa_n1 + $sisa_n2;
        $persentase_sisa = ($kuota_maksimal > 0) ? max(0, ($sisa_total / $kuota_maksimal) * 100) : 0;

        // FIXED A: Hitung Cuti Terpakai Tahun Ini menggunakan status 'Selesai'
        $terpakai = Pengajuan::where('user_id', $user->id)
            ->where('status', 'Selesai')
            ->whereYear('tgl_mulai', $tahun_skrg)
            ->sum('lama_cuti');

        // FIXED B: Pengajuan Aktif berkurang jika status sudah final ('Selesai', 'Ditolak', 'Dibatalkan')
        $jumlah_proses = Pengajuan::where('user_id', $user->id)
            ->whereNotIn('status', ['Selesai', 'Ditolak', 'Dibatalkan'])
            ->count();

        // C. Riwayat Pengajuan
        $riwayat = Pengajuan::with('jenisCuti')
            ->where('user_id', $user->id)
            ->latest() 
            ->take(5)
            ->get();

        // FIXED: Cek apakah hari ini pegawai sedang dalam masa cuti aktif dengan status 'Selesai'
        $today = Carbon::today();
        $is_cuti = Pengajuan::where('user_id', $user->id)
            ->where('status', 'Selesai')
            ->whereDate('tgl_mulai', '<=', $today)
            ->whereDate('tgl_selesai', '>=', $today)
            ->exists();

        return view('pegawai.dashboard', compact(
            'user',
            'sapaan',
            'tahun_skrg',
            'sisa_n',
            'sisa_n1',
            'sisa_n2',
            'sisa_total',
            'persentase_sisa',
            'jumlah_proses',
            'terpakai',
            'riwayat',
            'is_cuti'
        ));
    }
}