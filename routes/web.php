<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

// Import Controller Berdasarkan Namespace
use App\Http\Controllers\Pegawai\DashboardController as PegawaiDashboardController;
use App\Http\Controllers\Pegawai\PengajuanController as PegawaiPengajuanController;
use App\Http\Controllers\Pegawai\RegulasiController;
use App\Http\Controllers\Pegawai\KalenderController;

use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Admin\PegawaiController as AdminPegawaiController;
use App\Http\Controllers\Admin\PengajuanController as AdminPengajuanController;

use App\Http\Controllers\Kasi\DashboardController as KasiDashboardController;
use App\Http\Controllers\Kasi\PersetujuanController as KasiPersetujuanController;

use App\Http\Controllers\Kabid\DashboardController as KabidDashboardController;
use App\Http\Controllers\Kabid\PersetujuanController as KabidPersetujuanController;

use App\Http\Controllers\Sekdin\DashboardController as SekdinDashboardController;
use App\Http\Controllers\Sekdin\PersetujuanController as SekdinPersetujuanController;

use App\Http\Controllers\Kadin\DashboardController as KadinDashboardController;
use App\Http\Controllers\Kadin\PersetujuanController as KadinPersetujuanController;

// Halaman Depan / Landing Page
Route::get('/', function () {
    return view('welcome');
});

// Force Logout Utility (Bisa diakses jika keadaan darurat session nyangkut)
Route::get('/force-logout', function () {
    Auth::logout();
    request()->session()->invalidate();
    request()->session()->regenerateToken();
    return redirect('/login');
});

// ====================================================================
// GROUP ROUTE PROTECTED (Wajib Login & Terverifikasi)
// ====================================================================
Route::middleware(['auth', 'verified'])->group(function () {

    // 1. Redirector Dashboard Utama (Pintu Masuk Multi-role)
    Route::get('/dashboard', function () {
        $user = Auth::user();
        if ($user->role === 'pegawai') {
            return redirect()->route('pegawai.dashboard');
        } elseif ($user->role === 'admin') {
            return redirect()->route('admin.dashboard');
        } elseif ($user->role === 'kasubbag_umum') {
            return redirect()->route('kasubbag_umum.dashboard');
        } elseif ($user->role === 'kasi') {
            return redirect()->route('kasi.dashboard');
        } elseif ($user->role === 'kabid') {
            return redirect()->route('kabid.dashboard');
        } elseif ($user->role === 'sekdin') {
            return redirect()->route('sekdin.dashboard');
        } elseif ($user->role === 'kadin') {
            return redirect()->route('kadin.dashboard');
        }
        return view('dashboard');
    })->name('dashboard');

    // 2. Ruang Lingkup: PEGAWAI
    Route::prefix('pegawai')->name('pegawai.')->group(function () {
        Route::get('/dashboard', [PegawaiDashboardController::class, 'index'])->name('dashboard');
        Route::get('/pengajuan/create', [PegawaiPengajuanController::class, 'create'])->name('pengajuan.create');
        Route::post('/pengajuan/store', [PegawaiPengajuanController::class, 'store'])->name('pengajuan.store');
        Route::get('/kalender', [KalenderController::class, 'index'])->name('kalender.index');
        Route::get('/regulasi', [RegulasiController::class, 'index'])->name('regulasi.index');
    });

    // 3. Ruang Lingkup: ADMIN
    Route::prefix('admin')->name('admin.')->group(function () {
        // Dashboard Admin
        Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');
        
        // Manajemen Akun & Profil Pegawai (CRUD LENGKAP)
        Route::get('/pegawai', [AdminPegawaiController::class, 'index'])->name('pegawai.index');
        Route::get('/pegawai/create', [AdminPegawaiController::class, 'create'])->name('pegawai.create');
        Route::post('/pegawai', [AdminPegawaiController::class, 'store'])->name('pegawai.store');
        Route::get('/pegawai/{id}', [AdminPegawaiController::class, 'show'])->name('pegawai.show');
        Route::get('/pegawai/{id}/edit', [AdminPegawaiController::class, 'edit'])->name('pegawai.edit');
        Route::put('/pegawai/{id}', [AdminPegawaiController::class, 'update'])->name('pegawai.update');
        Route::delete('/pegawai/{id}', [AdminPegawaiController::class, 'destroy'])->name('pegawai.destroy');

        // Verifikasi Berkas Pengajuan Cuti oleh Admin (SUDAH DISINKRONKAN)
        Route::get('/pengajuan', [AdminPengajuanController::class, 'index'])->name('pengajuan.index');
        Route::get('/pengajuan/{id}', [AdminPengajuanController::class, 'show'])->name('pengajuan.show');
        Route::post('/pengajuan/{id}/teruskan', [AdminPengajuanController::class, 'teruskanKeKasi'])->name('pengajuan.teruskan');
        Route::get('/pengajuan/{id}/cetak', [AdminPengajuanController::class, 'cetak'])->name('pengajuan.cetak');
    });

    // 4. Ruang Lingkup: KASI
    Route::prefix('kasi')->name('kasi.')->group(function () {
        Route::get('/dashboard', [KasiDashboardController::class, 'index'])->name('dashboard');
        Route::get('/persetujuan', [KasiPersetujuanController::class, 'index'])->name('persetujuan.index');
        Route::get('/persetujuan/{id}', [KasiPersetujuanController::class, 'show'])->name('persetujuan.show');
        Route::put('/persetujuan/{id}', [KasiPersetujuanController::class, 'update'])->name('persetujuan.update');
    });

    // 5. Ruang Lingkup: KABID
    Route::prefix('kabid')->name('kabid.')->group(function () {
        Route::get('/dashboard', [KabidDashboardController::class, 'index'])->name('dashboard');
        Route::get('/persetujuan', [KabidPersetujuanController::class, 'index'])->name('persetujuan.index');
        Route::get('/persetujuan/{id}', [KabidPersetujuanController::class, 'show'])->name('persetujuan.show');
        Route::put('/persetujuan/{id}', [KabidPersetujuanController::class, 'update'])->name('persetujuan.update');
    });

    // 6. Ruang Lingkup: SEKDIN
    Route::prefix('sekdin')->name('sekdin.')->group(function () {
        Route::get('/dashboard', [SekdinDashboardController::class, 'index'])->name('dashboard');
        Route::get('/persetujuan', [SekdinPersetujuanController::class, 'index'])->name('persetujuan.index');
        Route::get('/persetujuan/{id}', [SekdinPersetujuanController::class, 'show'])->name('persetujuan.show');
        Route::put('/persetujuan/{id}', [SekdinPersetujuanController::class, 'update'])->name('persetujuan.update');
    });

    // 7. Ruang Lingkup: KADIN
    Route::prefix('kadin')->name('kadin.')->group(function () {
        Route::get('/dashboard', [KadinDashboardController::class, 'index'])->name('dashboard');
        Route::get('/persetujuan', [KadinPersetujuanController::class, 'index'])->name('persetujuan.index');
        Route::get('/persetujuan/{id}', [KadinPersetujuanController::class, 'show'])->name('persetujuan.show');
        Route::put('/persetujuan/{id}', [KadinPersetujuanController::class, 'update'])->name('persetujuan.update');
    });

    // 8. Manajemen Profil Pengguna Mandiri (Universal)
    Route::get('/profile', [ProfileController::class, 'index'])->name('profile.index');
    Route::get('/profile/edit', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Sertakan rute bawaan Laravel Breeze / Jetstream Auth
require __DIR__ . '/auth.php';