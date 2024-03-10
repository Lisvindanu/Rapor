<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;

class Soal extends Model
{
    use HasFactory, HasUuids;

    protected $table = 'soal';

    protected $fillable = [
        'id',
        'nama_soal',
        'keterangan',
        'soal_acak',
        'publik',
    ];

    public function pertanyaan()
    {
        return $this->hasMany(Pertanyaan::class);
    }
}
