<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     */
    public function create(): View
    {
        return view('auth.login');
    }

    /**
     * Handle an incoming authentication request.
     */
    public function store(LoginRequest $request): RedirectResponse
    {
        $request->authenticate();

        $request->session()->regenerate();

        // --- MODIFIKASI DIMULAI DARI SINI ---

        // Ambil role user yang sedang login
        $role = $request->user()->role;

        // Cek Role dan Redirect sesuai tujuan
        switch ($role) {
            case 'pelaksana':
                // Ini route yang tadi sudah kita buat
                return redirect()->intended(route('pegawai.dashboard', absolute: false));

            case 'kasi':
                // PENTING: Pastikan route 'kasi.dashboard' sudah dibuat di web.php
                // Kalau belum ada, baris ini akan error. 
                // Untuk sementara bisa diarahkan ke 'dashboard' biasa dulu jika belum siap.
                return redirect()->intended(route('kasi.dashboard', absolute: false));

            case 'admin':
                // Contoh untuk admin
                return redirect()->intended(route('admin.dashboard', absolute: false));

            default:
                // Fallback: Kalau role tidak dikenali, lempar ke dashboard default/umum
                return redirect()->intended(route('dashboard', absolute: false));
        }
        // --- SELESAI MODIFIKASI ---
    }

    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }
}
