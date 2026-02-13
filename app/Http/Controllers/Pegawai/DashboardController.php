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
        // 1. DATA USER LOGIN
        $user = Auth::user();

        // 2. LOGIKA SAPAAN WAKTU
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

        // 3. LOGIKA HITUNG SISA CUTI (Sesuai kode Native Anda)
        $tahun_skrg = date('Y');

        // [SIMULASI] Data sisa tahun lalu (idealnya ini dari database tabel user_balances)
        $db_sisa_tahun_lalu = 10;

        // Rumus N
        $sisa_n = 12;

        // Rumus N-1 (Maksimal 6)
        $sisa_n1 = ($db_sisa_tahun_lalu > 6) ? 6 : $db_sisa_tahun_lalu;

        // Rumus N-2 (Hangus)
        $sisa_n2 = 0;

        // Total Kuota Awal
        $total_kuota = $sisa_n + $sisa_n1 + $sisa_n2;

        // 4. QUERY DATABASE (ELOQUENT)

        // A. Hitung Cuti Terpakai Tahun Ini (Status: Disetujui)
        $terpakai = Pengajuan::where('user_id', $user->id)
            ->where('status', 'Disetujui')
            ->whereYear('tgl_mulai', $tahun_skrg)
            ->sum('lama_cuti');

        // Sisa Akhir Real-time
        $sisa_total = $total_kuota - $terpakai;
        $persentase_sisa = ($total_kuota > 0) ? ($sisa_total / $total_kuota) * 100 : 0;

        // B. Hitung Sedang Diproses (Selain Disetujui & Ditolak)
        $jumlah_proses = Pengajuan::where('user_id', $user->id)
            ->whereNotIn('status', ['Disetujui', 'Ditolak'])
            ->count();

        // C. Riwayat Pengajuan (Limit 5, Order by terbaru)
        // Kita gunakan 'with' untuk join tabel jenis_cuti agar hemat query
        $riwayat = Pengajuan::with('jenisCuti')
            ->where('user_id', $user->id)
            ->latest() // Otomatis order by created_at desc
            ->take(5)
            ->get();

        // Kirim semua variabel ke View
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
            'riwayat'
        ));
    }
}
