<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class Pengaduan extends Model
{
    use HasFactory;

    protected $table = 'pengaduan';

    protected $fillable = [
        'kode_pengaduan',
        'nama_pelapor',
        'email_pelapor',
        'kategori_pengaduan_id',
        'judul_pengaduan',
        'deskripsi_pengaduan',
        'status_pelapor',
        'cerita_singkat_peristiwa',
        'tanggal_kejadian',
        'lokasi_kejadian',
        'memiliki_disabilitas',
        'jenis_disabilitas',
        'alasan_pengaduan',
        'evidence_type',
        'evidence_path',
        'evidence_gdrive_link',
        'status_pengaduan',
        'tanggal_pengaduan',
        'keterangan_admin',
        'submit_anonim',
        'is_prioritas',
    ];

    protected $casts = [
        'tanggal_pengaduan' => 'datetime',
        'tanggal_kejadian' => 'date',
        'memiliki_disabilitas' => 'boolean',
        'submit_anonim' => 'boolean',
        'is_prioritas' => 'boolean',
        'alasan_pengaduan' => 'array',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            if (empty($model->kode_pengaduan)) {
                $model->kode_pengaduan = 'WB-' . date('Ymd') . '-' . str_pad(rand(1, 9999), 4, '0', STR_PAD_LEFT);
            }
        });
    }

    /**
     * Relationship dengan Kategori Pengaduan
     */
    public function refKategoriPengaduan()
    {
        return $this->belongsTo(\Illuminate\Database\Eloquent\Model::class, 'kategori_pengaduan_id')
            ->from('ref_kategori_pengaduan');
    }

    /**
     * Alternative method untuk kategori (backward compatibility)
     */
    public function kategoriPengaduan()
    {
        return $this->refKategoriPengaduan();
    }

    /**
     * Relationship dengan Terlapor
     */
    public function terlapor()
    {
        return $this->hasMany(PengaduanTerlapor::class, 'pengaduan_id');
    }

    /**
     * Relationship dengan User (Pelapor)
     */
    public function pelapor()
    {
        return $this->belongsTo(User::class, 'email_pelapor', 'email');
    }

    /**
     * Accessor untuk status pengaduan yang lebih readable
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

        return $labels[$this->status_pengaduan] ?? ucfirst($this->status_pengaduan);
    }

    /**
     * Accessor untuk badge status pengaduan
     */
    public function getStatusBadgeAttribute()
    {
        $badges = [
            'pending' => 'bg-warning text-dark',
            'proses' => 'bg-info text-white',
            'selesai' => 'bg-success text-white',
            'ditolak' => 'bg-danger text-white',
            'butuh_bukti' => 'bg-secondary text-white',
            'dibatalkan' => 'bg-dark text-white',
        ];

        return $badges[$this->status_pengaduan] ?? 'bg-secondary text-white';
    }

    /**
     * Accessor untuk nama pelapor (handle anonim)
     */
    public function getNamaPelaporDisplayAttribute()
    {
        return $this->submit_anonim ? 'Anonim' : $this->nama_pelapor;
    }

    /**
     * Accessor untuk status pelapor yang lebih readable
     */
    public function getStatusPelaporLabelAttribute()
    {
        $labels = [
            'saksi' => 'Saksi',
            'korban' => 'Korban',
        ];

        return $labels[$this->status_pelapor] ?? ucfirst($this->status_pelapor);
    }

    /**
     * Check if pengaduan can be cancelled by user
     */
    public function canBeCancelled()
    {
        return in_array($this->status_pengaduan, ['pending', 'butuh_bukti']);
    }

    /**
     * Check if pengaduan has evidence file
     */
    public function hasEvidenceFile()
    {
        return $this->evidence_type === 'file' && !empty($this->evidence_path);
    }

    /**
     * Check if pengaduan has Google Drive evidence
     */
    public function hasGdriveEvidence()
    {
        return $this->evidence_type === 'gdrive' && !empty($this->evidence_gdrive_link);
    }

    /**
     * Get evidence URL (for Google Drive)
     */
    public function getEvidenceUrlAttribute()
    {
        if ($this->evidence_type === 'gdrive') {
            return $this->evidence_gdrive_link;
        }
        
        if ($this->evidence_type === 'file' && $this->evidence_path) {
            return asset('storage/' . $this->evidence_path);
        }

        return null;
    }

    /**
     * Scope untuk filter berdasarkan status
     */
    public function scopeByStatus($query, $status)
    {
        return $query->where('status_pengaduan', $status);
    }

    /**
     * Scope untuk pengaduan pending
     */
    public function scopePending($query)
    {
        return $query->where('status_pengaduan', 'pending');
    }

    /**
     * Scope untuk pengaduan dalam proses
     */
    public function scopeInProgress($query)
    {
        return $query->where('status_pengaduan', 'proses');
    }

    /**
     * Scope untuk pengaduan selesai
     */
    public function scopeSelesai($query)
    {
        return $query->where('status_pengaduan', 'selesai');
    }

    /**
     * Scope untuk pengaduan ditolak
     */
    public function scopeDitolak($query)
    {
        return $query->where('status_pengaduan', 'ditolak');
    }

    /**
     * Scope untuk pengaduan yang butuh bukti tambahan
     */
    public function scopeButuhBukti($query)
    {
        return $query->where('status_pengaduan', 'butuh_bukti');
    }

    /**
     * Scope untuk pengaduan yang dibatalkan
     */
    public function scopeDibatalkan($query)
    {
        return $query->where('status_pengaduan', 'dibatalkan');
    }

    /**
     * Scope untuk pengaduan prioritas
     */
    public function scopePrioritas($query)
    {
        return $query->where('is_prioritas', true);
    }

    /**
     * Scope untuk pengaduan anonim
     */
    public function scopeAnonim($query)
    {
        return $query->where('submit_anonim', true);
    }

    /**
     * Scope untuk pengaduan dengan disabilitas
     */
    public function scopeWithDisabilitas($query)
    {
        return $query->where('memiliki_disabilitas', true);
    }

    /**
     * Scope untuk filter berdasarkan email pelapor
     */
    public function scopeByPelapor($query, $email)
    {
        return $query->where('email_pelapor', $email);
    }

    /**
     * Scope untuk filter berdasarkan kategori
     */
    public function scopeByKategori($query, $kategoriId)
    {
        return $query->where('kategori_pengaduan_id', $kategoriId);
    }

    /**
     * Scope untuk pencarian
     */
    public function scopeSearch($query, $search)
    {
        return $query->where(function ($q) use ($search) {
            $q->where('kode_pengaduan', 'ILIKE', "%{$search}%")
              ->orWhere('nama_pelapor', 'ILIKE', "%{$search}%")
              ->orWhere('judul_pengaduan', 'ILIKE', "%{$search}%")
              ->orWhere('cerita_singkat_peristiwa', 'ILIKE', "%{$search}%");
        });
    }

    /**
     * Get formatted alasan pengaduan
     */
    public function getFormattedAlasanPengaduanAttribute()
    {
        if (!$this->alasan_pengaduan) {
            return [];
        }

        $alasanLabels = [
            'saksi_khawatir' => 'Saya seorang saksi yang khawatir dengan keadaan Korban',
            'korban_bantuan' => 'Saya seorang Korban yang memerlukan bantuan pemulihan',
            'tindak_tegas' => 'Saya ingin Perguruan Tinggi menindak tegas Terlapor',
            'dokumentasi_keamanan' => 'Saya ingin Satuan Tugas mendokumentasikan kejadiannya, meningkatkan keamanan Perguruan Tinggi dari Kekerasan, dan memberi pelindungan bagi saya',
            'lainnya' => 'Lainnya',
        ];

        $result = [];
        foreach ($this->alasan_pengaduan as $alasan) {
            $result[] = $alasanLabels[$alasan] ?? $alasan;
        }

        return $result;
    }

    /**
     * Get short description for display
     */
    public function getShortDescriptionAttribute()
    {
        return Str::limit($this->cerita_singkat_peristiwa, 100);
    }

    /**
     * Get days since created
     */
    public function getDaysSinceCreatedAttribute()
    {
        return $this->created_at->diffInDays(now());
    }

    /**
     * Check if pengaduan is recent (within 7 days)
     */
    public function getIsRecentAttribute()
    {
        return $this->created_at->isAfter(now()->subDays(7));
    }

    /**
     * Get evidence type label
     */
    public function getEvidenceTypeLabelAttribute()
    {
        $labels = [
            'file' => 'File Upload',
            'gdrive' => 'Google Drive',
        ];

        return $labels[$this->evidence_type] ?? 'Tidak ada';
    }

    /**
     * Get file extension from evidence path
     */
    public function getEvidenceFileExtensionAttribute()
    {
        if ($this->evidence_path) {
            return pathinfo($this->evidence_path, PATHINFO_EXTENSION);
        }

        return null;
    }

    /**
     * Get file size if available
     */
    public function getEvidenceFileSizeAttribute()
    {
        if ($this->evidence_path && Storage::disk('public')->exists($this->evidence_path)) {
            $bytes = Storage::disk('public')->size($this->evidence_path);
            
            if ($bytes >= 1024 * 1024) {
                return round($bytes / (1024 * 1024), 2) . ' MB';
            } elseif ($bytes >= 1024) {
                return round($bytes / 1024, 2) . ' KB';
            } else {
                return $bytes . ' Bytes';
            }
        }

        return null;
    }
}