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

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__ . '/auth.php';
