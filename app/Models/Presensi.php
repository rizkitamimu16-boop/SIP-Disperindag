<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Presensi extends Model
{
    use HasFactory;

    protected $table = 'presensi';

    protected $fillable = [
        'pegawai_id',
        'tanggal',
        'jam_masuk',
        'status_masuk',
        'jarak_masuk',
        'foto_masuk',
        'jam_pulang',
        'status_pulang',
        'jarak_pulang',
        'foto_pulang',
        'status',
    ];

    protected function casts(): array
    {
        return [
            'tanggal'      => 'date',
            'jarak_masuk'  => 'float',
            'jarak_pulang' => 'float',
        ];
    }

    public function pegawai(): BelongsTo
    {
        return $this->belongsTo(Pegawai::class, 'pegawai_id');
    }

    // Alias kompatibilitas
    public function employee(): BelongsTo
    {
        return $this->pegawai();
    }
}
