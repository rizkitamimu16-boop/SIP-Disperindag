<?php

namespace App\Http\Controllers\Pegawai;

use App\Http\Controllers\Controller;
use App\Models\PengaturanKantor;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\View\View;
use App\Mail\AccountUpdated;

class PegawaiProfilController extends Controller
{
    public function index(): View
    {
        $user = Auth::user();
        $employee = $user->pegawai;
        $officeSettings = PengaturanKantor::getPengaturan();

        return view('pegawai.profil', compact('user', 'employee', 'officeSettings'));
    }

    public function update(Request $request): RedirectResponse
    {
        $user = Auth::user();
        $employee = $user->pegawai;

        $validated = $request->validate([
            'no_hp'    => 'nullable|string|max:20',
            'alamat'   => 'nullable|string',
            'password' => 'nullable|string|min:6|confirmed',
        ]);

        if ($employee) {
            $employee->update([
                'no_hp'  => $validated['no_hp'] ?? $employee->no_hp,
                'alamat' => $validated['alamat'] ?? $employee->alamat,
            ]);
        }

        if (!empty($validated['password'])) {
            $user->update([
                'password' => Hash::make($validated['password']),
            ]);

            try {
                $desc = "Anda baru saja mengubah password akun Anda. Jika Anda tidak merasa melakukannya, segera lapor ke Administrator!";
                Mail::to($user->email)->send(new AccountUpdated($user, $desc));
            } catch (\Exception $e) {}
        }

        return back()->with('success', 'Profil dan data diri berhasil diperbarui.');
    }
}
