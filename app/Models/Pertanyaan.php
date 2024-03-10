<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;

class Pertanyaan extends Model
{
    use HasFactory, HasUuids;

    protected $table = 'pertanyaan';

    protected $fillable = [
        'id',
        'soal_id',
        'pertanyaan',
        'jawaban_benar',
        'opsi_a',
        'opsi_b',
        'opsi_c',
        'opsi_d',
        'opsi_e',
        'tipe',
    ];

    public function soal()
    {
        return $this->belongsTo(Soal::class, 'soal_id', 'id');
    }
}
