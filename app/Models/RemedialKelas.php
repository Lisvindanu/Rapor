<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;

class RemedialKelas extends Model
{
    use HasFactory, HasUuids;

    protected $table = 'remedial_kelas';

    protected $fillable = [
        'id',
        'remedial_periode_id',
        'programstudi',
        'kodemk',
        'nip',
        'kode_edlink',
    ];

    //remedialperiode
    public function remedialperiode()
    {
        return $this->belongsTo(RemedialPeriode::class, 'remedial_periode_id', 'id');
    }
}
