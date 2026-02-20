<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class SuperAdminMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (Auth::guard('user')->check() && Auth::guard('user')->user()->role === 'admin') {
            return $next($request);
        }

        return redirect()->route('admin.dashboard')->with('error', 'Vous n\'avez pas les permissions nécessaires pour accéder à cette section.');
    }
}
