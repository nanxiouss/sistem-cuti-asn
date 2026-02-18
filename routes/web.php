<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Pegawai\DashboardController as PegawaiDashboardController;
use App\Http\Controllers\Pegawai\RegulasiController;

// 1. Halaman Depan
Route::get('/', function () {
    return view('welcome');
});

// 2. LOGIC REDIRECTOR (PINTU GERBANG)
// Ini menangkap route '/dashboard' default bawaan Laravel
Route::get('/dashboard', function () {
    $user = Auth::user();

    // Cek Role
    if ($user->role === 'pelaksana') { // Sesuaikan nama role di databasemu
        return redirect()->route('pegawai.dashboard');
    }

    // Jika Admin/Lainnya, tampilkan dashboard default
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');


// 3. GROUP ROUTE PEGAWAI
Route::middleware(['auth', 'verified', 'role:pelaksana'])->group(function () { // Pastikan middleware role sudah aktif

    Route::prefix('pegawai')->name('pegawai.')->group(function () {

        // Dashboard Pegawai
        Route::get('/dashboard', [PegawaiDashboardController::class, 'index'])->name('dashboard');
        Route::get('/regulasi', [RegulasiController::class, 'index'])->name('regulasi.index');
    });
});

// 4. GROUP ROUTE PROFILE (Bawaan Breeze)
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__ . '/auth.php';
