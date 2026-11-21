<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PengaturanKantor;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class AdminProfilController extends Controller
{
    public function index(): View
    {
        $user = Auth::user();
        $officeSettings = PengaturanKantor::getPengaturan();

        return view('admin.profil', compact('user', 'officeSettings'));
    }

    public function update(Request $request): RedirectResponse
    {
        $user = Auth::user();

        $validated = $request->validate([
            'nama'     => 'required|string|max:255',
            'email'    => 'required|email|unique:pengguna,email,' . $user->id,
            'no_hp'    => 'nullable|string|max:20',
            'password' => 'nullable|string|min:6|confirmed',
            'foto'     => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
        ], [
            'nama.required'      => 'Nama lengkap wajib diisi.',
            'email.required'     => 'Email kedinasan wajib diisi.',
            'email.unique'       => 'Email tersebut sudah terdaftar untuk pengguna lain.',
            'password.min'       => 'Kata sandi baru minimal 6 karakter.',
            'password.confirmed' => 'Konfirmasi kata sandi baru tidak cocok.',
            'foto.image'         => 'Berkas foto profil harus berformat gambar.',
            'foto.max'           => 'Ukuran foto profil maksimal 2 MB.',
        ]);

        $updateData = [
            'nama'  => $validated['nama'],
            'email' => $validated['email'],
            'no_hp' => $validated['no_hp'] ?? null,
        ];

        // Jika upload foto baru
        if ($request->hasFile('foto')) {
            if ($user->foto && Storage::disk('public')->exists($user->foto)) {
                Storage::disk('public')->delete($user->foto);
            }
            $updateData['foto'] = $request->file('foto')->store('admin-photos', 'public');
        }

        // Jika ubah kata sandi
        if (!empty($validated['password'])) {
            $updateData['password'] = Hash::make($validated['password']);
        }

        $user->update($updateData);

        return back()->with('success', 'Profil dan informasi akun dinas Anda berhasil diperbarui.');
    }
}
