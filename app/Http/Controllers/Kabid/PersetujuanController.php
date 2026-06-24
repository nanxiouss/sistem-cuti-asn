<?php

namespace App\Http\Controllers\Kabid;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Pengajuan;
use App\Models\Bidang; // Panggil Model Bidang untuk pencarian parent_id
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class PersetujuanController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $bidangIdKabid = $user->pegawai->bidang_id ?? null;

        // --- PERBAIKAN LOGIKA: Ambil ID Bidang Induk & Seluruh Seksi di bawahnya ---
        $daftarBidangBawahan = [];
        if ($bidangIdKabid) {
            $daftarBidangBawahan = Bidang::where('id', $bidangIdKabid)
                ->orWhere('parent_id', $bidangIdKabid)
                ->pluck('id')
                ->toArray(); // Menghasilkan array ID kelompok bidang, misal: [5, 6, 7, 8]
        }

        $pengajuan = Pengajuan::with(['user.pegawai.bidang', 'jenisCuti'])
            ->where('status', 'Menunggu Kabid')
            ->when(!empty($daftarBidangBawahan), function ($query) use ($daftarBidangBawahan) {
                $query->whereHas('user.pegawai', function ($q) use ($daftarBidangBawahan) {
                    // Menggunakan whereIn agar mencakup semua staff dari sub-seksi pecahan
                    $q->whereIn('bidang_id', $daftarBidangBawahan);
                });
            })
            ->latest()
            ->get();

        return view('kabid.persetujuan.index', compact('pengajuan'));
    }

    public function show($id)
    {
        $pengajuan = Pengajuan::with(['user.pegawai.bidang', 'jenisCuti'])->findOrFail($id);

        // Proteksi jika berkas bukan wewenang Kabid lagi
        if ($pengajuan->status !== 'Menunggu Kabid') {
            return redirect()->route('kabid.persetujuan.index')->with('error', 'Berkas ini sudah diproses atau tidak valid.');
        }

        return view('kabid.persetujuan.show', compact('pengajuan'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:Disetujui,Ditolak', 
            'catatan_kabid' => 'required_if:status,Ditolak|nullable|string|max:500',
            'password_verifikasi' => 'required_if:status,Disetujui|nullable|string'
        ], [
            'catatan_kabid.required_if' => 'Alasan penolakan (catatan) wajib diisi jika Anda menolak pengajuan ini.',
            'password_verifikasi.required_if' => 'Password verifikasi wajib diisi untuk menyetujui dan menandatangani berkas.'
        ]);

        $pengajuan = Pengajuan::findOrFail($id);
        
        // Proteksi Bypass Eksekusi Update
        if ($pengajuan->status !== 'Menunggu Kabid') {
            return redirect()->route('kabid.persetujuan.index')->with('error', 'Berkas sudah diproses di tahapan lain.');
        }

        // JIKA DISETUJUI (Proses TTD Digital Gambar)
        if ($request->status === 'Disetujui') {
            
            // 1. Verifikasi Password Akun Kabid
            if (!Hash::check($request->password_verifikasi, Auth::user()->password)) {
                return redirect()->back()
                    ->withErrors(['password_verifikasi' => 'Password verifikasi yang Anda masukkan tidak valid!'])
                    ->withInput();
            }

            // 2. Proteksi jika Kabid belum upload spesimen TTD di profilnya
            if (!Auth::user()->pegawai || empty(Auth::user()->pegawai->foto_ttd)) {
                return redirect()->back()
                    ->withErrors(['password_verifikasi' => 'Fitur Diblokir: Anda belum mengunggah file spesimen tanda tangan di profil akun Anda.'])
                    ->withInput();
            }

            // 3. Update Status Alur Berjalan ke Kasubbag Umum
            $pengajuan->status = 'Menunggu Kasubbag Umum'; 
            
            // 4. Salin foto TTD Kabid & Catat Waktu Riil Persetujuan
            $pengajuan->ttd_kabid = Auth::user()->pegawai->foto_ttd;
            $pengajuan->tgl_ttd_kabid = now();
            
            $pesan = 'Berkas pengajuan cuti berhasil disetujui, ditandatangani, dan diteruskan ke Kasubbag Umum!';
            
        } else {
            // JIKA DITOLAK
            $pengajuan->status = 'Ditolak'; 
            $pesan = 'Berkas pengajuan cuti telah ditolak.';
        }
        
        $pengajuan->catatan_kabid = $request->catatan_kabid; 
        $pengajuan->save();

        return redirect()->route('kabid.persetujuan.index')->with('success', $pesan);
    }
}