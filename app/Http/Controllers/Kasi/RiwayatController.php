<?php

namespace App\Http\Controllers\Kasi;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Pengajuan;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class RiwayatController extends Controller
{
    public function index(Request $request)
    {
        $user = Auth::user();

        // ==========================================
        // A. QUERY RIWAYAT PEGAWAI LAIN (STAF KASI)
        // ==========================================
        $query = Pengajuan::with(['user.pegawai', 'jenisCuti'])
            ->where('id_atasan', $user->id)
            ->where('user_id', '!=', $user->id) // Jangan masukkan pengajuan Kasi sendiri di tabel atas
            ->where(function ($q) {
                $q->whereNotNull('tgl_ttd_kasi')
                  ->orWhere('status', 'Ditolak'); // Mengizinkan berkas ditolak muncul di riwayat
            });

        // Filter Berdasarkan Status Fleksibel
        if ($request->filled('status')) {
            if ($request->status == 'Diproses') {
                // Berkas sudah disetujui Kasi, tapi masih mengantre di tingkat atas
                $query->whereNotIn('status', ['Disetujui', 'Ditolak', 'Selesai']);
            } else {
                $query->where('status', $request->status);
            }
        }

        // Filter Berdasarkan Bulan
        if ($request->filled('bulan')) {
            $query->whereMonth('tgl_mulai', $request->bulan);
        }

        // Filter Berdasarkan Tahun
        if ($request->filled('tahun')) {
            $query->whereYear('tgl_mulai', $request->tahun);
        }

        $riwayatPegawaiLain = $query->orderBy('updated_at', 'desc')->get();


        // ==========================================
        // B. QUERY RIWAYAT PENGAJUAN DIRI SENDIRI (PRIBADI KASI)
        // ==========================================
        $riwayatSaya = Pengajuan::with(['jenisCuti'])
            ->where('user_id', $user->id) // Khusus milik diri sendiri
            ->orderBy('created_at', 'desc')
            ->get();


        // Mengambil daftar tahun dari database untuk opsi filter
        $daftarTahun = Pengajuan::selectRaw('YEAR(tgl_mulai) as tahun')
            ->distinct()
            ->orderBy('tahun', 'desc')
            ->pluck('tahun');

        return view('kasi.riwayat.index', compact('riwayatPegawaiLain', 'riwayatSaya', 'daftarTahun'));
    }

    public function show($id)
    {
        $user = Auth::user();

        // Proteksi agar Kasi bisa melihat detail berkasnya sendiri ATAU berkas stafnya
        $pengajuan = Pengajuan::with(['user.pegawai', 'jenisCuti'])
            ->where(function ($q) use ($user) {
                $q->where('user_id', $user->id) // Milik sendiri
                  ->orWhere(function ($subQ) use ($user) { // Atau milik staf
                      $subQ->where('id_atasan', $user->id)
                           ->where(function ($sub) {
                               $sub->whereNotNull('tgl_ttd_kasi')
                                   ->orWhere('status', 'Ditolak');
                           });
                  });
            })
            ->findOrFail($id);

        return view('kasi.riwayat.show', compact('pengajuan'));
    }

    public function cetak($id)
    {
        // 1. Ambil data pengajuan beserta relasi (Kasi -> Kabid -> Kadin)
        $pengajuan = Pengajuan::with([
            'user.pegawai.bidang',
            'atasan.pegawai.bidang',
            'atasan.pegawai.atasan.pegawai.bidang'
        ])
        ->where('user_id', Auth::id()) // Proteksi: pastikan yang dicetak adalah pengajuannya sendiri
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

        // Atasan langsung Kasi adalah Kabid
        $kabid = $pengajuan->atasan;

        // Kepala Dinas
        $kadin = User::whereHas('pegawai', function ($query) {
            $query->where('jabatan', 'LIKE', '%Kepala Dinas%');
        })->first();

        return view('kasi.riwayat.cetak', compact(
            'pengajuan',
            'kabid',
            'kadin',
            'sisa_n',
            'sisa_n1',
            'sisa_n2'
        ));
    }
}