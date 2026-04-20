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
            ->where('status', 'Disetujui')
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

        // Ambil atasan berjenjang dari tabel pegawai
        $atasans = User::with('pegawai')
            ->whereIn('role', ['kasi', 'administrator', 'kadin'])
            ->get();

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
        // 1. Validasi
        $request->validate([
            'id_jenis_cuti' => 'required|exists:jenis_cutis,id',
            'tgl_mulai'     => 'required|date',
            'tgl_selesai'   => 'required|date|after_or_equal:tgl_mulai',
            'alasan'        => 'required',
            'alamat'        => 'required',
            'no_telepon'         => 'required',
            'id_atasan'     => 'required',
            'password_verifikasi' => 'required',
            'ttd_image'     => 'required',
            'bukti'         => 'nullable|image|mimes:jpeg,png,jpg|max:2048'
        ], [
            'id_jenis_cuti.required' => 'Jenis cuti harus dipilih.',
            'id_atasan.required'     => 'Atasan penilai harus dipilih.',
        ]);

        $user = Auth::user()->load('pegawai');

        // 2. Blokir Pengajuan Ganda & Cek Password
        if (!Hash::check($request->password_verifikasi, $user->password)) {
            return back()->withInput()->withErrors(['error' => 'Password verifikasi salah!']);
        }

        $sedangProses = Pengajuan::where('user_id', $user->id)
            ->whereNotIn('status', ['Disetujui', 'Ditolak', 'Tidak Disetujui']) // Disesuaikan sedikit
            ->exists();

        if ($sedangProses) {
            return back()
                ->withInput()
                ->withErrors(['error' => 'Gagal: Anda masih memeliki pengajuan cuti yang sedang diproses. Harap tunggu hingga proses selesai.']);
        }

        // 3. Hitung Hari Kerja (Senin-Jumat)
        $mulai = new \DateTime($request->tgl_mulai);
        $selesai = new \DateTime($request->tgl_selesai);
        
        $lama_cuti = 0;
        while ($mulai <= $selesai) {
            if (!in_array($mulai->format('N'), [6, 7])) {
                $lama_cuti++;
            }
            $mulai->modify('+1 day');
        }

        // 4. Blokir jika durasi melebihi saldo Cuti Tahunan
        $jenisCuti = JenisCuti::find($request->id_jenis_cuti);

        if ($jenisCuti && strtolower($jenisCuti->nama) == 'cuti tahunan') {
            $total_kuota = $user->pegawai->sisa_cuti_tahunan ?? 12;

            $terpakai = Pengajuan::where('user_id', $user->id)
                ->where('status', 'Disetujui')
                ->sum('lama_cuti');

            $sisa_total = $total_kuota - $terpakai;

            if ($lama_cuti > $sisa_total) {
                return back()->withErrors(['error' => "Gagal: Durasi cuti Anda ($lama_cuti hari) melebihi sisa Cuti Tahunan yang tersedia ($sisa_total hari)."]);
            }
        }

        // Proses Simpan tanda tangan
        $ttd_path = null;
        if ($request->ttd_image) {
            $image = explode(";base64,", $request->ttd_image);
            $image_base64 = base64_decode($image[1]);

            $fileName = 'ttd_' . time() . '.png';
            Storage::disk('public')->put('ttd/' . $fileName, $image_base64);

            $ttd_path = 'ttd/' . $fileName;
        }

        // 5. Mapping data
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
            'ttd_pegawai'   => $ttd_path,
        ];

        // 6. Handle Upload File Bukti
        if ($request->hasFile('bukti')) {
            $data['file_bukti'] = $request->file('bukti')->store('bukti', 'public');
        }

        Pengajuan::create($data);

        return redirect()->route('pegawai.dashboard')->with('success', 'Pengajuan cuti berhasil dikirim!');
    }
}