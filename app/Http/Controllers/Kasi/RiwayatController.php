<?php

namespace App\Http\Controllers\Kasi;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Pengajuan;
use Illuminate\Support\Facades\Auth;

class RiwayatController extends Controller
{
    public function index(Request $request)
    {
        $user = Auth::user();

        // 1. Ambil pengajuan staf Kasi ini yang SUDAH PERNAH DI-TTD ATAU yang statusnya DITOLAK
        $query = Pengajuan::with(['user.pegawai', 'jenisCuti'])
            ->where('id_atasan', $user->id)
            ->where(function ($q) {
                $q->whereNotNull('tgl_ttd_kasi')
                  ->orWhere('status', 'Ditolak'); // Mengizinkan berkas ditolak muncul di riwayat
            });

        // 2. Filter Berdasarkan Status Fleksibel
        if ($request->filled('status')) {
            if ($request->status == 'Diproses') {
                // Berkas sudah disetujui Kasi, tapi masih mengantre di Kabid/Kasubbag/Kadin dll
                $query->whereNotIn('status', ['Disetujui', 'Ditolak']);
            } else {
                // Berkas yang status akhirnya sudah 'Disetujui' (Final) atau 'Ditolak'
                $query->where('status', $request->status);
            }
        }

        // 3. Filter Berdasarkan Bulan
        if ($request->filled('bulan')) {
            $query->whereMonth('tgl_mulai', $request->bulan);
        }

        // 4. Filter Berdasarkan Tahun
        if ($request->filled('tahun')) {
            $query->whereYear('tgl_mulai', $request->tahun);
        }

        // PERBAIKAN LOGIKA: Urutkan berdasarkan waktu update terakhir (updated_at)
        // karena pengajuan ditolak tidak memiliki tgl_ttd_kasi
        $riwayatPengajuan = $query->orderBy('updated_at', 'desc')->get();

        // Mengambil daftar tahun dari database untuk opsi filter
        $daftarTahun = Pengajuan::selectRaw('YEAR(tgl_mulai) as tahun')
            ->distinct()
            ->orderBy('tahun', 'desc')
            ->pluck('tahun');

        return view('kasi.riwayat.index', compact('riwayatPengajuan', 'daftarTahun'));
    }

    public function show($id)
    {
        $user = Auth::user();

        // Proteksi disesuaikan dengan index agar pengajuan yang ditolak tidak 404 saat dibuka
        $pengajuan = Pengajuan::with(['user.pegawai', 'jenisCuti'])
            ->where('id_atasan', $user->id)
            ->where(function ($q) {
                $q->whereNotNull('tgl_ttd_kasi')
                  ->orWhere('status', 'Ditolak');
            })
            ->findOrFail($id);

        return view('kasi.riwayat.show', compact('pengajuan'));
    }
}