<?php

namespace App\Http\Controllers\Pegawai;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
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

        // Logika Saldo (Sesuai Native)
        $sisa_n = 12;
        $sisa_n1 = 6;
        $sisa_n2 = 0;

        $terpakai = Pengajuan::where('user_id', $user->id)
            ->where('status', 'Disetujui')
            ->whereYear('tgl_mulai', $tahun_skrg)
            ->sum('lama_cuti');

        $sisa_total = ($sisa_n + $sisa_n1 + $sisa_n2) - $terpakai;

        $jenis_cutis = JenisCuti::all(); // Mengambil kolom 'id' dan 'nama' dari DB
        $atasans = User::where('id', '!=', $user->id)->get();
        $atasan_sekarang = User::find($user->id_atasan);

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
            'bukti'         => 'nullable|image|mimes:jpeg,png,jpg|max:2048'
        ], [
            // Custom message agar pesan error lebih enak dibaca
            'id_jenis_cuti.required' => 'Jenis cuti harus dipilih.',
            'id_atasan.required'     => 'Atasan penilai harus dipilih.',
        ]);

        // 2. Hitung Hari Kerja (Senin-Jumat)
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

        // 3. Mapping data
        $data = [
            'user_id'       => auth()->id(),
            'jenis_cuti_id' => $request->id_jenis_cuti, // Gunakan id_jenis_cuti
            'alasan'        => $request->alasan,
            'tgl_mulai'     => $request->tgl_mulai,
            'tgl_selesai'   => $request->tgl_selesai,
            'lama_cuti'     => $lama_cuti,
            'alamat_cuti'   => $request->alamat,
            'no_telepon'    => $request->no_telp,
            'id_atasan'     => $request->id_atasan,
            'status'        => 'Menunggu Kasi',
        ];

        // 4. Handle Upload File
        if ($request->hasFile('bukti')) {
            $path = $request->file('bukti')->store('bukti-cuti', 'public');
            $data['file_bukti'] = $path;
        }

        // 5. Simpan ke Database
        Pengajuan::create($data);

        // 6. Redirect
        return redirect()->route('pegawai.dashboard')->with('success', 'Pengajuan cuti berhasil dikirim!');
    }
}
