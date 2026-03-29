<?php

namespace App\Http\Controllers\Pegawai;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Foundation\Support\Str;
use App\Models\User;
use App\Models\JenisCuti;
use App\Models\Pengajuan;
use Carbon\Carbon;

class PengajuanController extends Controller
{
    public function create()
    {
        $user = Auth::user();
        $tahun_skrg = date('Y');
        $min_date = date('Y-m-d');

        // 1. Logika Saldo (Sesuai perhitunganmu)
        $sisa_n = 12;
        $sisa_n1 = 6;
        $sisa_n2 = 0;

        $terpakai = Pengajuan::where('user_id', $user->id)
            ->where('status', 'Disetujui')
            ->whereYear('tgl_mulai', $tahun_skrg)
            ->sum('lama_cuti');

        $sisa_total = ($sisa_n + $sisa_n1 + $sisa_n2) - $terpakai;

        // 2. Modifikasi Koleksi Jenis Cuti agar angkanya sinkron
        $jenis_cutis = JenisCuti::all()->map(function ($item) use ($sisa_total) {
            // Jika nama cutinya adalah Cuti Tahunan, timpa kuotanya dengan sisa_total
            if (strtolower($item->nama) == 'cuti tahunan') {
                $item->kuota = $sisa_total;
            }
            return $item;
        });

        $atasan_sekarang = User::find($user->id_atasan);
        $atasans = User::where('role', 'atasan')->get();

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
            'no_telp'       => 'required',
            'id_atasan'     => 'required',
            'password_verifikasi' => 'required',
            'ttd_image' => 'required',
            'bukti'         => 'nullable|image|mimes:jpeg,png,jpg|max:2048'

        ], [
            // Custom message agar pesan error lebih enak dibaca
            'id_jenis_cuti.required' => 'Jenis cuti harus dipilih.',
            'id_atasan.required'     => 'Atasan penilai harus dipilih.',
        ]);

        $user = Auth::user();

        // 2. Blokir Pengajuan Ganda
        // mengecek apakah user masih punya pengajuan yang belum selesai
        if (!Hash::check($request->password_verifikasi, $user->password)) {
            return back()->withInput()->withErrors(['error' => 'Password verifikasi salah!']);
        }

        $sedangProses = Pengajuan::where('user_id', $user->id)
            ->whereNotIn('status', ['Disetujui', 'Perubahan', 'Ditangguhkan', 'Tidak Disetujui'])
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

        // Pakai kloning agar objek asli tidak berubah saat loop
        $tempMulai = clone $mulai;
        while ($tempMulai <= $selesai) {
            if (!in_array($tempMulai->format('N'), [6, 7])) {
                $lama_cuti++;
            }
            $tempMulai->modify('+1 day');
        }

        // 4. Blokir jika durasi melebihi saldo
        $jenisCuti = JenisCuti::find($request->id_jenis_cuti);

        if ($jenisCuti && strtolower($jenisCuti->nama) == 'cuti tahunan') {
            $tahun_skrg = date('Y');
            $sisa_n = 12;
            $sisa_n1 = 6;
            $sisa_n2 = 0;

            $terpakai = Pengajuan::where('user_id', $user->id)
                ->where('status', 'Disetujui')
                ->whereYear('tgl_mulai', $tahun_skrg)
                ->sum('lama_cuti');

            $sisa_total = ($sisa_n + $sisa_n1 + $sisa_n2) - $terpakai;

            if ($lama_cuti > $sisa_total) {
                return back()
                    ->withInput()
                    ->withErrors(['error' => "Gagal: Durasi cuti Anda ($lama_cuti hari) melebihi sisa Cuti Tahunan yang tersedia ($sisa_total hari)."]);
            }
        }

        // Proses Simpan tanda tangan
        $ttd_path = null;
        if ($request->filled('ttd_image')) { 
            $image_64 = $request->ttd_image;
            $image_parts = explode(";base64,", $image_64);
            $image_base64 = base64_decode($image_parts[1]);
            $imageName = 'ttd_' . $user->id . '_' . time() . '.png';
            
            Storage::disk('public')->put('ttd-pegawai/' . $imageName, $image_base64);
            $ttd_path = 'ttd-pegawai/' . $imageName;
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
            'no_telepon'    => $request->no_telp,
            'id_atasan'     => $request->id_atasan,
            'status'        => 'Menunggu Kasi',
            'ttd_pegawai'   => $ttd_path,
        ];

        // 6. Handle Upload File
        if ($request->hasFile('bukti')) {
            $path = $request->file('bukti')->store('bukti-cuti', 'public');
            $data['file_bukti'] = $path;
        }

        Pengajuan::create($data);

        return redirect()->route('pegawai.dashboard')->with('success', 'Pengajuan cuti berhasil dikirim!');
    }
}
