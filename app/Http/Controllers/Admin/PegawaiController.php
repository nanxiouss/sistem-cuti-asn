<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Pegawai;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Testing\Fluent\Concerns\Has;

class PegawaiController extends Controller
{
    public function index()
    {
        $user = User::with(['pegawai', 'pegawai.atasan'])
            ->orderBy('created_at', 'desc')
            ->get();
    }

    public function create()
    {
        $atasans = User::whereIn('role', ['kasi', 'kabid', 'sekdin', 'kadin'])->get();

        return view('admin.pegawai.create', compact('atasans'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nip'               => 'required|unique:users,nip|max:30',
            'nama'              => 'required|string|max:100',
            'password'          => 'required|min:6',
            'role'              => 'required|in:admin,pegawai,kasi,kabid,sekdin,kadin',
            'atasan_id'         => 'nullable|exists:users,id',
            'pangkat_golongan'  => 'nullable|string|max:100',
            'jabatan'           => 'nullable|string|max:100',
            'unit_kerja'        => 'nullable|string|max:100',
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
                'pangkat_golongan'  => $request->pangkat_golongan,
                'jabatan'           => $request->jabatan,
                'unit_kerja'        => $request->unit_kerja,
                'tmt_kerja'         => $request->tmt_kerja,
                'sisa_cuti_tahunan' => $request->sisa_cuti_tahunan,
                'no_telepon'        => $request->no_telepon,
            ]);

            DB::commit();
            return redirect()->route('admin.pegawai.index')->with('succes', 'Data pegawai berhasil ditambahkan!');

        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()
                ->withInput($request->except('password'))
                ->withErrors(['error' => 'Gagal menyimpan data: ' . $e->getMessage()]);
        }
    }

    public function edit($id)
    {
        $user = User::with('pegawai')->findOrFail($id);
        $atasans = User::whereIn('role', ['kasi', 'kabid', 'sekdin', 'kadin'])
            ->where('id', '!=', $id)
            ->get();

        return view('admin.pegawai.edit', compact('user', 'atasans'));
    }

    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);

        $request->validate([
            'nip'               => 'required|max:30|unique:users,nip,' . $user->id,
            'nama'              => 'required|string|max:100',
            'password'          => 'nullable|min:6',
            'role'              => 'required|in:admin,pegawai,kasi,kabid,sekdin,kadin',
            'atasan_id'         => 'nullable|exists:users,id',
            'pangkat_golongan'  => 'nullable|string|max:100',
            'jabatan'           => 'nullable|string|max:100',
            'unit_kerja'        => 'nullable|string|max:100',
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
                    'pangkat_golongan'  => $request->pangkat_golongan,
                    'jabatan'           => $request->jabatan,
                    'unit_kerja'        => $request->unit_kerja,
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
            return redirect()->route('admin.pegawai.index')->withErrors(['error' => 'Gagal menghapus data. Pastikan pegawai ini tidak memiliki riwayat pengajuan cuti aktif.']);
        }
    }
}