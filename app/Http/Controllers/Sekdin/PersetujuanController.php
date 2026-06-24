<?php

namespace App\Http\Controllers\Sekdin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Pengajuan;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class PersetujuanController extends Controller
{
    public function index()
    {
        // Sekdin memproses berkas masuk yang sudah di-acc Kasubbag Umum
        $pengajuan = Pengajuan::with(['user.pegawai.bidang', 'jenisCuti'])
            ->where('status', 'Menunggu Sekdin')
            ->latest()
            ->get();

        return view('sekdin.persetujuan.index', compact('pengajuan'));
    }

    public function show($id)
    {
        $pengajuan = Pengajuan::with(['user.pegawai.bidang', 'jenisCuti'])->findOrFail($id);

        // Proteksi jika berkas bukan wewenang Sekdin lagi
        if ($pengajuan->status !== 'Menunggu Sekdin') {
            return redirect()->route('sekdin.persetujuan.index')->with('error', 'Berkas ini sudah diproses atau tidak valid.');
        }

        return view('sekdin.persetujuan.show', compact('pengajuan'));
    }

    public function update(Request $request, $id)
    {
        // Validasi input tindakan Sekdin
        $request->validate([
            'status'              => 'required|in:Disetujui,Ditolak', 
            'catatan_sekdin'      => 'required_if:status,Ditolak|nullable|string|max:500',
            'password_verifikasi' => 'required_if:status,Disetujui|nullable|string'
        ], [
            'catatan_sekdin.required_if'      => 'Alasan penolakan (catatan) wajib diisi jika Anda menolak pengajuan ini.',
            'password_verifikasi.required_if' => 'Password verifikasi wajib diisi untuk menyetujui dan menandatangani berkas.'
        ]);

        $pengajuan = Pengajuan::findOrFail($id);
        
        // Proteksi Bypass Eksekusi Update
        if ($pengajuan->status !== 'Menunggu Sekdin') {
            return redirect()->route('sekdin.persetujuan.index')->with('error', 'Berkas sudah diproses di tahapan lain.');
        }

        // JIKA DISETUJUI (Meneruskan ke Kepala Dinas + Sematkan TTD Sekdin)
        if ($request->status === 'Disetujui') {
            
            // 1. Verifikasi Password Akun Sekdin
            if (!Hash::check($request->password_verifikasi, Auth::user()->password)) {
                return redirect()->back()
                    ->withErrors(['password_verifikasi' => 'Password verifikasi yang Anda masukkan tidak valid!'])
                    ->withInput();
            }

            // 2. Proteksi jika Sekdin belum upload spesimen TTD di profilnya
            if (!Auth::user()->pegawai || empty(Auth::user()->pegawai->foto_ttd)) {
                return redirect()->back()
                    ->withErrors(['password_verifikasi' => 'Fitur Diblokir: Anda belum mengunggah file spesimen tanda tangan di profil akun Anda.'])
                    ->withInput();
            }

            // 3. Update Status Alur Berjalan ke Kepala Dinas sesuai Flowchart
            // Catatan: Pastikan string 'Menunggu Kadin' atau 'Menunggu Kadis' sesuai dengan enum/aturan di database Anda.
            $pengajuan->status = 'Menunggu Kadin'; 
            
            // 4. Salin foto TTD Sekdin & Catat Waktu Riil Persetujuan
            $pengajuan->ttd_sekdin     = Auth::user()->pegawai->foto_ttd;
            $pengajuan->tgl_ttd_sekdin = now();
            
            $pesan = 'Berkas pengajuan cuti berhasil disetujui, ditandatangani, dan diteruskan ke Kepala Dinas!';
            
        } else {
            // JIKA DITOLAK
            $pengajuan->status = 'Ditolak'; 
            $pesan = 'Berkas pengajuan cuti telah ditolak dan dikembalikan.';
        }
        
        // Simpan catatan (bisa berisi alasan penolakan jika ditolak, atau null jika disetujui)
        $pengajuan->catatan_sekdin = $request->catatan_sekdin; 
        $pengajuan->save();

        return redirect()->route('sekdin.persetujuan.index')->with('success', $pesan);
    }
}