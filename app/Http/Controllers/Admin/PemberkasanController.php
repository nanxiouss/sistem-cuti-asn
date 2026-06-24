<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Pengajuan;
use App\Models\User;
use Illuminate\Support\Facades\DB; 
class PemberkasanController extends Controller
{
    public function index()
    {
        $pemberkasans = Pengajuan::with(['user.pegawai', 'jenisCuti'])
            ->whereIn('status', ['Menunggu Pemberkasan', 'Selesai'])
            ->latest()
            ->get();

        return view('admin.pemberkasan.index', compact('pemberkasans'));
    }

    public function show($id)
    {
        // 1. Ambil data pengajuan beserta relasi berantai ke atas
        $pengajuan = Pengajuan::with([
            'user.pegawai.bidang',
            'atasan.pegawai.bidang',
            'atasan.pegawai.atasan.pegawai.bidang' // Mengambil Kabid lewat atasannya Kasi
        ])->findOrFail($id);

        // 2. Definisikan Kasi (Atasan langsung pemohon)
        $kasi = $pengajuan->atasan;

        // 3. Ambil Kabid secara dinamis (Atasannya si Kasi)
        $kabid = ($kasi && $kasi->pegawai) ? $kasi->pegawai->atasan : null;

        // 4. Ambil Kepala Dinas berdasarkan nama jabatan
        $kadin = User::whereHas('pegawai', function ($query) {
            $query->where('jabatan', 'LIKE', '%Kepala Dinas%');
        })->first();

        // 5. Lempar semua variabel ke view bkn / cetak
        return view('admin.pemberkasan.show', compact('pengajuan', 'kasi', 'kabid', 'kadin'));
    }

    public function prosesPemberkasan(Request $request, $id)
    {
        $pengajuan = Pengajuan::with(['user.pegawai', 'jenisCuti'])->findOrFail($id);

        if ($pengajuan->status === 'Selesai') {
            return redirect()->back()->with('error', 'Dokumen ini sudah dirilis sebelumnya.');
        }

        DB::transaction(function () use ($pengajuan) {
            
            $pengajuan->update([
                'status' => 'Selesai' 
            ]);

            // LOGIKA PEMOTONGAN KUOTA CUTI SECARA DINAMIS
            if ($pengajuan->user && $pengajuan->user->pegawai) {
                $pegawai = $pengajuan->user->pegawai;
                $jenisCutiNama = strtolower($pengajuan->jenisCuti->nama ?? $pengajuan->jenisCuti->nama_cuti ?? '');
                
                // 1. Cuti Tahunan (ID = 1)
                if (str_contains($jenisCutiNama, 'tahunan') || $pengajuan->jenis_cuti_id == 1) {
                    $pegawai->decrement('sisa_cuti_tahunan', $pengajuan->lama_cuti); 
                } 
                // 2. Cuti Besar (ID = 2)
                elseif (str_contains($jenisCutiNama, 'besar') || $pengajuan->jenis_cuti_id == 2) {
                    $pegawai->decrement('sisa_cuti_besar', $pengajuan->lama_cuti);
                } 
                // 3. Cuti Melahirkan (ID = 4)
                elseif (str_contains($jenisCutiNama, 'melahirkan') || $pengajuan->jenis_cuti_id == 4) {
                    $pegawai->decrement('sisa_cuti_melahirkan', $pengajuan->lama_cuti);
                }
                
                // Catatan: Cuti Sakit, Cuti Alasan Penting, dll biasanya tidak mengurangi kuota tahunan/tetap (tidak perlu dikurangi)
            }
        });

        return redirect()->route('admin.pemberkasan.show', $id)
            ->with('success', 'Dokumen berhasil disimpan & dirilis ke pegawai. Berkas formulir cuti sekarang siap dicetak.');
    }
}