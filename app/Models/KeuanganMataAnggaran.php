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
        return $this->hasMany(KeuanganMataAnggaran::class, 'parent_mata_anggaran', 'id');
    }

    public function childrenRecursive()
    {
        return $this->hasMany(KeuanganMataAnggaran::class, 'parent_mata_anggaran', 'id')
            ->with('childrenRecursive');
    }

    // Scopes
    public function scopeParents($query)
    {
        return $query->whereNull('parent_mata_anggaran');
    }

    public function scopeByKategori($query, $kategori)
    {
        return $query->where('kategori', $kategori);
    }

    public function scopeDebet($query)
    {
        return $query->where('kategori', 'debet');
    }

    public function scopeKredit($query)
    {
        return $query->where('kategori', 'kredit');
    }

    // Accessors & Mutators
    public function getChildrenCountAttribute()
    {
        return $this->countRecursiveChildren($this);
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

    public function getFullPathAttribute()
    {
        $path = collect([$this->nama_mata_anggaran]);
        $parent = $this->parentMataAnggaran;

        while ($parent) {
            $path->prepend($parent->nama_mata_anggaran);
            $parent = $parent->parentMataAnggaran;
        }

        return $path->implode(' → ');
    }

    // Helper Methods
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

    public function getChildrenRecursive()
    {
        $children = collect();

        foreach ($this->childMataAnggaran as $child) {
            $children->push($child);
            $children = $children->merge($child->getChildrenRecursive());
        }

        return $children;
    }

    public function getAllDescendants()
    {
        return $this->getChildrenRecursive();
    }

    public function isChildOf($parentId)
    {
        if ($this->parent_mata_anggaran === $parentId) {
            return true;
        }

        if ($this->parentMataAnggaran) {
            return $this->parentMataAnggaran->isChildOf($parentId);
        }

        return false;
    }

    public function canBeParentOf($childId)
    {
        if ($this->id === $childId) {
            return false;
        }

        return !$this->isChildOf($childId);
    }

    protected $appends = ['children_count', 'is_parent', 'hierarchy_level', 'full_path'];
}
