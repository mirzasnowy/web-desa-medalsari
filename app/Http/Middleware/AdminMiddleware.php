<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class AdminMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Ganti dengan logika otorisasi admin Anda
        // Contoh sederhana: Cek apakah user login dan memiliki role 'admin'
        if (Auth::check() && Auth::user()->is_admin) { // Asumsikan ada kolom `is_admin` di tabel `users`
            return $next($request);
        }

        // Jika tidak diotorisasi, redirect atau tampilkan error
        return redirect('/')->with('error', 'Anda tidak memiliki akses ke halaman ini.');
    }
}