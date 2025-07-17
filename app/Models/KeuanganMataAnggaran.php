<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KeuanganMataAnggaran extends Model
{
    use HasFactory, HasUuids;

    protected $table = 'keuangan_mtang';

    protected $fillable = [
        'id',
        'kode_mata_anggaran',
        'nama_mata_anggaran',
        'nama_mata_anggaran_en',
        'deskripsi',
        'parent_mata_anggaran',
        'level_mata_anggaran',
        'kategori',
        'alokasi_anggaran',
        'sisa_anggaran',
        'tahun_anggaran',
        'status_aktif',
        'created_by',
        'updated_by',
    ];

    protected $casts = [
        'alokasi_anggaran' => 'decimal:2',
        'sisa_anggaran' => 'decimal:2',
        'status_aktif' => 'boolean',
    ];

    public function parentMataAnggaran()
    {
        return $this->belongsTo(KeuanganMataAnggaran::class, 'parent_mata_anggaran', 'id');
    }

    public function childMataAnggaran()
    {
        return $this->hasMany(KeuanganMataAnggaran::class, 'parent_mata_anggaran', 'id');
    }

    public function childrenRecursive()
    {
        return $this->hasMany(KeuanganMataAnggaran::class, 'parent_mata_anggaran', 'id')
            ->with('childrenRecursive');
    }

    public function scopeActive($query)
    {
        return $query->where('status_aktif', true);
    }

    public function scopeParents($query)
    {
        return $query->whereNull('parent_mata_anggaran');
    }

    public function scopeByTahunAnggaran($query, $tahun)
    {
        return $query->where('tahun_anggaran', $tahun);
    }

    public function getChildrenCountAttribute()
    {
        return $this->countRecursiveChildren($this);
    }

    protected function countRecursiveChildren($mataAnggaran)
    {
        $count = 0;

        if ($mataAnggaran->childMataAnggaran && $mataAnggaran->childMataAnggaran->isNotEmpty()) {
            foreach ($mataAnggaran->childMataAnggaran as $child) {
                $count += 1 + $this->countRecursiveChildren($child);
            }
        }

        return $count;
    }

    public function hasChildren()
    {
        return $this->childMataAnggaran()->exists();
    }

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            $model->created_by = auth()->id();
        });

        static::updating(function ($model) {
            $model->updated_by = auth()->id();
        });
    }

    protected $appends = ['children_count'];
}
