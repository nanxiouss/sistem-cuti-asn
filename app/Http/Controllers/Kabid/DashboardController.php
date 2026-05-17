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
        
        // Logika statistik Kabid (Asumsi status antreannya 'Menunggu ACC Kabid')
        $statistik = [
            'menunggu_aksi' => Pengajuan::where('status', 'Menunggu ACC Kabid')->count(),
            'pegawai_cuti' => Pengajuan::where('status', 'Disetujui')
                ->whereDate('tgl_mulai', '<=', Carbon::today())
                ->whereDate('tgl_selesai', '>=', Carbon::today())
                ->count(),
            'disetujui_bulan_ini' => Pengajuan::where('status', 'Disetujui')
                ->whereMonth('updated_at', Carbon::now()->month)
                ->count(),
        ];

        // Ambil 5 data terbaru yang butuh di-ACC Kabid
        $pengajuanButuhAksi = Pengajuan::with(['user', 'jenisCuti'])
            ->where('status', 'Menunggu ACC Kabid')
            ->latest()
            ->take(5)
            ->get();

        return view('kabid.dashboard', compact('statistik', 'pengajuanButuhAksi'));
    }
}