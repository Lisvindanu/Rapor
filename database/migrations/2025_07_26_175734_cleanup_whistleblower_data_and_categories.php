<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\KategoriPengaduan;

class KategoriPengaduanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Hapus semua data kategori yang sudah ada
        KategoriPengaduan::truncate();
        
        // Data kategori baru sesuai permintaan
        $kategoris = [
            [
                'nama_kategori' => 'Kekerasan/Pelecehan',
                'deskripsi_kategori' => 'Laporan terkait kekerasan fisik, psikis, atau pelecehan dalam bentuk apapun',
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama_kategori' => 'Diskriminasi',
                'deskripsi_kategori' => 'Laporan terkait diskriminasi berdasarkan ras, agama, gender, atau latar belakang lainnya',
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama_kategori' => 'Bullying/Perundungan',
                'deskripsi_kategori' => 'Laporan terkait intimidasi, perundungan, atau bullying dalam bentuk apapun',
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ];

        // Insert data baru
        KategoriPengaduan::insert($kategoris);
    }
}