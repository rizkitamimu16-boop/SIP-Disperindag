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
        // 1. Tabel Pengaturan Kantor
        Schema::create('pengaturan_kantor', function (Blueprint $table) {
            $table->id();
            $table->string('nama_instansi', 255)->default('Pemerintah Kota Gorontalo');
            $table->string('nama_skpd', 255)->default('Dinas Perindustrian dan Perdagangan Kota Gorontalo');
            $table->text('alamat_kantor')->nullable();
            $table->string('telepon_kantor', 50)->nullable();
            $table->decimal('latitude', 10, 7)->default(0.5375000);
            $table->decimal('longitude', 10, 7)->default(123.0625000);
            $table->integer('radius')->default(50); // Maks 50 meter geofencing
            $table->time('jam_masuk')->default('07:30:00');
            $table->time('batas_terlambat')->default('08:00:00');
            $table->time('batas_akhir_masuk')->default('11:00:00');
            $table->time('jam_pulang')->default('16:30:00');
            $table->time('batas_akhir_pulang')->default('19:00:00');
            $table->time('jam_pulang_jumat')->default('16:00:00');
            $table->decimal('bobot_kehadiran', 5, 2)->default(60.00);
            $table->decimal('bobot_produktivitas', 5, 2)->default(25.00);
            $table->decimal('bobot_kualitas', 5, 2)->default(15.00);
            $table->integer('ambang_sp1')->default(3);
            $table->integer('ambang_sp2')->default(6);
            $table->integer('ambang_sp3')->default(9);
            $table->string('pola_nomor_sp', 100)->default('800/{NO}/DISPERINDAG/2026');
            $table->text('template_sp')->nullable();
            $table->timestamps();
        });

        // 2. Tabel Presensi Harian
        Schema::create('presensi', function (Blueprint $table) {
            $table->id();
            $table->foreignId('pegawai_id')->constrained('pegawai')->cascadeOnDelete();
            $table->date('tanggal');
            $table->time('jam_masuk')->nullable();
            $table->enum('status_masuk', ['Tepat Waktu', 'Terlambat'])->nullable();
            $table->decimal('jarak_masuk', 8, 2)->nullable();
            $table->string('foto_masuk')->nullable();
            $table->time('jam_pulang')->nullable();
            $table->enum('status_pulang', ['Tepat Waktu', 'Pulang Cepat'])->nullable();
            $table->decimal('jarak_pulang', 8, 2)->nullable();
            $table->string('foto_pulang')->nullable();
            $table->enum('status', [
                'Hadir',
                'Terlambat',
                'Alpha',
                'Izin',
                'Cuti',
                'Dinas Luar'
            ])->default('Hadir');
            $table->timestamps();
        });

        // 3. Tabel Laporan Kegiatan Harian
        Schema::create('laporan_kegiatan', function (Blueprint $table) {
            $table->id();
            $table->foreignId('pegawai_id')->constrained('pegawai')->cascadeOnDelete();
            $table->date('tanggal');
            $table->string('nama_kegiatan', 255);
            $table->text('deskripsi');
            $table->string('foto')->nullable();
            $table->time('waktu_kirim')->nullable();
            $table->decimal('nilai_produktivitas', 5, 2)->default(0);
            $table->string('kategori_produktivitas', 50)->nullable();
            $table->decimal('nilai_kualitas', 5, 2)->default(0);
            $table->string('kategori_kualitas', 10)->nullable(); // A, B, C, D
            $table->text('catatan_kualitas')->nullable();
            $table->enum('status_verifikasi', [
                'Menunggu Review',
                'Disetujui',
                'Ditolak'
            ])->default('Menunggu Review');
            $table->timestamps();
        });

        // 4. Tabel Pengajuan Izin / Cuti
        Schema::create('pengajuan_izin', function (Blueprint $table) {
            $table->id();
            $table->foreignId('pegawai_id')->constrained('pegawai')->cascadeOnDelete();
            $table->enum('jenis', ['Izin', 'Cuti', 'Sakit', 'Dinas Luar']);
            $table->date('tanggal_mulai');
            $table->date('tanggal_selesai');
            $table->text('alasan');
            $table->string('dokumen')->nullable();
            $table->enum('status', [
                'Menunggu Review',
                'Disetujui',
                'Ditolak'
            ])->default('Menunggu Review');
            $table->text('catatan_admin')->nullable();
            $table->timestamp('tanggal_disetujui')->nullable();
            $table->timestamps();
        });

        // 5. Tabel Skor Kinerja Pegawai (IKP)
        Schema::create('skor_kinerja', function (Blueprint $table) {
            $table->id();
            $table->foreignId('pegawai_id')->constrained('pegawai')->cascadeOnDelete();
            $table->string('periode', 20); // Contoh: "2026-09"
            $table->decimal('nilai_kehadiran', 5, 2)->default(0);
            $table->decimal('nilai_produktivitas', 5, 2)->default(0);
            $table->decimal('nilai_kualitas', 5, 2)->default(0);
            $table->decimal('bobot_kehadiran', 5, 2)->default(60.00);
            $table->decimal('bobot_produktivitas', 5, 2)->default(25.00);
            $table->decimal('bobot_kualitas', 5, 2)->default(15.00);
            $table->decimal('nilai_akhir', 5, 2)->default(0);
            $table->enum('kategori', ['Sangat Baik', 'Baik', 'Cukup', 'Kurang'])->default('Baik');
            $table->enum('status', ['Final', 'Draft'])->default('Draft');
            $table->enum('rekomendasi_kontrak', [
                'Diperpanjang',
                'Dipertimbangkan',
                'Tidak Diperpanjang'
            ])->default('Diperpanjang');
            $table->timestamps();
        });

        // 6. Tabel Catatan Alpha (Pemicu SP)
        Schema::create('catatan_alpha', function (Blueprint $table) {
            $table->id();
            $table->foreignId('pegawai_id')->constrained('pegawai')->cascadeOnDelete();
            $table->date('tanggal');
            $table->string('alasan', 255)->nullable();
            $table->integer('siklus_sp')->default(1);
            $table->timestamps();
        });

        // 7. Tabel Surat Peringatan (SP)
        Schema::create('surat_peringatan', function (Blueprint $table) {
            $table->id();
            $table->foreignId('pegawai_id')->constrained('pegawai')->cascadeOnDelete();
            $table->enum('tingkat_sp', ['SP-1', 'SP-2', 'SP-3']);
            $table->integer('jumlah_alpha');
            $table->string('nomor_surat', 100);
            $table->date('tanggal_terbit');
            $table->string('dokumen')->nullable();
            $table->enum('status', ['Aktif', 'Selesai'])->default('Aktif');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('surat_peringatan');
        Schema::dropIfExists('catatan_alpha');
        Schema::dropIfExists('skor_kinerja');
        Schema::dropIfExists('pengajuan_izin');
        Schema::dropIfExists('laporan_kegiatan');
        Schema::dropIfExists('presensi');
        Schema::dropIfExists('pengaturan_kantor');
    }
};
