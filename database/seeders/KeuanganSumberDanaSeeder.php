<?php

namespace Database\Seeders;

use App\Models\KeuanganSumberDana;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class KeuanganSumberDanaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('keuangan_sumberdana')->truncate();

        $sumberDanas = [
            [
                'nama_sumber_dana' => 'Dropping dari Universitas',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama_sumber_dana' => 'Dropping dari Fakultas',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ];

        foreach ($sumberDanas as $sumberDana) {
            KeuanganSumberDana::create($sumberDana);
        }

        $this->command->info('✅ Berhasil menambahkan ' . count($sumberDanas) . ' data sumber dana');
    }
}
