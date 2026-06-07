<?php

namespace App\Http\Controllers\Pegawai;

use App\Http\Controllers\Controller;
use App\Models\Pengajuan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class RiwayatController extends Controller
{
    /**
     * Menampilkan daftar semua riwayat pengajuan cuti milik pegawai yang sedang login.
     * Mengatasi error 'Call to undefined method ...::index()'
     */
    public function index()
    {
        $pengajuans = Pengajuan::with(['jenisCuti'])
            ->where('user_id', Auth::id())
            ->orderBy('created_at', 'desc')
            ->get();

        return view('pegawai.riwayat.index', compact('pengajuans'));
    }

    /**
     * Menampilkan detail riwayat pengajuan cuti beserta live tracking.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        // 1. Ambil data pengajuan yang sesuai dengan user login beserta relasi jenis cutinya
        $pengajuan = Pengajuan::with(['jenisCuti'])
            ->where('user_id', Auth::id())
            ->findOrFail($id);

        $status = $pengajuan->status;
        $logs = [];

        // TAHAP 1: Pegawai Mengajukan (Status: Pasti Berhasil Selesai)
        $logs[] = [
            'title' => 'Pengajuan Cuti Berhasil Dikirim',
            'desc' => 'Pegawai berhasil melakukan submit formulir pengajuan ' . $pengajuan->jenisCuti->nama . ' selama ' . $pengajuan->lama_cuti . ' hari kerja.',
            'time' => $pengajuan->created_at->format('d M Y H:i') . ' WIB',
            'status' => 'done'
        ];

        // TAHAP 2: Sub Bagian Umum & Kepegawaian (Penelaah Teknis / Isi Blanko Kuota)
        // Lolos jika status sudah bukan status awal submisi ('Diajukan' / 'Menunggu Verifikasi')
        $isStep2Done = !in_array($status, ['Diajukan', 'Menunggu Verifikasi']);
        $logs[] = [
            'title' => 'Pemeriksaan Berkas & Pengisian Blanko (Subbag Umum)',
            'desc' => $isStep2Done 
                ? 'Penelaah teknis kepegawaian telah memeriksa berkas formulir, mengisi detail sisa kuota cuti tahunan, dan meneruskan berkas ke Kepala Seksi.' 
                : 'Berkas masuk ke dalam antrean meja Sub Bagian Umum & Kepegawaian untuk penelaahan teknis sisa kuota cuti.',
            // FIX: Menggunakan copy() agar objek asli created_at tidak ikut termutasi/berubah
            'time' => $isStep2Done ? $pengajuan->created_at->copy()->addMinutes(15)->format('d M Y H:i') . ' WIB' : null,
            'status' => $isStep2Done ? 'done' : ($status === 'Diajukan' || $status === 'Menunggu Verifikasi' ? 'process' : 'waiting')
        ];

        // TAHAP 3: Kepala Seksi (Kasi Check)
        // Indikator selesai: Kolom ttd_kasi atau tgl_ttd_kasi tidak kosong
        $isStep3Done = (!empty($pengajuan->ttd_kasi) || !empty($pengajuan->tgl_ttd_kasi)) && $status !== 'Ditolak';
        $logs[] = [
            'title' => 'Pemeriksaan & Catatan Kepala Seksi (Kasi)',
            'desc' => $isStep3Done 
                ? 'Disetujui oleh Kepala Seksi. Catatan: "' . ($pengajuan->catatan_kasi ?? 'Berkas sesuai syarat, lanjutkan.') . '"' 
                : ($status === 'Menunggu Persetujuan Kasi' ? 'Berkas sedang ditinjau dan menunggu keputusan persetujuan dari Kepala Seksi.' : 'Menunggu berkas diteruskan oleh penelaah teknis umum.'),
            'time' => $pengajuan->tgl_ttd_kasi ? Carbon::parse($pengajuan->tgl_ttd_kasi)->format('d M Y H:i') . ' WIB' : null,
            'status' => $isStep3Done ? 'done' : ($status === 'Menunggu Persetujuan Kasi' ? 'process' : 'waiting')
        ];

        // TAHAP 4: Kepala Bidang (Kabid)
        // Indikator selesai: Kolom ttd_kabid atau tgl_ttd_kabid tidak kosong
        $isStep4Done = (!empty($pengajuan->ttd_kabid) || !empty($pengajuan->tgl_ttd_kabid)) && $status !== 'Ditolak';
        $logs[] = [
            'title' => 'Pertimbangan Bidang oleh Kepala Bidang (Kabid)',
            'desc' => $isStep4Done 
                ? 'Disetujui oleh Kepala Bidang. Catatan: "' . ($pengajuan->catatan_kabid ?? 'Setuju, silakan diproses ke subbag kepegawaian.') . '"' 
                : ($status === 'Menunggu Persetujuan Kabid' ? 'Berkas berada di meja Kepala Bidang untuk pemberian pertimbangan dan persetujuan.' : 'Menunggu persetujuan dari Kepala Seksi selesai.'),
            'time' => $pengajuan->tgl_ttd_kabid ? Carbon::parse($pengajuan->tgl_ttd_kabid)->format('d M Y H:i') . ' WIB' : null,
            'status' => $isStep4Done ? 'done' : ($status === 'Menunggu Persetujuan Kabid' ? 'process' : 'waiting')
        ];

        // TAHAP 5: Kasubbag Umum Kepegawaian (Tanda Tangan Digital)
        // Indikator selesai: Kolom ttd_kasubbag atau tgl_ttd_kasubbag_umum tidak kosong
        $isStep5Done = (!empty($pengajuan->ttd_kasubbag) || !empty($pengajuan->tgl_ttd_kasubbag_umum)) && $status !== 'Ditolak';
        $logs[] = [
            'title' => 'Validasi Akhir & Tanda Tangan Digital Kasubbag Umum',
            'desc' => $isStep5Done 
                ? 'Kasubbag Umum & Kepegawaian telah memvalidasi administrasi kepegawaian secara penuh dan membubuhkan tanda tangan digital resmi.' 
                : ($status === 'Menunggu Ttd Kasubbag' ? 'Menunggu penandatanganan digital dokumen oleh Kasubbag Umum & Kepegawaian.' : 'Menunggu pertimbangan dari Kepala Bidang.'),
            'time' => $pengajuan->tgl_ttd_kasubbag_umum ? Carbon::parse($pengajuan->tgl_ttd_kasubbag_umum)->format('d M Y H:i') . ' WIB' : null,
            'status' => $isStep5Done ? 'done' : ($status === 'Menunggu Ttd Kasubbag' ? 'process' : 'waiting')
        ];

        // TAHAP 6: Sekretaris Dinas (Paraf Digital Sekdin)
        // Indikator selesai: Kolom ttd_sekdin atau tgl_ttd_sekdin tidak kosong
        $isStep6Done = (!empty($pengajuan->ttd_sekdin) || !empty($pengajuan->tgl_ttd_sekdin)) && $status !== 'Ditolak';
        $logs[] = [
            'title' => 'Paraf Koordinasi Sekretaris Dinas (Sekdin)',
            'desc' => $isStep6Done 
                ? 'Sekretaris Dinas telah memeriksa kesesuaian berkas dinas dan membubuhkan paraf koordinasi digital kedinasan.' 
                : ($status === 'Menunggu Paraf Sekdin' ? 'Berkas dalam antrean koordinasi dan pembubuhan paraf digital Sekretaris Dinas.' : 'Menunggu berkas divalidasi dan ditandatangani oleh Kasubbag Umum.'),
            'time' => $pengajuan->tgl_ttd_sekdin ? Carbon::parse($pengajuan->tgl_ttd_sekdin)->format('d M Y H:i') . ' WIB' : null,
            'status' => $isStep6Done ? 'done' : ($status === 'Menunggu Paraf Sekdin' ? 'process' : 'waiting')
        ];

        // TAHAP 7: Kepala Dinas (Kadin - Legalitas Akhir Keputusan)
        // Indikator selesai: Kolom ttd_kadin atau tgl_ttd_kadin tidak kosong
        $isStep7Done = (!empty($pengajuan->ttd_kadin) || !empty($pengajuan->tgl_ttd_kadin)) && $status !== 'Ditolak';
        $logs[] = [
            'title' => 'Keputusan Final Kepala Dinas (Kadin)',
            'desc' => $isStep7Done 
                ? 'Kepala Dinas memberikan keputusan MUTLAK disetujui dengan membubuhkan Tanda Tangan Digital utama pimpinan pada dokumen.' 
                : (in_array($status, ['Approved Kadin (Menunggu SK)', 'Menunggu Ttd Kadin']) ? 'Berkas masuk ke akun Kepala Dinas untuk penandatanganan SK / Surat Izin final secara elektronik.' : 'Menunggu berkas naik dari Sekretaris Dinas.'),
            'time' => $pengajuan->tgl_ttd_kadin ? Carbon::parse($pengajuan->tgl_ttd_kadin)->format('d M Y H:i') . ' WIB' : null,
            'status' => $isStep7Done ? 'done' : (in_array($status, ['Approved Kadin (Menunggu SK)', 'Menunggu Ttd Kadin']) ? 'process' : 'waiting')
        ];

        // TAHAP 8: Sub Bagian Umum (Pemberkasan Akhir, Input Nomor SK & Database Arsip)
        $isFinal = ($status === 'Selesai');
        $logs[] = [
            'title' => 'Pemberkasan Selesai & Arsip Dokumen',
            'desc' => $isFinal 
                ? 'Admin Kepegawaian berhasil melakukan penomoran SK, mengarsipkan lembar dokumen ke dalam sistem, dan merilis berkas fisik cetak mandiri untuk pegawai.' 
                : ($status === 'Selesai' ? 'Menunggu admin kepegawaian menyelesaikan penginputan nomor SK dan klik rilis berkas arsip.' : 'Menunggu keputusan persetujuan akhir ditandatangani oleh Kepala Dinas.'),
            'time' => $isFinal ? $pengajuan->updated_at->format('d M Y H:i') . ' WIB' : null,
            'status' => $isFinal ? 'done' : ($status === 'Selesai' ? 'process' : 'waiting')
        ];

        // ANTISIPASI KONDISI DITOLAK: Jika berkas ditolak di tengah alur, selipkan log penolakan di tumpukan paling atas
        if ($status === 'Ditolak') {
            $logs[] = [
                'title' => 'Pengajuan Cuti Ditolak ❌',
                'desc' => 'Mohon maaf, pengajuan cuti Anda tidak dapat disetujui setelah melalui evaluasi pimpinan. Silakan hubungi admin kepegawaian instansi Anda untuk info lebih lanjut.',
                'time' => $pengajuan->updated_at->format('d M Y H:i') . ' WIB',
                'status' => 'rejected'
            ];
        }

        // Balik urutan array log agar informasi TERBARU berada di posisi PALING ATAS (Shopee Live Tracing Style)
        $tracingLogs = array_reverse($logs);

        return view('pegawai.riwayat.show', compact('pengajuan', 'tracingLogs'));
    }
}