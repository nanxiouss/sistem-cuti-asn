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
        $pengajuan = Pengajuan::with([
            'user.pegawai.bidang',
            'atasan.pegawai.bidang',
            'atasan.pegawai.atasan.pegawai.bidang'
        ])->findOrFail($id);

        if (
            $pengajuan->status == 'Selesai' &&
            !is_null($pengajuan->snapshot_sisa_n)
        ) {
            $sisa_n = $pengajuan->snapshot_sisa_n;
            $sisa_n1 = $pengajuan->snapshot_sisa_n1;
            $sisa_n2 = $pengajuan->snapshot_sisa_n2;
        } else {
            $sisa_total = $pengajuan->user->pegawai->sisa_cuti_tahunan ?? 0;
            $sisa_n = min($sisa_total, 12);
            $sisa_n1 = max(min($sisa_total - $sisa_n, 6), 0);
            $sisa_n2 = max($sisa_total - $sisa_n - $sisa_n1, 0);
        }

        // =========================================================================
        // LOGIKA DINAMIS PENENTUAN STRUKTUR KOLOM TANDA TANGAN (KASI & KABID)
        // =========================================================================
        $kasi = null;
        $kabid = null;
        
        $rolePemohon = $pengajuan->user->role ?? '';

        if ($rolePemohon === 'kasubbag_umum' || $rolePemohon === 'kasubbag') {
            // Jika Kasubbag Umum, dia tidak punya Kasi atau Kabid. Atasan langsungnya adalah Sekdin.
            // Kolom Kasi & Kabid di view/PDF dibiarkan null (akan dihandle di tampilan Blade)
            $kasi = null;
            $kabid = null;
        } 
        elseif ($rolePemohon === 'kasi' || str_contains(strtolower($pengajuan->user->pegawai->jabatan ?? ''), 'kasi')) {
            // Jika Kasi yang mengajukan, dia tidak butuh TTD Kasi lain. 
            // Atasan pertamanya ($pengajuan->atasan) langsung masuk ke variabel $kabid.
            $kasi = null;
            $kabid = $pengajuan->atasan;
        } 
        else {
            // Jika Pegawai Biasa (Alur Standar)
            $kasi = $pengajuan->atasan;
            $kabid = ($kasi && $kasi->pegawai) ? $kasi->pegawai->atasan : null;
        }

        // Ambil data Kepala Dinas untuk tanda tangan akhir
        $kadin = User::whereHas('pegawai', function ($query) {
            $query->where('jabatan', 'LIKE', '%Kepala Dinas%');
        })->first();

        return view('admin.pemberkasan.show', compact(
            'pengajuan',
            'kasi',
            'kabid',
            'kadin',
            'sisa_n',
            'sisa_n1',
            'sisa_n2'
        ));
    }

    public function prosesPemberkasan(Request $request, $id)
    {
        $pengajuan = Pengajuan::with(['user.pegawai', 'jenisCuti'])
            ->lockForUpdate()
            ->findOrFail($id);

        if ($pengajuan->status === 'Selesai') {
            return redirect()->back()->with('error', 'Dokumen ini sudah dirilis sebelumnya.');
        }
        
        try {
            DB::transaction(function () use ($pengajuan) {
                if ($pengajuan->user && $pengajuan->user->pegawai) {
                    $pegawai = $pengajuan->user->pegawai;
                    $jenisCutiNama = strtolower($pengajuan->jenisCuti->nama ?? $pengajuan->jenisCuti->nama_cuti ?? '');
                    $lamaCuti = $pengajuan->lama_cuti;
                    $kolomSisa = null;

                    // 1. Tentukan kolom sisa HANYA untuk cuti yang memotong kuota
                    if (str_contains($jenisCutiNama, 'tahunan') || $pengajuan->jenis_cuti_id == 1) {
                        $kolomSisa = 'sisa_cuti_tahunan';
                    } elseif (str_contains($jenisCutiNama, 'besar') || $pengajuan->jenis_cuti_id == 2) {
                        $kolomSisa = 'sisa_cuti_besar';
                    } elseif (str_contains($jenisCutiNama, 'melahirkan') || $pengajuan->jenis_cuti_id == 4) {
                        $kolomSisa = 'sisa_cuti_melahirkan';
                    }

                    // 2. Validasi saldo HANYA jika jenis cutinya punya kuota (Tahunan, Besar, Melahirkan)
                    if ($kolomSisa) {
                        if ($pegawai->$kolomSisa < $lamaCuti) {
                            throw new \Exception("Saldo {$pengajuan->jenisCuti->nama} tidak mencukupi. Sisa saldo saat ini: {$pegawai->$kolomSisa} hari.");
                        }
                    }

                    // 3. Snapshot Form (Sisa Cuti Tahunan Murni)
                    // Biasanya di form cuti BKN, sisa cuti tahunan selalu ditampilkan di form 
                    // meskipun yang diajukan adalah cuti sakit/alasan penting.
                    $sisaTahunanAktif = $pegawai->sisa_cuti_tahunan;
                    
                    $sisa_n = min($sisaTahunanAktif, 12);
                    $sisa_n1 = max(min($sisaTahunanAktif - $sisa_n, 6), 0);
                    $sisa_n2 = max($sisaTahunanAktif - $sisa_n - $sisa_n1, 0);

                    // 4. Update tabel pengajuan untuk SEMUA JENIS CUTI
                    // Status akan berubah jadi selesai untuk semua (termasuk cuti sakit dkk)
                    $pengajuan->update([
                        'snapshot_sisa_n'  => $sisa_n,
                        'snapshot_sisa_n1' => $sisa_n1,
                        'snapshot_sisa_n2' => $sisa_n2,
                        'status'           => 'Selesai',
                    ]);
                        
                    // 5. Potong kuota di database HANYA jika jenis cutinya punya kuota
                    if ($kolomSisa) {
                        if ($kolomSisa === 'sisa_cuti_besar') {
                            // ATURAN BARU: Kalau ngambil cuti besar, sisa kuota langsung HANGUS
                            $pegawai->sisa_cuti_besar = 0;
                            $pegawai->save();
                        } else {
                            // Cuti tahunan dan melahirkan dipotong normal
                            $pegawai->decrement($kolomSisa, $lamaCuti);
                        }
                    }
                }
            });

            return redirect()->route('admin.pemberkasan.show', $id)
                ->with('success', 'Dokumen berhasil disimpan & dirilis ke pegawai. Berkas formulir cuti sekarang siap dicetak.');
                
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Gagal memproses pemberkasan: ' . $e->getMessage());
        }
    }
}