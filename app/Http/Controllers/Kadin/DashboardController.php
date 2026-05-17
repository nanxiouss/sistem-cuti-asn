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
        // Statistik Kadin
        $statistik = [
            'menunggu_aksi' => Pengajuan::where('status', 'Menunggu ACC Kadin')->count(),
            'pegawai_cuti' => Pengajuan::where('status', 'Disetujui')
                ->whereDate('tgl_mulai', '<=', Carbon::today())
                ->whereDate('tgl_selesai', '>=', Carbon::today())
                ->count(),
            'disetujui_bulan_ini' => Pengajuan::where('status', 'Disetujui')
                ->whereMonth('updated_at', Carbon::now()->month)
                ->count(),
        ];

        // Antrean 5 data teratas yang nunggu keputusan Kadin
        $pengajuanButuhAksi = Pengajuan::with(['user', 'jenisCuti'])
            ->where('status', 'Menunggu ACC Kadin')
            ->latest()
            ->take(5)
            ->get();

        return view('kadin.dashboard', compact('statistik', 'pengajuanButuhAksi'));
    }
}