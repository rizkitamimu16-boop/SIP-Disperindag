<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use App\Models\Presensi;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Bersihkan data presensi pada hari akhir pekan (Sabtu & Minggu)
        // karena kantor Dinas Perindag beroperasi 5 hari kerja (Senin - Jumat)
        if (DB::getDriverName() === 'mysql') {
            DB::statement("DELETE FROM presensi WHERE DAYOFWEEK(tanggal) IN (1, 7)");
        } else {
            Presensi::all()->filter(fn($p) => \Carbon\Carbon::parse($p->tanggal)->isWeekend())->each->delete();
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Tidak perlu rollback karena data akhir pekan adalah data tidak valid
    }
};
