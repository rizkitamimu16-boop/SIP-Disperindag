<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Pegawai;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use Illuminate\View\View;
use App\Mail\AccountCreated;
use App\Mail\AccountUpdated;
use App\Mail\PasswordReset;

class AdminPegawaiController extends Controller
{
    public function index(Request $request): View
    {
        $query = Pegawai::with('user')->latest();

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('nama', 'like', "%{$search}%")
                  ->orWhere('nip', 'like', "%{$search}%")
                  ->orWhere('jabatan', 'like', "%{$search}%");
            });
        }

        if ($request->filled('bidang') && in_array($request->bidang, Pegawai::BIDANG_RESMI)) {
            $query->where('bidang', $request->bidang);
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $pegawaiList = $query->get();

        return view('admin.data-pegawai', [
            'employees'   => $pegawaiList,
            'pegawaiList' => $pegawaiList,
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'nip'      => 'required|string|max:50|unique:pegawai,nip',
            'nama'     => 'required|string|max:255',
            'bidang'   => 'required|in:Perindustrian,Perdagangan,Sekretariat,Perlindungan Konsumen',
            'jabatan'  => 'required|string|max:255',
            'no_hp'    => 'nullable|string|max:20',
            'alamat'   => 'nullable|string',
            'email'    => 'required|email|unique:pengguna,email',
            'username' => 'nullable|string|max:100|unique:pengguna,username',
            'password' => 'nullable|string|min:6',
        ], [
            'nip.required'      => 'Nomor Induk Pegawai (NIP) wajib diisi.',
            'nip.unique'        => 'NIP tersebut sudah terdaftar di sistem.',
            'nama.required'     => 'Nama lengkap pegawai wajib diisi.',
            'bidang.required'   => 'Bidang kerja wajib dipilih.',
            'bidang.in'         => 'Bidang kerja harus salah satu dari 4 bidang resmi instansi.',
            'jabatan.required'  => 'Jabatan pegawai wajib diisi.',
            'email.required'    => 'Email kedinasan wajib diisi.',
            'email.unique'      => 'Email sudah terdaftar untuk pengguna lain.',
            'username.unique'   => 'Username sudah digunakan, silakan pilih username lain.',
            'password.min'      => 'Password minimal 6 karakter.',
        ]);

        // Buat data Pegawai
        $pegawai = Pegawai::create([
            'nip'     => $validated['nip'],
            'nama'    => $validated['nama'],
            'no_hp'   => $validated['no_hp'] ?? null,
            'jabatan' => $validated['jabatan'],
            'bidang'  => $validated['bidang'],
            'alamat'  => $validated['alamat'] ?? null,
            'status'  => 'Aktif',
        ]);

        // Tentukan username & password otomatis jika tidak diisi
        $username = !empty($validated['username']) 
            ? Str::slug($validated['username'], '_') 
            : Str::slug(explode(' ', $validated['nama'])[0], '') . '.' . substr(preg_replace('/\D/', '', $validated['nip']), -4);

        // Pastikan username unik
        $baseUsername = $username;
        $counter = 1;
        while (User::where('username', $username)->exists()) {
            $username = $baseUsername . $counter;
            $counter++;
        }

        $rawPassword = !empty($validated['password']) ? $validated['password'] : 'pegawai123';

        // Buat akun login Pengguna
        $user = User::create([
            'pegawai_id' => $pegawai->id,
            'nama'       => $validated['nama'],
            'username'   => $username,
            'email'      => $validated['email'],
            'password'   => Hash::make($rawPassword),
            'peran'      => 'pegawai',
            'status'     => 'aktif',
        ]);

        try {
            Mail::to($user->email)->send(new AccountCreated($user, $rawPassword));
        } catch (\Exception $e) {}

        return redirect()->route('admin.pegawai')->with('success', "Pegawai baru {$pegawai->nama} (NIP: {$pegawai->nip}) berhasil ditambahkan! Username: {$username}");
    }

    public function update(Request $request, int $id): RedirectResponse
    {
        $pegawai = Pegawai::with('user')->findOrFail($id);

        $validated = $request->validate([
            'nip'      => 'required|string|max:50|unique:pegawai,nip,' . $id,
            'nama'     => 'required|string|max:255',
            'bidang'   => 'required|in:Perindustrian,Perdagangan,Sekretariat,Perlindungan Konsumen',
            'jabatan'  => 'required|string|max:255',
            'no_hp'    => 'nullable|string|max:20',
            'alamat'   => 'nullable|string',
            'status'   => 'required|in:Aktif,Cuti',
            'email'    => 'required|email|unique:pengguna,email,' . ($pegawai->user ? $pegawai->user->id : 'NULL'),
        ], [
            'nip.required'      => 'Nomor Induk Pegawai (NIP) wajib diisi.',
            'nip.unique'        => 'NIP tersebut sudah terdaftar di sistem.',
            'nama.required'     => 'Nama lengkap pegawai wajib diisi.',
            'bidang.required'   => 'Bidang kerja wajib dipilih.',
            'bidang.in'         => 'Bidang kerja harus salah satu dari 4 bidang resmi instansi.',
            'jabatan.required'  => 'Jabatan pegawai wajib diisi.',
            'email.required'    => 'Email kedinasan wajib diisi.',
            'email.unique'      => 'Email sudah terdaftar untuk pengguna lain.',
        ]);

        $pegawai->update([
            'nip'     => $validated['nip'],
            'nama'    => $validated['nama'],
            'no_hp'   => $validated['no_hp'] ?? null,
            'jabatan' => $validated['jabatan'],
            'bidang'  => $validated['bidang'],
            'alamat'  => $validated['alamat'] ?? null,
            'status'  => $validated['status'],
        ]);

        if ($pegawai->user) {
            $oldEmail = $pegawai->user->email;
            $oldStatus = $pegawai->user->status;
            
            $pegawai->user->update([
                'nama'   => $validated['nama'],
                'email'  => $validated['email'],
                'status' => strtolower($validated['status']),
            ]);

            if ($oldEmail !== $validated['email'] || $oldStatus !== strtolower($validated['status'])) {
                try {
                    $desc = "Profil akun Anda (Email/Status) telah diubah oleh Admin.";
                    Mail::to($validated['email'])->send(new AccountUpdated($pegawai->user, $desc));
                } catch (\Exception $e) {}
            }
        }

        return redirect()->route('admin.pegawai')->with('success', "Data pegawai {$pegawai->nama} berhasil diperbarui.");
    }

    public function resetPassword(Request $request, int $id): RedirectResponse
    {
        $pegawai = Pegawai::with('user')->findOrFail($id);
        
        if (!$pegawai->user) {
            return redirect()->back()->with('error', 'Akun login untuk pegawai ini tidak ditemukan.');
        }

        $newPassword = 'pegawai123';
        $pegawai->user->update([
            'password' => Hash::make($newPassword),
        ]);

        try {
            Mail::to($pegawai->user->email)->send(new PasswordReset($pegawai->user, $newPassword));
        } catch (\Exception $e) {}

        return redirect()->route('admin.pegawai')->with('success', "Kata sandi untuk {$pegawai->nama} berhasil direset menjadi default: {$newPassword}");
    }

    public function destroy(int $id): RedirectResponse
    {
        $pegawai = Pegawai::findOrFail($id);
        $nama = $pegawai->nama;
        $pegawai->delete();

        return redirect()->route('admin.pegawai')->with('success', "Data pegawai {$nama} berhasil dihapus dari sistem.");
    }
}
