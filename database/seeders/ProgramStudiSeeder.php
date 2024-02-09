<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class ProgramStudiSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('programstudis')->insert([
            ['id' => Str::uuid(), 'kode' => 'TI', 'nama' => 'Teknik Industri', 'jenjang_id' => 1, 'fakultas_id' => '3949fb1f-f471-469e-b3f0-cafa4fd0f18c'],
            ['id' => Str::uuid(), 'kode' => 'TP', 'nama' => 'Teknologi Pangan', 'jenjang_id' => 1, 'fakultas_id' => '3949fb1f-f471-469e-b3f0-cafa4fd0f18c'],
            ['id' => Str::uuid(), 'kode' => 'PWK', 'nama' => 'Perencanaan Wilayah dan Kota', 'jenjang_id' => 1, 'fakultas_id' => '3949fb1f-f471-469e-b3f0-cafa4fd0f18c'],
            ['id' => Str::uuid(), 'kode' => 'IF', 'nama' => 'Teknik Informatika', 'jenjang_id' => 1, 'fakultas_id' => '3949fb1f-f471-469e-b3f0-cafa4fd0f18c'],
            ['id' => Str::uuid(), 'kode' => 'TM', 'nama' => 'Teknik Mesin', 'jenjang_id' => 1, 'fakultas_id' => '3949fb1f-f471-469e-b3f0-cafa4fd0f18c'],
            ['id' => Str::uuid(), 'kode' => 'TL', 'nama' => 'Teknik Lingkungan', 'jenjang_id' => 1, 'fakultas_id' => '3949fb1f-f471-469e-b3f0-cafa4fd0f18c'],
        ]);
    }
}
