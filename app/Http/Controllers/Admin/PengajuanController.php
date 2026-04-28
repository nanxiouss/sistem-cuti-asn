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
        $pengajuans = Pengajuan::with('user.pegawai', 'jenisCuti')->latest()->get();
        return view('admin.pengajuan.index', compact('pengajuans'));
    }

    public function show($id)
    {
        $pengajuan = Pengajuan::with('user.pegawai', 'atasan.pegawai', 'jenisCuti')->findOrFail($id);
        return view('admin.pengajuan.show', compact('pengajuan'));
    }


    public function teruskanKeKasi(Request $request, $id)
    {
        $pengajuan = Pengajuan::findOrFail($id);

        if ($pengajuan->status == 'Menunggu Verifikasi Admin') {
            $pengajuan->update(['status' => 'Menunggu Kasi']);
            return redirect()->back()->with('success', 'Berkas diverifikasi, diteruskan ke Kasi.');
        }

        return redirect()->back()->withErrors(['error' => 'Status pengajuan tidak valid untuk diteruskan ke Kasi.']);
    }

    public function teruskanKeKabid(Request $request, $id)
    {
        $pengajuan = Pengajuan::findOrFail($id);

        if ($pengajuan->status == 'ACC Kasi') { 
            $pengajuan->update(['status' => 'Menunggu Kabid']);
            return redirect()->back()->with('success', 'Berkas divalidasi ulang, diteruskan ke Kabid.');
        }

        return redirect()->back()->withErrors(['error' => 'Status pengajuan tidak valid untuk diteruskan ke Kabid.']);
    }

    public function teruskanKeSekdin(Request $request, $id)
    {
        $pengajuan = Pengajuan::findOrFail($id);

        if ($pengajuan->status == 'ACC Kabid') {
            $pengajuan->update(['status' => 'Menunggu Sekdin']);
            return redirect()->back()->with('success', 'Berkas divalidasi ulang, diteruskan ke Sekdin.');
        }

        return redirect()->back()->withErrors(['error' => 'Status pengajuan tidak valid untuk diteruskan ke Sekdin.']);
    }

    public function teruskanKeKadin(Request $request, $id)
    {
        $pengajuan = Pengajuan::findOrFail($id);

        if ($pengajuan->status == 'ACC Sekdin') {
            $pengajuan->update(['status' => 'Menunggu Kadin']);
            return redirect()->back()->with('success', 'Berkas divalidasi ulang, diteruskan ke Kadin.');
        }

        return redirect()->back()->withErrors(['error' => 'Status pengajuan tidak valid untuk diteruskan ke Kadin.']);
    }

    public function cetak($id)
    {
        $pengajuan = Pengajuan::with('user.pegawai', 'atasan.pegawai', 'jenisCuti')->findOrFail($id);

        if ($pengajuan->status !== 'Disetujui' && $pengajuan->status !== 'Arsip Admin') {
            return redirect()->back()->withErrors(['error' => 'Hanya pengajuan yang sudah disetujui penuh yang bisa dicetak.']);
        }

        $pdf = Pdf::loadView('admin.pengajuan.cetak', compact('pengajuan'))->setPaper('a4', 'portrait');
        return $pdf->stream('Surat_Cuti_' . $pengajuan->user->nama . '.pdf');
    }
}