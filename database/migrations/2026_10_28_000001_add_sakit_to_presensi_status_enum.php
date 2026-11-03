<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        if (DB::getDriverName() === 'mysql') {
            DB::statement("ALTER TABLE presensi MODIFY COLUMN status ENUM('Hadir', 'Terlambat', 'Alpha', 'Izin', 'Cuti', 'Dinas Luar', 'Sakit') NOT NULL DEFAULT 'Hadir'");
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (DB::getDriverName() === 'mysql') {
            DB::statement("ALTER TABLE presensi MODIFY COLUMN status ENUM('Hadir', 'Terlambat', 'Alpha', 'Izin', 'Cuti', 'Dinas Luar') NOT NULL DEFAULT 'Hadir'");
        }
    }
};
