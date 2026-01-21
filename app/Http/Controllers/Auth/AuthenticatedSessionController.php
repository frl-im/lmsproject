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
    public function loginSelector(): View
    {
        return view('auth.login-selector');
    }

    public function create(): View
    {
        // Jika user sudah login dan admin, redirect ke admin dashboard
        if (Auth::check() && Auth::user()->is_admin) {
            return redirect()->route('admin.dashboard');
        }
        
        return view('auth.login');
    }

    public function createAdmin(): View
    {
        // Jika user sudah login dan admin, redirect ke admin dashboard
        if (Auth::check() && Auth::user()->is_admin) {
            return redirect()->route('admin.dashboard');
        }
        
        return view('auth.admin-login');
    }

    public function store(LoginRequest $request): RedirectResponse
    {
        $request->authenticate();
        $request->session()->regenerate();

        // 🔥 PRIORITAS: login dari tombol "Login & Upgrade"
        if ($request->get('redirect') === 'upgrade') {
            return redirect()->route('finance.index');
        }

        // Routing berbasis role
        if ($request->user()->is_admin) {
            return redirect()->intended(route('admin.dashboard'));
        }

        return redirect()->intended(route('dashboard'));
    }


    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/');
    }
}
