<?php

namespace App\Helpers;

class KeuanganValidationHelper
{
    public static function getMataAnggaranRules($id = null): array
    {
        $unique = $id ? "unique:keuangan_mtang,kode_mata_anggaran,{$id}" : 'unique:keuangan_mtang,kode_mata_anggaran';

        return [
            'kode_mata_anggaran' => "required|string|max:50|{$unique}",
            'nama_mata_anggaran' => 'required|string|max:500',
            'parent_mata_anggaran' => 'nullable|exists:keuangan_mtang,id',
            'kategori' => 'required|in:debet,kredit',
        ];
    }

    public static function getMessages(): array
    {
        return [
            'kode_mata_anggaran.required' => 'Kode mata anggaran wajib diisi',
            'kode_mata_anggaran.unique' => 'Kode mata anggaran sudah digunakan',
            'nama_mata_anggaran.required' => 'Nama mata anggaran wajib diisi',
            'nama_mata_anggaran.max' => 'Nama mata anggaran maksimal 500 karakter',
            'parent_mata_anggaran.exists' => 'Parent mata anggaran tidak valid',
            'kategori.required' => 'Kategori wajib dipilih',
            'kategori.in' => 'Kategori harus debet atau kredit',
        ];
    }

    public static function validateParentChild($parentId, $currentId = null): bool
    {
        if (!$parentId || !$currentId) {
            return true;
        }

        if ($parentId === $currentId) {
            return false;
        }

        $parent = \App\Models\KeuanganMataAnggaran::find($parentId);
        if (!$parent) {
            return true;
        }

        $ancestor = $parent->parentMataAnggaran;
        while ($ancestor) {
            if ($ancestor->id === $currentId) {
                return false;
            }
            $ancestor = $ancestor->parentMataAnggaran;
        }

        return true;
    }

    public static function formatKodeMataAnggaran(string $kode): string
    {
        return strtoupper(trim($kode));
    }
}
