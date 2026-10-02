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
}
