<?php
namespace App\Helpers;

class KeuanganProgramValidationHelper
{
    public static function getProgramRules($id = null): array
    {
        $unique = $id ? "unique:keuangan_program,nama_program,{$id}" : 'unique:keuangan_program,nama_program';

        return [
            'nama_program' => "required|string|max:100|{$unique}",
        ];
    }

    public static function getMessages(): array
    {
        return [
            'nama_program.required' => 'Nama program wajib diisi',
            'nama_program.unique' => 'Nama program sudah ada',
            'nama_program.max' => 'Nama program maksimal 100 karakter'
        ];
    }
}
