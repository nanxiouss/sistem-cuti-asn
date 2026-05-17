<?php

namespace App\Http\Controllers\Kadin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Pengajuan;

class PersetujuanController extends Controller
{
    public function index()
    {
        $pengajuan = Pengajuan::with(['user', 'jenisCuti'])
            ->where('status', 'Menunggu ACC Kadin')
            ->latest()
            ->get();

        return view('kadin.persetujuan.index', compact('pengajuan'));
    }

    public function show($id)
    {
        $pengajuan = Pengajuan::with(['user.pegawai', 'jenisCuti'])->findOrFail($id);
        return view('kadin.persetujuan.show', compact('pengajuan'));
    }

    public function update(Request $request, $id)
    {
        $pengajuan = Pengajuan::findOrFail($id);
        
        // Finalisasi: Jika Kadin setuju, status ganti jadi 'Disetujui' (Selesai/Final)
        $pengajuan->update([
            'status' => $request->input('status'),
            // 'catatan_kadin' => $request->input('catatan') // Buka jika ada kolomnya
        ]);

        return redirect()->route('kadin.persetujuan.index')->with('success', 'Keputusan berhasil disimpan!');
    }
}