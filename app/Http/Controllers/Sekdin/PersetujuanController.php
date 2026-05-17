<?php

namespace App\Http\Controllers\Sekdin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Pengajuan;

class PersetujuanController extends Controller
{
    public function index()
    {
        $pengajuan = Pengajuan::with(['user', 'jenisCuti'])
            ->where('status', 'Menunggu ACC Sekdin')
            ->latest()
            ->get();

        return view('sekdin.persetujuan.index', compact('pengajuan'));
    }

    public function show($id)
    {
        $pengajuan = Pengajuan::with(['user.pegawai', 'jenisCuti'])->findOrFail($id);
        return view('sekdin.persetujuan.show', compact('pengajuan'));
    }

    public function update(Request $request, $id)
    {
        $pengajuan = Pengajuan::findOrFail($id);
        
        $pengajuan->update([
            'status' => $request->input('status'),
            // 'catatan_sekdin' => $request->input('catatan') // Buka jika ada kolom catatan
        ]);

        return redirect()->route('sekdin.persetujuan.index')->with('success', 'Berkas berhasil diproses!');
    }
}