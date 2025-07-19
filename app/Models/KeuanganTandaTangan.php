<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KeuanganTandaTangan extends Model
{
    use HasFactory, HasUuids;

    protected $table = 'keuangan_tandatangan';

    protected $fillable = [
        'nomor_ttd',
        'jabatan',
        'nama',
        'gambar_ttd',
    ];

    protected $casts = [
        'gambar_ttd' => 'string',
    ];

    // Accessors
    public function getFormattedCreatedAtAttribute()
    {
        return $this->created_at ? $this->created_at->format('d/m/Y H:i') : '-';
    }

    public function getHasImageAttribute()
    {
        return !empty($this->gambar_ttd);
    }

    public function getImagePreviewAttribute()
    {
        if (!$this->has_image) {
            return null;
        }

        // If it's already a data URL, return as is
        if (strpos($this->gambar_ttd, 'data:image/') === 0) {
            return $this->gambar_ttd;
        }

        // Otherwise, assume it's base64 and add the data URL prefix
        return 'data:image/png;base64,' . $this->gambar_ttd;
    }

    // Helper Methods
    public function canBeDeleted(): bool
    {
        // TODO: Check if signature is used in any documents/transactions
        return true;
    }

    protected $appends = ['formatted_created_at', 'has_image'];
}
