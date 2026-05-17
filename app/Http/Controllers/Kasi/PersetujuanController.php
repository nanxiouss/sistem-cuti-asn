<?php

namespace App\Http\Controllers\Kasi;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Pengajuan;
use Illuminate\Support\Facades\Auth;

class PersetujuanController extends Controller
{
    // 1. Menampilkan Halaman Semua Daftar Persetujuan (Menu Persetujuan)
    public function index()
    {
        $user = Auth::user();
        $unitKerjaKasi = $user->pegawai->unit_kerja ?? null;

        $pengajuan = Pengajuan::with(['user.pegawai', 'jenisCuti'])
            ->where('status', 'Menunggu ACC Kasi')
            ->when($unitKerjaKasi, function ($query) use ($unitKerjaKasi) {
                $query->whereHas('user.pegawai', function ($q) use ($unitKerjaKasi) {
                    $q->where('unit_kerja', $unitKerjaKasi);
                });
            })
            ->latest()
            ->get();

        return view('kasi.persetujuan.index', compact('pengajuan'));
    }

    // 2. Menampilkan Halaman Detail Spesifik 1 Pengajuan
    public function show($id)
    {
        $pengajuan = Pengajuan::with(['user.pegawai', 'jenisCuti'])->findOrFail($id);

        // Keamanan: Pastikan Kasi cuma bisa buka yang statusnya beneran nunggu dia
        if ($pengajuan->status !== 'Menunggu ACC Kasi') {
            return redirect()->route('kasi.dashboard')->with('error', 'Berkas ini sudah diproses atau tidak valid.');
        }

        return view('kasi.persetujuan.show', compact('pengajuan'));
    }

    // 3. Memproses Aksi Disetujui (ACC) atau Ditolak
    public function update(Request $request, $id)
    {
        // Validasi input dari form
        $request->validate([
            'status' => 'required|in:Disetujui,Ditolak',
            'catatan' => 'nullable|string'
        ]);

        $pengajuan = Pengajuan::findOrFail($id);
        
        // Update data
        $pengajuan->status = $request->status;
        
        // Kalau di database lu ada field buat nyimpen alasan penolakan dari Kasi,
        // misalnya field 'catatan_kasi', aktifin kode di bawah ini:
        // $pengajuan->catatan_kasi = $request->catatan; 
        
        $pengajuan->save();

        // Tentukan pesan sukses berdasarkan aksi
        $pesan = $request->status === 'Disetujui' 
            ? 'Berkas pengajuan cuti berhasil disetujui!' 
            : 'Berkas pengajuan cuti telah ditolak.';

        return redirect()->route('kasi.dashboard')->with('success', $pesan);
    }
}