<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;


class RaporExport implements WithHeadings
{
    public function collection()
    {
        // return User::all();
    }

    public function headings(): array
    {
        return [
            'No',
            'Periode',
            'ID Kelas',
            'Kode MK',
            'Nama Matakuliah',
            'Nama Kelas',
            'Jumlah Peserta',
            'NIP',
            'Dosen Pengajar',
            'NIDN',
            'Prodi',
        ];
    }
}
