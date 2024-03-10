<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Soal;
use App\Models\Pertanyaan;
use Illuminate\Support\Str;

class SoalSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Seed data untuk Soal
        $soal1 = Soal::create([
            'id' => Str::uuid(),
            'nama_soal' => 'Kuisioner Kepuasan Pelanggan',
            'keterangan' => 'Kuisioner untuk mengukur tingkat kepuasan pelanggan terhadap produk kami.',
            'soal_acak' => false,
            'jawaban_acak' => true,
            'publik' => true,
        ]);

        // Seed data untuk Pertanyaan
        Pertanyaan::create([
            'id' => Str::uuid(),
            'soal_id' => $soal1->id,
            'pertanyaan' => 'Apakah Anda puas dengan kualitas produk kami?',
            'jawaban_benar' => 'Ya',
            'opsi_a' => 'Ya',
            'opsi_b' => 'Tidak',
            'tipe' => 'Range Nilai',
        ]);

        Pertanyaan::create([
            'id' => Str::uuid(),
            'soal_id' => $soal1->id,
            'pertanyaan' => 'Bagaimana pendapat Anda mengenai harga produk kami?',
            'jawaban_benar' => 'Sangat baik',
            'opsi_a' => 'Sangat baik',
            'opsi_b' => 'Baik',
            'opsi_c' => 'Cukup',
            'opsi_d' => 'Kurang',
            'opsi_e' => 'Tidak baik',
            'tipe' => 'Pilihan Ganda',
        ]);

        Pertanyaan::create([
            'id' => Str::uuid(),
            'soal_id' => $soal1->id,
            'pertanyaan' => 'Berikan saran atau masukan untuk produk kami:',
            'jawaban_benar' => 'Es krim rasa stroberi sangat enak!',
            'tipe' => 'Essay',
        ]);
    }
}
