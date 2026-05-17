<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
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

Route::get('/', function () {
    return view('welcome');
});

// Redirector Dashboard
Route::get('/dashboard', function () {
    $user = Auth::user();
    if ($user->role === 'pegawai') {
        return redirect()->route('pegawai.dashboard');
    } elseif ($user->role === 'admin' || $user->role === 'administrator') {
        return redirect()->route('admin.dashboard');
    } elseif ($user->role === 'kasi') {
        return redirect()->route('kasi.dashboard');
    } elseif ($user->role === 'kabid') {
        return redirect()->route('kabid.dashboard');
    } elseif ($user->role === 'sekdin') {
        return redirect()->route('sekdin.dashboard');
    }
    elseif ($user->role === 'kadin') { // <-- TAMBAHAN KADIN
        return redirect()->route('kadin.dashboard');
    }
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

// Group Route Pegawai
Route::middleware(['auth', 'verified'])->group(function () {

    Route::prefix('pegawai')->name('pegawai.')->group(function () {
        Route::get('/dashboard', [PegawaiDashboardController::class, 'index'])->name('dashboard');
        Route::get('/pengajuan/create', [PegawaiPengajuanController::class, 'create'])->name('pengajuan.create');
        Route::post('/pengajuan/store', [PegawaiPengajuanController::class, 'store'])->name('pengajuan.store');
        Route::get('/kalender', [KalenderController::class, 'index'])->name('kalender.index');
        Route::get('/regulasi', [RegulasiController::class, 'index'])->name('regulasi.index');
    });
});

// Group Route Administrasi
Route::middleware(['auth', 'verified'])->group(function () {
    Route::prefix('admin')->name('admin.')->group(function () {
        Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');
        Route::get('/pegawai', [AdminPegawaiController::class, 'index'])->name('pegawai.index');
        Route::get('/pengajuan', [AdminPengajuanController::class, 'index'])->name('pengajuan.index');

        Route::get('/pegawai/create', [AdminPegawaiController::class, 'create'])->name('pegawai.create');
        Route::post('/pegawai', [AdminPegawaiController::class, 'store'])->name('pegawai.store');

        Route::get('/pengajuan/{id}/verif', [AdminPengajuanController::class, 'show'])->name('pengajuan.show');
        Route::patch('/pengajuan/{id}/verif', [AdminPengajuanController::class, 'updateStatus'])->name('pengajuan.update');
    });
});

// Group Route Kasi
Route::middleware(['auth', 'verified'])->group(function () {
    Route::prefix('kasi')->name('kasi.')->group(function () {
        Route::get('/dashboard', [KasiDashboardController::class, 'index'])->name('dashboard');

        Route::get('/persetujuan', [KasiPersetujuanController::class, 'index'])->name('persetujuan.index');
        Route::get('/persetujuan/{id}', [KasiPersetujuanController::class, 'show'])->name('persetujuan.show');
        Route::put('/persetujuan/{id}', [KasiPersetujuanController::class, 'update'])->name('persetujuan.update');
    });
});

// Group Route Khusus Kabid
Route::middleware(['auth', 'verified'])->group(function () {
    Route::prefix('kabid')->name('kabid.')->group(function () {
        Route::get('/dashboard', [KabidDashboardController::class, 'index'])->name('dashboard');
        Route::get('/persetujuan', [KabidPersetujuanController::class, 'index'])->name('persetujuan.index');
        Route::get('/persetujuan/{id}', [KabidPersetujuanController::class, 'show'])->name('persetujuan.show');
        Route::put('/persetujuan/{id}', [KabidPersetujuanController::class, 'update'])->name('persetujuan.update');
    });
});

// GROUP ROUTE SEKDIN
Route::middleware(['auth', 'verified'])->group(function () {
    Route::prefix('sekdin')->name('sekdin.')->group(function () {
        Route::get('/dashboard', [SekdinDashboardController::class, 'index'])->name('dashboard');
        Route::get('/persetujuan', [SekdinPersetujuanController::class, 'index'])->name('persetujuan.index');
        Route::get('/persetujuan/{id}', [SekdinPersetujuanController::class, 'show'])->name('persetujuan.show');
        Route::put('/persetujuan/{id}', [SekdinPersetujuanController::class, 'update'])->name('persetujuan.update');
    });
});

// GROUP ROUTE Kadin
Route::middleware(['auth', 'verified'])->group(function () {
    Route::prefix('kadin')->name('kadin.')->group(function () {
        Route::get('/dashboard', [KadinDashboardController::class, 'index'])->name('dashboard');
        Route::get('/persetujuan', [kadinPersetujuanController::class, 'index'])->name('persetujuan.index');
        Route::get('/persetujuan/{id}', [KadinPersetujuanController::class, 'show'])->name('persetujuan.show');
        Route::put('/persetujuan/{id}', [kadinPersetujuanController::class, 'update'])->name('persetujuan.update');
    });
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::get('/force-logout', function () {
    Auth::logout();
    request()->session()->invalidate();
    request()->session()->regenerateToken();
    return redirect('/login');
});

require __DIR__ . '/auth.php';
