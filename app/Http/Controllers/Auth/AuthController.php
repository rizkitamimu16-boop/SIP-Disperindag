<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\View\View;

class AuthController extends Controller
{
    /**
     * Tampilkan halaman formulir login.
     */
    public function showLoginForm(): View|RedirectResponse
    {
        // Jika sudah login, arahkan langsung ke dashboard masing-masing
        if (Auth::check()) {
            $user = Auth::user();
            if ($user->role === 'admin') {
                return redirect()->route('admin.dashboard');
            } elseif ($user->role === 'pegawai') {
                return redirect()->route('pegawai.dashboard');
            }
        }

        return view('auth.login');
    }

    /**
     * Proses autentikasi pengguna ke database MySQL.
     */
    public function login(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'username' => 'required|string',
            'password' => 'required|string',
            'role'     => 'nullable|string|in:admin,pegawai',
        ], [
            'username.required' => 'Username wajib diisi.',
            'password.required' => 'Kata sandi wajib diisi.',
        ]);

        $username = trim($validated['username']);
        $password = $validated['password'];
        $selectedRole = $validated['role'] ?? null;

        // Cari pengguna berdasarkan username atau email
        $user = User::where('username', $username)
            ->orWhere('email', $username)
            ->first();

        // 1. Validasi keberadaan akun dan kecocokan kata sandi hash
        if (!$user || !Hash::check($password, $user->password)) {
            return back()->withErrors([
                'login' => 'Username atau kata sandi yang Anda masukkan salah.'
            ])->withInput($request->only('username', 'role'));
        }

        // 2. Validasi status keaktifan akun
        if ($user->status !== 'aktif') {
            return back()->withErrors([
                'login' => 'Akun Anda saat ini dinonaktifkan oleh administrator.'
            ])->withInput($request->only('username', 'role'));
        }

        // 3. Validasi kesesuaian role yang dipilih (jika pengguna memilih tab peran tertentu)
        if ($selectedRole && $user->role !== $selectedRole) {
            $roleLabel = ($selectedRole === 'admin') ? 'Administrator' : 'Pegawai PPPK';
            return back()->withErrors([
                'login' => "Akun ini terdaftar sebagai " . strtoupper($user->role) . ", bukan {$roleLabel}."
            ])->withInput($request->only('username', 'role'));
        }

        // 4. Autentikasi sesi resmi Laravel
        Auth::login($user, $request->boolean('remember'));
        Auth::logoutOtherDevices($password);
        if ($request->hasSession()) {
            $request->session()->regenerate();
        }

        // 5. Arahkan pengguna ke panel yang sesuai
        if ($user->role === 'admin') {
            return redirect()->intended(route('admin.dashboard'));
        }

        return redirect()->intended(route('pegawai.dashboard'));
    }

    /**
     * Proses logout dan pembersihan sesi.
     */
    public function logout(Request $request): RedirectResponse
    {
        Auth::logout();
        if ($request->hasSession()) {
            $request->session()->invalidate();
            $request->session()->regenerateToken();
        }

        return redirect()->route('login')->with('success', 'Anda telah berhasil keluar dari sistem.');
    }
}
