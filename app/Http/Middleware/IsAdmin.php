<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class IsAdmin
{
    public function handle(Request $request, Closure $next)
    {
        // Kullanıcının admin olup olmadığını kontrol et
        if (Auth::check() && Auth::user()->is_admin) {
            return $next($request); // Adminse devam et
        }

        // Admin değilse 403 Forbidden döndür
        return response()->json(['error' => 'Forbidden'], 403);
    }
}
