<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PengaduanTerlapor extends Model
{
    /**
     * The table associated with the model.
     */
    protected $table = 'pengaduan_terlapor';

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'pengaduan_id',
        'nama_terlapor',
        'status_terlapor',
        'nomor_identitas',
        'unit_kerja_fakultas',
        'kontak_terlapor',
    ];

    /**
     * The attributes that should be cast.
     */
    protected $casts = [
        'pengaduan_id' => 'string', // Karena foreign key ke UUID
    ];

    /**
     * Get the pengaduan that owns the terlapor.
     */
    public function pengaduan()
    {
        return $this->belongsTo(Pengaduan::class, 'pengaduan_id');
    }

    /**
     * Get status label attribute
     */
    public function getStatusLabelAttribute()
    {
        $labels = [
            'mahasiswa' => 'Mahasiswa',
            'pegawai' => 'Pegawai/Staff',
        ];

        return $labels[$this->status_terlapor] ?? 'Unknown';
    }

    /**
     * Get formatted identity number
     */
    public function getFormattedIdentityAttribute()
    {
        if ($this->nomor_identitas) {
            $prefix = $this->status_terlapor === 'mahasiswa' ? 'NIM: ' : 'NIP: ';
            return $prefix . $this->nomor_identitas;
        }
        
        return 'Tidak tersedia';
    }
}