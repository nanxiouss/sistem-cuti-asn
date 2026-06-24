<?php

namespace App\Http\Controllers\Sekdin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Pengajuan;
use Illuminate\Support\Facades\Auth;

class RiwayatController extends Controller
{
    public function index(Request $request)
    {
        // 1. Base Query: Ambil pengajuan lintas bidang yang sudah pernah diproses oleh Sekdin
        $query = Pengajuan::with(['user.pegawai.bidang', 'jenisCuti'])
            ->where(function ($q) {
                $q->whereNotNull('tgl_ttd_sekdin') 
                  ->orWhereIn('status', ['Disetujui', 'Selesai']) 
                  ->orWhere(function ($sub) {
                      $sub->where('status', 'Ditolak')
                          ->whereNotNull('tgl_ttd_kasubbag_umum'); 
                  });
            });

        // 2. Filter Berdasarkan Status 
        if ($request->filled('status')) {
            $status = strtolower($request->status);
            
            if (in_array($status, ['diproses', 'proses'])) {
                // Berkas masih berjalan di tingkat atas (Kadin), kita kecualikan status final
                $query->whereNotIn('status', ['Disetujui', 'Ditolak', 'Selesai']);
            } elseif (in_array($status, ['disetujui', 'selesai'])) {
                $query->whereIn('status', ['Disetujui', 'Selesai', 'disetujui', 'selesai']);
            } else {
                $query->where('status', 'LIKE', $request->status);
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

        // Urutkan berdasarkan update terakhir agar data terbaru muncul paling atas
        $riwayatPengajuan = $query->orderBy('updated_at', 'desc')->get();

        // Mengambil daftar tahun dari database untuk opsi filter
        $daftarTahun = Pengajuan::selectRaw('YEAR(tgl_mulai) as tahun')
            ->distinct()
            ->orderBy('tahun', 'desc')
            ->pluck('tahun');

        return view('sekdin.riwayat.index', compact('riwayatPengajuan', 'daftarTahun'));
    }

    public function show($id)
    {
        // Proteksi halaman detail disamakan dengan rule index agar tidak terjadi error 404
        $pengajuan = Pengajuan::with(['user.pegawai.bidang', 'jenisCuti'])
            ->where(function ($q) {
                $q->whereNotNull('tgl_ttd_sekdin')
                  ->orWhereIn('status', ['Disetujui', 'Selesai'])
                  ->orWhere(function ($sub) {
                      $sub->where('status', 'Ditolak')
                          ->whereNotNull('tgl_ttd_kasubbag_umum');
                  });
            })
            ->findOrFail($id);

        return view('sekdin.riwayat.show', compact('pengajuan'));
    }
}