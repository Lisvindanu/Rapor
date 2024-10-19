<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\BtqPenilaian;

class BtqPenilaianSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Data untuk tabel btq_penilaian
        $data = [
            // Tulisan
            [
                'no_urut' => 1,
                'jenis_penilaian' => 'Tulisan',
                'text_penilaian' => 'Peserta menulis huruf hijaiyah dengan benar dan jelas',
                'is_active' => true,
            ],
            [
                'no_urut' => 2,
                'jenis_penilaian' => 'Tulisan',
                'text_penilaian' => 'Peserta dapat membedakan dan menulis huruf yang mirip (contoh: ba, ta, tsa)',
                'is_active' => true,
            ],
            [
                'no_urut' => 3,
                'jenis_penilaian' => 'Tulisan',
                'text_penilaian' => 'Peserta menulis tanda baca (fathah, kasrah, dhammah) dengan benar',
                'is_active' => true,
            ],
            [
                'no_urut' => 4,
                'jenis_penilaian' => 'Tulisan',
                'text_penilaian' => 'Peserta menulis tanda panjang (mad) dengan benar (contoh: مَٰلِكِ)',
                'is_active' => true,
            ],
            [
                'no_urut' => 5,
                'jenis_penilaian' => 'Tulisan',
                'text_penilaian' => 'Peserta menulis huruf bersyaddah dengan benar (contoh: رَبِّ)',
                'is_active' => true,
            ],
            [
                'no_urut' => 6,
                'jenis_penilaian' => 'Tulisan',
                'text_penilaian' => 'Peserta menulis tanda tanwin dan sukun dengan benar',
                'is_active' => true,
            ],
            [
                'no_urut' => 7,
                'jenis_penilaian' => 'Tulisan',
                'text_penilaian' => 'Peserta menulis huruf yang didiktekan dengan benar (2/4)',
                'is_active' => true,
            ],
            [
                'no_urut' => 8,
                'jenis_penilaian' => 'Tulisan',
                'text_penilaian' => 'Peserta menulis tanda baca yang didiktekan dengan benar (fathah, kasrah, dhammah) (2/4)',
                'is_active' => true,
            ],
            [
                'no_urut' => 9,
                'jenis_penilaian' => 'Tulisan',
                'text_penilaian' => 'Peserta menulis huruf bersambung yang didiktekan dengan benar (2/4)',
                'is_active' => true,
            ],
            [
                'no_urut' => 10,
                'jenis_penilaian' => 'Tulisan',
                'text_penilaian' => 'Peserta menulis tanda panjang (mad) yang didiktekan dengan tepat (2/4)',
                'is_active' => true,
            ],

            // Hafalan
            [
                'no_urut' => 1,
                'jenis_penilaian' => 'Hafalan',
                'text_penilaian' => 'An-Nas',
                'is_active' => true,
            ],
            [
                'no_urut' => 2,
                'jenis_penilaian' => 'Hafalan',
                'text_penilaian' => 'Al-Falaq',
                'is_active' => true,
            ],
            [
                'no_urut' => 3,
                'jenis_penilaian' => 'Hafalan',
                'text_penilaian' => 'Al-Ikhlas',
                'is_active' => true,
            ],
            [
                'no_urut' => 4,
                'jenis_penilaian' => 'Hafalan',
                'text_penilaian' => 'Al-Lahab',
                'is_active' => true,
            ],
            [
                'no_urut' => 5,
                'jenis_penilaian' => 'Hafalan',
                'text_penilaian' => 'An-Nasr',
                'is_active' => true,
            ],
            [
                'no_urut' => 6,
                'jenis_penilaian' => 'Hafalan',
                'text_penilaian' => 'Al-Kafirun',
                'is_active' => true,
            ],
            [
                'no_urut' => 7,
                'jenis_penilaian' => 'Hafalan',
                'text_penilaian' => 'Al-Kawthar',
                'is_active' => true,
            ],
            [
                'no_urut' => 8,
                'jenis_penilaian' => 'Hafalan',
                'text_penilaian' => 'Al-Ma\'un',
                'is_active' => true,
            ],
            [
                'no_urut' => 9,
                'jenis_penilaian' => 'Hafalan',
                'text_penilaian' => 'Quraisy',
                'is_active' => true,
            ],
            [
                'no_urut' => 10,
                'jenis_penilaian' => 'Hafalan',
                'text_penilaian' => 'Al-Fil',
                'is_active' => true,
            ],
            [
                'no_urut' => 11,
                'jenis_penilaian' => 'Hafalan',
                'text_penilaian' => 'Al-Humazah',
                'is_active' => true,
            ],
            [
                'no_urut' => 12,
                'jenis_penilaian' => 'Hafalan',
                'text_penilaian' => 'Al-Asr',
                'is_active' => true,
            ],
            [
                'no_urut' => 13,
                'jenis_penilaian' => 'Hafalan',
                'text_penilaian' => 'At-Takathur',
                'is_active' => true,
            ],
            [
                'no_urut' => 14,
                'jenis_penilaian' => 'Hafalan',
                'text_penilaian' => 'Al-Qari\'ah',
                'is_active' => true,
            ],
            [
                'no_urut' => 15,
                'jenis_penilaian' => 'Hafalan',
                'text_penilaian' => 'Al-Adiyat',
                'is_active' => true,
            ],
            [
                'no_urut' => 16,
                'jenis_penilaian' => 'Hafalan',
                'text_penilaian' => 'Hafal Juz 30',
                'is_active' => true,
            ],
            [
                'no_urut' => 17,
                'jenis_penilaian' => 'Hafalan',
                'text_penilaian' => 'Hafal Lebih dari 2 Juz',
                'is_active' => true,
            ],
            [
                'no_urut' => 18,
                'jenis_penilaian' => 'Hafalan',
                'text_penilaian' => 'Hafal Lebih dari 5 Juz',
                'is_active' => true,
            ],
            [
                'no_urut' => 19,
                'jenis_penilaian' => 'Hafalan',
                'text_penilaian' => 'Hafal Lebih dari 10 Juz',
                'is_active' => true,
            ],
            [
                'no_urut' => 20,
                'jenis_penilaian' => 'Hafalan',
                'text_penilaian' => 'Hafal 30 Juz',
                'is_active' => true,
            ],

            // Bacaan
            [
                'no_urut' => 1,
                'jenis_penilaian' => 'Bacaan',
                'text_penilaian' => 'Peserta mengenal huruf hijaiyah dengan benar',
                'is_active' => true,
            ],
            [
                'no_urut' => 2,
                'jenis_penilaian' => 'Bacaan',
                'text_penilaian' => 'Peserta membaca tanda baca dasar (fathah, kasrah, dhammah) dengan benar',
                'is_active' => true,
            ],
            [
                'no_urut' => 3,
                'jenis_penilaian' => 'Bacaan',
                'text_penilaian' => 'Peserta membaca huruf bersambung dengan benar (contoh: كٓهيعٓصٓ pada ayat 1)',
                'is_active' => true,
            ],
            [
                'no_urut' => 4,
                'jenis_penilaian' => 'Bacaan',
                'text_penilaian' => 'Peserta membaca huruf sukun dengan benar',
                'is_active' => true,
            ],
            [
                'no_urut' => 5,
                'jenis_penilaian' => 'Bacaan',
                'text_penilaian' => 'Peserta membaca huruf bersyaddah dengan benar (contoh: رَبُّكَ pada ayat 2)',
                'is_active' => true,
            ],
            [
                'no_urut' => 6,
                'jenis_penilaian' => 'Bacaan',
                'text_penilaian' => 'Peserta membaca dengan intonasi dan artikulasi yang baik',
                'is_active' => true,
            ],
            [
                'no_urut' => 7,
                'jenis_penilaian' => 'Bacaan',
                'text_penilaian' => 'Peserta membaca ayat pendek tanpa terhenti (ayat 1-3)',
                'is_active' => true,
            ],
            [
                'no_urut' => 8,
                'jenis_penilaian' => 'Bacaan',
                'text_penilaian' => 'Peserta membaca ayat yang lebih panjang tanpa kesalahan (ayat 4)',
                'is_active' => true,
            ],
            [
                'no_urut' => 9,
                'jenis_penilaian' => 'Bacaan',
                'text_penilaian' => 'Peserta membaca dengan irama yang baik dan teratur',
                'is_active' => true,
            ],
            [
                'no_urut' => 10,
                'jenis_penilaian' => 'Bacaan',
                'text_penilaian' => 'Peserta menyelesaikan bacaan tanpa kesalahan berarti sepanjang ayat 1-10',
                'is_active' => true,
            ],
            [
                'no_urut' => 11,
                'jenis_penilaian' => 'Bacaan',
                'text_penilaian' => 'Membaca ayat dengan jeda yang tepat sesuai kaidah waqaf (berhenti)',
                'is_active' => true,
            ],
            [
                'no_urut' => 12,
                'jenis_penilaian' => 'Bacaan',
                'text_penilaian' => 'Peserta menerapkan hukum izhar dengan benar',
                'is_active' => true,
            ],
            [
                'no_urut' => 13,
                'jenis_penilaian' => 'Bacaan',
                'text_penilaian' => 'Peserta menerapkan hukum ikhfa dengan tepat',
                'is_active' => true,
            ],
            [
                'no_urut' => 14,
                'jenis_penilaian' => 'Bacaan',
                'text_penilaian' => 'Peserta menerapkan hukum idgham dengan benar',
                'is_active' => true,
            ],
            [
                'no_urut' => 15,
                'jenis_penilaian' => 'Bacaan',
                'text_penilaian' => 'Peserta menerapkan hukum iqlab dengan benar',
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
