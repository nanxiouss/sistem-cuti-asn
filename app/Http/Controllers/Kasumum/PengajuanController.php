<?php

namespace App\Http\Controllers\Kasumum;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\Pegawai;
use App\Models\JenisCuti;
use App\Models\Pengajuan;
use Carbon\Carbon;

class PengajuanController extends Controller
{
    // ==============================================================================
    // 1. FORM FORMULIR PENGAJUAN CUTI BARU (KHUSUS KASUBBAG UMUM)
    // ==============================================================================
    public function create()
    {
        // Load data user login beserta profil pegawai dan relasi bidang kerjanya
        $user = Auth::user()->load(['pegawai.atasan', 'pegawai.bidang']);

        if (!$user->pegawai) {
            return back()->withErrors(['error' => 'Profil kepegawaian Anda belum terdaftar di sistem. Silakan hubungi admin!']);
        }

        $tmtCpns = $user->pegawai->masa_kerja; 
        $belumSatuTahun = !$tmtCpns || Carbon::parse($tmtCpns)->diffInYears(now()) < 1;

        $tahun_skrg = date('Y');
        $min_date = date('Y-m-d');

        // --- Logika Kuota Cuti Riil dari Database ---
        $sisa_total = $user->pegawai->sisa_cuti_tahunan ?? 0;

        // Pecahan data N, N-1, N-2 untuk display informasi di Blade (Khusus Cuti Tahunan)
        $sisa_n = $sisa_total > 12 ? 12 : $sisa_total;
        $sisa_n1 = ($sisa_total - $sisa_n) > 6 ? 6 : ($sisa_total - $sisa_n);
        $sisa_n2 = ($sisa_total - $sisa_n - $sisa_n1) > 0 ? ($sisa_total - $sisa_n - $sisa_n1) : 0;

        // Memetakan kuota pilihan Jenis Cuti secara dinamis berdasarkan sisa saldo pegawai
        $jenis_cutis = JenisCuti::all()->map(function ($item) use ($user) {
            $namaCuti = strtolower($item->nama ?? $item->nama_cuti ?? '');
            $pegawai = $user->pegawai;

            if (str_contains($namaCuti, 'tahunan') || $item->id == 1) {
                $item->kuota = $pegawai->sisa_cuti_tahunan ?? 0;
            } elseif (str_contains($namaCuti, 'besar') || $item->id == 2) {
                $item->kuota = $pegawai->sisa_cuti_besar ?? 0;
            } elseif (str_contains($namaCuti, 'melahirkan') || $item->id == 4) {
                $item->kuota = $pegawai->sisa_cuti_melahirkan ?? 0;
            }
            return $item;
        });

        // --- LOGIKA ATASAN KHUSUS KASUBBAG UMUM ---
        // Alur Kasubbag Umum: Penilai pertamanya wajib Sekretaris Dinas (Sekdin)
        if (!empty($user->pegawai->atasan_id)) {
            // Jika atasan sudah di-set manual permanen di profil pegawai
            $atasans = User::with('pegawai')->where('id', $user->pegawai->atasan_id)->get();
        } else {
            // Ambil user yang memiliki role 'sekdin' atau 'sekretaris'
            $atasans = User::with('pegawai')
                ->whereIn('role', ['sekdin', 'sekretaris'])
                ->get();

            // Jika role sekdin tidak ditemukan/belum di-set di database, backup tampilkan seluruh sekdin/atasan relevan
            if ($atasans->isEmpty()) {
                $atasans = User::with('pegawai')->where('role', 'sekdin')->get();
            }
        }

        $atasan_sekarang = $user->pegawai->atasan ?? null;

        // Pastikan path view diarahkan ke folder kasubbag_umum / kasubbag
        return view('kasumum.pengajuan.create', compact(
            'user',
            'tahun_skrg',
            'min_date',
            'sisa_n',
            'sisa_n1',
            'sisa_n2',
            'sisa_total',
            'jenis_cutis',
            'atasans',
            'atasan_sekarang',
            'belumSatuTahun'
        ));
    }

    // ==============================================================================
    // 2. PROSES PENYIMPANAN DATA PENGAJUAN CUTI
    // ==============================================================================
    public function store(Request $request)
    {
        // Validasi struktur inputan form aplikasi cuti
        $request->validate([
            'id_jenis_cuti'       => 'required|exists:jenis_cutis,id',
            'tgl_mulai'           => 'required|date',
            'tgl_selesai'         => 'required|date|after_or_equal:tgl_mulai',
            'alasan'              => 'required|string',
            'alamat'              => 'required|string',
            'no_telepon'          => 'nullable|string|max:20', 
            'id_atasan'           => 'required|exists:users,id',
            'konfirmasi_ttd'      => 'required|accepted',
            'password_verifikasi' => 'required',
            'bukti'               => 'nullable|file|mimes:pdf,jpeg,png,jpg|max:5120'
        ], [
            'id_jenis_cuti.required' => 'Jenis kategori cuti wajib Anda tentukan.',
            'id_atasan.required'     => 'Pejabat atasan penilai (Sekretaris Dinas) wajib dipilih.',
            'konfirmasi_ttd.accepted'=> 'Anda harus menyetujui penyematan tanda tangan elektronik.',
            'bukti.max'              => 'Ukuran file lampiran maksimal adalah 5MB.',
        ]);

        $user = Auth::user()->load('pegawai');
        $tmtCpns = $user->pegawai->masa_kerja;

        if (!$tmtCpns || Carbon::parse($tmtCpns)->diffInYears(now()) < 1) {
            return back()->withInput()->withErrors([
                'error' => 'Gagal mengirim berkas! Anda belum memenuhi syarat minimal 1 tahun masa kerja CPNS untuk dapat mengajukan cuti.'
            ]);
        }

        if (!Hash::check($request->password_verifikasi, $user->password)) {
            return back()->withInput()->withErrors(['error' => 'Password verifikasi yang Anda masukkan tidak valid!']);
        }

        $sedangProses = Pengajuan::where('user_id', $user->id)
            ->whereNotIn('status', ['Disetujui', 'Ditolak', 'Dibatalkan'])
            ->exists();

        if ($sedangProses) {
            return back()
                ->withInput()
                ->withErrors(['error' => 'Gagal mengirim berkas! Anda masih memiliki dokumen pengajuan cuti yang berstatus aktif berjalan di sistem.']);
        }

        if (!$user->pegawai || empty($user->pegawai->foto_ttd)) {
            return back()
                ->withInput()
                ->withErrors(['error' => 'Fitur Diblokir: Anda belum membuat tanda tangan QR Code di pengaturan profil akun Anda.']);
        }

        // Perhitungan Jumlah Hari Kerja Nyata (Mengecualikan Hari Sabtu dan Minggu)
        $mulai = new \DateTime($request->tgl_mulai);
        $selesai = new \DateTime($request->tgl_selesai);
        
        $pencacah = clone $mulai;
        $lama_cuti = 0;
        
        while ($pencacah <= $selesai) {
            if (!in_array($pencacah->format('N'), [6, 7])) { 
                $lama_cuti++;
            }
            $pencacah->modify('+1 day');
        }

        if ($lama_cuti == 0) {
            return back()->withInput()->withErrors(['error' => 'Gagal: Rentang tanggal yang Anda pilih hanya berisi hari libur akhir pekan (Sabtu/Minggu).']);
        }

        $jenisCuti = JenisCuti::find($request->id_jenis_cuti);

        if ($jenisCuti) {
            $jenisCutiNama = strtolower($jenisCuti->nama ?? $jenisCuti->nama_cuti ?? '');
            $pegawai = $user->pegawai;
            $sisa_kuota = 0;
            $nama_label = '';

            // Cek batasan kuota dinamis sesuai jenis cutinya
            if (str_contains($jenisCutiNama, 'tahunan') || $request->id_jenis_cuti == 1) {
                $sisa_kuota = $pegawai->sisa_cuti_tahunan ?? 0;
                $nama_label = 'Cuti Tahunan';
            } elseif (str_contains($jenisCutiNama, 'besar') || $request->id_jenis_cuti == 2) {
                $sisa_kuota = $pegawai->sisa_cuti_besar ?? 0;
                $nama_label = 'Cuti Besar';
            } elseif (str_contains($jenisCutiNama, 'melahirkan') || $request->id_jenis_cuti == 4) {
                $sisa_kuota = $pegawai->sisa_cuti_melahirkan ?? 0;
                $nama_label = 'Cuti Melahirkan';
            }

            // Jika jenis cutinya masuk dalam salah satu kategori pembatasan kuota
            if ($nama_label !== '' && $lama_cuti > $sisa_kuota) {
                return back()->withInput()->withErrors([
                    'error' => "Batas Kuota Melampaui: Durasi pengajuan Anda ($lama_cuti hari) melebihi sisa saldo kuota $nama_label Anda ($sisa_kuota hari)."
                ]);
            }
        }

        $noTelepon = preg_replace('/[^0-9]/', '', $request->no_telepon);
        $noTelepon = preg_replace('/^62|^0/', '', $noTelepon);
        $noTelepon = '0' . $noTelepon;

        // Penyusunan Array data objek
        $data = [
            'user_id'       => $user->id,
            'jenis_cuti_id' => $request->id_jenis_cuti,
            'alasan'        => $request->alasan,
            'tgl_mulai'     => $request->tgl_mulai,
            'tgl_selesai'   => $request->tgl_selesai,
            'lama_cuti'     => $lama_cuti,
            'alamat_cuti'   => $request->alamat,
            'no_telepon'    => $noTelepon,
            'id_atasan'     => $request->id_atasan,
            'status'        => 'Menunggu Verifikasi Admin', 
            'ttd_pegawai'   => $user->pegawai->foto_ttd,
        ];

        if ($request->hasFile('bukti')) {
            $data['file_bukti'] = $request->file('bukti')->store('bukti_cuti', 'public');
        }

        Pengajuan::create($data);

        // Redirect disesuaikan ke dashboard Kasubbag Umum
        return redirect()->route('kasumum.dashboard')->with('success', 'Dokumen permohonan cuti berhasil diajukan! Berkas kini berada di antrean verifikasi.');
    }
}