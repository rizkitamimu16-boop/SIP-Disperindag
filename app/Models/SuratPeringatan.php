<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class SuratPeringatan extends Model
{
    use HasFactory;

    protected $table = 'surat_peringatan';

    protected $fillable = [
        'pegawai_id',
        'tingkat_sp',
        'jumlah_alpha',
        'nomor_surat',
        'tanggal_terbit',
        'dokumen',
        'status',
    ];

    protected function casts(): array
    {
        return [
            'tanggal_terbit' => 'date',
            'jumlah_alpha'   => 'integer',
        ];
    }

    public function pegawai(): BelongsTo
    {
        return $this->belongsTo(Pegawai::class, 'pegawai_id');
    }

    public function employee(): BelongsTo
    {
        return $this->pegawai();
    }

    public function getIsDraftAttribute(): bool
    {
        return empty($this->nomor_surat);
    }

    public function getIsTerbitAttribute(): bool
    {
        return !empty($this->nomor_surat);
    }

    /**
     * Sinkronisasi draf SP semiotomatis berdasarkan akumulasi Alpha pegawai
     */
    public static function syncDraftSpForPegawai(Pegawai $pegawai): ?self
    {
        $office = PengaturanKantor::getPengaturan();
        $ambangSp1 = $office->ambang_sp1 ?? 3;
        $ambangSp2 = $office->ambang_sp2 ?? 6;
        $ambangSp3 = $office->ambang_sp3 ?? 9;

        $alphaCount = Presensi::where('pegawai_id', $pegawai->id)
            ->where('status', 'Alpha')
            ->count();

        $tingkatSp = null;
        if ($alphaCount >= $ambangSp3) {
            $tingkatSp = 'SP-3';
        } elseif ($alphaCount >= $ambangSp2) {
            $tingkatSp = 'SP-2';
        } elseif ($alphaCount >= $ambangSp1) {
            $tingkatSp = 'SP-1';
        }

        if (!$tingkatSp) {
            return null;
        }

        // Cek apakah draf atau surat terbit untuk tingkat ini sudah ada
        $existing = self::where('pegawai_id', $pegawai->id)
            ->where('tingkat_sp', $tingkatSp)
            ->first();

        if ($existing) {
            if (empty($existing->nomor_surat) && $existing->jumlah_alpha !== $alphaCount) {
                $existing->update(['jumlah_alpha' => $alphaCount]);
            }
            return $existing;
        }

        return self::create([
            'pegawai_id'     => $pegawai->id,
            'tingkat_sp'     => $tingkatSp,
            'jumlah_alpha'   => $alphaCount,
            'nomor_surat'    => '', // Draf menunggu penomoran Admin
            'tanggal_terbit' => now()->toDateString(),
            'status'         => 'Aktif',
        ]);
    }

    /**
     * Sinkronisasi seluruh pegawai aktif yang mencapai ambang batas SP
     */
    public static function syncAllDrafts(): void
    {
        $pegawais = Pegawai::where('status', 'Aktif')->get();
        foreach ($pegawais as $pegawai) {
            self::syncDraftSpForPegawai($pegawai);
        }
    }
}

