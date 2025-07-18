<?php

namespace App\Helpers;

use Illuminate\Http\Request;

class KeuanganValidationHelper
{
    /**
     * Clean and prepare mata anggaran data
     */
    public static function prepareMataAnggaranData(Request $request): array
    {
        $data = $request->all();

        // Handle parent
        $data['parent_mata_anggaran'] = empty($data['parent_mata_anggaran']) ? null : $data['parent_mata_anggaran'];

        // Handle currency - fix NaN issue
        $data['alokasi_anggaran'] = self::cleanCurrency($data['alokasi_anggaran'] ?? 0);

        // Handle checkbox
        $data['status_aktif'] = $request->has('status_aktif');

        return $data;
    }

    /**
     * Clean currency input
     */
    public static function cleanCurrency($value): float
    {
        if (is_null($value) || $value === '') return 0.0;

        // Remove non-numeric except decimal
        $cleaned = preg_replace('/[^\d.]/', '', $value);

        if ($cleaned === '' || $cleaned === '.') return 0.0;

        return max(0, floatval($cleaned));
    }

    /**
     * Validation rules for mata anggaran
     */
    public static function getMataAnggaranRules($id = null): array
    {
        $unique = $id ? "unique:keuangan_mtang,kode_mata_anggaran,{$id}" : 'unique:keuangan_mtang,kode_mata_anggaran';

        return [
            'kode_mata_anggaran' => "required|string|max:20|{$unique}|regex:/^[A-Za-z0-9.\-]+$/",
            'nama_mata_anggaran' => 'required|string|max:255',
            'nama_mata_anggaran_en' => 'nullable|string|max:255',
            'deskripsi' => 'nullable|string|max:65535',
            'parent_mata_anggaran' => 'nullable|exists:keuangan_mtang,id',
            'kategori' => 'nullable|string|max:100|in:operasional,investasi,pembiayaan,lainnya',
            'alokasi_anggaran' => 'nullable|numeric|min:0|max:999999999999.99',
            'tahun_anggaran' => 'required|integer|between:2020,2030',
            'status_aktif' => 'boolean',
        ];
    }

    /**
     * Custom validation messages
     */
    public static function getMessages(): array
    {
        return [
            'kode_mata_anggaran.required' => 'Kode mata anggaran wajib diisi',
            'kode_mata_anggaran.unique' => 'Kode mata anggaran sudah digunakan',
            'kode_mata_anggaran.regex' => 'Kode hanya boleh huruf, angka, titik, dan tanda hubung',
            'nama_mata_anggaran.required' => 'Nama mata anggaran wajib diisi',
            'tahun_anggaran.required' => 'Tahun anggaran wajib dipilih',
            'tahun_anggaran.between' => 'Tahun anggaran harus antara 2020-2030',
            'alokasi_anggaran.numeric' => 'Alokasi anggaran harus berupa angka',
            'alokasi_anggaran.min' => 'Alokasi anggaran tidak boleh negatif',
            'parent_mata_anggaran.exists' => 'Parent mata anggaran tidak valid',
            'kategori.in' => 'Kategori tidak valid',
        ];
    }

    /**
     * Calculate level and set defaults
     */
    public static function setMataAnggaranDefaults(array $data, $parent = null): array
    {
        // Set sisa anggaran
        $data['sisa_anggaran'] = $data['alokasi_anggaran'] ?? 0;

        // Calculate level
        if ($data['parent_mata_anggaran'] && $parent) {
            $data['level_mata_anggaran'] = ($parent->level_mata_anggaran ?? 0) + 1;
            $data['tahun_anggaran'] = $parent->tahun_anggaran;
        } else {
            $data['level_mata_anggaran'] = 0;
        }

        return $data;
    }
}
