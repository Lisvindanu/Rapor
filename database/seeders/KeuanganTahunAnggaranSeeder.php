<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\KeuanganTahunAnggaran;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class KeuanganTahunAnggaranSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $this->command->info('🗑️ Menghapus data tahun anggaran lama...');

        // Disable foreign key checks
        if (DB::getDriverName() === 'mysql') {
            DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        }

        KeuanganTahunAnggaran::truncate();

        if (DB::getDriverName() === 'mysql') {
            DB::statement('SET FOREIGN_KEY_CHECKS=1;');
        }

        $this->command->info('📅 Membuat data tahun anggaran...');

        // Data tahun anggaran
        $tahunAnggaranData = [
            [
                'tahun_anggaran' => '2023',
                'tgl_awal_anggaran' => '2023-01-01',
                'tgl_akhir_anggaran' => '2023-12-31',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'tahun_anggaran' => '2024',
                'tgl_awal_anggaran' => '2024-01-01',
                'tgl_akhir_anggaran' => '2024-12-31',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'tahun_anggaran' => '2025',
                'tgl_awal_anggaran' => '2025-01-01',
                'tgl_akhir_anggaran' => '2025-12-31',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'tahun_anggaran' => '2024/2025',
                'tgl_awal_anggaran' => '2024-07-01',
                'tgl_akhir_anggaran' => '2025-06-30',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'tahun_anggaran' => '2025/2026',
                'tgl_awal_anggaran' => '2025-07-01',
                'tgl_akhir_anggaran' => '2026-06-30',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ]
        ];

        foreach ($tahunAnggaranData as $data) {
            KeuanganTahunAnggaran::create($data);
            $this->command->info("✅ Tahun anggaran {$data['tahun_anggaran']} berhasil dibuat");
        }

        $this->command->info("🎉 Seeder tahun anggaran selesai! Total: " . count($tahunAnggaranData) . " data");
    }
}
