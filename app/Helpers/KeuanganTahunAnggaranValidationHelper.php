<?php

namespace App\Helpers;

class KeuanganTahunAnggaranValidationHelper
{
    public static function getTahunAnggaranRules($id = null): array
    {
        $unique = $id ? "unique:keuangan_tahun_anggaran,tahun_anggaran,{$id}" : 'unique:keuangan_tahun_anggaran,tahun_anggaran';

        return [
            'tahun_anggaran' => "required|string|max:10|{$unique}",
            'tgl_awal_anggaran' => 'required|date',
            'tgl_akhir_anggaran' => 'required|date|after:tgl_awal_anggaran'
        ];
    }

    public static function getMessages(): array
    {
        return [
            'tahun_anggaran.required' => 'Tahun anggaran wajib diisi',
            'tahun_anggaran.unique' => 'Tahun anggaran sudah ada',
            'tahun_anggaran.max' => 'Tahun anggaran maksimal 10 karakter',
            'tgl_awal_anggaran.required' => 'Tanggal awal anggaran wajib diisi',
            'tgl_awal_anggaran.date' => 'Format tanggal awal tidak valid',
            'tgl_akhir_anggaran.required' => 'Tanggal akhir anggaran wajib diisi',
            'tgl_akhir_anggaran.date' => 'Format tanggal akhir tidak valid',
            'tgl_akhir_anggaran.after' => 'Tanggal akhir harus setelah tanggal awal'
        ];
    }

    public static function validateOverlap($request, $excludeId = null): bool
    {
        $query = \App\Models\KeuanganTahunAnggaran::query();

        if ($excludeId) {
            $query->where('id', '!=', $excludeId);
        }

        return $query->where(function ($q) use ($request) {
            $q->whereBetween('tgl_awal_anggaran', [$request->tgl_awal_anggaran, $request->tgl_akhir_anggaran])
                ->orWhereBetween('tgl_akhir_anggaran', [$request->tgl_awal_anggaran, $request->tgl_akhir_anggaran])
                ->orWhere(function ($subQ) use ($request) {
                    $subQ->where('tgl_awal_anggaran', '<=', $request->tgl_awal_anggaran)
                        ->where('tgl_akhir_anggaran', '>=', $request->tgl_akhir_anggaran);
                });
        })->exists();
    }

    public static function formatTahunAnggaran(string $tahun): string
    {
        return trim($tahun);
    }

    public static function canBeDeleted($tahunAnggaranId): bool
    {
        // TODO: Implementasi ketika sudah ada relasi dengan tabel transaksi
        // $tahunAnggaran = \App\Models\KeuanganTahunAnggaran::find($tahunAnggaranId);
        // return $tahunAnggaran && !$tahunAnggaran->isUsedInTransactions();
        return true;
    }

    public static function getSearchRules(): array
    {
        return [
            'search' => 'nullable|string|max:100',
            'tahun' => 'nullable|string|max:10',
            'status' => 'nullable|in:aktif,belum_dimulai,selesai',
            'per_page' => 'nullable|integer|min:10|max:100',
            'sort_by' => 'nullable|in:tahun_anggaran,tgl_awal_anggaran,tgl_akhir_anggaran,created_at',
            'sort_order' => 'nullable|in:asc,desc',
        ];
    }
}
