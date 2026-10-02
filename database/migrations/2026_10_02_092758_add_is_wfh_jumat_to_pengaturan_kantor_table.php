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
        Schema::table('pengaturan_kantor', function (Blueprint $table) {
            $table->boolean('is_wfh_jumat')->default(false)->after('jam_pulang_jumat');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('pengaturan_kantor', function (Blueprint $table) {
            $table->dropColumn('is_wfh_jumat');
        });
    }
};
