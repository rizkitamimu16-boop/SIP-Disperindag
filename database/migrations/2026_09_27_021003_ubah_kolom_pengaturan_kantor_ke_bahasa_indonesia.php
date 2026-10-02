<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('pengaturan_kantor', function (Blueprint $table) {
            $table->string('titik_koordinat', 255)->default('0.5375000,123.0625000')->after('telepon_kantor');
            $table->renameColumn('radius', 'radius_absensi_meter');
        });

        // Copy existing lat/long data to new column before dropping using Query Builder for SQLite compatibility
        $pengaturan = DB::table('pengaturan_kantor')->get();
        foreach ($pengaturan as $p) {
            DB::table('pengaturan_kantor')
                ->where('id', $p->id)
                ->update(['titik_koordinat' => $p->latitude . ',' . $p->longitude]);
        }

        Schema::table('pengaturan_kantor', function (Blueprint $table) {
            $table->dropColumn(['latitude', 'longitude']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('pengaturan_kantor', function (Blueprint $table) {
            $table->decimal('latitude', 10, 7)->default(0.5375000)->after('telepon_kantor');
            $table->decimal('longitude', 10, 7)->default(123.0625000)->after('latitude');
        });

        // Try to revert back data using PHP loop for SQLite compatibility
        $pengaturan = DB::table('pengaturan_kantor')->get();
        foreach ($pengaturan as $p) {
            $coords = explode(',', $p->titik_koordinat);
            DB::table('pengaturan_kantor')
                ->where('id', $p->id)
                ->update([
                    'latitude' => $coords[0] ?? 0.5375000,
                    'longitude' => $coords[1] ?? 123.0625000
                ]);
        }

        Schema::table('pengaturan_kantor', function (Blueprint $table) {
            $table->dropColumn('titik_koordinat');
            $table->renameColumn('radius_absensi_meter', 'radius');
        });
    }
};
