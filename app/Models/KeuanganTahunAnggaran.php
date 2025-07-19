<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Carbon\Carbon;

class KeuanganTahunAnggaran extends Model
{
    use HasFactory, HasUuids;

    protected $table = 'keuangan_tahun_anggaran';

    protected $fillable = [
        'tahun_anggaran',
        'tgl_awal_anggaran',
        'tgl_akhir_anggaran'
    ];

    protected $casts = [
        'tgl_awal_anggaran' => 'date',
        'tgl_akhir_anggaran' => 'date'
    ];

    /**
     * Scope untuk filter berdasarkan tahun
     */
    public function scopeByTahun($query, $tahun)
    {
        return $query->where('tahun_anggaran', 'LIKE', "%{$tahun}%");
    }

    /**
     * Scope untuk tahun anggaran aktif
     */
    public function scopeAktif($query)
    {
        $today = Carbon::now()->format('Y-m-d');
        return $query->where('tgl_awal_anggaran', '<=', $today)
            ->where('tgl_akhir_anggaran', '>=', $today);
    }

    /**
     * Accessor untuk format periode lengkap
     */
    public function getPeriodeLengkapAttribute()
    {
        return $this->tgl_awal_anggaran->format('d M Y') . ' - ' .
            $this->tgl_akhir_anggaran->format('d M Y');
    }

    /**
     * Accessor untuk durasi dalam hari
     */
    public function getDurasiHariAttribute()
    {
        return $this->tgl_awal_anggaran->diffInDays($this->tgl_akhir_anggaran) + 1;
    }

    /**
     * Cek apakah tahun anggaran sedang aktif
     */
    public function getIsAktifAttribute()
    {
        $today = Carbon::now();
        return $today->between($this->tgl_awal_anggaran, $this->tgl_akhir_anggaran);
    }

    /**
     * Get status tahun anggaran
     */
    public function getStatusAttribute()
    {
        $today = Carbon::now();

        if ($today < $this->tgl_awal_anggaran) {
            return 'Belum Dimulai';
        } elseif ($today > $this->tgl_akhir_anggaran) {
            return 'Selesai';
        } else {
            return 'Aktif';
        }
    }

    /**
     * Get status class untuk badge
     */
    public function getStatusClassAttribute()
    {
        switch ($this->status) {
            case 'Aktif':
                return 'success';
            case 'Belum Dimulai':
                return 'warning';
            case 'Selesai':
                return 'secondary';
            default:
                return 'info';
        }
    }
}
