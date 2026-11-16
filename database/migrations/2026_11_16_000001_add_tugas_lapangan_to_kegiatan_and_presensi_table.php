<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('laporan_kegiatan', function (Blueprint $table) {
            if (!Schema::hasColumn('laporan_kegiatan', 'is_tugas_lapangan')) {
                $table->boolean('is_tugas_lapangan')->default(false)->after('surat_tugas');
            }
        });

        Schema::table('presensi', function (Blueprint $table) {
            if (!Schema::hasColumn('presensi', 'keterangan')) {
                $table->string('keterangan')->nullable()->after('status');
            }
        });
    }

    public function down(): void
    {
        Schema::table('laporan_kegiatan', function (Blueprint $table) {
            if (Schema::hasColumn('laporan_kegiatan', 'is_tugas_lapangan')) {
                $table->dropColumn('is_tugas_lapangan');
            }
        });

        Schema::table('presensi', function (Blueprint $table) {
            if (Schema::hasColumn('presensi', 'keterangan')) {
                $table->dropColumn('keterangan');
            }
        });
    }
};
