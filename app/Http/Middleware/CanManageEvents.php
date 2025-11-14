<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CanManageEvents
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Cek jika user login DAN method canManageEvents() return true
        if ($request->user() && $request->user()->canManageEvents()) {
            return $next($request); // Izinkan masuk
        }

        // Tendang jika tidak punya hak
        abort(403, 'UNAUTHORIZED ACTION.');
    }
}