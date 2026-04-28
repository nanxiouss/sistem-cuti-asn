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

        // Ambil role user yang sedang login
        $role = $request->user()->role;

        // Cek Role dan Redirect sesuai tujuan
        switch ($role) {
            case 'pegawai':
                return redirect()->intended(route('pegawai.dashboard', absolute: false));

            case 'kasi':
                return redirect()->intended(route('kasi.dashboard', absolute: false));

            case 'kabid': // Untuk Kabid
                return redirect()->intended(route('administrator.dashboard', absolute: false));

            case 'sekdin': // Untuk Sekretaris Dinas
                return redirect()->intended(route('sekdin.dashboard', absolute: false));

            case 'kadin': // Untuk Kepala Dinas
                return redirect()->intended(route('kadin.dashboard', absolute: false));

            case 'admin': // Untuk Admin Kepegawaian
                return redirect()->intended(route('admin.dashboard', absolute: false));

            default:
                // Fallback: Kalau role tidak dikenali
                return redirect()->intended(route('dashboard', absolute: false));
        }
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