<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;

class Pegawai extends Model
{
    use HasFactory, HasUuids;

    protected $table = 'pegawai';

    protected $fillable = [
        'id',
        'nama',
        'nip',
        'nidn',
        'nik',
        'npwp',
        'pangkat',
        'jabatan_fungsional',
        'jenis_pegawai',
        'jk',
        'agama',
        'tempat_lahir',
        'tanggal_lahir',
        'email',
        'no_hp',
        'unit_kerja_id',
    ];

    public function unitKerja()
    {
        return $this->belongsTo(UnitKerja::class, 'unit_kerja_id', 'id');
    }

    public function dosen()
    {
        return $this->hasOne(Dosen::class, 'pegawai_id', 'id');
    }
}
