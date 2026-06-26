<?php

namespace App\Http\Controllers\Kasi;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Pengajuan;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class PersetujuanController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $bidangIdKasi = $user->pegawai->bidang_id ?? null;

        $pengajuan = Pengajuan::with(['user.pegawai.bidang', 'jenisCuti'])
            ->where('status', 'Menunggu Kasi')
            ->when($bidangIdKasi, function ($query) use ($bidangIdKasi) {
                $query->whereHas('user.pegawai', function ($q) use ($bidangIdKasi) {
                    $q->where('bidang_id', $bidangIdKasi);
                });
            })
            ->latest()
            ->get();

        return view('kasi.persetujuan.index', compact('pengajuan'));
    }

    public function show($id)
    {
        $pengajuan = Pengajuan::with(['user.pegawai.bidang', 'jenisCuti'])->findOrFail($id);

        if ($pengajuan->status !== 'Menunggu Kasi') {
            return redirect()->route('kasi.persetujuan.index')->with('error', 'Berkas ini sudah diproses atau tidak valid.');
        }

        return view('kasi.persetujuan.show', compact('pengajuan'));
    }

    public function update(Request $request, $id)
    {
        // Validasi input mengikuti format penamaan di role pegawai
        $request->validate([
            'status' => 'required|in:Disetujui,Ditolak', 
            'catatan' => 'required_if:status,Ditolak|nullable|string|max:500',
            'password_verifikasi' => 'required_if:status,Disetujui|nullable|string'
        ], [
            'catatan.required_if' => 'Alasan penolakan (catatan) wajib diisi jika Anda menolak pengajuan ini.',
            'password_verifikasi.required_if' => 'Password verifikasi wajib diisi untuk menyetujui dan menandatangani berkas.'
        ]);

        $pengajuan = Pengajuan::findOrFail($id);
        
        if ($pengajuan->status !== 'Menunggu Kasi') {
            return redirect()->route('kasi.persetujuan.index')->with('error', 'Berkas sudah diproses di tahapan lain.');
        }

        // JIKA DISETUJUI (Proses TTD Digital Gambar/QR)
        if ($request->status === 'Disetujui') {
            
            // 1. Verifikasi Password Akun Kasi
            if (!Hash::check($request->password_verifikasi, Auth::user()->password)) {
                return redirect()->back()
                    ->withErrors(['password_verifikasi' => 'Password verifikasi yang Anda masukkan tidak valid!'])
                    ->withInput();
            }

            // 2. Proteksi jika Kasi belum upload spesimen TTD di profilnya
            if (!Auth::user()->pegawai || empty(Auth::user()->pegawai->foto_ttd)) {
                return redirect()->back()
                    ->withErrors(['password_verifikasi' => 'Fitur Diblokir: Anda belum mengunggah file spesimen tanda tangan di profil akun Anda.'])
                    ->withInput();
            }

            // 3. Update Status Alur Berjalan ke Kabid & Catat ID Kasi
            $pengajuan->status = 'Menunggu Kabid'; 
            $pengajuan->id_atasan = Auth::user()->id;
            
            // 4. Salin foto TTD/QR Kasi & Catat Waktu Riil Persetujuan
            $pengajuan->ttd_kasi = Auth::user()->pegawai->foto_ttd;
            $pengajuan->tgl_ttd_kasi = now();
            $pengajuan->nama_kasi = Auth::user()->nama;
            $pengajuan->nip_kasi = Auth::user()->nip;
            $pengajuan->jabatan_kasi = Auth::user()->pegawai->bidang->nama_bidang;
            
            $pesan = 'Berkas pengajuan cuti berhasil disetujui, ditandatangani, dan diteruskan ke Kabid!';
            
        } else {
            // JIKA DITOLAK
            $pengajuan->status = 'Ditolak'; 
            $pengajuan->id_atasan = Auth::user()->id; 
            $pesan = 'Berkas pengajuan cuti telah ditolak.';
        }
        
        $pengajuan->catatan_kasi = $request->catatan; 
        $pengajuan->save();

        return redirect()->route('kasi.persetujuan.index')->with('success', $pesan);
    }
}