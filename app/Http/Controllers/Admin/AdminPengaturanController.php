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
        $user = auth()->user();
        if ($user && $user->isKabid()) {
            abort(403, 'Kepala Bidang tidak memiliki wewenang untuk mengakses pengaturan sistem.');
        }

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
        $user = auth()->user();
        if (!$user || $user->isKabid()) {
            return back()->withErrors(['error' => 'Anda tidak memiliki wewenang untuk memperbarui konfigurasi sistem kantor.']);
        }

        $pengaturan = PengaturanKantor::getPengaturan();

        // Validasi penjumlahan bobot harus 100% jika diisi
        if ($request->has('bobot_kehadiran') && $request->has('bobot_produktivitas') && $request->has('bobot_kualitas')) {
            $totalBobot = floatval($request->bobot_kehadiran) + floatval($request->bobot_produktivitas) + floatval($request->bobot_kualitas);
            if (abs($totalBobot - 100.0) > 0.01) {
                return back()->withInput()->with('error', "Total akumulasi bobot IKP harus tepat 100%. Saat ini totalnya: {$totalBobot}%.");
            }
        }

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

        return back()->with('success', 'Konfigurasi parameter sistem Disperindag berhasil diperbarui!');
    }

    public function storeAdmin(Request $request): RedirectResponse
    {
        $user = auth()->user();
        if (!$user || $user->isKabid()) {
            return back()->withErrors(['error' => 'Anda tidak memiliki wewenang untuk menambahkan akun administrator baru.']);
        }

        $validated = $request->validate([
            'nama'     => 'required|string|max:255',
            'username' => 'required|string|max:100|unique:pengguna,username',
            'email'    => 'required|email|unique:pengguna,email',
            'password' => 'required|string|min:6',
            'bidang'   => 'nullable|string|in:Perindustrian,Perdagangan,Sekretariat,Perlindungan Konsumen',
        ], [
            'nama.required'     => 'Nama lengkap administrator wajib diisi.',
            'username.required' => 'Username login administrator wajib diisi.',
            'username.unique'   => 'Username ini sudah terdaftar di sistem.',
            'email.required'    => 'Email kedinasan wajib diisi.',
            'email.unique'      => 'Email sudah terdaftar untuk pengguna lain.',
            'password.min'      => 'Kata sandi minimal 6 karakter.',
            'bidang.in'         => 'Bidang harus salah satu dari 4 bidang resmi instansi atau dikosongkan untuk Administrator Global.',
        ]);

        User::create([
            'nama'     => $validated['nama'],
            'username' => $validated['username'],
            'email'    => $validated['email'],
            'password' => Hash::make($validated['password']),
            'peran'    => 'admin',
            'bidang'   => !empty($validated['bidang']) ? $validated['bidang'] : null,
            'status'   => 'aktif',
        ]);

        $roleText = !empty($validated['bidang']) ? "Kepala Bidang {$validated['bidang']}" : "Administrator Global";
        return back()->with('success', "Akun {$roleText} '{$validated['nama']}' berhasil ditambahkan ke sistem.");
    }

    public function updateAdmin(Request $request, int $id): RedirectResponse
    {
        $user = auth()->user();
        if (!$user || $user->isKabid()) {
            return back()->withErrors(['error' => 'Anda tidak memiliki wewenang untuk mengubah akun administrator.']);
        }

        $admin = User::where('peran', 'admin')->findOrFail($id);

        $validated = $request->validate([
            'nama'     => 'required|string|max:255',
            'username' => 'required|string|max:100|unique:pengguna,username,' . $id,
            'email'    => 'required|email|unique:pengguna,email,' . $id,
            'password' => 'nullable|string|min:6',
            'bidang'   => 'nullable|string|in:Perindustrian,Perdagangan,Sekretariat,Perlindungan Konsumen',
            'status'   => 'required|in:aktif,nonaktif',
        ], [
            'nama.required'     => 'Nama lengkap administrator wajib diisi.',
            'username.required' => 'Username login administrator wajib diisi.',
            'username.unique'   => 'Username ini sudah terdaftar di sistem.',
            'email.required'    => 'Email kedinasan wajib diisi.',
            'email.unique'      => 'Email sudah terdaftar untuk pengguna lain.',
            'password.min'      => 'Kata sandi minimal 6 karakter.',
            'bidang.in'         => 'Bidang harus salah satu dari 4 bidang resmi instansi atau dikosongkan.',
        ]);

        $admin->nama = $validated['nama'];
        $admin->username = $validated['username'];
        $admin->email = $validated['email'];
        $admin->bidang = !empty($validated['bidang']) ? $validated['bidang'] : null;
        $admin->status = $validated['status'];

        if (!empty($validated['password'])) {
            $admin->password = Hash::make($validated['password']);
        }

        $admin->save();

        return back()->with('success', "Akun Administrator '{$admin->nama}' berhasil diperbarui.");
    }

    public function destroyAdmin(int $id): RedirectResponse
    {
        $user = auth()->user();
        if (!$user || !$user->isSuperAdmin()) {
            return back()->withErrors(['error' => 'Hanya Administrator Utama (Super Admin) yang berhak menghapus akun admin lain.']);
        }

        $admin = User::where('peran', 'admin')->findOrFail($id);
        
        if ($user->id === $admin->id) {
            return back()->withErrors(['error' => 'Anda tidak dapat menghapus akun Anda sendiri.']);
        }
        
        $nama = $admin->nama;
        $admin->delete();
        
        return back()->with('success', "Akun Administrator '{$nama}' berhasil dihapus.");
    }
}
