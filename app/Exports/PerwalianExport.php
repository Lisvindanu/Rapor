<?php

namespace App\Exports;

use Illuminate\Contracts\Support\Responsable;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class PerwalianExport implements FromCollection, WithHeadings, WithMapping
{
    protected $mahasiswa;
    protected $periodeList;

    public function __construct(Collection $mahasiswa, array $periodeList)
    {
        $this->mahasiswa = $mahasiswa;
        $this->periodeList = $periodeList;
    }

    public function collection()
    {
        return $this->mahasiswa;
    }

    public function headings(): array
    {
        return array_merge(
            ['No', 'NRP', 'Nama', 'Program Studi', 'Status Mahasiswa'],
            $this->periodeList,
            ['Rekomendasi']
        );
    }

    public function map($row): array
    {
        static $no = 1;

        $perwalianMap = collect($row->perwalian)->keyBy('id_periode');

        $periodeData = array_map(function ($periode) use ($perwalianMap) {
            return isset($perwalianMap[$periode])
                ? $perwalianMap[$periode]['status_mahasiswa']
                : '-';
        }, $this->periodeList);

        $rekomendasi = '-';

        if (strtolower($row->statusmahasiswa) === 'aktif') {
            $nonAktifCount = collect($row->perwalian)
                ->whereIn('id_periode', $this->periodeList)
                ->where('status_mahasiswa', 'Non Aktif')
                ->count();

            if (count($row->perwalian) <= 6 || $nonAktifCount >= 5) {
                $rekomendasi = 'Mengundurkan Diri';
            } else  {
                $rekomendasi = 'Cuti';
            }
        }

        return array_merge([
            $no++,
            $row->nim,
            $row->nama,
            $row->programstudi,
            $row->statusmahasiswa,
        ], $periodeData, [$rekomendasi]);
    }
}
