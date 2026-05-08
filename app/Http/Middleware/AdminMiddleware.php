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
        // Belum login sama sekali → ke login admin
        if (!Auth::check()) {
            return redirect()->route('admin.login')
                ->with('error', 'Silakan login sebagai admin terlebih dahulu.');
        }

        // Login tapi bukan admin → tolak akses
        if (!Auth::user()->isAdmin()) {
            abort(403, 'Akses ditolak. Halaman ini hanya untuk administrator.');
        }

        return $next($request);
    }
}
