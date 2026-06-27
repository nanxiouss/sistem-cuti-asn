<?php

namespace App\Http\Controllers\Kasi;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Pengajuan;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class KalenderController extends Controller
{
    public function index()
    {
        // 1. Dapatkan data user (Kasi) yang sedang login beserta relasi pegawainya
        $user = Auth::user();
        
        // Ambil bidang_id milik Kasi tersebut
        $bidangId = $user->pegawai->bidang_id ?? null;

        // PROTEKSI: Jika user tidak memiliki bidang_id atau bukan struktur pegawai, kunci kalender kosong
        if (!$bidangId) {
            $events = [];
            $dailyCounts = [];
            return view('kasi.kalender.index', compact('events', 'dailyCounts'))
                ->with('error', 'Bidang kerja Anda tidak ditemukan. Gagal memuat data kalender.');
        }

        // 2. AMBIL DATA CUTI KHUSUS PEGAWAI DI BIDANG YANG SAMA DENGAN KASI
        // Menampilkan cuti yang statusnya sudah 'Disetujui' atau 'Selesai' (Sudah Terbit Form)
        $dataCuti = Pengajuan::with(['user.pegawai', 'jenisCuti'])
            ->whereIn('status', ['Disetujui', 'Selesai']) 
            ->whereHas('user.pegawai', function ($query) use ($bidangId) {
                // Query mengunci: hanya mengambil pegawai yang bidang_id-nya SAMA dengan bidang_id si Kasi
                $query->where('bidang_id', $bidangId);
            })
            ->get();

        // 3. HITUNG JUMLAH REKAP PEGAWAI YANG CUTI PER HARI
        $dailyCounts = [];
        foreach ($dataCuti as $cuti) {
            if ($cuti->tgl_mulai && $cuti->tgl_selesai) {
                $start = Carbon::parse($cuti->tgl_mulai);
                $end = Carbon::parse($cuti->tgl_selesai);
                
                // Melakukan perulangan dari tanggal mulai sampai tanggal selesai cuti
                for ($date = $start; $date->lte($end); $date->addDay()) {
                    $dateStr = $date->format('Y-m-d');
                    if (!isset($dailyCounts[$dateStr])) {
                        $dailyCounts[$dateStr] = 0;
                    }
                    $dailyCounts[$dateStr]++;
                }
            }
        }

        // 4. TRANSFORMASI DATA UNTUK FORMAT FULLCALENDAR (MODE AGENDA)
        $events = $dataCuti->map(function ($cuti) {
            $namaCuti = $cuti->jenisCuti->nama ?? 'Cuti';

            // Pewarnaan Lencana Kalender Berdasarkan Jenis Cuti agar Kasi mudah memantau
            $warna = '#3B82F6'; // Default: Biru (Cuti Tahunan)
            if (str_contains(strtolower($namaCuti), 'sakit')) {
                $warna = '#EF4444'; // Merah
            } elseif (str_contains(strtolower($namaCuti), 'melahirkan')) {
                $warna = '#EC4899'; // Pink
            } elseif (str_contains(strtolower($namaCuti), 'besar')) {
                $warna = '#F59E0B'; // Kuning/Amber
            } elseif (str_contains(strtolower($namaCuti), 'penting')) {
                $warna = '#10B981'; // Hijau (Alasan Penting)
            }

            return [
                'title' => ($cuti->user->nama ?? 'Pegawai') . ' (' . $namaCuti . ')',
                'start' => $cuti->tgl_mulai,
                // Ditambahkan 1 hari karena batas akhir FullCalendar bersifat eksklusif (Exclusive End Date)
                'end'   => Carbon::parse($cuti->tgl_selesai)->addDay()->format('Y-m-d'), 
                'color' => $warna,
                'textColor' => '#ffffff',
                'extendedProps' => [
                    'keterangan' => $cuti->alasan ?? 'Tidak ada alasan dicantumkan'
                ]
            ];
        });

        // 5. Lempar data ke view kalender
        return view('kasi.kalender.index', compact('events', 'dailyCounts'));
    }
}