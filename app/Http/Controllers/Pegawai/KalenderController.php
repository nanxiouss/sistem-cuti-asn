<?php

namespace App\Http\Controllers\Pegawai;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Pengajuan;
use Carbon\Carbon;

class KalenderController extends Controller
{
    public function index()
    {
        // Ambil data cuti disetujui
        $dataCuti = Pengajuan::with(['user', 'jenisCuti'])
            ->where('status', 'Disetujui')
            ->get();

        // TRANSFORMASI DATA (Cara yang lebih aman)
        $events = $dataCuti->map(function ($cuti) {
            // 1. Tentukan Nama Cuti (Pakai optional chaining agar tidak error jika null)
            $namaCuti = $cuti->jenisCuti->nama_cuti ?? 'Cuti';

            // 2. Tentukan Warna
            $warna = '#3B82F6'; // Default Biru
            if (str_contains($namaCuti, 'Sakit')) {
                $warna = '#EF4444';
            } elseif (str_contains($namaCuti, 'Melahirkan')) {
                $warna = '#EC4899';
            } elseif (str_contains($namaCuti, 'Besar')) {
                $warna = '#F59E0B';
            }

            // 3. Return Array Event
            return [
                'title' => ($cuti->user->nama ?? 'Pegawai') . ' (' . $namaCuti . ')',
                'start' => $cuti->tgl_mulai,
                'end'   => Carbon::parse($cuti->tgl_selesai)->addDay()->format('Y-m-d'),
                'color' => $warna,
                'textColor' => '#ffffff',
                'extendedProps' => [
                    'keterangan' => $cuti->keterangan ?? '-'
                ]
            ];
        });

        // Pastikan TIDAK ADA koma setelah compact
        return view('Pegawai.kalender.index', compact('events'));
    }
}
