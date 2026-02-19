<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class PrestataireMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (Auth::guard('user')->check() && Auth::guard('user')->user()->role === 'prestataire') {
            return $next($request);
        }

        // If not appropriate role, redirect or error
        return redirect()->route('user.login')->with('error', 'Accès réservé aux prestataires.');
    }
}
