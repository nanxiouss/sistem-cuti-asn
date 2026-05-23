<?php

namespace App\Http\Controllers\Pegawai;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use App\Models\User;
use App\Models\Pegawai;
use App\Models\JenisCuti;
use App\Models\Pengajuan;
use Carbon\Carbon;

class PengajuanController extends Controller
{
    public function create()
    {
        $user = Auth::user()->load('pegawai');

        if (!$user->pegawai) {
            return back()->withErrors(['error' => 'Data pegawai belum lengkap!']);
        }

        $tahun_skrg = date('Y');
        $min_date = date('Y-m-d');

        // --- Logika Pemecahan Saldo ---
        $kuota_db = $user->pegawai->sisa_cuti_tahunan ?? 12;
        $sisa_n = 12;
        $sisa_n1 = 0;
        $sisa_n2 = 0;

        if ($kuota_db > 12) {
            $sisa_n1 = $kuota_db - 12;
            if ($sisa_n1 > 6) {
                $sisa_n2 = $sisa_n1 - 6;
                $sisa_n1 = 6;
            }
        } else {
            $sisa_n = $kuota_db;
        }

        $total_kuota = $sisa_n + $sisa_n1 + $sisa_n2;

        $terpakai = Pengajuan::where('user_id', $user->id)
            ->where('status', 'like', '%Disetujui%')
            ->whereYear('tgl_mulai', $tahun_skrg)
            ->sum('lama_cuti');

        $sisa_total = $total_kuota - $terpakai;

        // Modifikasi Koleksi Jenis Cuti
        $jenis_cutis = JenisCuti::all()->map(function ($item) use ($sisa_total) {
            if (strtolower($item->nama) == 'cuti tahunan') {
                $item->kuota = $sisa_total;
            }
            return $item;
        });

        // --- Logika Penentuan List Atasan (Dropdown) ---
        if (!empty($user->pegawai->atasan_id)) {
            $atasans = User::with('pegawai')
                ->where('id', $user->pegawai->atasan_id)
                ->get();
        } else {
            $role_user = $user->role;
            $unit_kerja = $user->pegawai->unit_kerja ?? '';

            if ($role_user == 'kasi' || $role_user == 'kasubbag_umum') {
                $atasans = User::with('pegawai')
                    ->whereIn('role', ['kabid', 'sekdin'])
                    ->get();
            } elseif ($role_user == 'kabid' || $role_user == 'sekdin') {
                $atasans = User::with('pegawai')
                    ->where('role', 'kadin')
                    ->get();
            } else {
                $atasans = User::with('pegawai')
                    ->whereIn('role', ['kasi', 'kasubbag_umum', 'kabid'])
                    ->whereHas('pegawai', function ($query) use ($unit_kerja) {
                        if (!empty($unit_kerja)) {
                            $query->where('unit_kerja', $unit_kerja);
                        }
                    })->get();

                if ($atasans->isEmpty()) {
                    $atasans = User::with('pegawai')->whereIn('role', ['kasi', 'kabid'])->get();
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

    public function store(Request $request)
    {
        // 1. Validasi Input Form
        $request->validate([
            'id_jenis_cuti'       => 'required|exists:jenis_cutis,id',
            'tgl_mulai'           => 'required|date',
            'tgl_selesai'         => 'required|date|after_or_equal:tgl_mulai',
            'alasan'              => 'required',
            'alamat'              => 'required',
            'no_telepon'          => 'required',
            'id_atasan'           => 'required',
            'konfirmasi_ttd'      => 'required|accepted',
            'password_verifikasi' => 'required',
            'bukti'               => 'nullable|file|mimes:pdf,jpeg,png,jpg|max:2048'
        ], [
            'id_jenis_cuti.required' => 'Jenis cuti harus dipilih.',
            'id_atasan.required'     => 'Atasan penilai harus dipilih.',
        ]);

        $user = Auth::user()->load('pegawai');

        // 2. Validasi Keamanan: Cek Password
        if (!Hash::check($request->password_verifikasi, $user->password)) {
            return back()->withInput()->withErrors(['error' => 'Password verifikasi salah!']);
        }

        // 3. Validasi Keamanan: Blokir Pengajuan Ganda yang Masih Berjalan
        $sedangProses = Pengajuan::where('user_id', $user->id)
            ->where('status', 'not like', '%Disetujui%')
            ->where('status', 'not like', '%Ditolak%')
            ->exists();

        if ($sedangProses) {
            return back()
                ->withInput()
                ->withErrors(['error' => 'Gagal: Anda masih memiliki pengajuan cuti yang sedang diproses. Harap tunggu hingga proses selesai.']);
        }

        // 4. Validasi Keamanan: Pastikan Pegawai SUDAH PUNYA file Tanda Tangan di profilnya
        // *Catatan: Sesuaikan 'foto_ttd' di bawah ini dengan nama kolom asli pada tabel 'pegawais' Anda
        if (!$user->pegawai || empty($user->pegawai->foto_ttd)) {
            return back()
                ->withInput()
                ->withErrors(['error' => 'Gagal: Anda belum mengunggah file tanda tangan di halaman profil. Silakan lengkapi profil terlebih dahulu!']);
        }

        // 5. Hitung Hari Kerja (Senin-Jumat)
        $mulai = new \DateTime($request->tgl_mulai);
        $selesai = new \DateTime($request->tgl_selesai);

        $lama_cuti = 0;
        while ($mulai <= $selesai) {
            if (!in_array($mulai->format('N'), [6, 7])) {
                $lama_cuti++;
            }
            $mulai->modify('+1 day');
        }

        // 6. Blokir jika durasi melebihi saldo Cuti Tahunan
        $jenisCuti = JenisCuti::find($request->id_jenis_cuti);

        if ($jenisCuti && strtolower($jenisCuti->nama) == 'cuti tahunan') {
            $total_kuota = $user->pegawai->sisa_cuti_tahunan ?? 12;

            $terpakai = Pengajuan::where('user_id', $user->id)
                ->where('status', 'like', '%Disetujui%')
                ->sum('lama_cuti');

            $sisa_total = $total_kuota - $terpakai;

            if ($lama_cuti > $sisa_total) {
                return back()->withErrors(['error' => "Gagal: Durasi cuti Anda ($lama_cuti hari) melebihi sisa Cuti Tahunan yang tersedia ($sisa_total hari)."]);
            }
        }

        // 7. Mapping Data untuk Disimpan
        $data = [
            'user_id'       => $user->id,
            'jenis_cuti_id' => $request->id_jenis_cuti,
            'alasan'        => $request->alasan,
            'tgl_mulai'     => $request->tgl_mulai,
            'tgl_selesai'   => $request->tgl_selesai,
            'lama_cuti'     => $lama_cuti,
            'alamat_cuti'   => $request->alamat,
            'no_telepon'    => $request->no_telepon,
            'id_atasan'     => $request->id_atasan,
            'status'        => 'Menunggu Verifikasi Admin',

            // Mengambil langsung path string/text dari tanda tangan profil pegawai
            'ttd_pegawai'   => $user->pegawai->foto_ttd,
        ];

        // 8. Handle Upload File Bukti (Jika Ada)
        if ($request->hasFile('bukti')) {
            $data['file_bukti'] = $request->file('bukti')->store('bukti', 'public');
        }

        // 9. Eksekusi Create Data
        Pengajuan::create($data);

        return redirect()->route('pegawai.dashboard')->with('success', 'Pengajuan cuti berhasil dikirim ke Sub Bagian Umum & Kepegawaian!');
    }
}
