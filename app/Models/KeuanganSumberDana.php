<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KeuanganSumberDana extends Model
{
    use HasFactory, HasUuids;

    protected $table = 'keuangan_sumberdana';

    protected $fillable = [
        'nama_sumber_dana',
    ];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    // Scopes untuk filtering dan searching
    public function scopeByNama($query, $nama)
    {
        return $query->where('nama_sumber_dana', 'like', '%' . $nama . '%');
    }

    public function scopeOrderByNama($query, $direction = 'asc')
    {
        return $query->orderBy('nama_sumber_dana', $direction);
    }

    public function scopeRecent($query)
    {
        return $query->orderBy('created_at', 'desc');
    }

    // Accessors
    public function getFormattedCreatedAtAttribute()
    {
        return $this->created_at->format('d/m/Y H:i');
    }

    public function getShortNameAttribute()
    {
        return strlen($this->nama_sumber_dana) > 50
            ? substr($this->nama_sumber_dana, 0, 50) . '...'
            : $this->nama_sumber_dana;
    }

    // Helper Methods
    public function isUsedInTransactions()
    {
        // TODO: Implementasi ketika sudah ada relasi dengan tabel transaksi
        // return $this->transactions()->exists();
        return false;
    }

    protected $appends = ['formatted_created_at', 'short_name'];
}
