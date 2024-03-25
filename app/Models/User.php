<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Support\Facades\Hash;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, HasUuids;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'id', // Add this line
        'name',
        'email',
        'password',
        'username', // Add this line
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    // public function getIsDefaultPasswordAttribute()
    // {
    //     // Ubah sesuai dengan logika pengecekan password default
    //     // return $this->password === Hash::make('password');
    //     // Ganti 'password_default' dengan hash password default yang Anda gunakan
    //     $defaultPasswordHash = Hash::make('password');

    //     // Gunakan Hash::check() untuk membandingkan
    //     return Hash::check($this->password, $defaultPasswordHash);
    // }

    // pegawai
    public function pegawai()
    {
        return $this->hasOne(Pegawai::class, 'nip', 'username');
    }

    // role
    public function roles()
    {
        return $this->belongsToMany(Role::class);
    }
}
