<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;


class RemedialAjuanDetail extends Model
{
    use HasFactory, HasUuids;

    protected $table = 'remedial_ajuan_detail';

    protected $fillable = [
        'id',
        'remedial_ajuan_id',
        'kode_periode',
        'krs_id',
        'idmk',
        'namakelas',
        'harga_remedial',
        'status_ajuan'
    ];

    //remedialAjuan
    public function remedialajuan()
    {
        return $this->belongsTo(RemedialAjuan::class, 'remedial_ajuan_id', 'id');
    }

    // kelas kuliah
    public function kelasKuliah()
    {
        return $this->belongsTo(KelasKuliah::class, 'idmk', 'kodemk')
            ->where('namakelas', $this->namakelas)
            ->where('periodeakademik', $this->kode_periode);
    }

    // krs
    public function krs()
    {
        return $this->belongsTo(Krs::class, 'krs_id', 'id');
    }
}
