<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PengaduanTerlapor extends Model
{
    use HasFactory;

    protected $table = 'pengaduan_terlapor';

    protected $fillable = [
        'pengaduan_id',
        'nama_terlapor',
        'status_terlapor',
        'nomor_identitas',
        'unit_kerja_fakultas',
        'kontak_terlapor'
    ];

    /**
     * Relasi dengan Pengaduan
     */
    public function pengaduan()
    {
        return $this->belongsTo(Pengaduan::class);
    }

    /**
     * Scope untuk terlapor mahasiswa
     */
    public function scopeMahasiswa($query)
    {
        return $query->where('status_terlapor', 'mahasiswa');
    }

    /**
     * Scope untuk terlapor pegawai
     */
    public function scopePegawai($query)
    {
        return $query->where('status_terlapor', 'pegawai');
    }

    /**
     * Accessor untuk mendapatkan label status terlapor
     */
    public function getStatusLabelAttribute()
    {
        return $this->status_terlapor === 'mahasiswa' ? 'Mahasiswa' : 'Pegawai';
    }
}