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
        $user = Auth::user()->load('pegawai'); 

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

        // --- LOGIKA HITUNG SISA CUTI (Pecah ke N, N-1, N-2) ---
        $tahun_skrg = date('Y');

        // Ambil kuota dasar dari database
        $kuota_db = $user->pegawai->sisa_cuti_tahunan ?? 12;

        // Pemecahan otomatis
        $sisa_n = 12;
        $sisa_n1 = 0;
        $sisa_n2 = 0;

        if ($kuota_db > 12) {
            $sisa_n1 = $kuota_db - 12;
            
            // Aturan PNS/Umum: N-1 maksimal 6, sisanya dilempar ke N-2
            if ($sisa_n1 > 6) {
                $sisa_n2 = $sisa_n1 - 6;
                $sisa_n1 = 6;
            }
        } else {
            // Jika kuota_db kurang dari 12
            $sisa_n = $kuota_db;
        }

        $total_kuota = $sisa_n + $sisa_n1 + $sisa_n2; // Hasilnya pasti sama dengan $kuota_db

        // A. Hitung Cuti Terpakai Tahun Ini
        $terpakai = Pengajuan::where('user_id', $user->id)
            ->where('status', 'Disetujui')
            ->whereYear('tgl_mulai', $tahun_skrg)
            ->sum('lama_cuti');

        // Sisa Akhir Real-time
        $sisa_total = $total_kuota - $terpakai;
        $persentase_sisa = ($total_kuota > 0) ? max(0, ($sisa_total / $total_kuota) * 100) : 0;

        // B. Hitung Sedang Diproses
        $jumlah_proses = Pengajuan::where('user_id', $user->id)
            ->whereNotIn('status', ['Disetujui', 'Ditolak', 'Tidak Disetujui'])
            ->count();

        // C. Riwayat Pengajuan
        $riwayat = Pengajuan::with('jenisCuti')
            ->where('user_id', $user->id)
            ->latest() 
            ->take(5)
            ->get();

        $today = Carbon::today();
        $is_cuti = Pengajuan::where('user_id', $user->id)
            ->where('status', 'Disetujui')
            ->whereDate('tgl_mulai', '<=', $today)
            ->whereDate('tgl_selesai', '>=', $today)
            ->exists();

        // Kirim sisa_n, n1, n2 kembali ke View agar UI kamu tetap jalan!
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