<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class LaporanKegiatan extends Model
{
    use HasFactory;

    protected $table = 'laporan_kegiatan';

    protected $fillable = [
        'pegawai_id',
        'tanggal',
        'nama_kegiatan',
        'deskripsi',
        'foto',
        'waktu_kirim',
        'nilai_produktivitas',
        'kategori_produktivitas',
        'nilai_kualitas',
        'kategori_kualitas',
        'catatan_kualitas',
        'status_verifikasi',
    ];

    protected function casts(): array
    {
        return [
            'tanggal'             => 'date',
            'nilai_produktivitas' => 'float',
            'nilai_kualitas'      => 'float',
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
}
