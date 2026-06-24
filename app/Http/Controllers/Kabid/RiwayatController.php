<?php

namespace App\Http\Controllers\Kabid;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Pengajuan;
use App\Models\Bidang;
use Illuminate\Support\Facades\Auth;

class RiwayatController extends Controller
{
    public function index(Request $request)
    {
        $user = Auth::user();

        // 1. Ambil ID Bidang tempat Kabid ini bernaung
        $kabidBidangId = $user->pegawai->id_bidang ?? $user->pegawai->bidang_id ?? null;

        // 2. Ambil semua ID Seksi (anak) di bawah Bidang ini
        $childBidangIds = Bidang::where('parent_id', $kabidBidangId)->pluck('id')->toArray();

        // 3. Gabungkan ID Induk dan ID Anak
        $allBidangIds = array_merge([$kabidBidangId], $childBidangIds);

        // 4. Query Pengajuan: Ambil yang berada di bidang tersebut & sudah di-ttd ATAU sudah ditolak
        $query = Pengajuan::with(['user.pegawai.bidang', 'jenisCuti'])
            ->whereHas('user.pegawai.bidang', function ($q) use ($allBidangIds) {
                $q->whereIn('id', $allBidangIds);
            })
            ->where(function ($q) {
                $q->whereNotNull('tgl_ttd_kabid')
                  ->orWhere('status', 'Ditolak'); // Mengizinkan status Ditolak muncul di riwayat
            });

        // 5. Filter Berdasarkan Status Fleksibel
        if ($request->filled('status')) {
            if ($request->status == 'Diproses') {
                $query->whereNotIn('status', ['Disetujui', 'Ditolak']);
            } else {
                $query->where('status', $request->status);
            }
        }

        // 6. Filter Berdasarkan Bulan & Tahun
        if ($request->filled('bulan')) {
            $query->whereMonth('tgl_mulai', $request->bulan);
        }
        if ($request->filled('tahun')) {
            $query->whereYear('tgl_mulai', $request->tahun);
        }

        // Urutkan berdasarkan update terakhir agar pengajuan ditolak/disetujui terbaru muncul paling atas
        $riwayatPengajuan = $query->orderBy('updated_at', 'desc')->get();

        // Mengambil daftar tahun dari database untuk opsi filter
        $daftarTahun = Pengajuan::selectRaw('YEAR(tgl_mulai) as tahun')
            ->distinct()
            ->orderBy('tahun', 'desc')
            ->pluck('tahun');

        return view('kabid.riwayat.index', compact('riwayatPengajuan', 'daftarTahun'));
    }

    public function show($id)
    {
        $user = Auth::user();
        
        $kabidBidangId = $user->pegawai->id_bidang ?? $user->pegawai->bidang_id ?? null;
        $childBidangIds = Bidang::where('parent_id', $kabidBidangId)->pluck('id')->toArray();
        $allBidangIds = array_merge([$kabidBidangId], $childBidangIds);

        // Proteksi berkas disesuaikan dengan rule index (agar tidak 404 saat membuka data ditolak)
        $pengajuan = Pengajuan::with(['user.pegawai.bidang.parent', 'jenisCuti'])
            ->whereHas('user.pegawai.bidang', function ($q) use ($allBidangIds) {
                $q->whereIn('id', $allBidangIds);
            })
            ->where(function ($q) {
                $q->whereNotNull('tgl_ttd_kabid')
                  ->orWhere('status', 'Ditolak');
            })
            ->findOrFail($id);

        return view('kabid.riwayat.show', compact('pengajuan'));
    }
}