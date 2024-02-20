<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;

class Rapor extends Model
{
    use HasFactory, HasUuids;

    protected $table = 'rapor_kinerja_v1';

    protected $fillable = [
        'id',
        'periode_rapor',
        'dosen_nip',
        'bkd_pendidikan',
        'bkd_penelitian',
        'bkd_ppm',
        'bkd_penunjangan',
        'bkd_kewajibankhusus',
        'edom_materipembelajaran',
        'edom_pengelolaankelas',
        'edom_prosespengajaran',
        'edom_penilaian',
        'edasep_atasan',
        'edasep_sejawat',
        'edasep_bawahan',
    ];
}
