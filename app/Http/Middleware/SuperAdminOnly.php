<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class SuperAdminOnly
{
    /**
     * Handle an incoming request
     */
    public function handle(Request $request, Closure $next): Response
    {
        $sessionRole = strtolower(trim((string) $request->session()->get('admin_role', '')));
        $authRole = strtolower(trim((string) (Auth::user()->role ?? '')));

        $allowedRoles = ['admin', 'super admin', 'super_admin', 'superadmin'];

        if (!in_array($sessionRole, $allowedRoles, true) &&
            !in_array($authRole, $allowedRoles, true)) {
            abort(403, 'Akses ditolak');
        }

        if (!Auth::check()) {
            return $next($request);
        }

        if (!$request->session()->has('admin_name')) {
            $request->session()->put('admin_name', (string) (Auth::user()->name ?? 'Admin'));
        }

        if (!$request->session()->has('admin_role')) {
            $request->session()->put('admin_role', (string) (Auth::user()->role ?? 'Admin'));
        }

        return $next($request);
    }
}
