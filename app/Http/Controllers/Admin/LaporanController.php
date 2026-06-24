<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Pengajuan;

class LaporanController extends Controller
{
    // Fungsi untuk memanggil query dasar beserta filternya
    private function getFilteredData(Request $request)
    {
        $query = Pengajuan::with(['user.pegawai.bidang', 'jenisCuti']);

        // Filter Berdasarkan Status
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

        // Filter Berdasarkan Bulan Pelaksanaan
        if ($request->filled('bulan')) {
            $query->whereMonth('tgl_mulai', $request->bulan);
        }

        // Filter Berdasarkan Tahun Pelaksanaan
        if ($request->filled('tahun')) {
            $query->whereYear('tgl_mulai', $request->tahun);
        }

        return $query->orderBy('created_at', 'desc');
    }

    // TAMPILAN HALAMAN INDEX
    public function index(Request $request)
    {
        $laporan = $this->getFilteredData($request)->get();

        // Mengambil daftar tahun dinamis
        $daftarTahun = Pengajuan::selectRaw('YEAR(tgl_mulai) as tahun')
            ->distinct()
            ->orderBy('tahun', 'desc')
            ->pluck('tahun');

        return view('admin.laporan.index', compact('laporan', 'daftarTahun'));
    }

    // FUNGSI EXPORT KE EXCEL
    public function exportExcel(Request $request)
    {
        $laporan = $this->getFilteredData($request)->get();
        $namaFile = 'Laporan_Cuti_Pegawai_' . date('Ymd_His') . '.xls';

        // Mengembalikan view sebagai file download berformat Excel (.xls)
        return response((string) view('admin.laporan.excel', compact('laporan')))
            ->header('Content-Type', 'application/vnd.ms-excel')
            ->header('Content-Disposition', 'attachment; filename="' . $namaFile . '"');
    }
}