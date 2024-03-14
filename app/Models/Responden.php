<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;

class Responden extends Model
{
    use HasFactory, HasUuids;

    protected $table = 'responden_kuesionersdm';

    protected $fillable = [
        'id',
        'kuesioner_sdm_id',
        'pegawai_nip',
    ];

    public function kuesionerSDM()
    {
        return $this->belongsTo(KuesionerSDM::class, 'kuesioner_sdm_id', 'id');
    }

    public function pegawai()
    {
        return $this->belongsTo(Pegawai::class, 'pegawai_nip', 'nip');
    }
}
