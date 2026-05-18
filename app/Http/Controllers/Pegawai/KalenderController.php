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

        // TRANSFORMASI DATA 
        $events = $dataCuti->map(function ($cuti) {
            $namaCuti = $cuti->jenisCuti->nama_cuti ?? 'Cuti';

            $warna = '#3B82F6'; 
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

        return view('Pegawai.kalender.index', compact('events'));
    }
}
