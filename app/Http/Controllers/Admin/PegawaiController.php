<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Pegawai;
use App\Models\Bidang; 
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class PegawaiController extends Controller
{
    // 1. TAMPILKAN DAFTAR PEGAWAI
    public function index()
    {
        $user = User::with(['pegawai.atasan', 'pegawai.bidang'])
            ->where('role', '!=', 'admin') 
            ->orderBy('created_at', 'desc')
            ->get();
        
        return view('admin.pegawai.index', compact('user'));
    }

    // 2. FORM TAMBAH PEGAWAI
    public function create()
    {
        // PERUBAHAN: Load relasi pegawai agar field bidang_id bisa diakses langsung di Blade group
        $atasans = User::with('pegawai')
            ->whereIn('role', ['kasi', 'kabid', 'kasubbag_umum', 'sekdin', 'kadin'])
            ->get();
            
        $bidangs = Bidang::orderBy('nama_bidang', 'asc')->get();

        return view('admin.pegawai.create', compact('atasans', 'bidangs'));
    }

    // 3. SIMPAN PEGAWAI BARU
    public function store(Request $request)
    {
        $request->validate([
            'nip'               => 'required|unique:users,nip|max:30',
            'nama'              => 'required|string|max:100',
            'password'          => 'required|min:6',
            'role'              => 'required|in:admin,pegawai,kasi,kabid,kasubbag_umum,sekdin,kadin', 
            'atasan_id'         => 'nullable|exists:users,id',
            'bidang_id'         => 'nullable|exists:bidangs,id', 
            'pangkat_golongan'  => 'nullable|string|max:100',
            'jabatan'           => 'nullable|string|max:100',
            'tmt_kerja'         => 'nullable|date',
            'sisa_cuti_tahunan' => 'required|integer|min:0',
            'no_telepon'        => 'nullable|string|max:20',
        ]);

        try {
            DB::beginTransaction();

            $user = User::create([
                'nip'      => $request->nip,
                'nama'     => $request->nama,
                'password' => Hash::make($request->password),
                'role'     => $request->role,  
            ]);

            Pegawai::create([
                'user_id'           => $user->id,
                'atasan_id'         => $request->atasan_id,
                'bidang_id'         => $request->bidang_id, 
                'pangkat_golongan'  => $request->pangkat_golongan,
                'jabatan'           => $request->jabatan,
                'tmt_kerja'         => $request->tmt_kerja,
                'sisa_cuti_tahunan' => $request->sisa_cuti_tahunan,
                'no_telepon'        => $request->no_telepon,
            ]);

            DB::commit();
            return redirect()->route('admin.pegawai.index')->with('success', 'Data pegawai berhasil ditambahkan!');

        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()
                ->withInput($request->except('password'))
                ->withErrors(['error' => 'Gagal menyimpan data: ' . $e->getMessage()]);
        }
    }

    // 4. DETAIL PEGAWAI
    public function show($id)
    {
        $user = User::with(['pegawai.atasan', 'pegawai.bidang'])->findOrFail($id);
        return view('admin.pegawai.show', compact('user'));
    }

    // 5. FORM EDIT PEGAWAI
    public function edit($id)
    {
        $user = User::with('pegawai')->findOrFail($id);
        
        // PERUBAHAN: Load relasi pegawai agar field bidang_id bisa diakses langsung di Blade group saat edit
        $atasans = User::with('pegawai')
            ->whereIn('role', ['kasi', 'kabid', 'kasubbag_umum', 'sekdin', 'kadin'])
            ->where('id', '!=', $id) 
            ->get();
            
        $bidangs = Bidang::orderBy('nama_bidang', 'asc')->get();

        return view('admin.pegawai.edit', compact('user', 'atasans', 'bidangs'));
    }

    // 6. UPDATE DATA PEGAWAI
    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);

        $request->validate([
            'nip'               => 'required|max:30|unique:users,nip,' . $user->id,
            'nama'              => 'required|string|max:100',
            'password'          => 'nullable|min:6',
            'role'              => 'required|in:admin,pegawai,kasi,kabid,kasubbag_umum,sekdin,kadin', 
            'atasan_id'         => 'nullable|exists:users,id',
            'bidang_id'         => 'nullable|exists:bidangs,id', 
            'pangkat_golongan'  => 'nullable|string|max:100',
            'jabatan'           => 'nullable|string|max:100',
            'tmt_kerja'         => 'nullable|date',
            'sisa_cuti_tahunan' => 'required|integer|min:0',
            'no_telepon'        => 'nullable|string|max:20',
        ]);

        try {
            DB::beginTransaction();

            $userData = [
                'nip'   => $request->nip,
                'nama'  => $request->nama,
                'role'  => $request->role,
            ];

            if ($request->filled('password')) {
                $userData['password'] = Hash::make($request->password);
            }

            $user->update($userData);

            Pegawai::updateOrCreate(
                ['user_id' => $user->id],
                [
                    'atasan_id'         => $request->atasan_id,
                    'bidang_id'         => $request->bidang_id, 
                    'pangkat_golongan'  => $request->pangkat_golongan,
                    'jabatan'           => $request->jabatan,
                    'tmt_kerja'         => $request->tmt_kerja,
                    'sisa_cuti_tahunan' => $request->sisa_cuti_tahunan,
                    'no_telepon'        => $request->no_telepon,
                ]
            );

            DB::commit();
            return redirect()->route('admin.pegawai.index')->with('success', 'Data pegawai berhasil diperbarui!');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()
                ->withInput($request->except('password'))
                ->withErrors(['error' => 'Gagal memperbarui data: ' . $e->getMessage()]);
        }
    }

    // 7. HAPUS AKUN PEGAWAI
    public function destroy($id)
    {
        try {
            DB::beginTransaction();

            $user = User::findOrFail($id);

            if ($user->pegawai) {
                $user->pegawai->delete();
            }

            $user->delete();

            DB::commit();
            return redirect()->route('admin.pegawai.index')->with('success', 'Data pegawai berhasil dihapus!');

        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->route('admin.pegawai.index')->withErrors(['error' => 'Gagal menghapus data. Pastikan pegawai ini tidak memiliki riwayat pengajuan cuti aktif di database.']);
        }
    }
}