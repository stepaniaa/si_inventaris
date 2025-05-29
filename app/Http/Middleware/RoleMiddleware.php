<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class RoleMiddleware
{
    public function handle($request, Closure $next, ...$roles)
    {
        // Cek apakah user sudah login
        if (!Auth::check()) {
            abort(403, 'Unauthorized');
        }

        // Jika $roles hanya string (seperti 'staff|kaunit'), ubah jadi array
        if (is_string($roles[0])) {
            $roles = explode('|', $roles[0]); // Memecah string menjadi array
        }

        // Cek apakah role user ada dalam array $roles yang diizinkan
        if (!in_array(Auth::user()->role, $roles)) {
            abort(403, 'Unauthorized');
        }

        return $next($request);
    }
}