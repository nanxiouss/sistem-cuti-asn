<?php

namespace App\Http\Controllers\Kasumum;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Pengajuan;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class RiwayatController extends Controller
{
    public function index(Request $request)
    {
        // ==========================================
        // A. QUERY RIWAYAT PEGAWAI LAIN (DI LUAR KASUMUM)
        // ==========================================
        $query = Pengajuan::with(['user.pegawai.bidang', 'jenisCuti'])
            ->where('user_id', '!=', Auth::id()) // Batasi: Bukan milik diri sendiri
            ->where(function ($q) {
                $q->whereNotNull('tgl_ttd_kasubbag_umum') 
                  ->orWhereIn('status', ['Disetujui', 'Selesai', 'disetujui', 'selesai']) 
                  ->orWhere(function ($sub) {
                      $sub->whereIn('status', ['Ditolak', 'ditolak'])
                          ->whereNotNull('tgl_ttd_kabid'); 
                  });
            });

        // Filter Berdasarkan Status, Bulan, Tahun untuk Pegawai Lain
        if ($request->filled('status')) {
            $status = $request->status;
            if (in_array(strtolower($status), ['diproses', 'proses'])) {
                $query->whereNotIn('status', ['Disetujui', 'Ditolak', 'Selesai', 'disetujui', 'ditolak', 'selesai']);
            } else {
                $query->where(function ($q) use ($status) {
                    $q->where('status', $status)
                      ->orWhere('status', strtolower($status))
                      ->orWhere('status', ucfirst(strtolower($status)));
                });
            }
        }

        if ($request->filled('bulan')) {
            $query->whereMonth('tgl_mulai', $request->bulan);
        }

        if ($request->filled('tahun')) {
            $query->whereYear('tgl_mulai', $request->tahun);
        }

        $riwayatPegawaiLain = $query->orderBy('updated_at', 'desc')->get();


        // ==========================================
        // B. QUERY RIWAYAT PENGAJUAN DIRI SENDIRI
        // ==========================================
        $riwayatSaya = Pengajuan::with(['user.pegawai.bidang', 'jenisCuti'])
            ->where('user_id', Auth::id()) // Khusus milik diri sendiri
            ->orderBy('created_at', 'desc')
            ->get();


        // Mengambil daftar tahun untuk opsi filter berkas pegawai lain
        $daftarTahun = Pengajuan::selectRaw('YEAR(tgl_mulai) as tahun')
            ->distinct()
            ->orderBy('tahun', 'desc')
            ->pluck('tahun');

        return view('kasumum.riwayat.index', compact('riwayatPegawaiLain', 'riwayatSaya', 'daftarTahun'));
    }

    public function show($id)
    {
        // Izinkan Kasumum melihat detail berkasnya sendiri atau berkas pegawai lain yang sah lolos alur
        $pengajuan = Pengajuan::with(['user.pegawai.bidang', 'jenisCuti'])
            ->where(function ($q) {
                $q->where('user_id', Auth::id()) // Milik sendiri
                  ->orWhere(function($subQ) { // Atau milik pegawai lain yang sah masuk ke areanya
                      $subQ->whereNotNull('tgl_ttd_kasubbag_umum')
                           ->orWhereIn('status', ['Disetujui', 'Selesai', 'disetujui', 'selesai'])
                           ->orWhere(function ($sub) {
                               $sub->whereIn('status', ['Ditolak', 'ditolak'])
                                   ->whereNotNull('tgl_ttd_kabid');
                           });
                  });
            })
            ->findOrFail($id);

        return view('kasumum.riwayat.show', compact('pengajuan'));
    }

    public function cetak($id)
    {
        // Ambil data pengajuan beserta relasi atasan (Kasubbag Umum -> Kabid -> Kadin)
        $pengajuan = Pengajuan::with([
            'user.pegawai.bidang',
            'atasan.pegawai.bidang',
            'atasan.pegawai.atasan.pegawai.bidang'
        ])
        ->where('user_id', Auth::id()) // Keamanan: Pastikan yang mencetak adalah pemilik berkasnya sendiri
        ->findOrFail($id);

        if ($pengajuan->status == 'Selesai' && !is_null($pengajuan->snapshot_sisa_n)) {
            $sisa_n = $pengajuan->snapshot_sisa_n;
            $sisa_n1 = $pengajuan->snapshot_sisa_n1;
            $sisa_n2 = $pengajuan->snapshot_sisa_n2;
        } else {
            $sisa_total = $pengajuan->user->pegawai->sisa_cuti_tahunan ?? 0;
            $sisa_n = min($sisa_total, 12);
            $sisa_n1 = max(min($sisa_total - $sisa_n, 6), 0);
            $sisa_n2 = max($sisa_total - $sisa_n - $sisa_n1, 0);
        }

        // Atasan langsung Kasumum biasanya adalah Kabid atau Sekretaris Dinas (disesuaikan dengan logic input `atasan_id`)
        $kabid = $pengajuan->atasan;

        // Kepala Dinas
        $kadin = User::whereHas('pegawai', function ($query) {
            $query->where('jabatan', 'LIKE', '%Kepala Dinas%');
        })->first();

        return view('kasumum.riwayat.cetak', compact(
            'pengajuan',
            'kabid',
            'kadin',
            'sisa_n',
            'sisa_n1',
            'sisa_n2'
        ));
    }
}