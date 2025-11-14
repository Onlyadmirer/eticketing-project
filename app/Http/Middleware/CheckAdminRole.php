<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckAdminRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Cek jika user login DAN user->isAdmin() (method dari User.php)
        if ($request->user() && $request->user()->isAdmin()) {
            return $next($request); // Lanjutkan ke halaman
        }

        // Jika bukan admin, tendang ke halaman 403 (Forbidden)
        abort(403, 'UNAUTHORIZED ACTION.');
    }
}