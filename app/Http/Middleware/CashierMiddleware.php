<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CashierMiddleware
{
    public function handle(Request $request, Closure $next): Response
    {
        if (!auth()->check()) {
            return redirect()->route('login');
        }

        if (!auth()->user()->isCashier() && !auth()->user()->isAdmin()) {
            abort(403, 'Akses ditolak. Hanya kasir atau admin yang dapat mengakses halaman ini.');
        }

        return $next($request);
    }
}