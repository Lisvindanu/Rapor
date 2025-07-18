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
        'kode_mata_anggaran',
        'nama_mata_anggaran',
        'parent_mata_anggaran',
        'kategori',
    ];

    protected $casts = [
        'kategori' => 'string',
    ];

    // Relationships
    public function parentMataAnggaran()
    {
        return $this->belongsTo(KeuanganMataAnggaran::class, 'parent_mata_anggaran', 'id');
    }

    public function childMataAnggaran()
    {
        return $this->hasMany(KeuanganMataAnggaran::class, 'parent_mata_anggaran', 'id')
            ->orderBy('kode_mata_anggaran');
    }

    // Scopes
    public function scopeParents($query)
    {
        return $query->whereNull('parent_mata_anggaran');
    }

    public function scopeDebet($query)
    {
        return $query->where('kategori', 'debet');
    }

    public function scopeKredit($query)
    {
        return $query->where('kategori', 'kredit');
    }

    // Accessors
    public function getChildrenCountAttribute()
    {
        return $this->childMataAnggaran()->count();
    }

    public function getIsParentAttribute()
    {
        return is_null($this->parent_mata_anggaran);
    }

    public function getHierarchyLevelAttribute()
    {
        $level = 0;
        $parent = $this->parentMataAnggaran;
        while ($parent) {
            $level++;
            $parent = $parent->parentMataAnggaran;
        }
        return $level;
    }

    // Helper Methods
    public function hasChildren()
    {
        return $this->childMataAnggaran()->exists();
    }

    protected $appends = ['children_count', 'is_parent', 'hierarchy_level'];
}
