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
        'status_pelapor',
        'cerita_singkat_peristiwa',
        'tanggal_kejadian',
        'lokasi_kejadian',
        'memiliki_disabilitas',
        'jenis_disabilitas',
        'alasan_pengaduan',
        'tanggal_pengaduan',
        'status_pengaduan',
        'is_anonim',
        'evidence_path',
        'evidence_type',
        'evidence_gdrive_link',
        'admin_response',
        'handled_by',
        'closed_at'
    ];

    protected $casts = [
        'tanggal_pengaduan' => 'datetime',
        'tanggal_kejadian' => 'date',
        'is_anonim' => 'boolean',
        'memiliki_disabilitas' => 'boolean',
        'alasan_pengaduan' => 'array', // Cast JSON ke array
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
     * Relasi dengan Terlapor (One to Many)
     */
    public function terlapor()
    {
        return $this->hasMany(\App\Models\PengaduanTerlapor::class);
    }

    /**
     * Relasi dengan Admin yang menangani
     */
    public function handler()
    {
        return $this->belongsTo(User::class, 'handled_by');
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
     * Scope untuk pengaduan yang bisa dibatalkan
     */
    public function scopeCanBeCancelled($query)
    {
        return $query->whereIn('status_pengaduan', ['pending', 'butuh_bukti']);
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
            'ditolak' => 'danger',
            'butuh_bukti' => 'secondary',
            'dibatalkan' => 'dark'
        ];

        return $colors[$this->status_pengaduan] ?? 'secondary';
    }

    /**
     * Get status label
     */
    public function getStatusLabelAttribute()
    {
        $labels = [
            'pending' => 'Menunggu',
            'proses' => 'Sedang Diproses', 
            'selesai' => 'Selesai',
            'ditolak' => 'Ditolak',
            'butuh_bukti' => 'Butuh Bukti Tambahan',
            'dibatalkan' => 'Dibatalkan'
        ];

        return $labels[$this->status_pengaduan] ?? 'Unknown';
    }

    /**
     * Get alasan pengaduan labels
     */
    public function getAlasanPengaduanLabelsAttribute()
    {
        $options = [
            'saksi_khawatir' => 'Saya seorang saksi yang khawatir dengan keadaan Korban',
            'korban_bantuan' => 'Saya seorang Korban yang memerlukan bantuan pemulihan',
            'tindak_tegas' => 'Saya ingin Perguruan Tinggi menindak tegas Terlapor',
            'dokumentasi_keamanan' => 'Saya ingin Satuan Tugas mendokumentasikan kejadiannya, meningkatkan keamanan Perguruan Tinggi dari Kekerasan, dan memberi pelindungan bagi saya',
            'lainnya' => 'Lainnya'
        ];

        if (!$this->alasan_pengaduan) {
            return [];
        }

        return array_map(function($alasan) use ($options) {
            return $options[$alasan] ?? $alasan;
        }, $this->alasan_pengaduan);
    }

    /**
     * Check if pengaduan can be cancelled
     */
    public function canBeCancelled()
    {
        return in_array($this->status_pengaduan, ['pending', 'butuh_bukti']);
    }

    /**
     * Check if evidence is required
     */
    public function needsEvidence()
    {
        return empty($this->evidence_path) && empty($this->evidence_gdrive_link);
    }
}