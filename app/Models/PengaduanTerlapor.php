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

    /**
     * Get the pengaduan that owns the terlapor.
     */
    public function pengaduan()
    {
        return $this->belongsTo(Pengaduan::class, 'pengaduan_id');
    }

    /**
     * Get status terlapor label
     */
    public function getStatusTerlaporLabelAttribute()
    {
        $labels = [
            'mahasiswa' => 'Mahasiswa',
            'pegawai' => 'Pegawai',
        ];

        return $labels[$this->status_terlapor] ?? 'Unknown';
    }
}