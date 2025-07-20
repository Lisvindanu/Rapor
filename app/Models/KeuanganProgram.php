<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;

class KeuanganProgram extends Model
{
    use HasFactory, HasUuids;

    protected $table = 'keuangan_program';

    protected $fillable = [
        'nama_program'
    ];

    /**
     * Scope untuk filter berdasarkan nama
     */
    public function scopeByNama($query, $nama)
    {
        return $query->where('nama_program', 'LIKE', "%{$nama}%");
    }

    /**
     * Accessor untuk format nama yang rapi
     */
    public function getNamaProgramCapitalizedAttribute()
    {
        return ucwords(strtolower($this->nama_program));
    }

    /**
     * Get badge class berdasarkan nama program
     */
    public function getBadgeClassAttribute()
    {
        $program = strtolower($this->nama_program);

        if (str_contains($program, 'reguler pagi')) {
            return 'success';
        } elseif (str_contains($program, 'reguler sore')) {
            return 'warning';
        } elseif (str_contains($program, 'kerja sama')) {
            return 'info';
        } else {
            return 'primary';
        }
    }

    /**
     * Get icon berdasarkan nama program
     */
    public function getIconAttribute()
    {
        $program = strtolower($this->nama_program);

        if (str_contains($program, 'reguler pagi')) {
            return 'sun';
        } elseif (str_contains($program, 'reguler sore')) {
            return 'moon';
        } elseif (str_contains($program, 'kerja sama')) {
            return 'handshake';
        } else {
            return 'graduation-cap';
        }
    }
}
