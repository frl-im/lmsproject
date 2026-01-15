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
     * Display the admin login view.
     */
    public function createAdmin(): View
    {
        session(['admin_login' => true]);
        return view('auth.admin-login');
    }

    /**
     * Handle an incoming authentication request.
     */
   public function store(LoginRequest $request): RedirectResponse
{
    $request->authenticate();

    $request->session()->regenerate();

    // --- LOGIKA BARU ---
    // Jika user adalah admin, arahkan ke dashboard admin
    if ($request->user()->is_admin === 1) { // Sesuaikan angka 1 jika kamu pakai boolean/integer
        return redirect()->intended(route('admin.dashboard'));
    }

    // Jika siswa, arahkan ke dashboard siswa biasa
    return redirect()->intended(route('dashboard', absolute: false));
}

    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $wasAdmin = $request->session()->get('admin_login', false);

        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        if ($wasAdmin) {
            return redirect()->route('admin.login');
        }

        return redirect('/');
    }
}
