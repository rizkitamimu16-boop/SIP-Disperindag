<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CatatanAlpha extends Model
{
    use HasFactory;

    protected $table = 'catatan_alpha';

    protected $fillable = [
        'pegawai_id',
        'tanggal',
        'alasan',
        'siklus_sp',
    ];

    protected function casts(): array
    {
        return [
            'tanggal'   => 'date',
            'siklus_sp' => 'integer',
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
