<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Dosen extends Model
{
    use HasFactory, HasUuids;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'dosens';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['id', 'nama', 'nidn', 'nip', 'email', 'alamat', 'nohp', 'jeniskelamin', 'agama', 'tempatlahir', 'tanggallahir', 'homebase', 'golpangkat', 'jabatanfungsional', 'jabatanstruktural', 'pendidikanterakhir'];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'tanggallahir' => 'date',
    ];
}
