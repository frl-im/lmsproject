<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class IsAdmin
{
    public function handle(Request $request, Closure $next): Response
    {
        // Belum login
        if (!auth()->check()) {
            return redirect()->route('login');
        }

        // Bukan admin
        if (!auth()->user()->is_admin) {
            abort(403, 'Akses khusus admin');
        }

        return $next($request);
    }
}
