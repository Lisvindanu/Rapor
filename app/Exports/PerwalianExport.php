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
        // $perwalianCols = array_map(fn($p) => "Perwalian $p", $this->periodeList);
        // $dppCols = array_map(fn($p) => "DPP $p", $this->periodeList);

        // return array_merge(
        //     ['No', 'NRP', 'Nama', 'Program Studi', 'Status Mahasiswa'],
        //     $perwalianCols,
        //     $dppCols,
        //     ['Rekomendasi']
        // );
        $periodeCols = [];

        foreach ($this->periodeList as $periode) {
            $periodeCols[] = "Perwalian $periode";
            $periodeCols[] = "DPP $periode";
        }

        return array_merge(
            ['No', 'NRP', 'Nama', 'Program Studi', 'Status Mahasiswa'],
            $periodeCols,
            [
                'Total DPP Belum Lunas (Rp)', 
                'Rekomendasi',
                'Jumlah Belum Lunas',
                'Jumlah Non Aktif',
                'Jumlah Perwalian',
                'Total Periode'
            ]
        );
    }

    // public function map($row): array
    // {
    //     static $no = 1;

    //     $perwalianMap = collect($row->perwalian)->keyBy('id_periode');
    //     $invoiceDPP = collect($row->invoice)
    //         ->where('id_jenis_akun', 'DPP')
    //         ->groupBy('id_periode');

    //     // $periodeData = array_map(function ($periode) use ($perwalianMap) {
    //     //     return isset($perwalianMap[$periode])
    //     //         ? $perwalianMap[$periode]['status_mahasiswa']
    //     //         : '-';
    //     // }, $this->periodeList);

    //     // $rekomendasi = '-';

    //     // if (strtolower($row->statusmahasiswa) === 'aktif') {
    //     //     $totalPeriode = count($this->periodeList);
    //     //     $filteredPerwalian = collect($row->perwalian)->whereIn('id_periode', $this->periodeList);

    //     //     $jumlahPerwalian = $filteredPerwalian->count();
    //     //     $nonAktifCount = $filteredPerwalian->where('status_mahasiswa', 'Non Aktif')->count();
    //     //     $aktifCount = $filteredPerwalian->where('status_mahasiswa', 'Aktif')->count();

    //     //     $persentasePerwalian = $totalPeriode > 0 ? ($jumlahPerwalian / $totalPeriode) : 0;

    //     //     if ($nonAktifCount === 0 && $jumlahPerwalian === $totalPeriode) {
    //     //         // Tambahkan kondisi jika sudah terlalu lama kuliah
    //     //         if ($aktifCount >= 12) {
    //     //             $rekomendasi = 'Cuti';
    //     //         } else {
    //     //             $rekomendasi = '-';
    //     //         }
    //     //     } elseif ($persentasePerwalian <= 0.5 || $nonAktifCount >= 5) {
    //     //         $rekomendasi = 'Mengundurkan Diri';
    //     //     } elseif ($nonAktifCount > 0) {
    //     //         $rekomendasi = 'Cuti';
    //     //     }
    //     // }

    //     // return array_merge([
    //     //     $no++,
    //     //     $row->nim,
    //     //     $row->nama,
    //     //     $row->programstudi,
    //     //     $row->statusmahasiswa,
    //     // ], $periodeData, [$rekomendasi]);

    //     $periodePerwalian = array_map(function ($periode) use ($perwalianMap) {
    //         return isset($perwalianMap[$periode])
    //             ? $perwalianMap[$periode]['status_mahasiswa']
    //             : '-';
    //     }, $this->periodeList);

    //     $periodeDPP = array_map(function ($periode) use ($invoiceDPP) {
    //         if (!isset($invoiceDPP[$periode])) return '-';

    //         $invoices = $invoiceDPP[$periode];
    //         $isLunasAll = $invoices->every(fn($inv) => $inv['is_lunas']);
    //         return $isLunasAll ? 'Lunas' : 'Belum Lunas';
    //     }, $this->periodeList);

    //     // Logika Rekomendasi (dapat disesuaikan dengan invoice juga jika mau)
    //     $rekomendasi = '-';
    //     if (strtolower($row->statusmahasiswa) === 'aktif') {
    //         $totalPeriode = count($this->periodeList);
    //         $filteredPerwalian = collect($row->perwalian)->whereIn('id_periode', $this->periodeList);

    //         $jumlahPerwalian = $filteredPerwalian->count();
    //         $nonAktifCount = $filteredPerwalian->where('status_mahasiswa', 'Non Aktif')->count();
    //         $aktifCount = $filteredPerwalian->where('status_mahasiswa', 'Aktif')->count();

    //         $persentasePerwalian = $totalPeriode > 0 ? ($jumlahPerwalian / $totalPeriode) : 0;

    //         if ($nonAktifCount === 0 && $jumlahPerwalian === $totalPeriode) {
    //             if ($aktifCount >= 12) {
    //                 $rekomendasi = 'Cuti';
    //             } else {
    //                 $rekomendasi = '-';
    //             }
    //         } elseif ($persentasePerwalian <= 0.5 || $nonAktifCount >= 5) {
    //             $rekomendasi = 'Mengundurkan Diri';
    //         } elseif ($nonAktifCount > 0) {
    //             $rekomendasi = 'Cuti';
    //         }
    //     }

    //     return array_merge([
    //         $no++,
    //         $row->nim,
    //         $row->nama,
    //         $row->programstudi,
    //         $row->statusmahasiswa,
    //     ], $periodePerwalian, $periodeDPP, [$rekomendasi]);
    // }

//    public function map($row): array
//     {
//         static $no = 1;

//         $perwalianMap = collect($row->perwalian)->keyBy('id_periode');
//         $invoiceDPP = collect($row->invoice)
//             ->where('id_jenis_akun', 'DPP')
//             ->groupBy('id_periode');

//         $periodeData = [];

//         foreach ($this->periodeList as $periode) {
//             $statusPerwalian = isset($perwalianMap[$periode])
//                 ? $perwalianMap[$periode]['status_mahasiswa']
//                 : '-';

//             if (!isset($invoiceDPP[$periode])) {
//                 $statusDPP = '-';
//             } else {
//                 $invoices = $invoiceDPP[$periode];
//                 $statusDPP = $invoices->every(fn($inv) => $inv['is_lunas']) ? 'Lunas' : 'Belum Lunas';
//             }

//             $periodeData[] = $statusPerwalian;
//             $periodeData[] = $statusDPP;
//         }

//         // Hitung total nominal_sisa_tagihan untuk DPP yang belum lunas
//         $totalBelumLunas = collect($row->invoice)
//             ->where('id_jenis_akun', 'DPP')
//             ->where('is_lunas', false)
//             ->sum(fn($inv) => floatval($inv['nominal_sisa_tagihan'] ?? 0));

//         // Rekomendasi tetap
//         $rekomendasi = '-';
//         if (strtolower($row->statusmahasiswa) === 'aktif') {
//             $totalPeriode = count($this->periodeList);
//             $filteredPerwalian = collect($row->perwalian)->whereIn('id_periode', $this->periodeList);

//             $jumlahPerwalian = $filteredPerwalian->count();
//             $nonAktifCount = $filteredPerwalian->where('status_mahasiswa', 'Non Aktif')->count();
//             $aktifCount = $filteredPerwalian->where('status_mahasiswa', 'Aktif')->count();

//             $persentasePerwalian = $totalPeriode > 0 ? ($jumlahPerwalian / $totalPeriode) : 0;

//             if ($nonAktifCount === 0 && $jumlahPerwalian === $totalPeriode) {
//                 $rekomendasi = $aktifCount >= 12 ? 'Cuti' : '-';
//             } elseif ($persentasePerwalian <= 0.5 || $nonAktifCount >= 5) {
//                 $rekomendasi = 'Mengundurkan Diri';
//             } elseif ($nonAktifCount > 0) {
//                 $rekomendasi = 'Cuti';
//             }
//         }

//         return array_merge([
//             $no++,
//             $row->nim,
//             $row->nama,
//             $row->programstudi,
//             $row->statusmahasiswa,
//         ], $periodeData, [
//             number_format($totalBelumLunas, 0, ',', '.'), // misalnya dalam format ribuan
//             $rekomendasi
//         ]);
//     }

  public function map($row): array
    {
        static $no = 1;

        $perwalianMap = collect($row->perwalian)->keyBy('id_periode');
        $invoiceDpp = collect($row->invoice)
            ->where('id_jenis_akun', 'DPP')
            ->groupBy('id_periode');

        $periodeData = [];

        foreach ($this->periodeList as $periode) {
            $statusPerwalian = isset($perwalianMap[$periode])
                ? $perwalianMap[$periode]['status_mahasiswa']
                : '-';

            $tagihan = $invoiceDpp->get($periode, collect());

            if ($tagihan->isEmpty()) {
                $statusKeuangan = '-';
            } else {
                $belumLunas = $tagihan->where('is_lunas', false)->sum('nominal_sisa_tagihan');
                $statusKeuangan = $belumLunas > 0 ? 'Belum Lunas' : 'Lunas';
            }

            $periodeData[] = $statusPerwalian;
            $periodeData[] = $statusKeuangan;
        }

        // Hitung jumlah belum lunas secara total
        $belumLunasInvoices = collect($row->invoice)
            ->where('id_jenis_akun', 'DPP')
            ->where('is_lunas', false);

        $jumlahBelumLunas = collect($row->invoice)
            ->where('id_jenis_akun', 'DPP')
            ->where('is_lunas', false)
            ->groupBy('id_periode') // penting: kelompokan berdasarkan periode
            ->count();

        $totalNominalBelumLunas = $belumLunasInvoices->sum(fn($inv) => floatval($inv['nominal_sisa_tagihan'] ?? 0));

        // Rekap status perwalian
        $totalPeriode = count($this->periodeList);
        $filteredPerwalian = collect($row->perwalian)->whereIn('id_periode', $this->periodeList);
        $jumlahPerwalian = $filteredPerwalian->count();
        $nonAktifCount = $filteredPerwalian->where('status_mahasiswa', 'Non Aktif')->count();

        $persentasePerwalian = $totalPeriode > 0 ? ($jumlahPerwalian / $totalPeriode) : 0;

        // Cek dua periode terakhir apakah Non Aktif semua
        $duaPeriodeAkhir = array_slice($this->periodeList, -2);
        $duaPeriodeNonAktif = collect($duaPeriodeAkhir)->every(function ($periode) use ($perwalianMap) {
            return isset($perwalianMap[$periode]) && $perwalianMap[$periode]['status_mahasiswa'] === 'Non Aktif';
        });

        // Rekomendasi
        $rekomendasi = '-';

        // if (strtolower($row->statusmahasiswa) === 'aktif') {
            
            // logika rekomendasi
            // '-' untuk kondisi jumlah belum lunas ada dibawah 2, nonaktif = 0, jumlah perwalian = total periode
            // 'cuti' jika jumlah perwalian = total periode, nonaktif <= 4,
            // 'mengundurkan diri' jika persentase perwalian <= 0.5 atau nonaktif >= 5, belum lunas >= 5


            // kategori 1 (Tidak ada tindakan)
                // aktif semua, tunggakan ada kurang dari 1, tidak ada nonaktif, perwalian lengkap 
                
            // kategori 2 (Cuti)
                // ada tunggakan <= 2, perwalian lengkap, nonaktif <= 4
                // ada tunggakan <= 4 dan dua periode terakhir nonaktif semua

            // kategori 3 (Mengundurkan Diri)
                // persentase perwalian <= 0.5, nonaktif >= 5, atau tunggakan >= 5
            
        // }
        if (strtolower($row->statusmahasiswa) === 'aktif') {
            
            // mengudurkanDiri:
            // if ($persentasePerwalian <= 0.5 || $nonAktifCount >= 5 || ($jumlahBelumLunas >= 5 && $jumlah) {
            //     $rekomendasi = 'Mengundurkan Diri';
            // } 
            
            // tidak ada tindakan:
            
            //cuti:
            if ($jumlahBelumLunas <= 2 && $jumlahPerwalian === $totalPeriode && $nonAktifCount <= 4) {
                $rekomendasi = 'Cuti';
            }

            if ($jumlahBelumLunas < 1 && $nonAktifCount === 0 && $jumlahPerwalian === $totalPeriode) {
                $rekomendasi = '-';
            }


        }

        return array_merge([
            $no++,
            $row->nim,
            $row->nama,
            $row->programstudi,
            $row->statusmahasiswa,
        ], $periodeData, [
            number_format($totalNominalBelumLunas, 2, ',', '.'),
            $rekomendasi,
            $jumlahBelumLunas,
            $nonAktifCount,
            $jumlahPerwalian,
            $totalPeriode
        ]);
    }
}
