<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;

class Krs extends Model
{
    use HasFactory, HasUuids;

    protected $table = 'krs';

    protected $fillable = [
        'id',
        'idperiode',
        'namakelas',
        'nim',
        'idmk',
        'namamk',
        'jenismatakuliah',
        'sksmk',
        'skspraktikum',
        'skstatapmuka',
        'skssimulasi',
        'skspraktlap',
        'nnumerik',
        'nangka',
        'nhuruf',
        'krsdiajukan',
        'krsdisetujui'
    ];
}
