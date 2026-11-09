<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('laporan_kegiatan', function (Blueprint $table) {
            if (!Schema::hasColumn('laporan_kegiatan', 'surat_tugas')) {
                $table->string('surat_tugas')->nullable()->after('foto');
            }
        });
    }

    public function down(): void
    {
        Schema::table('laporan_kegiatan', function (Blueprint $table) {
            if (Schema::hasColumn('laporan_kegiatan', 'surat_tugas')) {
                $table->dropColumn('surat_tugas');
            }
        });
    }
};

