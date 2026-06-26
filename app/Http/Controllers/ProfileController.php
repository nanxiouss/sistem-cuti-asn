<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Hash;
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
        $pegawai = $user->pegawai;

        // 1. Validasi: Mengubah batas maksimal foto & ttd menjadi 5MB (5120 KB)
        $request->validate([
            'no_telepon'   => 'required|string|max:20',
            'foto_profil'  => 'nullable|image|mimes:jpeg,png,jpg|max:5120',
            'foto_ttd'     => 'nullable|image|mimes:jpeg,png,jpg|max:5120',
            'password'     => 'nullable|string|min:8|confirmed', 
        ]);

        // Format Nomor Telepon agar selalu disimpan dengan awalan '0'
        $noTelepon = preg_replace('/[^0-9]/', '', $request->no_telepon);
        $noTelepon = preg_replace('/^62|^0/', '', $noTelepon);
        $noTelepon = '0' . $noTelepon;

        // 2. Update data pada tabel 'users' 
        if ($request->filled('password')) {
            $user->password = Hash::make($request->password);
        }
        $user->save();

        // 3. Siapkan array data untuk disimpan ke tabel 'pegawais'
        $dataPegawai = [
            'no_telepon' => $noTelepon,
        ];

        // 4. Proses Upload Foto Profil jika ada file baru
        if ($request->hasFile('foto_profil')) {
            if ($pegawai && $pegawai->foto_profil) {
                Storage::disk('public')->delete($pegawai->foto_profil);
            }
            $dataPegawai['foto_profil'] = $request->file('foto_profil')->store('profil', 'public');
        }

        // 5. Proses Upload & Generate QR Code Tanda Tangan
        if ($request->hasFile('foto_ttd')) {
            // Hapus file QR / TTD lama jika ada
            if ($pegawai && $pegawai->foto_ttd) {
                Storage::disk('public')->delete($pegawai->foto_ttd);
            }

            // Simpan gambar TTD asli yang diupload user ke folder terpisah
            $ttdAsliPath = $request->file('foto_ttd')->store('ttd_asli', 'public');

            // Siapkan konten/isi dari QR Code.
            $qrContent = asset('storage/' . $ttdAsliPath);

            // Generate QR Code menjadi bentuk string SVG
            $qrSvg = \SimpleSoftwareIO\QrCode\Facades\QrCode::size(300)
                        ->margin(1)
                        ->generate($qrContent);

            // Tentukan nama file QR Code baru
            $qrFileName = 'ttd/qr_' . $user->id . '_' . time() . '.svg';

            // Simpan file QR Code tersebut ke storage public
            Storage::disk('public')->put($qrFileName, $qrSvg);

            // Masukkan path QR Code ke array untuk disimpan di database
            $dataPegawai['foto_ttd'] = $qrFileName;
        }

        // 6. Jalankan updateOrCreate
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