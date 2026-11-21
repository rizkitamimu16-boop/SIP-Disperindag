<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('pengguna', function (Blueprint $table) {
            if (!Schema::hasColumn('pengguna', 'bidang')) {
                $table->string('bidang', 50)->nullable()->after('peran');
            }
            if (!Schema::hasColumn('pengguna', 'no_hp')) {
                $table->string('no_hp', 20)->nullable()->after('email');
            }
            if (!Schema::hasColumn('pengguna', 'foto')) {
                $table->string('foto', 255)->nullable()->after('no_hp');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('pengguna', function (Blueprint $table) {
            if (Schema::hasColumn('pengguna', 'foto')) {
                $table->dropColumn('foto');
            }
            if (Schema::hasColumn('pengguna', 'no_hp')) {
                $table->dropColumn('no_hp');
            }
            if (Schema::hasColumn('pengguna', 'bidang')) {
                $table->dropColumn('bidang');
            }
        });
    }
};
