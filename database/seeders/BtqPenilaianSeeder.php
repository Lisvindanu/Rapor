<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\BtqPenilaian;
use Illuminate\Support\Str;

class BtqPenilaianSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Contoh data untuk tabel btq_penilaian
        $data = [
            // Bacaan
            [
                'no_urut' => 1,
                'jenis_penilaian' => 'Bacaan',
                'text_penilaian' => 'Penilaian bacaan Al-Quran secara tartil',
                'is_active' => true,
            ],
            [
                'no_urut' => 2,
                'jenis_penilaian' => 'Bacaan',
                'text_penilaian' => 'Penilaian kelancaran bacaan Al-Quran',
                'is_active' => true,
            ],
            // Tulisan
            [
                'no_urut' => 1,
                'jenis_penilaian' => 'Tulisan',
                'text_penilaian' => 'Penilaian ketepatan penulisan huruf Arab',
                'is_active' => true,
            ],
            [
                'no_urut' => 2,
                'jenis_penilaian' => 'Tulisan',
                'text_penilaian' => 'Penilaian kerapihan tulisan huruf Arab',
                'is_active' => true,
            ],
            // Hafalan
            [
                'no_urut' => 1,
                'jenis_penilaian' => 'Hafalan',
                'text_penilaian' => 'Penilaian hafalan surah pendek',
                'is_active' => true,
            ],
            [
                'no_urut' => 2,
                'jenis_penilaian' => 'Hafalan',
                'text_penilaian' => 'Penilaian hafalan dengan tajwid yang benar',
                'is_active' => true,
            ],
        ];

        foreach ($data as $item) {
            BtqPenilaian::create([
                'no_urut' => $item['no_urut'],
                'jenis_penilaian' => $item['jenis_penilaian'],
                'text_penilaian' => $item['text_penilaian'],
                'is_active' => $item['is_active'],
            ]);
        }
    }
}
