<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Modul extends Model
{
    use HasFactory, HasUuids;

    protected $table = 'moduls';

    protected $fillable = [
        'id', 'nama_modul', 'tautan', 'urutan'
    ];

    public function menus()
    {
        return $this->hasMany(Menu::class);
    }
}
