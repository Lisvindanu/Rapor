<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;

class RefKategoriPengaduan extends Model
{
    use HasFactory, HasUuids;

    protected $table = 'ref_kategori_pengaduan';

    /**
     * The primary key type
     */
    protected $keyType = 'string';
    
    /**
     * Indicates if the IDs are auto-incrementing
     */
    public $incrementing = false;

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'nama_kategori',
        'deskripsi',
    ];

    /**
     * The attributes that should be cast.
     */
    protected $casts = [
        // Hapus is_active cast karena kolom tidak ada
    ];

    /**
     * Get the pengaduan for the kategori.
     */
    public function pengaduan()
    {
        return $this->hasMany(Pengaduan::class, 'kategori_pengaduan_id');
    }

    /**
     * Scope a query to only include active categories.
     * (Disabled karena kolom is_active tidak ada)
     */
    public function scopeActive($query)
    {
        // Return semua data karena tidak ada kolom is_active
        return $query;
    }

    /**
     * Scope a query to order by name.
     */
    public function scopeOrderByName($query)
    {
        return $query->orderBy('nama_kategori');
    }

    /**
     * Get formatted name for display
     */
    public function getFormattedNameAttribute()
    {
        return ucfirst($this->nama_kategori);
    }

    /**
     * Get status label (disabled karena tidak ada kolom is_active)
     */
    public function getStatusLabelAttribute()
    {
        return 'Aktif'; // Default return
    }

    /**
     * Get status badge class (disabled karena tidak ada kolom is_active)
     */
    public function getStatusBadgeAttribute()
    {
        return 'badge-success'; // Default return
    }
}