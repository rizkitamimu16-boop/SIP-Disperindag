<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schedule;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');

// JADWAL OTOMATISASI ALPHA
// Berjalan otomatis setiap hari kerja (Senin - Jumat) jam 12:00 WITA
Schedule::command('absensi:alpha')
    ->timezone('Asia/Makassar')
    ->weekdays()
    ->dailyAt('12:00');
