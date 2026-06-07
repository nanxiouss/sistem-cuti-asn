<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class ProfileController extends Controller
{
    /**
     * Display the user's profile form dynamically based on role.
     */
    public function index(Request $request): View
    {
        $user = $request->user();

        // Mapping folder khusus untuk kasubbag_umum ke kasumum
        $roleFolder = $user->role;
        if ($roleFolder === 'kasubbag_umum') {
            $roleFolder = 'kasumum';
        }
        
        // Mengarahkan ke folder view sesuai role user yang sedang login (lowercase)
        return view("{$roleFolder}.profile.index", [
            'user' => $user,
        ]);
    }

    /**
     * Display the edit form dynamically based on role.
     */
    public function edit(Request $request): View
    {
        $user = $request->user();

        // Mapping folder khusus untuk kasubbag_umum ke kasumum agar tidak error saat edit
        $roleFolder = $user->role;
        if ($roleFolder === 'kasubbag_umum') {
            $roleFolder = 'kasumum';
        }

        return view("{$roleFolder}.profile.edit", [
            'user' => $user,
        ]);
    }

    /**
     * Update the user's profile information.
     */
    public function update(Request $request): RedirectResponse
    {
        $user = $request->user();

        // Eager load atau ambil data relasi pegawai milik user saat ini
        $pegawai = $user->pegawai;

        // 1. Validasi gabungan antara data User dan data Pegawai
        $request->validate([
            'nama'             => 'required|string|max:100',
            'no_telepon'       => 'required|string|max:20',
            'pangkat_golongan' => 'nullable|string|max:100',
            'jabatan'          => 'nullable|string|max:100',
            'unit_kerja'       => 'nullable|string|max:100',
            'tmt_kerja'        => 'nullable|date',
            'foto_profil'      => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'foto_ttd'         => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        // 2. Update data nama pada tabel 'users'
        $user->update([
            'nama' => $request->nama
        ]);

        // 3. Siapkan array data untuk disimpan ke tabel 'pegawais'
        $dataPegawai = [
            'no_telepon'       => $request->no_telepon,
            'pangkat_golongan' => $request->pangkat_golongan,
            'jabatan'          => $request->jabatan,
            'unit_kerja'       => $request->unit_kerja,
            'tmt_kerja'        => $request->tmt_kerja,
        ];

        // 4. Proses Upload Foto Profil jika ada file baru
        if ($request->hasFile('foto_profil')) {
            if ($pegawai && $pegawai->foto_profil) {
                Storage::disk('public')->delete($pegawai->foto_profil);
            }
            $dataPegawai['foto_profil'] = $request->file('foto_profil')->store('profil', 'public');
        }

        // 5. Proses Upload Foto Tanda Tangan jika ada file baru
        if ($request->hasFile('foto_ttd')) {
            if ($pegawai && $pegawai->foto_ttd) {
                Storage::disk('public')->delete($pegawai->foto_ttd);
            }
            $dataPegawai['foto_ttd'] = $request->file('foto_ttd')->store('ttd', 'public');
        }

        // 6. Jalankan updateOrCreate agar jika data di tabel pegawais belum ada, otomatis dibuatkan
        $user->pegawai()->updateOrCreate(
            ['user_id' => $user->id],
            $dataPegawai
        );

        return Redirect::route('profile.index')->with('status', 'profile-updated');
    }

    /**
     * Delete the user's account.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();

        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }
}