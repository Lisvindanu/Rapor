<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;

class Pengaduan extends Model
{
    use HasFactory, HasUuids;

    /**
     * FIXED: Set the correct table name to match migration
     */
    protected $table = 'whistle_pengaduan';

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
        'judul_pengaduan',
        'uraian_pengaduan',
        'anonymous',
        'kode_pengaduan',
        'status_pengaduan',
        'kategori_pengaduan_id',
        'tanggal_pengaduan',
        'pelapor_id',
        'nama_pelapor',
        'email_pelapor',
        'status_pelapor',
        'cerita_singkat_peristiwa',
        'tanggal_kejadian',
        'lokasi_kejadian',
        'memiliki_disabilitas',
        'jenis_disabilitas',
        'alasan_pengaduan',
        'evidence_type',
        'evidence_gdrive_link'
    ];

    /**
     * The attributes that should be cast.
     */
    protected $casts = [
        'tanggal_pengaduan' => 'datetime',
        'tanggal_kejadian' => 'date',
        'anonymous' => 'boolean',
        'memiliki_disabilitas' => 'boolean',
        'alasan_pengaduan' => 'array',
    ];

    /**
     * Get the kategori that owns the pengaduan.
     */
    public function kategori()
    {
        return $this->belongsTo(RefKategoriPengaduan::class, 'kategori_pengaduan_id');
    }

    /**
     * Alternative relationship method untuk backward compatibility
     */
    public function refKategoriPengaduan()
    {
        return $this->belongsTo(RefKategoriPengaduan::class, 'kategori_pengaduan_id');
    }

    /**
     * Get the pelapor that owns the pengaduan.
     */
    public function pelapor()
    {
        return $this->belongsTo(User::class, 'pelapor_id');
    }

    /**
     * Get the terlapor for the pengaduan.
     */
    public function terlapor()
    {
        return $this->hasMany(PengaduanTerlapor::class, 'pengaduan_id');
    }

    /**
     * Scope a query to only include pengaduan by email.
     */
    public function scopeByEmail($query, $email)
    {
        return $query->where('email_pelapor', $email);
    }

    /**
     * Scope a query to only include pengaduan by status.
     */
    public function scopeByStatus($query, $status)
    {
        return $query->where('status_pengaduan', $status);
    }

    /**
     * Get status label attribute
     */
    public function getStatusLabelAttribute()
    {
        $labels = [
            'pending' => 'Menunggu',
            'proses' => 'Sedang Diproses',
            'selesai' => 'Selesai',
            'ditolak' => 'Ditolak',
            'butuh_bukti' => 'Butuh Bukti Tambahan',
            'dibatalkan' => 'Dibatalkan',
        ];

        return $labels[$this->status_pengaduan] ?? 'Unknown';
    }

    /**
     * Get status badge attribute for display
     */
    public function getStatusBadgeAttribute()
    {
        $badges = [
            'pending' => 'badge-warning',
            'proses' => 'badge-info',
            'selesai' => 'badge-success',
            'ditolak' => 'badge-danger',
            'butuh_bukti' => 'badge-secondary',
            'dibatalkan' => 'badge-dark',
        ];

        return $badges[$this->status_pengaduan] ?? 'badge-light';
    }

    /**
     * Check if pengaduan can be cancelled
     */
    public function canBeCancelled()
    {
        return in_array($this->status_pengaduan, ['pending', 'butuh_bukti']);
    }
}