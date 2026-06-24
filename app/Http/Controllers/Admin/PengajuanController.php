<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Pengajuan;

class PengajuanController extends Controller
{
    public function index()
    {
        // Mengambil semua pengajuan, diurutkan agar yang butuh tindakan Admin berada di paling atas
        $pengajuans = Pengajuan::with(['user.pegawai', 'jenisCuti'])
            ->orderByRaw("CASE WHEN status = 'Menunggu Verifikasi Admin' THEN 1 ELSE 2 END")
            ->latest()
            ->get();
            
        return view('admin.pengajuan.index', compact('pengajuans'));
    }

    public function show($id)
    {
        // Menyertakan relasi atasan untuk pelacakan identitas tracker
        $pengajuan = Pengajuan::with(['user.pegawai.bidang', 'atasan.pegawai', 'jenisCuti'])->findOrFail($id);
        return view('admin.pengajuan.show', compact('pengajuan'));
    }

    public function teruskanKeKasi(Request $request, $id)
    {
        $pengajuan = Pengajuan::findOrFail($id);

        // Hanya bisa meneruskan jika statusnya sedang mandek di Admin Kepegawaian
        if ($pengajuan->status === 'Menunggu Verifikasi Admin') {
            $pengajuan->update([
                'status' => 'Menunggu Kasi'
            ]);
            
            return redirect()->route('admin.pengajuan.index')
                             ->with('success', 'Berkas berhasil diverifikasi dan telah diteruskan ke Kasi.');
        }

        return redirect()->back()
                         ->withErrors(['error' => 'Gagal! Berkas tidak berada dalam tahapan verifikasi Admin.']);
    }
}