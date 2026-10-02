<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PengajuanIzin extends Model
{
    use HasFactory;

    protected $table = 'pengajuan_izin';

    protected $fillable = [
        'pegawai_id',
        'jenis',
        'tanggal_mulai',
        'tanggal_selesai',
        'alasan',
        'dokumen',
        'status',
        'catatan_admin',
        'tanggal_disetujui',
    ];

    protected function casts(): array
    {
        return [
            'tanggal_mulai'     => 'date',
            'tanggal_selesai'   => 'date',
            'tanggal_disetujui' => 'datetime',
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
