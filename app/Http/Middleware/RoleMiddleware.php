<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class RoleMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, string $role): Response
    {
        // Jika belum login, arahkan ke login
        if (!Auth::check()) {
            return redirect()->route('login')->withErrors([
                'auth' => 'Silakan masuk terlebih dahulu untuk mengakses halaman ini.'
            ]);
        }

        $user = Auth::user();

        // Cek status akun
        if ($user->status !== 'aktif') {
            Auth::logout();
            $request->session()->invalidate();
            $request->session()->regenerateToken();

            return redirect()->route('login')->withErrors([
                'auth' => 'Akun Anda saat ini dinonaktifkan. Hubungi Administrator.'
            ]);
        }

        // Cek kecocokan role
        if ($user->role !== $role) {
            // Arahkan ke dashboard yang sesuai dengan peran pengguna
            if ($user->role === 'admin') {
                return redirect()->route('admin.dashboard');
            } elseif ($user->role === 'pegawai') {
                return redirect()->route('pegawai.dashboard');
            }

            abort(403, 'Akses tidak diizinkan untuk peran ini.');
        }

        return $next($request);
    }
}
