<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PremiumMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        $user = Auth::user();

        // Jika belum login
        if (!$user) {
            return redirect()->route('login');
        }

        // Jika bukan premium
        if (!$user->is_premium) {
            return redirect()->route('finance.index')
                ->with('warning', 'Fitur ini hanya untuk user Premium');
        }

        return $next($request);
    }
}
