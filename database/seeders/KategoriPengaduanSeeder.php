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
        $kategori = [
            [
                'nama' => 'Kekerasan Seksual',
                'deskripsi' => 'Tindakan kekerasan yang bersifat seksual, termasuk pemerkosaan, pelecehan seksual fisik, dan tindakan seksual tanpa persetujuan',
                'is_active' => true
            ],
            [
                'nama' => 'Pelecehan Seksual',
                'deskripsi' => 'Ucapan, gesture, atau perilaku yang tidak pantas dan bersifat seksual yang membuat tidak nyaman',
                'is_active' => true
            ],
            [
                'nama' => 'Diskriminasi',
                'deskripsi' => 'Perlakuan tidak adil berdasarkan gender, ras, agama, orientasi seksual, atau karakteristik lainnya',
                'is_active' => true
            ],
            [
                'nama' => 'Bullying/Perundungan',
                'deskripsi' => 'Tindakan intimidasi, penghinaan, atau perundungan baik secara fisik maupun psikologis',
                'is_active' => true
            ],
            [
                'nama' => 'Penyalahgunaan Wewenang',
                'deskripsi' => 'Penggunaan posisi atau kekuasaan untuk melakukan tindakan yang tidak semestinya atau merugikan orang lain',
                'is_active' => true
            ],
            [
                'nama' => 'Cyber Bullying',
                'deskripsi' => 'Tindakan intimidasi, pelecehan, atau perundungan yang dilakukan melalui media digital atau online',
                'is_active' => true
            ],
            [
                'nama' => 'Lainnya',
                'deskripsi' => 'Kategori lain yang berkaitan dengan PPKPT dan tidak termasuk dalam kategori di atas',
                'is_active' => true
            ]
        ];

        foreach ($kategori as $item) {
            KategoriPengaduan::create($item);
        }
    }
}