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
        // Disable foreign key checks for truncation, syntax depends on the database
        if (DB::getDriverName() === 'mysql') {
            DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        }

        $this->command->info('🗑️ Menghapus data lama...');
        KeuanganMataAnggaran::truncate();

        if (DB::getDriverName() === 'mysql') {
            DB::statement('SET FOREIGN_KEY_CHECKS=1;');
        } elseif (DB::getDriverName() === 'pgsql') {
            // For PostgreSQL, truncate with cascade handles it
            // No need for a separate command here if using TRUNCATE ... CASCADE
        }

        $this->command->info('📝 Membuat data mata anggaran baru...');

        // Data mata anggaran lengkap sesuai gambar
        $mataAnggaranData = [
            // I. IMPLEMENTASI VISI DAN MISI
            [
                'kode' => 'I', 'nama' => 'IMPLEMENTASI VISI DAN MISI', 'kategori' => 'debet',
                'children' => [
                    ['kode' => '1.1', 'nama' => 'Bantuan Keagamaan', 'kategori' => 'debet'],
                    ['kode' => '1.2', 'nama' => 'Pendanaan Kegiatan (Diskusi, Seminar Ke-Islaman dan Ke-Sunda-an, SPJ dll.)', 'kategori' => 'debet'],
                    ['kode' => '1.3', 'nama' => 'Haji, Umroh dan Qurban', 'kategori' => 'debet'],
                ]
            ],
            // II. PENDIDIKAN DAN PENGAJARAN
            [
                'kode' => 'II', 'nama' => 'PENDIDIKAN DAN PENGAJARAN', 'kategori' => 'debet',
                'children' => [
                    ['kode' => '2.1', 'nama' => 'Honorarium Mengajar/Praktikum/Ujian dan Bimbingan', 'kategori' => 'debet'],
                    ['kode' => '2.2', 'nama' => 'Evaluasi Kurikulum dan Perangkat Pembelajaran', 'kategori' => 'debet'],
                    ['kode' => '2.3', 'nama' => 'Workshop/Seminar/Pelatihan Dosen', 'kategori' => 'debet'],
                    ['kode' => '2.4', 'nama' => 'Peningkatan Status/Reakreditasi Program Studi', 'kategori' => 'debet'],
                    ['kode' => '2.5', 'nama' => 'Dana Ujian', 'kategori' => 'debet'],
                    ['kode' => '2.6', 'nama' => 'Bantuan Studi Lanjut', 'kategori' => 'debet'],
                    ['kode' => '2.7', 'nama' => 'Langganan Jurnal Ilmiah/Buku', 'kategori' => 'debet'],
                    ['kode' => '2.8', 'nama' => 'Monitoring dan Evaluasi Pendidikan dan Pengajaran', 'kategori' => 'debet'],
                ]
            ],
            // III. PENELITIAN
            [
                'kode' => 'III', 'nama' => 'PENELITIAN', 'kategori' => 'debet',
                'children' => [
                    ['kode' => '3.1', 'nama' => 'Bantuan Penelitian Internal', 'kategori' => 'debet'],
                    ['kode' => '3.2', 'nama' => 'Workshop/Seminar/Pelatihan Penelitian', 'kategori' => 'debet'],
                    ['kode' => '3.3', 'nama' => 'Seminar/Publikasi Hasil Penelitian', 'kategori' => 'debet'],
                    ['kode' => '3.4', 'nama' => 'Dana Kepakaran Penelitian', 'kategori' => 'debet'],
                ]
            ],
            // IV. PENGABDIAN MASYARAKAT
            [
                'kode' => 'IV', 'nama' => 'PENGABDIAN MASYARAKAT', 'kategori' => 'debet',
                'children' => [
                    ['kode' => '4.1', 'nama' => 'Honorarium Panitia/Peserta/Narasumber', 'kategori' => 'debet'],
                    ['kode' => '4.2', 'nama' => 'Pembuatan Proposal, ATK, Penggandaan', 'kategori' => 'debet'],
                    ['kode' => '4.3', 'nama' => 'Transportasi dan Akomodasi', 'kategori' => 'debet'],
                    ['kode' => '4.4', 'nama' => 'Konsumsi', 'kategori' => 'debet'],
                    ['kode' => '4.5', 'nama' => 'Publikasi', 'kategori' => 'debet'],
                    ['kode' => '4.6', 'nama' => 'Lain-lain', 'kategori' => 'debet'],
                ]
            ],
            // V. PEMBINAAN KEMAHASISWAAN
            [
                'kode' => 'V', 'nama' => 'PEMBINAAN KEMAHASISWAAN', 'kategori' => 'debet',
                'children' => [
                    ['kode' => '5.1', 'nama' => 'Pembinaan & Pengemb. Penalaran Mahasiswa', 'kategori' => 'debet'],
                    ['kode' => '5.2', 'nama' => 'Bantuan Kegiatan Mahasiswa', 'kategori' => 'debet'],
                    ['kode' => '5.3', 'nama' => 'Lomba Kreativitas dan Prestasi Mahasiswa', 'kategori' => 'debet'],
                    ['kode' => '5.4', 'nama' => 'Bantuan Lain-lain', 'kategori' => 'debet'],
                ]
            ],
            // VI. KESEJAHTERAAN PEGAWAI DAN DOSEN
            [
                'kode' => 'VI', 'nama' => 'KESEJAHTERAAN PEGAWAI DAN DOSEN', 'kategori' => 'debet',
                'children' => [
                    ['kode' => '6.1', 'nama' => 'Incentif Kehadiran Dosen dan Tenaga Kependidikan', 'kategori' => 'debet'],
                    ['kode' => '6.2', 'nama' => 'Dana Kesehatan Pegawai', 'kategori' => 'debet'],
                    ['kode' => '6.3', 'nama' => 'Asuransi Pegawai dan Pensiun', 'kategori' => 'debet'],
                    ['kode' => '6.4', 'nama' => 'Bantuan musibah/Pernikahan/Kelahiran dll.', 'kategori' => 'debet'],
                    ['kode' => '6.5', 'nama' => 'Tunjangan Hari Raya', 'kategori' => 'debet'],
                    ['kode' => '6.6', 'nama' => 'Transport Perjalanan Dinas Tenaga Pendidikan dan Kependidikan', 'kategori' => 'debet'],
                    ['kode' => '6.7', 'nama' => 'Panitia Adchok & Incentif Lain-lain', 'kategori' => 'debet'],
                    ['kode' => '6.8', 'nama' => 'Biaya Pengendalian Manajemen', 'kategori' => 'debet'],
                    ['kode' => '6.9', 'nama' => 'Seragam Pegawai', 'kategori' => 'debet'],
                    ['kode' => '6.10', 'nama' => 'Pembinaan Pegawai', 'kategori' => 'debet'],
                ]
            ],
            // VII. SARANA DAN PRASARANA
            [
                'kode' => 'VII', 'nama' => 'SARANA DAN PRASARANA', 'kategori' => 'debet',
                'children' => [
                    ['kode' => '7.1', 'nama' => 'ATK dan Sejenisnya', 'kategori' => 'debet'],
                    ['kode' => '7.2', 'nama' => 'Pengadaan Inventaris Kantor', 'kategori' => 'debet'],
                    ['kode' => '7.3', 'nama' => 'Listrik, Air, Ledeng dan Telepon', 'kategori' => 'debet'],
                    ['kode' => '7.4', 'nama' => 'Pemeliharaan Sarana dan Prasarana', 'kategori' => 'debet'],
                    ['kode' => '7.5', 'nama' => 'Kebersihan Lingkungan', 'kategori' => 'debet'],
                    ['kode' => '7.6', 'nama' => 'Keamanan', 'kategori' => 'debet'],
                    ['kode' => '7.7', 'nama' => 'Pengembangan Teknologi Informasi dan Komunikasi', 'kategori' => 'debet'],
                ]
            ],
            // VIII. KERJASAMA, PROMOSI DAN BANTUAN SOSIAL/KELEMBAGAAN
            [
                'kode' => 'VIII', 'nama' => 'KERJASAMA, PROMOSI DAN BANTUAN SOSIAL/KELEMBAGAAN', 'kategori' => 'debet',
                'children' => [
                    ['kode' => '8.1', 'nama' => 'Kerjasama Kelembagaan', 'kategori' => 'debet'],
                    ['kode' => '8.2', 'nama' => 'Promosi', 'kategori' => 'debet'],
                    ['kode' => '8.3', 'nama' => 'Bantuan Sosial/Kelembagaan', 'kategori' => 'debet'],
                ]
            ],
            // IX. PENDAPATAN
            [
                'kode' => 'IX', 'nama' => 'PENDAPATAN', 'kategori' => 'kredit',
                'children' => [
                    ['kode' => '9.1', 'nama' => 'Dana Pengembangan', 'kategori' => 'kredit'],
                    ['kode' => '9.2', 'nama' => 'Dana Registrasi', 'kategori' => 'kredit'],
                    ['kode' => '9.3', 'nama' => 'Dana SKS', 'kategori' => 'kredit'],
                    ['kode' => '9.4', 'nama' => 'Dana Ujian', 'kategori' => 'kredit'],
                    ['kode' => '9.5', 'nama' => 'Dana Lain-lain', 'kategori' => 'kredit'],
                    ['kode' => '9.6', 'nama' => 'Dana Perpustakaan', 'kategori' => 'kredit'],
                    ['kode' => '9.7', 'nama' => 'Dana Kemahasiswaan', 'kategori' => 'kredit'],
                    ['kode' => '9.8', 'nama' => 'Dana Praktikum', 'kategori' => 'kredit'],
                    ['kode' => '9.9', 'nama' => 'Dana Wisuda', 'kategori' => 'kredit'],
                    ['kode' => '9.10', 'nama' => 'Pendapatan lain-lain', 'kategori' => 'kredit'],
                ]
            ],
        ];

        foreach ($mataAnggaranData as $parentData) {
            $parent = KeuanganMataAnggaran::create([
                'id' => Str::uuid(),
                'kode_mata_anggaran' => $parentData['kode'],
                'nama_mata_anggaran' => $parentData['nama'],
                'parent_mata_anggaran' => null,
                'kategori' => $parentData['kategori'],
            ]);

            $this->command->info("✅ Parent: {$parent->kode_mata_anggaran} - {$parent->nama_mata_anggaran}");

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
