<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Pegawai extends Model
{
    use HasFactory;

    protected $table = 'pegawai';

    // 4 Bidang Resmi Instansi Disperindag Kota Gorontalo (PRD Bab 65.2)
    public const BIDANG_RESMI = [
        'Perindustrian',
        'Perdagangan',
        'Sekretariat',
        'Perlindungan Konsumen'
    ];

    // Alias konstanta lama untuk kompatibilitas
    public const DEPARTMENTS = self::BIDANG_RESMI;

    protected $fillable = [
        'nip',
        'nama',
        'no_hp',
        'jabatan',
        'bidang',
        'alamat',
        'foto',
        'status',
    ];

    public function user(): HasOne
    {
        return $this->hasOne(User::class, 'pegawai_id');
    }

    public function presensi(): HasMany
    {
        return $this->hasMany(Presensi::class, 'pegawai_id');
    }

    public function laporanKegiatan(): HasMany
    {
        return $this->hasMany(LaporanKegiatan::class, 'pegawai_id');
    }

    public function pengajuanIzin(): HasMany
    {
        return $this->hasMany(PengajuanIzin::class, 'pegawai_id');
    }

    public function skorKinerja(): HasMany
    {
        return $this->hasMany(SkorKinerja::class, 'pegawai_id');
    }

    public function catatanAlpha(): HasMany
    {
        return $this->hasMany(CatatanAlpha::class, 'pegawai_id');
    }

    public function suratPeringatan(): HasMany
    {
        return $this->hasMany(SuratPeringatan::class, 'pegawai_id');
    }

    // Accessor kompatibilitas bahasa
    public function getNameAttribute(): string
    {
        return $this->nama ?? '';
    }

    public function getEmployeeNumberAttribute(): string
    {
        return $this->nip ?? '';
    }

    public function getDepartmentAttribute(): string
    {
        return $this->bidang ?? '';
    }

    public function getPositionAttribute(): string
    {
        return $this->jabatan ?? '';
    }
}
