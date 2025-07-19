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
        'kontak_terlapor',
    ];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * Relationship dengan Pengaduan
     */
    public function pengaduan()
    {
        return $this->belongsTo(Pengaduan::class, 'pengaduan_id');
    }

    /**
     * Accessor untuk status terlapor yang lebih readable
     */
    public function getStatusTerlaporLabelAttribute()
    {
        $labels = [
            'mahasiswa' => 'Mahasiswa',
            'pegawai' => 'Pegawai/Dosen',
        ];

        return $labels[$this->status_terlapor] ?? ucfirst($this->status_terlapor);
    }

    /**
     * Accessor untuk badge status terlapor
     */
    public function getStatusTerlaporBadgeAttribute()
    {
        $badges = [
            'mahasiswa' => 'bg-primary',
            'pegawai' => 'bg-success',
        ];

        return $badges[$this->status_terlapor] ?? 'bg-secondary';
    }

    /**
     * Scope untuk filter berdasarkan status
     */
    public function scopeByStatus($query, $status)
    {
        return $query->where('status_terlapor', $status);
    }

    /**
     * Scope untuk filter mahasiswa
     */
    public function scopeMahasiswa($query)
    {
        return $query->where('status_terlapor', 'mahasiswa');
    }

    /**
     * Scope untuk filter pegawai
     */
    public function scopePegawai($query)
    {
        return $query->where('status_terlapor', 'pegawai');
    }
}