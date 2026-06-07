<?php

namespace App\Http\Controllers\Kabid;

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

        // Ambil bidang_id Kabid untuk memfilter bawahan di Bidang yang sama
        // Sesuai perubahan struktur tabel kedinasan terbaru
        $bidangIdKabid = $user->pegawai->bidang_id ?? null;

        // Scope Query dasar agar tidak menuliskan kode penapis bidang berulang-ulang
        $queryBidangKabid = function ($query) use ($bidangIdKabid) {
            if ($bidangIdKabid) {
                $query->whereHas('user.pegawai', function ($q) use ($bidangIdKabid) {
                    $q->where('bidang_id', $bidangIdKabid);
                });
            }
        };

        // --- Logika statistik Kabid (Hanya Bidang Sendiri) ---
        
        // 1. Total antrean berstatus 'Menunggu Kabid' di bidang tersebut
        $totalMenungguAksi = Pengajuan::where('status', 'Menunggu Kabid')
            ->where($queryBidangKabid)
            ->count();

        // 2. Hitung jumlah bawahan satu bidang yang sedang menjalani cuti HARI INI
        // (Status 'Disetujui' adalah status final akhir atau tahap setelah Kabid berlalu)
        $pegawaiCutiHariIni = Pengajuan::where('status', 'Disetujui')
            ->whereDate('tgl_mulai', '<=', $hariIni)
            ->whereDate('tgl_selesai', '>=', $hariIni)
            ->where($queryBidangKabid)
            ->count();

        // 3. Hitung total akumulasi cuti bawahan di bidang tersebut yang disetujui sepanjang bulan ini
        $disetujuiBulanIni = Pengajuan::where('status', 'Disetujui')
            ->whereMonth('tgl_mulai', $bulanIni)
            ->where($queryBidangKabid)
            ->count();

        // Membungkus data statistik ke dalam satu array untuk dikirim ke view
        $statistik = [
            'menunggu_aksi' => $totalMenungguAksi,
            'pegawai_cuti' => $pegawaiCutiHariIni,
            'disetujui_bulan_ini' => $disetujuiBulanIni,
        ];

        // --- Ambil data antrean untuk tabel (Limit 5) ---
        // Menyertakan eager loading 'user.pegawai.bidang' agar view bisa mencetak nama seksi bawahan
        $pengajuanButuhAksi = Pengajuan::with(['user.pegawai.bidang', 'jenisCuti'])
            ->where('status', 'Menunggu Kabid')
            ->where($queryBidangKabid)
            ->latest()
            ->take(5)
            ->get();

        return view('kabid.dashboard', compact('statistik', 'pengajuanButuhAksi'));
    }
}