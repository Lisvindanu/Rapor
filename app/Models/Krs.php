<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;

class Krs extends Model
{
    use HasFactory, HasUuids;

    protected $table = 'krs';

    protected $fillable = [
        'id',
        'idperiode',
        'namakelas',
        'nim',
        'idmk',
        'namamk',
        'jenismatakuliah',
        'sksmk',
        'skspraktikum',
        'skstatapmuka',
        'skssimulasi',
        'skspraktlap',
        'nnumerik',
        'nangka',
        'nhuruf',
        'krsdiajukan',
        'krsdisetujui',
        'presensi'
    ];

    // kelaskuliah
    public function kelasKuliah()
    {
        return $this->belongsTo(KelasKuliah::class, 'idmk', 'kodemk')
            ->where('namakelas', $this->namakelas)
            ->where('periodeakademik', $this->idperiode);
    }

    // Relasi dengan PresensiKuliah
    public function presensiKuliahs()
    {
        return $this->hasMany(PresensiKuliah::class, 'nim', 'nim')
            ->where('kodemk', $this->idmk)
            ->where('kelas', $this->namakelas)
            ->where('periodeakademik', $this->idperiode);
    }

    // Method untuk menghitung jumlah presensi
    public function hitungJumlahPresensi()
    {
        $jumlahPresensi = $this->presensiKuliahs()->count();
        $jumlahHadir = $this->presensiKuliahs()->where('presensi', 'HADIR')->count();

        // hitung persentasenya
        if ($jumlahPresensi == 0) {
            $persentase = 0;
        } else {
            $persentase = ($jumlahHadir / $jumlahPresensi) * 100;
        }

        $this->presensi = $persentase;
        $this->save();
    }
}
