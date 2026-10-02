<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PengaturanKantor;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\View\View;

class AdminPengaturanController extends Controller
{
    public function index(): View
    {
        $pengaturan = PengaturanKantor::getPengaturan();
        $adminUsers = User::where('peran', 'admin')->latest()->get();

        return view('admin.pengaturan-sistem', [
            'officeSettings' => $pengaturan,
            'pengaturan'     => $pengaturan,
            'adminUsers'     => $adminUsers,
        ]);
    }

    public function update(Request $request): RedirectResponse
    {
        $pengaturan = PengaturanKantor::getPengaturan();

        $pengaturan->update($request->only([
            'nama_skpd',
            'nama_instansi',
            'alamat_kantor',
            'telepon_kantor',
            'titik_koordinat',
            'radius_absensi_meter',
            'jam_masuk',
            'batas_terlambat',
            'batas_akhir_masuk',
            'jam_pulang',
            'batas_akhir_pulang',
            'jam_pulang_jumat',
            'bobot_kehadiran',
            'bobot_produktivitas',
            'bobot_kualitas',
            'ambang_sp1',
            'ambang_sp2',
            'ambang_sp3',
            'pola_nomor_sp',
            'template_sp',
        ]));
        
        $pengaturan->is_wfh_jumat = $request->has('is_wfh_jumat');
        $pengaturan->save();

        return back()->with('success', 'Konfigurasi parameter sistem Disperindag berhasil diperbarui ke database!');
    }

    public function storeAdmin(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'nama'     => 'required|string|max:255',
            'username' => 'required|string|max:100|unique:pengguna,username',
            'email'    => 'required|email|unique:pengguna,email',
            'password' => 'required|string|min:6',
        ], [
            'nama.required'     => 'Nama lengkap administrator wajib diisi.',
            'username.required' => 'Username login administrator wajib diisi.',
            'username.unique'   => 'Username ini sudah terdaftar di sistem.',
            'email.required'    => 'Email kedinasan wajib diisi.',
            'email.unique'      => 'Email sudah terdaftar untuk pengguna lain.',
            'password.min'      => 'Kata sandi minimal 6 karakter.',
        ]);

        User::create([
            'nama'     => $validated['nama'],
            'username' => $validated['username'],
            'email'    => $validated['email'],
            'password' => Hash::make($validated['password']),
            'peran'    => 'admin',
            'status'   => 'aktif',
        ]);

        return back()->with('success', "Akun Administrator baru '{$validated['nama']}' berhasil ditambahkan ke sistem.");
    }

    public function updateAdmin(Request $request, int $id): RedirectResponse
    {
        $admin = User::where('peran', 'admin')->findOrFail($id);

        $validated = $request->validate([
            'nama'     => 'required|string|max:255',
            'username' => 'required|string|max:100|unique:pengguna,username,' . $id,
            'email'    => 'required|email|unique:pengguna,email,' . $id,
            'password' => 'nullable|string|min:6',
            'status'   => 'required|in:aktif,nonaktif',
        ], [
            'nama.required'     => 'Nama lengkap administrator wajib diisi.',
            'username.required' => 'Username login administrator wajib diisi.',
            'username.unique'   => 'Username ini sudah terdaftar di sistem.',
            'email.required'    => 'Email kedinasan wajib diisi.',
            'email.unique'      => 'Email sudah terdaftar untuk pengguna lain.',
            'password.min'      => 'Kata sandi minimal 6 karakter.',
        ]);

        $admin->nama = $validated['nama'];
        $admin->username = $validated['username'];
        $admin->email = $validated['email'];
        $admin->status = $validated['status'];

        if (!empty($validated['password'])) {
            $admin->password = Hash::make($validated['password']);
        }

        $admin->save();

        return back()->with('success', "Akun Administrator '{$admin->nama}' berhasil diperbarui.");
    }

    public function destroyAdmin(int $id): \Illuminate\Http\RedirectResponse
    {
        if (auth()->id() !== 1) {
            return back()->withErrors(['error' => 'Hanya Administrator Utama yang berhak menghapus akun admin lain.']);
        }

        $admin = \App\Models\User::where('peran', 'admin')->findOrFail($id);
        
        if (auth()->id() === $admin->id) {
            return back()->withErrors(['error' => 'Anda tidak dapat menghapus akun Anda sendiri.']);
        }
        
        $nama = $admin->nama;
        $admin->delete();
        
        return back()->with('success', "Akun Administrator '{$nama}' berhasil dihapus.");
    }
}