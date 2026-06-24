<?php

namespace App\Http\Controllers\Kadin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Pengajuan;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class PersetujuanController extends Controller
{
    public function index()
    {
        // Kadin memproses berkas masuk yang sudah di-acc Sekdin
        $pengajuan = Pengajuan::with(['user.pegawai.bidang', 'jenisCuti'])
            ->where('status', 'Menunggu Kadin') 
            ->latest()
            ->get();

        return view('kadin.persetujuan.index', compact('pengajuan'));
    }

    public function show($id)
    {
        $pengajuan = Pengajuan::with(['user.pegawai.bidang', 'jenisCuti'])->findOrFail($id);

        // Proteksi jika berkas bukan wewenang Kadin lagi
        if ($pengajuan->status !== 'Menunggu Kadin') {
            return redirect()->route('kadin.persetujuan.index')->with('error', 'Berkas ini sudah diproses atau tidak valid.');
        }

        return view('kadin.persetujuan.show', compact('pengajuan'));
    }

    public function update(Request $request, $id)
    {
        // Validasi input tindakan Kadin (Catatan Kadin dihapus)
        $request->validate([
            'status'              => 'required|in:Disetujui,Ditolak', 
            'password_verifikasi' => 'required_if:status,Disetujui|nullable|string'
        ], [
            'password_verifikasi.required_if' => 'Password verifikasi wajib diisi untuk menyetujui dan menandatangani berkas.'
        ]);

        $pengajuan = Pengajuan::findOrFail($id);
        
        // Proteksi Bypass Eksekusi Update
        if ($pengajuan->status !== 'Menunggu Kadin') {
            return redirect()->route('kadin.persetujuan.index')->with('error', 'Berkas sudah diproses di tahapan lain.');
        }

        // JIKA DISETUJUI (Meneruskan ke Admin untuk Pemberkasan + Sematkan TTD Kadin)
        if ($request->status === 'Disetujui') {
            
            // 1. Verifikasi Password Akun Kadin
            if (!Hash::check($request->password_verifikasi, Auth::user()->password)) {
                return redirect()->back()
                    ->withErrors(['password_verifikasi' => 'Password verifikasi yang Anda masukkan tidak valid!'])
                    ->withInput();
            }

            // 2. Proteksi jika Kadin belum upload spesimen TTD di profilnya
            if (!Auth::user()->pegawai || empty(Auth::user()->pegawai->foto_ttd)) {
                return redirect()->back()
                    ->withErrors(['password_verifikasi' => 'Fitur Diblokir: Anda belum mengunggah file spesimen tanda tangan di profil akun Anda.'])
                    ->withInput();
            }

            // 3. Update Status Alur Berjalan ke Admin untuk Pemberkasan Nomor SK
            $pengajuan->status = 'Menunggu Pemberkasan'; 
            
            // 4. Salin foto TTD Kadin & Catat Waktu Riil Persetujuan
            $pengajuan->ttd_kadin     = Auth::user()->pegawai->foto_ttd;
            $pengajuan->tgl_ttd_kadin = now();
            
            $pesan = 'Berkas pengajuan cuti berhasil disetujui, ditandatangani, dan diteruskan ke Admin untuk penomoran berkas!';
            
        } else {
            // JIKA DITOLAK
            $pengajuan->status = 'Ditolak'; 
            $pesan = 'Berkas pengajuan cuti telah ditolak dan dikembalikan.';
        }
        
        // Proses simpan data (Tanpa menyimpan catatan_kadin)
        $pengajuan->save();

        return redirect()->route('kadin.persetujuan.index')->with('success', $pesan);
    }
}