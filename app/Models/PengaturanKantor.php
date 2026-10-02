<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PengaturanKantor extends Model
{
    use HasFactory;

    protected $table = 'pengaturan_kantor';

    protected $fillable = [
        'nama_instansi',
        'nama_skpd',
        'alamat_kantor',
        'telepon_kantor',
        'titik_koordinat',
        'radius_absensi_meter',
        'jam_masuk',
        'batas_terlambat',
        'batas_akhir_masuk',
        'jam_pulang',
        'batas_akhir_pulang',
        'jam_pulang_jumat',
        'bobot_kehadiran',
        'bobot_produktivitas',
        'bobot_kualitas',
        'ambang_sp1',
        'ambang_sp2',
        'ambang_sp3',
        'pola_nomor_sp',
        'template_sp',
        'is_wfh_jumat',
    ];

    protected function casts(): array
    {
        return [
            'radius_absensi_meter' => 'integer',
            'bobot_kehadiran'     => 'float',
            'bobot_produktivitas' => 'float',
            'bobot_kualitas'      => 'float',
            'ambang_sp1'          => 'integer',
            'ambang_sp2'          => 'integer',
            'ambang_sp3'          => 'integer',
            'is_wfh_jumat'        => 'boolean',
        ];
    }

    public static function getPengaturan(): self
    {
        return self::firstOrCreate(
            ['id' => 1],
            [
                'nama_instansi'       => 'Pemerintah Kota Gorontalo',
                'nama_skpd'           => 'Dinas Perindustrian dan Perdagangan Kota Gorontalo',
                'alamat_kantor'       => 'Jl. Jend. Sudirman No. 24, Kota Gorontalo',
                'telepon_kantor'      => '(0435) 821-456',
                'titik_koordinat'     => '0.5375000,123.0625000',
                'radius_absensi_meter'=> 50,
                'jam_masuk'           => '07:30:00',
                'batas_terlambat'     => '08:00:00',
                'batas_akhir_masuk'   => '11:00:00',
                'jam_pulang'          => '16:30:00',
                'batas_akhir_pulang'  => '19:00:00',
                'jam_pulang_jumat'    => '16:00:00',
                'bobot_kehadiran'     => 60.00,
                'bobot_produktivitas' => 25.00,
                'bobot_kualitas'      => 15.00,
                'ambang_sp1'          => 3,
                'ambang_sp2'          => 6,
                'ambang_sp3'          => 9,
                'pola_nomor_sp'       => '800/{NO}/DISPERINDAG/2026',
                'template_sp'         => 'Berdasarkan rekapitulasi kehadiran, Saudara telah mengakumulasi ketidakhadiran tanpa keterangan sah...',
                'is_wfh_jumat'        => false,
            ]
        );
    }
}
