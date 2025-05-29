<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class CekBagian
{
    public function handle($request, Closure $next, ...$bagians)
    {
        //dd(Auth::user()->bagian);
        if (Auth::check() && in_array(Auth::user()->bagian, $bagians)) {
            return $next($request);
        }

        abort(403, 'Akses ditolak. Anda tidak memiliki hak akses ke halaman ini.');
    }
}