<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Pengajuan;
use Barryvdh\DomPDF\Facade\Pdf;

class PengajuanController extends Controller
{
    public function index()
    {
        // Mengambil semua pengajuan, tapi diurutkan: 
        // Yang statusnya 'Menunggu Verifikasi Admin' ditaruh paling atas karena butuh aksi Admin.
        $pengajuans = Pengajuan::with(['user.pegawai', 'jenisCuti'])
            ->orderByRaw("CASE WHEN status = 'Menunggu Verifikasi Admin' THEN 1 ELSE 2 END")
            ->latest()
            ->get();
            
        return view('admin.pengajuan.index', compact('pengajuans'));
    }

    public function show($id)
    {
        $pengajuan = Pengajuan::with(['user.pegawai', 'atasan.pegawai', 'jenisCuti'])->findOrFail($id);
        return view('admin.pengajuan.show', compact('pengajuan'));
    }

    public function teruskanKeKasi(Request $request, $id)
    {
        $pengajuan = Pengajuan::findOrFail($id);

        // Validasi sesuai Flowchart: Admin hanya bisa meneruskan jika statusnya sedang menunggu Admin
        if ($pengajuan->status === 'Menunggu Verifikasi Admin') {
            $pengajuan->update([
                'status' => 'Menunggu Kasi' // Status berubah, lanjut ke Kasi/Kepala UPTD
            ]);
            
            // Redirect ke index agar rapi (tidak stuck di halaman show)
            return redirect()->route('admin.pengajuan.index')
                             ->with('success', 'Berkas diverifikasi dan telah diteruskan ke Kasi.');
        }

        return redirect()->back()
                         ->withErrors(['error' => 'Gagal! Berkas ini belum di-ACC Atasan Langsung atau sudah diproses sebelumnya.']);
    }

    public function cetak($id)
    {
        $pengajuan = Pengajuan::with(['user.pegawai', 'atasan.pegawai', 'jenisCuti'])->findOrFail($id);

        // Mencegah cetak jika belum ACC sepenuhnya
        if (!in_array($pengajuan->status, ['Disetujui', 'Arsip Admin'])) {
            return redirect()->back()->withErrors(['error' => 'Hanya pengajuan yang sudah disetujui penuh oleh Kasi yang bisa dicetak.']);
        }

        $pdf = Pdf::loadView('admin.pengajuan.cetak', compact('pengajuan'))->setPaper('a4', 'portrait');
        return $pdf->stream('Surat_Cuti_' . $pengajuan->user->nama . '.pdf');
    }
}