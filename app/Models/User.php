<?php

namespace App\Models;

use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable;

    protected $table = 'pengguna';

    protected $fillable = [
        'pegawai_id',
        'nama',
        'username',
        'email',
        'password',
        'peran',
        'status',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    /**
     * Relasi ke biodata Pegawai PPPK
     */
    public function pegawai(): BelongsTo
    {
        return $this->belongsTo(Pegawai::class, 'pegawai_id');
    }

    // Alias untuk kompatibilitas
    public function employee(): BelongsTo
    {
        return $this->pegawai();
    }

    // Accessor untuk backward compatibility jika dipanggil ->role
    public function getRoleAttribute(): string
    {
        return $this->peran ?? 'pegawai';
    }

    // Accessor untuk backward compatibility jika dipanggil ->name
    public function getNameAttribute(): string
    {
        return $this->nama ?? '';
    }

    public function isAdmin(): bool
    {
        return $this->peran === 'admin';
    }

    public function isPegawai(): bool
    {
        return $this->peran === 'pegawai';
    }
}
