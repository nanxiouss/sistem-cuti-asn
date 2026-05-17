<?php

namespace App\Http\Controllers\Kabid;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Pengajuan;

class PersetujuanController extends Controller
{
    public function index()
    {
        // Ambil data yang nunggu ACC Kabid aja
        $pengajuan = Pengajuan::with(['user', 'jenisCuti'])
            ->where('status', 'Menunggu ACC Kabid')
            ->latest()
            ->get();

        return view('kabid.persetujuan.index', compact('pengajuan'));
    }

    public function show($id)
    {
        $pengajuan = Pengajuan::with(['user.pegawai', 'jenisCuti'])->findOrFail($id);
        return view('kabid.persetujuan.show', compact('pengajuan'));
    }

    public function update(Request $request, $id)
    {
        $pengajuan = Pengajuan::findOrFail($id);
        
        // Status bisa 'Disetujui' (Selesai) atau 'Ditolak'
        $pengajuan->update([
            'status' => $request->input('status'),
            // Kalau di database lu ada kolom khusus misal catatan_kabid, bisa pakai ini:
            // 'catatan_kabid' => $request->input('catatan')
        ]);

        return redirect()->route('kabid.persetujuan.index')->with('success', 'Berkas berhasil diproses!');
    }
}