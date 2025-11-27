<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class EnsureOrganizerApproved
{
    public function handle(Request $request, Closure $next): Response
    {
        if (Auth::check() && Auth::user()->role === 'organizer') {
            if (Auth::user()->organizer_status !== 'approved') {
                return redirect()->route('organizer.status');
            }
        }

        return $next($request);
    }
}