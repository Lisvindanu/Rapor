<?php

namespace App\Helpers;

class KeuanganTandaTanganValidationHelper
{
    /**
     * Get validation rules for tanda tangan
     */
    public static function getTandaTanganRules($id = null): array
    {
        $unique = $id
            ? "unique:keuangan_tandatangan,nomor_ttd,{$id}"
            : 'unique:keuangan_tandatangan,nomor_ttd';

        return [
            'nomor_ttd' => "required|string|max:50|{$unique}",
            'jabatan' => 'required|string|max:200',
            'nama' => 'required|string|max:200',
            'gambar_ttd' => 'nullable|string|max:10485760',
        ];
    }

    /**
     * Get validation messages
     */
    public static function getMessages(): array
    {
        return [
            'nomor_ttd.required' => 'Nomor TTD wajib diisi',
            'nomor_ttd.string' => 'Nomor TTD harus berupa teks',
            'nomor_ttd.max' => 'Nomor TTD maksimal 50 karakter',
            'nomor_ttd.unique' => 'Nomor TTD sudah digunakan',
            'jabatan.required' => 'Jabatan wajib diisi',
            'jabatan.string' => 'Jabatan harus berupa teks',
            'jabatan.max' => 'Jabatan maksimal 200 karakter',
            'nama.required' => 'Nama wajib diisi',
            'nama.string' => 'Nama harus berupa teks',
            'nama.max' => 'Nama maksimal 200 karakter',
            'gambar_ttd.string' => 'Format gambar tanda tangan tidak valid',
        ];
    }

    /**
     * Format nomor TTD
     */
    public static function formatNomorTtd(string $nomor): string
    {
        return strtoupper(trim($nomor));
    }

    /**
     * Format nama dan jabatan
     */
    public static function formatNama(string $nama): string
    {
        return trim(ucwords(strtolower($nama)));
    }

    public static function formatJabatan(string $jabatan): string
    {
        return trim(ucwords(strtolower($jabatan)));
    }

    /**
     * Validate if tanda tangan can be deleted
     */
    public static function canBeDeleted($tandaTanganId): bool
    {
        return true;
    }

    /**
     * Validate image format
     */
    public static function validateImageFormat(string $imageData): bool
    {
        if (strpos($imageData, 'data:image/') === 0) {
            $base64 = explode(',', $imageData)[1] ?? '';
            return base64_decode($base64, true) !== false;
        }

        return base64_decode($imageData, true) !== false;
    }

    /**
     * Search validation
     */
    public static function getSearchRules(): array
    {
        return [
            'search' => 'nullable|string|max:100',
            'per_page' => 'nullable|integer|min:10|max:100',
            'sort_by' => 'nullable|in:nomor_ttd,nama,jabatan,created_at',
            'sort_order' => 'nullable|in:asc,desc',
        ];
    }
}
