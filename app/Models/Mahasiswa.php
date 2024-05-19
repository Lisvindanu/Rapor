<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Mahasiswa extends Model
{
    use HasFactory, HasUuids;

    protected $table = 'mahasiswa';

    protected $fillable = [
        'id',
        'agama',
        'alamat',
        'email',
        'emailkampus',
        'gelombang',
        'jalurpendaftaran',
        'jeniskelamin',
        'kelasperkuliahan',
        'konsentrasi',
        'nama',
        'namaibu',
        'nik',
        'nim',
        'nohp',
        'periodemasuk',
        'programstudi',
        'sistemkuliah',
        'statusmahasiswa',
        'tanggallahir',
        'tempatlahir'
    ];
}
