<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\KeuanganMataAnggaran;
use Illuminate\Support\Str;

class KeuanganMataAnggaranSeeder extends Seeder
{
    public function run(): void
    {
        // Data mata anggaran dengan struktur baru (hanya debet/kredit)
        $mataAnggaranData = [
            // MATA ANGGARAN DEBET (PENGELUARAN/BIAYA)
            [
                'kode' => '1',
                'nama' => 'IMPLEMENTASI VISI DAN MISI',
                'kategori' => 'debet',
                'children' => [
                    [
                        'kode' => '1.1',
                        'nama' => 'Pendanaan Kegiatan Diskusi dan Seminar',
                        'kategori' => 'debet'
                    ],
                    [
                        'kode' => '1.2',
                        'nama' => 'Haji, Umroh dan Qurban',
                        'kategori' => 'debet'
                    ]
                ]
            ],
            [
                'kode' => '2',
                'nama' => 'PENDIDIKAN DAN PENGAJARAN',
                'kategori' => 'debet',
                'children' => [
                    [
                        'kode' => '2.1',
                        'nama' => 'Evaluasi Kurikulum dan Perangkat Pembelajaran',
                        'kategori' => 'debet'
                    ],
                    [
                        'kode' => '2.2',
                        'nama' => 'Peningkatan Status/Reakreditasi Program Studi',
                        'kategori' => 'debet'
                    ],
                    [
                        'kode' => '2.3',
                        'nama' => 'Dana Ujian',
                        'kategori' => 'debet'
                    ]
                ]
            ],
            [
                'kode' => '3',
                'nama' => 'PENELITIAN',
                'kategori' => 'debet',
                'children' => [
                    [
                        'kode' => '3.1',
                        'nama' => 'Dana Kepakaran Penelitian',
                        'kategori' => 'debet'
                    ]
                ]
            ],
            [
                'kode' => '4',
                'nama' => 'KESEJAHTERAAN PEGAWAI DAN DOSEN',
                'kategori' => 'debet',
                'children' => [
                    [
                        'kode' => '4.1',
                        'nama' => 'Dana Kesehatan Pegawai',
                        'kategori' => 'debet'
                    ],
                    [
                        'kode' => '4.2',
                        'nama' => 'Asuransi Pegawai dan Pensiun',
                        'kategori' => 'debet'
                    ],
                    [
                        'kode' => '4.3',
                        'nama' => 'Transport Perjalanan Dinas',
                        'kategori' => 'debet'
                    ]
                ]
            ],
            [
                'kode' => '5',
                'nama' => 'SARANA DAN PRASARANA',
                'kategori' => 'debet',
                'children' => [
                    [
                        'kode' => '5.1',
                        'nama' => 'ATK dan Sejenisnya',
                        'kategori' => 'debet'
                    ],
                    [
                        'kode' => '5.2',
                        'nama' => 'Pengadaan Inventaris Kantor',
                        'kategori' => 'debet'
                    ],
                    [
                        'kode' => '5.3',
                        'nama' => 'Listrik, Air, dan Telepon',
                        'kategori' => 'debet'
                    ]
                ]
            ],

            // MATA ANGGARAN KREDIT (PENDAPATAN/PENERIMAAN)
            [
                'kode' => '10',
                'nama' => 'PENDAPATAN OPERASIONAL',
                'kategori' => 'kredit',
                'children' => [
                    [
                        'kode' => '10.1',
                        'nama' => 'Uang Kuliah Mahasiswa',
                        'kategori' => 'kredit'
                    ],
                    [
                        'kode' => '10.2',
                        'nama' => 'Biaya Pendaftaran',
                        'kategori' => 'kredit'
                    ],
                    [
                        'kode' => '10.3',
                        'nama' => 'Biaya Wisuda',
                        'kategori' => 'kredit'
                    ]
                ]
            ],
            [
                'kode' => '11',
                'nama' => 'PENDAPATAN NON-OPERASIONAL',
                'kategori' => 'kredit',
                'children' => [
                    [
                        'kode' => '11.1',
                        'nama' => 'Hibah dan Donasi',
                        'kategori' => 'kredit'
                    ],
                    [
                        'kode' => '11.2',
                        'nama' => 'Pendapatan Kerjasama',
                        'kategori' => 'kredit'
                    ],
                    [
                        'kode' => '11.3',
                        'nama' => 'Bunga Bank',
                        'kategori' => 'kredit'
                    ]
                ]
            ],
            [
                'kode' => '12',
                'nama' => 'PENDAPATAN LAIN-LAIN',
                'kategori' => 'kredit',
                'children' => [
                    [
                        'kode' => '12.1',
                        'nama' => 'Penjualan Aset',
                        'kategori' => 'kredit'
                    ],
                    [
                        'kode' => '12.2',
                        'nama' => 'Pendapatan Sewa',
                        'kategori' => 'kredit'
                    ]
                ]
            ]
        ];

        foreach ($mataAnggaranData as $parentData) {
            // Create parent mata anggaran
            $parent = KeuanganMataAnggaran::create([
                'id' => Str::uuid(),
                'kode_mata_anggaran' => $parentData['kode'],
                'nama_mata_anggaran' => $parentData['nama'],
                'parent_mata_anggaran' => null,
                'kategori' => $parentData['kategori'],
            ]);

            // Create children mata anggaran
            if (isset($parentData['children'])) {
                foreach ($parentData['children'] as $childData) {
                    KeuanganMataAnggaran::create([
                        'id' => Str::uuid(),
                        'kode_mata_anggaran' => $childData['kode'],
                        'nama_mata_anggaran' => $childData['nama'],
                        'parent_mata_anggaran' => $parent->id,
                        'kategori' => $childData['kategori'],
                    ]);
                }
            }
        }

        $this->command->info('Keuangan Mata Anggaran seeder completed successfully!');
    }
}
