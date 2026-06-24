<?php

namespace App\Http\Controllers\Kadin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Pengajuan;
use Illuminate\Support\Facades\Auth;

class RiwayatController extends Controller
{
    public function index(Request $request)
    {
        // 1. Base Query: Ambil pengajuan lintas bidang yang sudah pernah diproses/ditinjau oleh Kadin
        $query = Pengajuan::with(['user.pegawai.bidang', 'jenisCuti'])
            ->where(function ($q) {
                $q->whereNotNull('tgl_ttd_kadin') // Sudah disetujui/ditandatangani Kadin
                  ->orWhereIn('status', ['Disetujui', 'Selesai', 'disetujui', 'selesai']) // Otomatis muncul jika status akhirnya sudah final
                  ->orWhere(function ($sub) {
                      // Jika ditolak di tingkat akhir (Kadin), pastikan track record-nya lolos dari Sekdin
                      $sub->whereIn('status', ['Ditolak', 'ditolak'])
                          ->whereNotNull('tgl_ttd_sekdin'); 
                  });
            });

        // 2. Filter Berdasarkan Status Fleksibel
        if ($request->filled('status')) {
            $status = $request->status;
            
            if (in_array(strtolower($status), ['diproses', 'proses'])) {
                // Berkas sudah diparaf Kadin namun masih dalam proses administrasi akhir (belum completely final)
                $query->whereNotIn('status', ['Disetujui', 'Ditolak', 'Selesai', 'disetujui', 'ditolak', 'selesai']);
            } else {
                // Mencegah bug data kosong akibat ketidakcocokan huruf kapital (e.g., 'Disetujui' vs 'disetujui')
                $query->where(function ($q) use ($status) {
                    $q->where('status', $status)
                      ->orWhere('status', strtolower($status))
                      ->orWhere('status', ucfirst(strtolower($status)));
                });
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

        return view('kadin.riwayat.index', compact('riwayatPengajuan', 'daftarTahun'));
    }

    public function show($id)
    {
        // Proteksi halaman detail disamakan dengan rule index agar tidak terjadi error 404
        $pengajuan = Pengajuan::with(['user.pegawai.bidang', 'jenisCuti'])
            ->where(function ($q) {
                $q->whereNotNull('tgl_ttd_kadin')
                  ->orWhereIn('status', ['Disetujui', 'Selesai', 'disetujui', 'selesai'])
                  ->orWhere(function ($sub) {
                      $sub->whereIn('status', ['Ditolak', 'ditolak'])
                          ->whereNotNull('tgl_ttd_sekdin');
                  });
            })
            ->findOrFail($id);

        return view('kadin.riwayat.show', compact('pengajuan'));
    }
}