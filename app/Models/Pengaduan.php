<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pengaduan extends Model
{
    use HasFactory;

    protected $table = 'pengaduan';

    protected $fillable = [
        'user_id',
        'kategori_id',
        'kode_pengaduan',
        'judul_pengaduan',
        'deskripsi_pengaduan',
        'tanggal_pengaduan',
        'status_pengaduan',
        'is_anonim',
        'evidence_path',
        'admin_response',
        'handled_by',
        'closed_at'
    ];

    protected $casts = [
        'tanggal_pengaduan' => 'datetime',
        'is_anonim' => 'boolean',
        'closed_at' => 'datetime'
    ];

    /**
     * Relasi dengan User (Pelapor)
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Relasi dengan Kategori
     */
    public function kategori()
    {
        return $this->belongsTo(KategoriPengaduan::class, 'kategori_id');
    }

    /**
     * Relasi dengan Admin yang menangani
     */
    public function handler()
    {
        return $this->belongsTo(User::class, 'handled_by');
    }

    /**
     * Relasi ke unit kerja melalui user -> pegawai -> unit_kerja
     */
    public function unitKerja()
    {
        return $this->hasOneThrough(
            UnitKerja::class,
            User::class,
            'id', // Foreign key pada users table
            'id', // Foreign key pada unit_kerja table  
            'user_id', // Local key pada pengaduan table
            'key_relation' // Local key yang menghubungkan ke pegawai
        )->join('pegawai', 'users.key_relation', '=', 'pegawai.nip')
          ->where('unit_kerja.id', '=', 'pegawai.unit_kerja_id');
    }

    /**
     * Scope untuk pengaduan berdasarkan status
     */
    public function scopeByStatus($query, $status)
    {
        return $query->where('status_pengaduan', $status);
    }

    /**
     * Scope untuk pengaduan prioritas (pending > 3 hari)
     */
    public function scopePrioritas($query)
    {
        return $query->where('status_pengaduan', 'pending')
                     ->where('created_at', '<', now()->subDays(3));
    }

    /**
     * Scope untuk pengaduan hari ini
     */
    public function scopeHariIni($query)
    {
        return $query->whereDate('created_at', today());
    }

    /**
     * Scope untuk pengaduan minggu ini
     */
    public function scopeMingguIni($query)
    {
        return $query->whereBetween('created_at', [
            now()->startOfWeek(),
            now()->endOfWeek()
        ]);
    }

    /**
     * Get status badge color
     */
    public function getStatusBadgeAttribute()
    {
        $colors = [
            'pending' => 'warning',
            'proses' => 'info', 
            'selesai' => 'success',
            'ditolak' => 'danger'
        ];

        return $colors[$this->status_pengaduan] ?? 'secondary';
    }

    /**
     * Get status text
     */
    public function getStatusTextAttribute()
    {
        $texts = [
            'pending' => 'Menunggu Review',
            'proses' => 'Dalam Proses',
            'selesai' => 'Selesai',
            'ditolak' => 'Ditolak'
        ];

        return $texts[$this->status_pengaduan] ?? 'Unknown';
    }

    /**
     * Check if pengaduan is prioritas
     */
    public function getIsPrioritasAttribute()
    {
        return $this->status_pengaduan === 'pending' && 
               $this->created_at->lt(now()->subDays(3));
    }
}