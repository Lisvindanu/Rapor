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
            $totalPeriode = count($this->periodeList);
            $filteredPerwalian = collect($row->perwalian)->whereIn('id_periode', $this->periodeList);

            $jumlahPerwalian = $filteredPerwalian->count();
            $nonAktifCount = $filteredPerwalian->where('status_mahasiswa', 'Non Aktif')->count();
            $aktifCount = $filteredPerwalian->where('status_mahasiswa', 'Aktif')->count();

            $persentasePerwalian = $totalPeriode > 0 ? ($jumlahPerwalian / $totalPeriode) : 0;

            if ($nonAktifCount === 0 && $jumlahPerwalian === $totalPeriode) {
                // Tambahkan kondisi jika sudah terlalu lama kuliah
                if ($aktifCount >= 12) {
                    $rekomendasi = 'Cuti';
                } else {
                    $rekomendasi = '-';
                }
            } elseif ($persentasePerwalian <= 0.5 || $nonAktifCount >= 5) {
                $rekomendasi = 'Mengundurkan Diri';
            } elseif ($nonAktifCount > 0) {
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
