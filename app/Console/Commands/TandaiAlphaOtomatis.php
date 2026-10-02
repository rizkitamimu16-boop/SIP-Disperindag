<?php

namespace App\Console\Commands;

use Illuminate\Console\Attributes\Description;
use Illuminate\Console\Attributes\Signature;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use App\Models\Pegawai;
use App\Models\Presensi;
use App\Models\PengajuanIzin;
use Carbon\Carbon;

#[Signature('absensi:alpha')]
#[Description('Otomatisasi Alpha dengan API Hari Libur Nasional & pengecekan pengajuan izin')]
class TandaiAlphaOtomatis extends Command
{
    /**
     * Execute the console command.
     */
    public function handle()
    {
        $today = Carbon::today();
        $dateString = $today->toDateString();

        // 1. Pengecualian Akhir Pekan (Sabtu & Minggu)
        if ($today->isWeekend()) {
            $this->info("Hari ini akhir pekan ({$dateString}). Otomatisasi Alpha dilewati.");
            return;
        }

        // 2. Cek Tanggal Merah / Cuti Bersama via API
        try {
            // Memanggil API kalender libur Indonesia
            $response = Http::timeout(10)->get('https://api-harilibur.vercel.app/api', [
                'month' => $today->month,
                'year' => $today->year,
            ]);

            if ($response->successful()) {
                $holidays = $response->json();
                
                // Cari apakah tanggal hari ini ada di dalam daftar libur
                $isHoliday = collect($holidays)->firstWhere('holiday_date', $dateString);

                if ($isHoliday) {
                    $namaLibur = $isHoliday['holiday_name'] ?? 'Libur Nasional';
                    $this->info("Hari ini adalah hari libur: {$namaLibur}. Otomatisasi Alpha dilewati.");
                    Log::info("Otomatisasi Alpha di-skip karena hari libur: {$namaLibur}");
                    return; // Hentikan script
                }
            } else {
                Log::warning("Gagal menghubungi API Hari Libur. Status code: " . $response->status());
            }
        } catch (\Exception $e) {
            Log::error("Error saat memanggil API Hari Libur: " . $e->getMessage());
        }

        // 3. Eksekusi Penandaan Alpha
        $pegawais = Pegawai::where('status', 'aktif')->get();
        $countAlpha = 0;

        foreach ($pegawais as $pegawai) {
            // Cek apakah pegawai sudah absen
            $sudahAbsen = Presensi::where('pegawai_id', $pegawai->id)
                ->where('tanggal', $dateString)
                ->first();

            if ($sudahAbsen) {
                continue;
            }

            // Cek apakah sedang ada pengajuan izin/cuti/sakit yang masih 'Menunggu Review'
            $sedangMengajukanIzin = PengajuanIzin::where('pegawai_id', $pegawai->id)
                ->where('status', 'Menunggu Review')
                ->whereDate('tanggal_mulai', '<=', $today)
                ->whereDate('tanggal_selesai', '>=', $today)
                ->exists();

            if ($sedangMengajukanIzin) {
                continue; // Lewati karena menunggu keputusan admin
            }

            // Jika tidak absen dan tidak ada pengajuan tertunda
            Presensi::create([
                'pegawai_id' => $pegawai->id,
                'tanggal'    => $dateString,
                'status'     => 'Alpha'
            ]);
            
            $countAlpha++;
        }

        $this->info("Selesai! {$countAlpha} pegawai ditandai Alpha untuk tanggal {$dateString}.");
        Log::info("Otomatisasi Alpha berjalan. {$countAlpha} pegawai ditandai Alpha pada {$dateString}.");
    }
}
