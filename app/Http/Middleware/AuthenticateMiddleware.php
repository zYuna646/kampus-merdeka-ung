<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class AuthenticateMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {

        // Cek apakah pengguna telah login
        if (!Auth::check()) {
            // Jika pengguna belum login, redirect ke halaman login
            return redirect('/login')->with('loginError', 'Login Terlebih Dahulu');;
        }

        // Jika pengguna sudah login, lanjutkan ke request berikutnya
        return $next($request);
    }
}
