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
        'bidang',
        'no_hp',
        'foto',
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

    /**
     * Cek apakah akun adalah Super Administrator utama
     */
    public function isSuperAdmin(): bool
    {
        return $this->id === 1 || ($this->peran === 'admin' && empty($this->bidang) && $this->username === 'admin');
    }

    /**
     * Cek apakah akun adalah Kepala Bidang (Admin dengan scope bidang tertentu)
     */
    public function isKabid(): bool
    {
        return $this->peran === 'admin' && !empty($this->bidang);
    }

    /**
     * Accessor untuk nama bidang/departemen
     */
    public function getDepartmentAttribute(): string
    {
        if ($this->isKabid()) {
            return 'Kepala Bidang ' . $this->bidang;
        }

        if ($this->isSuperAdmin()) {
            return 'Super Administrator';
        }

        if ($this->isAdmin()) {
            return 'Admin Kepegawaian';
        }

        return $this->pegawai->bidang ?? 'Pegawai';
    }

    /**
     * URL Foto Avatar
     */
    public function getAvatarUrlAttribute(): string
    {
        if (!empty($this->foto) && \Illuminate\Support\Facades\Storage::disk('public')->exists($this->foto)) {
            return asset('storage/' . $this->foto);
        }
        if ($this->pegawai && !empty($this->pegawai->foto) && \Illuminate\Support\Facades\Storage::disk('public')->exists($this->pegawai->foto)) {
            return asset('storage/' . $this->pegawai->foto);
        }
        return '';
    }
}
