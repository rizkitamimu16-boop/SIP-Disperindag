<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Str;
use Carbon\Carbon;
use App\Models\PengajuanIzin;
use App\Models\LaporanKegiatan;
use App\Models\SuratPeringatan;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        if ($this->app->environment('production')) {
            URL::forceScheme('https');
        }

        // View Composer untuk Lonceng Notifikasi di Header (Admin & Pegawai)
        View::composer(['components.header', 'components.notification-bell'], function ($view) {
            if (!Auth::check()) {
                $view->with(['notifCount' => 0, 'notifItems' => []]);
                return;
            }

            $user = Auth::user();
            $notifItems = [];

            try {
                if ($user->peran === 'admin') {
                    // 1. Pengajuan Izin / Cuti / Sakit yang menunggu review
                    $izins = PengajuanIzin::with('pegawai')
                        ->where('status', 'Menunggu Review')
                        ->latest()
                        ->take(5)
                        ->get();
                    foreach ($izins as $izin) {
                        $notifItems[] = [
                            'type'  => 'izin',
                            'title' => 'Pengajuan ' . $izin->jenis,
                            'desc'  => ($izin->pegawai->nama ?? 'Pegawai') . ' mengajukan dispensasi (' . $izin->jenis . ')',
                            'time'  => $izin->created_at ? $izin->created_at->diffForHumans() : 'Baru saja',
                            'url'   => route('admin.persetujuan'),
                            'icon'  => 'calendar',
                            'color' => 'blue',
                        ];
                    }

                    // 2. Laporan Kegiatan yang menunggu verifikasi
                    $kegiatans = LaporanKegiatan::with('pegawai')
                        ->where('status_verifikasi', 'Menunggu Review')
                        ->latest()
                        ->take(5)
                        ->get();
                    foreach ($kegiatans as $keg) {
                        $notifItems[] = [
                            'type'  => 'kegiatan',
                            'title' => 'Verifikasi Laporan',
                            'desc'  => ($keg->pegawai->nama ?? 'Pegawai') . ' mengirim laporan: ' . Str::limit($keg->nama_kegiatan, 28),
                            'time'  => $keg->created_at ? $keg->created_at->diffForHumans() : 'Baru saja',
                            'url'   => route('admin.kegiatan'),
                            'icon'  => 'clipboard',
                            'color' => 'emerald',
                        ];
                    }

                    // 3. Draf SP baru yang belum bernomor
                    $sps = SuratPeringatan::with('pegawai')
                        ->where(function($q) {
                            $q->whereNull('nomor_surat')->orWhere('nomor_surat', '');
                        })
                        ->latest()
                        ->take(5)
                        ->get();
                    foreach ($sps as $sp) {
                        $notifItems[] = [
                            'type'  => 'sp',
                            'title' => 'Draf ' . $sp->tingkat_sp,
                            'desc'  => ($sp->pegawai->nama ?? 'Pegawai') . ' terdeteksi ' . $sp->jumlah_alpha . ' kali Alpha',
                            'time'  => $sp->created_at ? $sp->created_at->diffForHumans() : 'Baru saja',
                            'url'   => route('admin.sp'),
                            'icon'  => 'alert',
                            'color' => 'amber',
                        ];
                    }
                } elseif ($user->peran === 'pegawai' && $user->pegawai) {
                    $pegawaiId = $user->pegawai->id;

                    // 1. Status pengajuan izin yang sudah diproses admin
                    $izins = PengajuanIzin::where('pegawai_id', $pegawaiId)
                        ->where('status', '!=', 'Menunggu Review')
                        ->latest()
                        ->take(4)
                        ->get();
                    foreach ($izins as $izin) {
                        $isApproved = $izin->status === 'Disetujui';
                        $notifItems[] = [
                            'type'  => 'izin',
                            'title' => 'Pengajuan ' . $izin->status,
                            'desc'  => 'Permohonan ' . $izin->jenis . ' Anda telah ' . strtolower($izin->status) . ' oleh Admin',
                            'time'  => $izin->updated_at ? $izin->updated_at->diffForHumans() : 'Baru saja',
                            'url'   => route('pegawai.pengajuan'),
                            'icon'  => $isApproved ? 'check' : 'x',
                            'color' => $isApproved ? 'emerald' : 'rose',
                        ];
                    }

                    // 2. Status verifikasi laporan kegiatan
                    $kegiatans = LaporanKegiatan::where('pegawai_id', $pegawaiId)
                        ->where('status_verifikasi', '!=', 'Menunggu Review')
                        ->latest()
                        ->take(4)
                        ->get();
                    foreach ($kegiatans as $keg) {
                        $isApproved = $keg->status_verifikasi === 'Disetujui';
                        $notifItems[] = [
                            'type'  => 'kegiatan',
                            'title' => 'Laporan ' . $keg->status_verifikasi,
                            'desc'  => Str::limit($keg->nama_kegiatan, 24) . ($isApproved ? ' (Nilai: ' . $keg->nilai_kualitas . ')' : ''),
                            'time'  => $keg->updated_at ? $keg->updated_at->diffForHumans() : 'Baru saja',
                            'url'   => route('pegawai.kegiatan'),
                            'icon'  => $isApproved ? 'check' : 'x',
                            'color' => $isApproved ? 'emerald' : 'rose',
                        ];
                    }

                    // 3. Surat Peringatan aktif yang telah diterbitkan
                    $sps = SuratPeringatan::where('pegawai_id', $pegawaiId)
                        ->whereNotNull('nomor_surat')
                        ->where('nomor_surat', '!=', '')
                        ->where('status', 'Aktif')
                        ->latest()
                        ->take(3)
                        ->get();
                    foreach ($sps as $sp) {
                        $notifItems[] = [
                            'type'  => 'sp',
                            'title' => 'Surat Peringatan: ' . $sp->tingkat_sp,
                            'desc'  => 'No: ' . $sp->nomor_surat . ' telah resmi diterbitkan',
                            'time'  => $sp->tanggal_terbit ? Carbon::parse($sp->tanggal_terbit)->diffForHumans() : 'Baru saja',
                            'url'   => route('pegawai.sp'),
                            'icon'  => 'alert',
                            'color' => 'red',
                        ];
                    }
                }
            } catch (\Exception $e) {
                // Jangan sampai error notifikasi menghentikan rendering halaman utama
            }

            $notifCount = count($notifItems);
            $view->with(compact('notifCount', 'notifItems'));
        });
    }
}
