<?php

namespace App\Http\Controllers\Pegawai;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\Pegawai;
use App\Models\JenisCuti;
use App\Models\Pengajuan;

class PengajuanController extends Controller
{
    // 1. FORM FORMULIR PENGAJUAN CUTI BARU
    public function create()
    {
        // Load data user login beserta profil pegawai dan relasi bidang kerjanya
        $user = Auth::user()->load(['pegawai.atasan', 'pegawai.bidang']);

        if (!$user->pegawai) {
            return back()->withErrors(['error' => 'Profil kepegawaian Anda belum terdaftar di sistem. Silakan hubungi admin!']);
        }

        $tahun_skrg = date('Y');
        $min_date = date('Y-m-d');

        // --- Logika Kuota Cuti Riil dari Database ---
        $sisa_total = $user->pegawai->sisa_cuti_tahunan ?? 0;

        // Pecahan data N, N-1, N-2 untuk display informasi di Blade
        $sisa_n = $sisa_total > 12 ? 12 : $sisa_total;
        $sisa_n1 = ($sisa_total - $sisa_n) > 6 ? 6 : ($sisa_total - $sisa_n);
        $sisa_n2 = ($sisa_total - $sisa_n - $sisa_n1) > 0 ? ($sisa_total - $sisa_n - $sisa_n1) : 0;

        // Modifikasi Koleksi kuota pilihan Jenis Cuti khusus untuk Cuti Tahunan
        $jenis_cutis = JenisCuti::all()->map(function ($item) use ($sisa_total) {
            if (strtolower($item->nama) == 'cuti tahunan') {
                $item->kuota = $sisa_total;
            }
            return $item;
        });

        // --- Logika Penentuan List Dropdown Atasan Berdasarkan Kluster Bidang Dinas ---
        if (!empty($user->pegawai->atasan_id)) {
            // Jika user sudah dikunci atasan langsungnya oleh admin, panggil atasan tersebut secara spesifik
            $atasans = User::with('pegawai')
                ->where('id', $user->pegawai->atasan_id)
                ->get();
        } else {
            $role_user = $user->role;
            // Ambil bidang_id langsung dari properti foreign key tabel pegawais
            $bidang_id = $user->pegawai->bidang_id ?? ($user->pegawai->bidang->id ?? null);

            if (in_array($role_user, ['kasi', 'kasubbag_umum'])) {
                // Kasi & Kasubbag mengajukan verifikasi langsung ke Kabid atau Sekdin
                $atasans = User::with('pegawai')
                    ->whereIn('role', ['kabid', 'sekdin'])
                    ->get();
            } elseif (in_array($role_user, ['kabid', 'sekdin'])) {
                // Level Kabid & Sekdin langsung diverifikasi oleh Kepala Dinas
                $atasans = User::with('pegawai')
                    ->where('role', 'kadin')
                    ->get();
            } else {
                // Pegawai/Staf biasa mendeteksi Atasan (Kasi/Kasubbag/Kabid) yang berada di dalam SATU BIDANG YANG SAMA
                $atasans = User::with('pegawai')
                    ->whereIn('role', ['kasi', 'kasubbag_umum', 'kabid'])
                    ->whereHas('pegawai', function ($query) use ($bidang_id) {
                        if (!empty($bidang_id)) {
                            $query->where('bidang_id', $bidang_id);
                        }
                    })->get();

                // Langkah Cadangan (Fallback): Jika di bidangnya belum ada atasan, tampilkan list seluruh pejabat struktural dinas
                if ($atasans->isEmpty()) {
                    $atasans = User::with('pegawai')->whereIn('role', ['kasi', 'kabid', 'kasubbag_umum'])->get();
                }
            }
        }

        $atasan_sekarang = $user->pegawai->atasan ?? null;

        return view('pegawai.pengajuan.create', compact(
            'user',
            'tahun_skrg',
            'min_date',
            'sisa_n',
            'sisa_n1',
            'sisa_n2',
            'sisa_total',
            'jenis_cutis',
            'atasans',
            'atasan_sekarang'
        ));
    }

    // 2. PROSES PENYIMPANAN DATA PENGAJUAN CUTI
    public function store(Request $request)
    {
        // Validasi struktur inputan form aplikasi cuti
        $request->validate([
            'id_jenis_cuti'       => 'required|exists:jenis_cutis,id',
            'tgl_mulai'           => 'required|date',
            'tgl_selesai'         => 'required|date|after_or_equal:tgl_mulai',
            'alasan'              => 'required|string',
            'alamat'              => 'required|string',
            'no_telepon'          => 'nullable|string', 
            'id_atasan'           => 'required|exists:users,id',
            'konfirmasi_ttd'      => 'required|accepted',
            'password_verifikasi' => 'required',
            'bukti'               => 'nullable|file|mimes:pdf,jpeg,png,jpg|max:2048'
        ], [
            'id_jenis_cuti.required' => 'Jenis kategori cuti wajib Anda tentukan.',
            'id_atasan.required'     => 'Pejabat atasan penilai wajib dipilih.',
            'konfirmasi_ttd.accepted'=> 'Anda harus menyetujui penyematan tanda tangan elektronik.',
        ]);

        $user = Auth::user()->load('pegawai');

        // Validasi Kredensial Keamanan: Verifikasi kecocokan password user
        if (!Hash::check($request->password_verifikasi, $user->password)) {
            return back()->withInput()->withErrors(['error' => 'Password verifikasi yang Anda masukkan tidak valid!']);
        }

        // Validasi Alur Kerja: Blokir pengajuan baru jika ada berkas lama yang statusnya belum selesai
        $sedangProses = Pengajuan::where('user_id', $user->id)
            ->whereNotIn('status', ['Disetujui', 'Ditolak', 'Dibatalkan'])
            ->exists();

        if ($sedangProses) {
            return back()
                ->withInput()
                ->withErrors(['error' => 'Gagal mengirim berkas! Anda masih memiliki dokumen pengajuan cuti yang berstatus aktif berjalan di sistem.']);
        }

        // Validasi Kelengkapan Dokumen: Pastikan user sudah mengatur berkas spesimen tanda tangan digital (TTD)
        if (!$user->pegawai || empty($user->pegawai->foto_ttd)) {
            return back()
                ->withInput()
                ->withErrors(['error' => 'Fitur Diblokir: Anda belum mengunggah file tanda tangan elektronik di pengaturan profil akun Anda.']);
        }

        // Perhitungan Jumlah Hari Kerja Nyata (Mengecualikan Hari Sabtu dan Minggu) menggunakan Object Cloning
        $mulai = new \DateTime($request->tgl_mulai);
        $selesai = new \DateTime($request->tgl_selesai);
        
        $pencacah = clone $mulai;
        $lama_cuti = 0;
        
        while ($pencacah <= $selesai) {
            if (!in_array($pencacah->format('N'), [6, 7])) { // 6 = Sabtu, 7 = Minggu
                $lama_cuti++;
            }
            $pencacah->modify('+1 day');
        }

        if ($lama_cuti == 0) {
            return back()->withInput()->withErrors(['error' => 'Gagal: Rentang tanggal yang Anda pilih hanya berisi hari libur akhir pekan (Sabtu/Minggu).']);
        }

        // Validasi Saldo Batas Atas Kuota Cuti Tahunan
        $jenisCuti = JenisCuti::find($request->id_jenis_cuti);

        if ($jenisCuti && strtolower($jenisCuti->nama) == 'cuti tahunan') {
            $sisa_total = $user->pegawai->sisa_cuti_tahunan ?? 0;

            if ($lama_cuti > $sisa_total) {
                return back()->withInput()->withErrors(['error' => "Batas Kuota Melampaui: Durasi pengajuan Anda ($lama_cuti hari) melebihi sisa saldo cuti tahunan aktif Anda ($sisa_total hari)."]);
            }
        }

        // Penyusunan Array data objek pemetaan data ke dalam database tabel pengajuans
        $data = [
            'user_id'       => $user->id,
            'jenis_cuti_id' => $request->id_jenis_cuti,
            'alasan'        => $request->alasan,
            'tgl_mulai'     => $request->tgl_mulai,
            'tgl_selesai'   => $request->tgl_selesai,
            'lama_cuti'     => $lama_cuti,
            'alamat_cuti'   => $request->alamat,
            'no_telepon'    => $request->no_telepon ?? $user->pegawai->no_telepon,
            'id_atasan'     => $request->id_atasan,
            'status'        => 'Menunggu Verifikasi Admin', // Alur masuk berkas ke meja Admin Umum terlebih dahulu
            'ttd_pegawai'   => $user->pegawai->foto_ttd,
        ];

        // Eksekusi penyimpanan berkas lampiran pendukung berkas cuti (Jika diunggah)
        if ($request->hasFile('bukti')) {
            $data['file_bukti'] = $request->file('bukti')->store('bukti_cuti', 'public');
        }

        // Lakukan create row pengajuan baru
        Pengajuan::create($data);

        return redirect()->route('pegawai.dashboard')->with('success', 'Dokumen permohonan cuti berhasil diajukan! Berkas kini berada di antrean Sub Bagian Umum & Kepegawaian.');
    }
}