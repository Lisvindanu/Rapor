<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\KeuanganMataAnggaran;
use Illuminate\Support\Str;

class KeuanganMataAnggaranSeeder extends Seeder
{
    public function run(): void
    {
        $tahunAnggaran = date('Y');

        // Data mata anggaran sesuai gambar yang diberikan
        $mataAnggaranData = [
            [
                'kode' => '1',
                'nama' => 'IMPLEMENTASI VISI DAN MISI',
                'nama_en' => 'Implementation of Vision and Mission',
                'kategori' => 'Visi Misi',
                'children' => [
                    [
                        'kode' => '1.2',
                        'nama' => 'Pendanaan Kegiatan (Diskusi, Seminar Ke-Islaman dan Ke-Sundaan, SPJ dll.)',
                        'nama_en' => 'Activity Funding (Discussion, Islamic and Sundanese Seminars, SPJ etc.)',
                        'alokasi' => 5000000
                    ],
                    [
                        'kode' => '1.3',
                        'nama' => 'Haji, Umroh dan Qurban',
                        'nama_en' => 'Hajj, Umrah and Qurban',
                        'alokasi' => 3000000
                    ]
                ]
            ],
            [
                'kode' => '2',
                'nama' => 'PENDIDIKAN DAN PENGAJARAN',
                'nama_en' => 'Education and Teaching',
                'kategori' => 'Pendidikan',
                'children' => [
                    [
                        'kode' => '2.2',
                        'nama' => 'Evaluasi Kurikulum dan Perangkat Pembelajaran',
                        'nama_en' => 'Curriculum and Learning Tools Evaluation',
                        'alokasi' => 2500000
                    ],
                    [
                        'kode' => '2.4',
                        'nama' => 'Peningkatan Status/Reakreditasi Program Studi',
                        'nama_en' => 'Status Improvement/Reaccreditation of Study Programs',
                        'alokasi' => 8000000
                    ],
                    [
                        'kode' => '2.5',
                        'nama' => 'Dana Ujian',
                        'nama_en' => 'Examination Fund',
                        'alokasi' => 1500000
                    ],
                    [
                        'kode' => '2.6',
                        'nama' => 'Bantuan Studi Lanjut',
                        'nama_en' => 'Further Study Assistance',
                        'alokasi' => 10000000
                    ],
                    [
                        'kode' => '2.8',
                        'nama' => 'Monitoring dan Evaluasi Pendidikan dan Pengajaran',
                        'nama_en' => 'Education and Teaching Monitoring and Evaluation',
                        'alokasi' => 3000000
                    ]
                ]
            ],
            [
                'kode' => '3',
                'nama' => 'PENELITIAN',
                'nama_en' => 'Research',
                'kategori' => 'Penelitian',
                'children' => [
                    [
                        'kode' => '3.4',
                        'nama' => 'Dana Kepakaran Penelitian',
                        'nama_en' => 'Research Expertise Fund',
                        'alokasi' => 15000000
                    ]
                ]
            ],
            [
                'kode' => '5',
                'nama' => 'PEMBINAAN KEMAHASISWAAN',
                'nama_en' => 'Student Development',
                'kategori' => 'Kemahasiswaan',
                'children' => [
                    [
                        'kode' => '5.1',
                        'nama' => 'Pembinaan & Pengemb.Pendaran Mahasiswa',
                        'nama_en' => 'Student Leadership Development',
                        'alokasi' => 4000000
                    ],
                    [
                        'kode' => '5.3',
                        'nama' => 'Lomba Kreativitas dan Prestasi Mahasiswa',
                        'nama_en' => 'Student Creativity and Achievement Competition',
                        'alokasi' => 6000000
                    ]
                ]
            ],
            [
                'kode' => '6',
                'nama' => 'KESEJAHTERAAN PEGAWAI DAN DOSEN',
                'nama_en' => 'Employee and Lecturer Welfare',
                'kategori' => 'Kesejahteraan',
                'children' => [
                    [
                        'kode' => '6.2',
                        'nama' => 'Dana Kesehatan Pegawai',
                        'nama_en' => 'Employee Health Fund',
                        'alokasi' => 7500000
                    ],
                    [
                        'kode' => '6.3',
                        'nama' => 'Asuransi Pegawai dan Pensiun',
                        'nama_en' => 'Employee Insurance and Pension',
                        'alokasi' => 12000000
                    ],
                    [
                        'kode' => '6.4',
                        'nama' => 'Bantuan musibah/Pernikahan/Kelahiran dll.',
                        'nama_en' => 'Disaster/Wedding/Birth Assistance etc.',
                        'alokasi' => 5000000
                    ],
                    [
                        'kode' => '6.6',
                        'nama' => 'Transport Perjalanan Dinas Tenaga Pendidikan dan Kependidikan',
                        'nama_en' => 'Official Travel Transport for Education Personnel',
                        'alokasi' => 8000000
                    ],
                    [
                        'kode' => '6.7',
                        'nama' => 'Panitia Adhok & Incentif Lain-lain',
                        'nama_en' => 'Ad-hoc Committee & Other Incentives',
                        'alokasi' => 4500000
                    ],
                    [
                        'kode' => '6.8',
                        'nama' => 'Biaya Pengendalian Manajemen',
                        'nama_en' => 'Management Control Costs',
                        'alokasi' => 3500000
                    ],
                    [
                        'kode' => '6.10',
                        'nama' => 'Pembinaan Pegawai',
                        'nama_en' => 'Employee Development',
                        'alokasi' => 6000000
                    ]
                ]
            ],
            [
                'kode' => '7',
                'nama' => 'SARANA DAN PRASARANA',
                'nama_en' => 'Facilities and Infrastructure',
                'kategori' => 'Sarana Prasarana',
                'children' => [
                    [
                        'kode' => '7.1',
                        'nama' => 'ATK dan Sejenisnya',
                        'nama_en' => 'Office Supplies and Similar',
                        'alokasi' => 4000000
                    ],
                    [
                        'kode' => '7.2',
                        'nama' => 'Pengadaan Inventaris Kantor',
                        'nama_en' => 'Office Inventory Procurement',
                        'alokasi' => 15000000
                    ],
                    [
                        'kode' => '7.3',
                        'nama' => 'Listrik, Air, Ledeng dan Telepon',
                        'nama_en' => 'Electricity, Water, Plumbing and Telephone',
                        'alokasi' => 18000000
                    ],
                    [
                        'kode' => '7.4',
                        'nama' => 'Pemeliharaan Sarana dan Prasarana',
                        'nama_en' => 'Facilities and Infrastructure Maintenance',
                        'alokasi' => 25000000
                    ],
                    [
                        'kode' => '7.5',
                        'nama' => 'Kebersihan Lingkungan',
                        'nama_en' => 'Environmental Cleanliness',
                        'alokasi' => 6000000
                    ],
                    [
                        'kode' => '7.7',
                        'nama' => 'Pengembangan Teknologi Informasi dan Komunikasi',
                        'nama_en' => 'Information and Communication Technology Development',
                        'alokasi' => 20000000
                    ]
                ]
            ],
            [
                'kode' => '8',
                'nama' => 'KERJASAMA, PROMOSI DAN BANTUAN SOSIAL/KELEMBAGAAN',
                'nama_en' => 'Cooperation, Promotion and Social/Institutional Aid',
                'kategori' => 'Kerjasama',
                'children' => [
                    [
                        'kode' => '8.2',
                        'nama' => 'Promosi',
                        'nama_en' => 'Promotion',
                        'alokasi' => 8000000
                    ],
                    [
                        'kode' => '8.3',
                        'nama' => 'Bantuan Sosial/Kelembagaan',
                        'nama_en' => 'Social/Institutional Aid',
                        'alokasi' => 5000000
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
                'nama_mata_anggaran_en' => $parentData['nama_en'],
                'kategori' => $parentData['kategori'],
                'parent_mata_anggaran' => null,
                'level_mata_anggaran' => 0,
                'alokasi_anggaran' => 0,
                'sisa_anggaran' => 0,
                'tahun_anggaran' => $tahunAnggaran,
                'status_aktif' => true,
                'created_by' => null,
                'updated_by' => null,
            ]);

            // Create children mata anggaran
            if (isset($parentData['children'])) {
                foreach ($parentData['children'] as $childData) {
                    KeuanganMataAnggaran::create([
                        'id' => Str::uuid(),
                        'kode_mata_anggaran' => $childData['kode'],
                        'nama_mata_anggaran' => $childData['nama'],
                        'nama_mata_anggaran_en' => $childData['nama_en'],
                        'parent_mata_anggaran' => $parent->id,
                        'level_mata_anggaran' => 1,
                        'alokasi_anggaran' => $childData['alokasi'],
                        'sisa_anggaran' => $childData['alokasi'],
                        'tahun_anggaran' => $tahunAnggaran,
                        'status_aktif' => true,
                        'created_by' => null,
                        'updated_by' => null,
                    ]);
                }
            }
        }

        $this->command->info('Keuangan Mata Anggaran seeder completed successfully!');
    }
}
