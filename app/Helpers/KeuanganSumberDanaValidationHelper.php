<?php

namespace App\Helpers;

class KeuanganSumberDanaValidationHelper
{
    /**
     * Get validation rules for sumber dana
     */
    public static function getSumberDanaRules($id = null): array
    {
        $unique = $id
            ? "unique:keuangan_sumberdana,nama_sumber_dana,{$id}"
            : 'unique:keuangan_sumberdana,nama_sumber_dana';

        return [
            'nama_sumber_dana' => "required|string|max:200|{$unique}",
        ];
    }

    /**
     * Get validation messages
     */
    public static function getMessages(): array
    {
        return [
            'nama_sumber_dana.required' => 'Nama sumber dana wajib diisi',
            'nama_sumber_dana.string' => 'Nama sumber dana harus berupa teks',
            'nama_sumber_dana.max' => 'Nama sumber dana maksimal 200 karakter',
            'nama_sumber_dana.unique' => 'Nama sumber dana sudah digunakan',
        ];
    }

    /**
     * Format nama sumber dana
     */
    public static function formatNamaSumberDana(string $nama): string
    {
        return trim(ucwords(strtolower($nama)));
    }

    /**
     * Validate if sumber dana can be deleted
     */
    public static function canBeDeleted($sumberDanaId): bool
    {
        // TODO: Implementasi ketika sudah ada relasi dengan tabel transaksi
        // $sumberDana = \App\Models\KeuanganSumberDana::find($sumberDanaId);
        // return $sumberDana && !$sumberDana->isUsedInTransactions();
        return true;
    }

    /**
     * Search validation
     */
    public static function getSearchRules(): array
    {
        return [
            'search' => 'nullable|string|max:100',
            'per_page' => 'nullable|integer|min:10|max:100',
            'sort_by' => 'nullable|in:nama_sumber_dana,created_at',
            'sort_order' => 'nullable|in:asc,desc',
        ];
    }
}
