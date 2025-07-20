<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\KeuanganProgram;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class KeuanganProgramSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $this->command->info('🗑️ Menghapus data program lama...');

        // Disable foreign key checks
        if (DB::getDriverName() === 'mysql') {
            DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        }

        KeuanganProgram::truncate();

        if (DB::getDriverName() === 'mysql') {
            DB::statement('SET FOREIGN_KEY_CHECKS=1;');
        }

        $this->command->info('🎓 Membuat data program...');

        // Data program sesuai requirement
        $programData = [
            [
                'nama_program' => 'Reguler Pagi',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'nama_program' => 'Reguler Sore',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'nama_program' => 'Kerja Sama',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ]
        ];

        foreach ($programData as $data) {
            KeuanganProgram::create($data);
            $this->command->info("✅ Program {$data['nama_program']} berhasil dibuat");
        }

        $this->command->info("🎉 Seeder program selesai! Total: " . count($programData) . " data");
    }
}
