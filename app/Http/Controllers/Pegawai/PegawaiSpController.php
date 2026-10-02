<?php

namespace App\Http\Controllers\Pegawai;

use App\Http\Controllers\Controller;
use App\Models\CatatanAlpha;
use App\Models\SuratPeringatan;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class PegawaiSpController extends Controller
{
    public function index(): View
    {
        $employee = Auth::user()->pegawai;
        $spCount = 0;
        $alphaCount = 0;
        $spLetters = collect();

        if ($employee) {
            $alphaCount = \App\Models\Presensi::where('pegawai_id', $employee->id)
                ->where('status', 'Alpha')
                ->count();
            $spLetters = SuratPeringatan::where('pegawai_id', $employee->id)
                ->where('status', 'Aktif')
                ->latest()
                ->get();
            $spCount = $spLetters->count();
        }

        return view('pegawai.pelanggaran-sp', compact('employee', 'spCount', 'alphaCount', 'spLetters'));
    }
}
