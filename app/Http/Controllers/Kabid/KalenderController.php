<?php

namespace App\Http\Controllers\Kabid;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Pengajuan;
use App\Models\Bidang; 
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class KalenderController extends Controller
{
    public function index()
    {
        // 1. Dapatkan data user (Kabid) yang sedang login beserta relasi pegawainya
        $user = Auth::user();
        
        // Ambil bidang_id induk milik Kabid (menggunakan fallback seperti contoh Anda)
        $kabidBidangId = $user->pegawai->id_bidang ?? $user->pegawai->bidang_id ?? null;

        // PROTEKSI: Jika user tidak memiliki bidang_id, kunci kalender kosong
        if (!$kabidBidangId) {
            $events = [];
            $dailyCounts = [];
            return view('kabid.kalender.index', compact('events', 'dailyCounts'))
                ->with('error', 'Bidang induk Anda tidak ditemukan. Gagal memuat data kalender.');
        }

        // 2. LOGIKA STRUKTUR BERTINGKAT: Ambil ID bidang anak dan gabungkan dengan ID induk
        $childBidangIds = Bidang::where('parent_id', $kabidBidangId)->pluck('id')->toArray();
        $allBidangIds = array_merge([$kabidBidangId], $childBidangIds);

        // 3. AMBIL DATA CUTI PEGAWAI DI LINGKUP BIDANG INDUK & ANAK
        $dataCuti = Pengajuan::with(['user.pegawai.bidang', 'jenisCuti'])
            ->whereIn('status', ['Disetujui', 'Selesai']) 
            ->whereHas('user.pegawai.bidang', function ($query) use ($allBidangIds) {
                $query->whereIn('id', $allBidangIds);
            })
            ->get();

        // 4. HITUNG JUMLAH REKAP PEGAWAI YANG CUTI PER HARI
        $dailyCounts = [];
        foreach ($dataCuti as $cuti) {
            if ($cuti->tgl_mulai && $cuti->tgl_selesai) {
                $start = Carbon::parse($cuti->tgl_mulai);
                $end = Carbon::parse($cuti->tgl_selesai);
                
                for ($date = $start; $date->lte($end); $date->addDay()) {
                    $dateStr = $date->format('Y-m-d');
                    if (!isset($dailyCounts[$dateStr])) {
                        $dailyCounts[$dateStr] = 0;
                    }
                    $dailyCounts[$dateStr]++;
                }
            }
        }

        // 5. TRANSFORMASI DATA UNTUK FORMAT FULLCALENDAR (DENGAN NAMA BIDANG DI SAMPING NAMA)
        $events = $dataCuti->map(function ($cuti) {
            $namaCuti = $cuti->jenisCuti->nama ?? 'Cuti';
            $namaPegawai = $cuti->user->nama ?? 'Pegawai';
            $namaBidang = $cuti->user->pegawai->bidang->nama ?? $cuti->user->pegawai->bidang->nama_bidang ?? 'Induk';

            // Pewarnaan Lencana Kalender Berdasarkan Jenis Cuti
            $warna = '#3B82F6'; // Default: Biru
            if (str_contains(strtolower($namaCuti), 'sakit')) {
                $warna = '#EF4444'; // Merah
            } elseif (str_contains(strtolower($namaCuti), 'melahirkan')) {
                $warna = '#EC4899'; // Pink
            } elseif (str_contains(strtolower($namaCuti), 'besar')) {
                $warna = '#F59E0B'; // Kuning
            } elseif (str_contains(strtolower($namaCuti), 'penting')) {
                $warna = '#10B981'; // Hijau
            }

            return [
                // Mengubah title kalender agar memuat nama bidang di samping nama pegawai
                'title' => $namaPegawai . ' - ' . $namaBidang . ' (' . $namaCuti . ')',
                'start' => $cuti->tgl_mulai,
                'end'   => Carbon::parse($cuti->tgl_selesai)->addDay()->format('Y-m-d'), 
                'color' => $warna,
                'textColor' => '#ffffff',
                'extendedProps' => [
                    'keterangan' => $cuti->alasan ?? 'Tidak ada alasan dicantumkan',
                    'nama_pegawai' => $namaPegawai, // Disimpan terpisah untuk kebutuhan detail popup alert
                    'nama_bidang' => $namaBidang
                ]
            ];
        });

        // 6. Lempar data ke view kalender khusus folder kabid
        return view('kabid.kalender.index', compact('events', 'dailyCounts'));
    }
}