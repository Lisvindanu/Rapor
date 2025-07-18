<?php

namespace App\Helpers;

class KeuanganValidationHelper
{
    /**
     * Validation rules for mata anggaran
     */
    public static function getMataAnggaranRules($id = null): array
    {
        $unique = $id ? "unique:keuangan_mtang,kode_mata_anggaran,{$id}" : 'unique:keuangan_mtang,kode_mata_anggaran';

        return [
            'kode_mata_anggaran' => "required|string|max:20|{$unique}|regex:/^[A-Za-z0-9.\-]+$/",
            'nama_mata_anggaran' => 'required|string|max:255',
            'parent_mata_anggaran' => 'nullable|exists:keuangan_mtang,id',
            'kategori' => 'required|in:debet,kredit',
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
            'nama_mata_anggaran.max' => 'Nama mata anggaran maksimal 255 karakter',
            'parent_mata_anggaran.exists' => 'Parent mata anggaran tidak valid',
            'kategori.required' => 'Kategori wajib dipilih',
            'kategori.in' => 'Kategori harus debet atau kredit',
        ];
    }

    /**
     * Prevent circular reference in parent-child relationship
     */
    public static function validateParentChild($parentId, $currentId = null): bool
    {
        if (!$parentId || !$currentId) {
            return true;
        }

        // Jika parent sama dengan current, maka circular
        if ($parentId === $currentId) {
            return false;
        }

        // Check apakah current adalah ancestor dari parent
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

    /**
     * Format kode mata anggaran
     */
    public static function formatKodeMataAnggaran(string $kode): string
    {
        return strtoupper(trim($kode));
    }

    /**
     * Generate kode mata anggaran otomatis berdasarkan parent
     */
    public static function generateKodeMataAnggaran($parentId = null): string
    {
        if (!$parentId) {
            // Generate kode untuk parent (level 0)
            $lastParent = \App\Models\KeuanganMataAnggaran::whereNull('parent_mata_anggaran')
                ->orderBy('kode_mata_anggaran', 'desc')
                ->first();

            if (!$lastParent) {
                return '1';
            }

            $lastNumber = intval($lastParent->kode_mata_anggaran);
            return strval($lastNumber + 1);
        }

        // Generate kode untuk child
        $parent = \App\Models\KeuanganMataAnggaran::find($parentId);
        if (!$parent) {
            return '1';
        }

        $lastChild = \App\Models\KeuanganMataAnggaran::where('parent_mata_anggaran', $parentId)
            ->orderBy('kode_mata_anggaran', 'desc')
            ->first();

        if (!$lastChild) {
            return $parent->kode_mata_anggaran . '.1';
        }

        // Extract number setelah titik terakhir
        $parts = explode('.', $lastChild->kode_mata_anggaran);
        $lastNumber = intval(end($parts));

        array_pop($parts);
        return implode('.', $parts) . '.' . ($lastNumber + 1);
    }
}
