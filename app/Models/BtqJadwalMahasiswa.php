<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Concerns\HasUuids;

class BtqJadwalMahasiswa extends Model
{
    use HasFactory, SoftDeletes, HasUuids;

    protected $table = 'btq_jadwal_mahasiswa';

    // Kolom yang bisa diisi (fillable)
    protected $fillable = [
        'jadwal_id',
        'mahasiswa_id',
        'nilai_bacaan',
        'nilai_tulisan',
        'nilai_hafalan',
        'lampiran',
    ];

    // Relasi ke tabel 'btq_jadwal'
    public function jadwal()
    {
        return $this->belongsTo(BtqJadwal::class, 'jadwal_id', 'id');
    }

    // Relasi ke tabel 'mahasiswa'
    public function mahasiswa()
    {
        return $this->belongsTo(Mahasiswa::class, 'mahasiswa_id', 'nim');
    }
}
