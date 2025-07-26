<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;

class RefKategoriPengaduan extends Model
{
    use HasUuids;

    /**
     * The table associated with the model.
     */
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
    ];

    /**
     * The attributes that should be cast.
     */
    protected $casts = [
        'id' => 'string',
    ];

    /**
     * Get the pengaduan for the kategori.
     */
    public function pengaduan()
    {
        return $this->hasMany(Pengaduan::class, 'kategori_pengaduan_id');
    }

    /**
     * Alternative method name for backward compatibility
     */
    public function whistlePengaduan()
    {
        return $this->hasMany(Pengaduan::class, 'kategori_pengaduan_id');
    }
}