<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Pengajuan;
use Illuminate\Support\Facades\DB;

class PemberkasanController extends Controller
{
    public function index()
    {
        // Menampilkan pengajuan yang siap diproses (Menunggu Pemberkasan) dan yang sudah difinalisasi (Selesai)
        $pemberkasans = Pengajuan::with(['user.pegawai', 'jenisCuti'])
            ->whereIn('status', ['Menunggu Pemberkasan', 'Selesai'])
            ->latest()
            ->get();

        return view('admin.pemberkasan.index', compact('pemberkasans'));
    }

    public function show($id)
    {
        // Izinkan melihat detail data baik yang masih menunggu maupun yang sudah selesai diproses
        $pengajuan = Pengajuan::with(['user.pegawai', 'atasan.pegawai', 'jenisCuti'])
            ->whereIn('status', ['Menunggu Pemberkasan', 'Selesai'])
            ->findOrFail($id);

        return view('admin.pemberkasan.show', compact('pengajuan'));
    }

    public function prosesPemberkasan(Request $request, $id)
    {
        // Validasi nomor_sk dihapus karena alur baru langsung klik Simpan & Rilis

        $pengajuan = Pengajuan::with(['user.pegawai', 'jenisCuti'])->findOrFail($id);

        // Mencegah proses ulang jika statusnya sudah telanjur 'Selesai'
        if ($pengajuan->status === 'Selesai') {
            return redirect()->back()->with('error', 'Dokumen ini sudah dirilis sebelumnya.');
        }

        // Gunakan Database Transaction agar proses update status dan pemotongan kuota aman
        DB::transaction(function () use ($pengajuan) {
            
            // 1. Update status pengajuan langsung menjadi Selesai tanpa menginput nomor_sk
            $pengajuan->update([
                'status' => 'Selesai' 
            ]);

            // 2. LOGIKA PEMOTONGAN KUOTA CUTI:
            // Memotong kuota hanya jika jenis cuti yang diambil adalah Cuti Tahunan
            // Serta pastikan relasi model ke tabel pegawai tersedia
            if ($pengajuan->user && $pengajuan->user->pegawai) {
                $jenisCutiNama = strtolower($pengajuan->jenisCuti->nama ?? $pengajuan->jenisCuti->nama_cuti ?? '');
                
                if (str_contains($jenisCutiNama, 'tahunan') || $pengajuan->jenis_cuti_id == 1) {
                    $pegawai = $pengajuan->user->pegawai;
                    
                    // Kurangi sisa kuota cuti tahunan milik pegawai berdasarkan durasi hari lama_cuti
                    // Catatan: Sesuaikan kembali ke 'sisa_cuti_tahunan' atau 'sisa_cuti_tahun_ini' mengikuti kolom tabel Anda
                    $pegawai->decrement('sisa_cuti_tahunan', $pengajuan->lama_cuti); 
                }
            }
        });

        // Mengarahkan kembali ke halaman detail berkas (show) agar admin bisa langsung menekan tombol cetak
        return redirect()->route('admin.pemberkasan.show', $id)
            ->with('success', 'Dokumen berhasil disimpan & dirilis ke pegawai. Berkas formulir cuti sekarang siap dicetak.');
    }
}