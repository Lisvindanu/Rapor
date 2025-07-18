<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\KeuanganMataAnggaran;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;

class KeuanganMataAnggaranSeeder extends Seeder
{
    public function run(): void
    {
        // Data mata anggaran sesuai struktur yang benar dari gambar
        $mataAnggaranData = [
            // I. IMPLEMENTASI VISI DAN MISI (parent)
            [
                'kode' => 'I',
                'nama' => 'IMPLEMENTASI VISI DAN MISI',
                'kategori' => 'debet',
                'children' => [
                    [
                        'kode' => '1.2',
                        'nama' => 'Pendanaan Kegiatan (Diskusi, Seminar Ke-Islaman dan Ke-Sunda-an, SPJ dll.)',
                        'kategori' => 'debet'
                    ],
                    [
                        'kode' => '1.3',
                        'nama' => 'Haji, Umroh dan Qurban',
                        'kategori' => 'debet'
                    ]
                ]
            ],

            // II. PENDIDIKAN DAN PENGAJARAN
            [
                'kode' => 'II',
                'nama' => 'PENDIDIKAN DAN PENGAJARAN',
                'kategori' => 'debet',
                'children' => [
                    [
                        'kode' => '2.2',
                        'nama' => 'Evaluasi Kurikulum dan Perangkat Pembelajaran',
                        'kategori' => 'debet'
                    ],
                    [
                        'kode' => '2.4',
                        'nama' => 'Peningkatan Status/Reakreditasi Program Studi',
                        'kategori' => 'debet'
                    ],
                    [
                        'kode' => '2.5',
                        'nama' => 'Dana Ujian',
                        'kategori' => 'debet'
                    ],
                    [
                        'kode' => '2.6',
                        'nama' => 'Bantuan Studi Lanjut',
                        'kategori' => 'debet'
                    ],
                    [
                        'kode' => '2.8',
                        'nama' => 'Monitoring dan Evaluasi Pendidikan dan Pengajaran',
                        'kategori' => 'debet'
                    ]
                ]
            ],

            // III. PENELITIAN
            [
                'kode' => 'III',
                'nama' => 'PENELITIAN',
                'kategori' => 'debet',
                'children' => [
                    [
                        'kode' => '3.4',
                        'nama' => 'Dana Kepakaran Penelitian',
                        'kategori' => 'debet'
                    ]
                ]
            ],

            // V. PEMBINAAN KEMAHASISWAAN
            [
                'kode' => 'V',
                'nama' => 'PEMBINAAN KEMAHASISWAAN',
                'kategori' => 'debet',
                'children' => [
                    [
                        'kode' => '5.1',
                        'nama' => 'Pembinaan & Pengemb. Penalaran Mahasiswa',
                        'kategori' => 'debet'
                    ],
                    [
                        'kode' => '5.3',
                        'nama' => 'Lomba Kreativitas dan Prestasi Mahasiswa',
                        'kategori' => 'debet'
                    ]
                ]
            ],

            // VI. KESEJAHTERAAN PEGAWAI DAN DOSEN
            [
                'kode' => 'VI',
                'nama' => 'KESEJAHTERAAN PEGAWAI DAN DOSEN',
                'kategori' => 'debet',
                'children' => [
                    [
                        'kode' => '6.2',
                        'nama' => 'Dana Kesehatan Pegawai',
                        'kategori' => 'debet'
                    ],
                    [
                        'kode' => '6.3',
                        'nama' => 'Asuransi Pegawai dan Pensiun',
                        'kategori' => 'debet'
                    ],
                    [
                        'kode' => '6.4',
                        'nama' => 'Bantuan musibah/Pernikahan/Kelahiran dll.',
                        'kategori' => 'debet'
                    ],
                    [
                        'kode' => '6.6',
                        'nama' => 'Transport Perjalanan Dinas Tenaga Pendidikan dan Kependidikan',
                        'kategori' => 'debet'
                    ],
                    [
                        'kode' => '6.7',
                        'nama' => 'Panitia Adchok & Incentif Lain-lain',
                        'kategori' => 'debet'
                    ],
                    [
                        'kode' => '6.8',
                        'nama' => 'Biaya Pengendalian Manajemen',
                        'kategori' => 'debet'
                    ],
                    [
                        'kode' => '6.10',
                        'nama' => 'Pembinaan Pegawai',
                        'kategori' => 'debet'
                    ]
                ]
            ],

            // VII. SARANA DAN PRASARANA
            [
                'kode' => 'VII',
                'nama' => 'SARANA DAN PRASARANA',
                'kategori' => 'debet',
                'children' => [
                    [
                        'kode' => '7.1',
                        'nama' => 'ATK dan Sejenisnya',
                        'kategori' => 'debet'
                    ],
                    [
                        'kode' => '7.2',
                        'nama' => 'Pengadaan Inventaris Kantor',
                        'kategori' => 'debet'
                    ],
                    [
                        'kode' => '7.3',
                        'nama' => 'Listrik, Air, Ledeng dan Telepon',
                        'kategori' => 'debet'
                    ],
                    [
                        'kode' => '7.4',
                        'nama' => 'Pemeliharaan Sarana dan Prasarana',
                        'kategori' => 'debet'
                    ],
                    [
                        'kode' => '7.5',
                        'nama' => 'Kebersihan Lingkungan',
                        'kategori' => 'debet'
                    ],
                    [
                        'kode' => '7.7',
                        'nama' => 'Pengembangan Teknologi Informasi dan Komunikasi',
                        'kategori' => 'debet'
                    ]
                ]
            ],

            // VIII. KERJASAMA, PROMOSI DAN BANTUAN SOSIAL/KELEMBAGAAN
            [
                'kode' => 'VIII',
                'nama' => 'KERJASAMA, PROMOSI DAN BANTUAN SOSIAL/KELEMBAGAAN',
                'kategori' => 'debet',
                'children' => [
                    [
                        'kode' => '8.2',
                        'nama' => 'Promosi',
                        'kategori' => 'debet'
                    ],
                    [
                        'kode' => '8.3',
                        'nama' => 'Bantuan Sosial/Kelembagaan',
                        'kategori' => 'debet'
                    ]
                ]
            ]
        ];

        // Hapus data lama jika ada (PostgreSQL compatible)
        $this->command->info('🗑️  Menghapus data lama...');

        // Untuk PostgreSQL, hapus children dulu, kemudian parent
        KeuanganMataAnggaran::whereNotNull('parent_mata_anggaran')->delete();
        KeuanganMataAnggaran::whereNull('parent_mata_anggaran')->delete();

        $this->command->info('📝 Membuat data mata anggaran baru...');

        foreach ($mataAnggaranData as $parentData) {
            // Create parent mata anggaran
            $parent = KeuanganMataAnggaran::create([
                'id' => Str::uuid(),
                'kode_mata_anggaran' => $parentData['kode'],
                'nama_mata_anggaran' => $parentData['nama'],
                'parent_mata_anggaran' => null,
                'kategori' => $parentData['kategori'],
            ]);

            $this->command->info("✅ Parent: {$parent->kode_mata_anggaran} - {$parent->nama_mata_anggaran}");

            // Create children mata anggaran
            if (isset($parentData['children'])) {
                foreach ($parentData['children'] as $childData) {
                    $child = KeuanganMataAnggaran::create([
                        'id' => Str::uuid(),
                        'kode_mata_anggaran' => $childData['kode'],
                        'nama_mata_anggaran' => $childData['nama'],
                        'parent_mata_anggaran' => $parent->id,
                        'kategori' => $childData['kategori'],
                    ]);

                    $this->command->info("   ↳ Child: {$child->kode_mata_anggaran} - {$child->nama_mata_anggaran}");
                }
            }
        }

        $parentCount = KeuanganMataAnggaran::whereNull('parent_mata_anggaran')->count();
        $childCount = KeuanganMataAnggaran::whereNotNull('parent_mata_anggaran')->count();

        $this->command->info('');
        $this->command->info('🎉 Keuangan Mata Anggaran seeder completed successfully!');
        $this->command->info("📊 Total Parent: {$parentCount}");
        $this->command->info("📊 Total Children: {$childCount}");
        $this->command->info("📊 Total Records: " . ($parentCount + $childCount));
    }
}
