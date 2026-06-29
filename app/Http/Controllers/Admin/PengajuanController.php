<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Pengajuan;

class PengajuanController extends Controller
{
    public function index()
    {
        // Mengambil semua pengajuan, diurutkan agar yang butuh tindakan Admin berada di paling atas
        $pengajuans = Pengajuan::with(['user.pegawai', 'jenisCuti'])
            ->orderByRaw("CASE WHEN status = 'Menunggu Verifikasi Admin' THEN 1 ELSE 2 END")
            ->latest()
            ->get();
            
        return view('admin.pengajuan.index', compact('pengajuans'));
    }

    public function show($id)
    {
        // Menyertakan relasi atasan untuk pelacakan identitas tracker
        $pengajuan = Pengajuan::with(['user.pegawai.bidang', 'atasan.pegawai', 'jenisCuti'])->findOrFail($id);
        return view('admin.pengajuan.show', compact('pengajuan'));
    }

    public function teruskanKeKasi(Request $request, $id)
    {
        // Eager load relasi 'atasan' untuk membaca role-nya secara langsung
        $pengajuan = Pengajuan::with('atasan')->findOrFail($id);

        // Hanya bisa meneruskan jika statusnya sedang mandek di Admin Kepegawaian
        if ($pengajuan->status === 'Menunggu Verifikasi Admin') {
            
            $atasan = $pengajuan->atasan; // Menuju ke objek User si atasan
            
            if (!$atasan) {
                return redirect()->back()->withErrors(['error' => 'Gagal: Data Pejabat Penilai (Atasan) tidak ditemukan untuk berkas ini.']);
            }

            // Menentukan status alur berikutnya secara dinamis berdasarkan ROLE dari Atasan yang dituju
            switch ($atasan->role) {
                case 'kasi':
                    $statusBaru = 'Menunggu Kasi';
                    $pesanSukses = 'Berkas pegawai berhasil diverifikasi dan diteruskan ke Kepala Seksi (Kasi).';
                    break;
                    
                case 'kabid':
                    $statusBaru = 'Menunggu Kabid';
                    $pesanSukses = 'Berkas berhasil diverifikasi dan diteruskan ke Kepala Bidang (Kabid).';
                    break;
                    
                case 'sekdin':
                    $statusBaru = 'Menunggu Sekdin';
                    $pesanSukses = 'Berkas berhasil diverifikasi dan diteruskan ke Sekretaris Dinas (Sekdin).';
                    break;
                    
                case 'kadin':
                    $statusBaru = 'Menunggu Kadin';
                    $pesanSukses = 'Berkas berhasil diverifikasi dan diteruskan langsung ke Kepala Dinas (Kadin).';
                    break;
                    
                default:
                    // Fallback aman jika role tidak spesifik
                    $statusBaru = 'Menunggu Kasi';
                    $pesanSukses = 'Berkas berhasil diverifikasi dan diteruskan ke tahapan selanjutnya.';
                    break;
            }

            // Update status pengajuan berdasarkan hasil map role di atas
            $pengajuan->update([
                'status' => $statusBaru
            ]);
            
            return redirect()->route('admin.pengajuan.index')
                             ->with('success', $pesanSukses);
        }

        return redirect()->back()
                         ->withErrors(['error' => 'Gagal! Berkas tidak berada dalam tahapan verifikasi Admin.']);
    }
}