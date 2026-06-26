<?php

namespace App\Http\Controllers\Kasumum;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Pengajuan;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class PersetujuanController extends Controller
{
    public function index()
    {
        // Kasubbag Umum memproses berkas masuk dari seluruh bidang (global)
        $pengajuan = Pengajuan::with(['user.pegawai.bidang', 'jenisCuti'])
            ->where('status', 'Menunggu Kasubbag Umum')
            ->latest()
            ->get();

        return view('kasumum.persetujuan.index', compact('pengajuan'));
    }

    public function show($id)
    {
        $pengajuan = Pengajuan::with(['user.pegawai.bidang', 'jenisCuti'])->findOrFail($id);

        // Proteksi jika berkas bukan wewenang Kasubbag Umum lagi
        if ($pengajuan->status !== 'Menunggu Kasubbag Umum') {
            return redirect()->route('kasumum.persetujuan.index')->with('error', 'Berkas ini sudah diproses atau tidak valid.');
        }

        return view('kasumum.persetujuan.show', compact('pengajuan'));
    }

    public function update(Request $request, $id)
    {
        // Validasi input tindakan Kasubbag Umum
        $request->validate([
            'status' => 'required|in:Disetujui,Ditolak', 
            'catatan_kasubbag' => 'required_if:status,Ditolak|nullable|string|max:500',
            'password_verifikasi' => 'required_if:status,Disetujui|nullable|string'
        ], [
            'catatan_kasubbag.required_if' => 'Alasan penolakan (catatan) wajib diisi jika Anda menolak pengajuan ini.',
            'password_verifikasi.required_if' => 'Password verifikasi wajib diisi untuk menyetujui dan menandatangani berkas.'
        ]);

        $pengajuan = Pengajuan::findOrFail($id);
        
        // Proteksi Bypass Eksekusi Update
        if ($pengajuan->status !== 'Menunggu Kasubbag Umum') {
            return redirect()->route('kasumum.persetujuan.index')->with('error', 'Berkas sudah diproses di tahapan lain.');
        }

        // JIKA DISETUJUI (Meneruskan ke Sekdin + Sematkan TTD)
        if ($request->status === 'Disetujui') {
            
            // 1. Verifikasi Password Akun Kasubbag Umum
            if (!Hash::check($request->password_verifikasi, Auth::user()->password)) {
                return redirect()->back()
                    ->withErrors(['password_verifikasi' => 'Password verifikasi yang Anda masukkan tidak valid!'])
                    ->withInput();
            }

            // 2. Proteksi jika Kasubbag belum upload spesimen TTD di profilnya
            if (!Auth::user()->pegawai || empty(Auth::user()->pegawai->foto_ttd)) {
                return redirect()->back()
                    ->withErrors(['password_verifikasi' => 'Fitur Diblokir: Anda belum mengunggah file spesimen tanda tangan di profil akun Anda.'])
                    ->withInput();
            }

            // 3. Update Status Alur Berjalan ke Sekdin sesuai Flowchart
            $pengajuan->status = 'Menunggu Sekdin'; 
            
            // 4. Salin foto TTD Kasubbag & Catat Waktu Riil Persetujuan (Cocok dengan kolom 21 & 26 di DB)
            $pengajuan->ttd_kasubbag = Auth::user()->pegawai->foto_ttd;
            $pengajuan->tgl_ttd_kasubbag_umum = now();
            $pengajuan->nama_kasubbag = Auth::user()->nama;
            $pengajuan->nip_kasubbag = Auth::user()->nip;
            $pengajuan->jabatan_kasubbag = Auth::user()->pegawai->bidang->nama_bidang;
            
            $pesan = 'Berkas pengajuan cuti berhasil disetujui, ditandatangani, dan diteruskan ke Sekretaris Dinas (Sekdin)!';
            
        } else {
            // JIKA DITOLAK
            $pengajuan->status = 'Ditolak'; 
            $pesan = 'Berkas pengajuan cuti telah ditolak dan dikembalikan.';
        }
        
        $pengajuan->catatan_kasubbag = $request->catatan_kasubbag; 
        $pengajuan->save();

        return redirect()->route('kasumum.persetujuan.index')->with('success', $pesan);
    }
}