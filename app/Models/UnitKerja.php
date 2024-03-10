<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UnitKerja extends Model
{
    use HasFactory, HasUuids;

    protected $table = 'unit_kerja';

    protected $fillable = [
        'id',
        'kode_unit',
        'nama_unit',
        'nama_unit_en',
        'nama_singkat',
        'parent_unit',
        'jenis_unit',
        'tk_pendidikan',
        'alamat',
        'telepon',
        'website',
        'alamat_email',
        'akreditasi',
        'no_sk_akreditasi',
        'tanggal_akreditasi',
        'no_sk_pendirian',
        'tanggal_sk_pendirian',
        'gedung',
        'akademik',
        'status_aktif',
    ];

    public function parentUnit()
    {
        return $this->belongsTo(UnitKerja::class, 'parent_unit', 'id');
    }

    public function childUnit()
    {
        return $this->hasMany(UnitKerja::class, 'parent_unit', 'id');
    }

    public function childrenRecursive()
    {
        return $this->hasMany(UnitKerja::class, 'parent_unit', 'id')->with('childrenRecursive');
    }
}
