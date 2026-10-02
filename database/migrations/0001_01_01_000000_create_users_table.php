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
        // 1. Tabel Pegawai (Biodata Resmi Pegawai PPPK)
        Schema::create('pegawai', function (Blueprint $table) {
            $table->id();
            $table->string('nip', 50)->unique(); // Nomor Induk Pegawai
            $table->string('nama', 255);
            $table->string('no_hp', 20)->nullable();
            $table->string('jabatan', 255);
            $table->enum('bidang', [
                'Perindustrian',
                'Perdagangan',
                'Sekretariat',
                'Perlindungan Konsumen'
            ]); // 4 Bidang Resmi Instansi
            $table->text('alamat')->nullable();
            $table->string('foto')->nullable();
            $table->enum('status', ['Aktif', 'Cuti'])->default('Aktif');
            $table->timestamps();
        });

        // 2. Tabel Pengguna (Akun Login & Hak Akses Sistem)
        Schema::create('pengguna', function (Blueprint $table) {
            $table->id();
            $table->foreignId('pegawai_id')->nullable()->constrained('pegawai')->cascadeOnDelete();
            $table->string('nama', 255);
            $table->string('username', 100)->unique();
            $table->string('email', 150)->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->enum('peran', ['admin', 'pegawai'])->default('pegawai');
            $table->enum('status', ['aktif', 'nonaktif'])->default('aktif');
            $table->rememberToken();
            $table->timestamps();
        });

        Schema::create('password_reset_tokens', function (Blueprint $table) {
            $table->string('email')->primary();
            $table->string('token');
            $table->timestamp('created_at')->nullable();
        });

        Schema::create('sessions', function (Blueprint $table) {
            $table->string('id')->primary();
            $table->foreignId('user_id')->nullable()->index();
            $table->string('ip_address', 45)->nullable();
            $table->text('user_agent')->nullable();
            $table->longText('payload');
            $table->integer('last_activity')->index();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sessions');
        Schema::dropIfExists('password_reset_tokens');
        Schema::dropIfExists('pengguna');
        Schema::dropIfExists('pegawai');
    }
};
