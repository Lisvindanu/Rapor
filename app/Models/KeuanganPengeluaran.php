<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class KeuanganPengeluaran extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'keuangan_pengeluaran';

    protected $fillable = [
        'nomor_bukti',
        'tanggal',
        'sudah_terima_dari',
        'uang_sebanyak',
        'uang_sebanyak_angka',
        'untuk_pembayaran',
        'mata_anggaran_id',
        'program_id',
        'sumber_dana_id',
        'tahun_anggaran_id',
        'dekan_id',
        'wakil_dekan_ii_id',
        'ksb_keuangan_id',
        'penerima_id',
        'status',
        'keterangan'
    ];

    protected $casts = [
        'tanggal' => 'date',
        'uang_sebanyak_angka' => 'decimal:2'
    ];

    // Relationships
    public function mataAnggaran()
    {
        return $this->belongsTo(KeuanganMataAnggaran::class, 'mata_anggaran_id');
    }

    public function program()
    {
        return $this->belongsTo(KeuanganProgram::class, 'program_id');
    }

    public function sumberDana()
    {
        return $this->belongsTo(KeuanganSumberDana::class, 'sumber_dana_id');
    }

    public function tahunAnggaran()
    {
        return $this->belongsTo(KeuanganTahunAnggaran::class, 'tahun_anggaran_id');
    }

    public function dekan()
    {
        return $this->belongsTo(KeuanganTandaTangan::class, 'dekan_id');
    }

    public function wakilDekanII()
    {
        return $this->belongsTo(KeuanganTandaTangan::class, 'wakil_dekan_ii_id');
    }

    public function ksbKeuangan()
    {
        return $this->belongsTo(KeuanganTandaTangan::class, 'ksb_keuangan_id');
    }

    public function penerima()
    {
        return $this->belongsTo(KeuanganTandaTangan::class, 'penerima_id');
    }

    // Scopes
    public function scopeByStatus($query, $status)
    {
        return $query->where('status', $status);
    }

    public function scopeByTahunAnggaran($query, $tahunId)
    {
        return $query->where('tahun_anggaran_id', $tahunId);
    }

    // Business Logic
    public function canBeEdited()
    {
        return in_array($this->status, ['draft', 'rejected']);
    }

    public function canBeDeleted()
    {
        return in_array($this->status, ['draft', 'rejected']);
    }

    // Auto-generate nomor bukti
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            if (!$model->nomor_bukti) {
                $model->nomor_bukti = $model->generateNomorBukti();
            }
        });
    }

    private function generateNomorBukti()
    {
        $lastNumber = static::whereYear('created_at', date('Y'))
            ->orderByRaw('CAST(SUBSTRING(nomor_bukti FROM \'\\.([0-9]+)$\') AS INTEGER) DESC')
            ->first();

        $increment = 1;
        if ($lastNumber && preg_match('/\.(\d+)$/', $lastNumber->nomor_bukti, $matches)) {
            $increment = (int) $matches[1] + 1;
        }

        return 'P.' . date('y') . sprintf('%02d', date('m')) . '.' . sprintf('%03d', $increment);
    }
}
