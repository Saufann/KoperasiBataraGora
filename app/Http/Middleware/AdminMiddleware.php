<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class AdminMiddleware
{
    public function handle(Request $request, Closure $next): Response
    {
        if (Auth::check()) {
            $role = strtolower(trim((string) (Auth::user()->role ?? '')));
            $allowedRoles = ['admin', 'super admin', 'super_admin', 'superadmin'];

            if (in_array($role, $allowedRoles, true)) {
                return $next($request);
            }
        }

        return redirect()->route('user.landing')->with('error', 'Anda bukan Admin!');
    }
}
