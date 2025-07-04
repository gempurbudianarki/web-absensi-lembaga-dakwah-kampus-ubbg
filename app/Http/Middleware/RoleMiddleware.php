<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class RoleMiddleware
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next, ...$roles): Response
    {
        $user = Auth::user();

        // Kembalikan ke logika normal
        if (in_array($user->role, $roles)) {
            return $next($request);
        }

        abort(403, 'AKSES DITOLAK. ANDA TIDAK MEMILIKI HAK AKSES UNTUK HALAMAN INI.');
    }
}
