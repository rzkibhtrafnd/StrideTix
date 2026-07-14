<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class EnsureUserIsAdmin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (Auth::check()) {
            $role = Auth::user()->role;
            $normalizedRole = $role instanceof \App\Enums\UserRole ? $role->value : (is_string($role) ? strtolower($role) : (int) $role);

            if ($normalizedRole === \App\Enums\UserRole::ADMIN->value || $normalizedRole === 'admin') {
                return $next($request);
            }
        }

        abort(403, 'Akses ditolak. Halaman ini hanya dapat diakses oleh Administrator Utama.');
    }
}