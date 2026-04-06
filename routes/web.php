<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Pegawai\DashboardController as PegawaiDashboardController;
use App\Http\Controllers\Pegawai\PengajuanController;
use App\Http\Controllers\Pegawai\RegulasiController;
use App\Http\Controllers\Pegawai\KalenderController;

Route::get('/', function () {
    return view('welcome');
});

// Redirector Dashboard
Route::get('/dashboard', function () {
    $user = Auth::user();
    if ($user->role === 'pegawai') {
        return redirect()->route('pegawai.dashboard');
    }
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

// Group Route Pegawai
Route::middleware(['auth', 'verified'])->group(function () {

    Route::prefix('pegawai')->name('pegawai.')->group(function () {
        Route::get('/dashboard', [PegawaiDashboardController::class, 'index'])->name('dashboard');
        Route::get('/pengajuan/create', [PengajuanController::class, 'create'])->name('pengajuan.create');
        Route::post('/pengajuan/store', [PengajuanController::class, 'store'])->name('pengajuan.store');
        Route::get('/kalender', [KalenderController::class, 'index'])->name('kalender.index');
        Route::get('/regulasi', [RegulasiController::class, 'index'])->name('regulasi.index');
    });
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__ . '/auth.php';
