<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class ResponsableMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (Auth::guard('user')->check() && Auth::guard('user')->user()->role === 'responsable') {
            return $next($request);
        }

        if (Auth::guard('user')->check()) {
            Auth::guard('user')->logout();
        }

        return redirect()->route('login')->with('error', 'Accès réservé aux responsables.');
    }
}
