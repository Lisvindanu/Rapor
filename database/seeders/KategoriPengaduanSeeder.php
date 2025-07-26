<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // 1. Hapus data pengaduan yang sudah ada (data test)
        DB::table('pengaduan_terlapor')->delete();
        DB::table('pengaduan')->delete();
        
        // 2. Reset auto increment jika diperlukan
        if (config('database.default') === 'mysql') {
            DB::statement('ALTER TABLE pengaduan AUTO_INCREMENT = 1');
            DB::statement('ALTER TABLE pengaduan_terlapor AUTO_INCREMENT = 1');
        } elseif (config('database.default') === 'pgsql') {
            DB::statement('ALTER SEQUENCE pengaduan_id_seq RESTART WITH 1');
            DB::statement('ALTER SEQUENCE pengaduan_terlapor_id_seq RESTART WITH 1');
        }
        
        // 3. Hapus kategori lama dan insert yang baru
        DB::table('kategori_pengaduan')->delete();
        
        // 4. Insert kategori baru
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

        DB::table('kategori_pengaduan')->insert($kategoris);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Tidak perlu rollback karena ini cleanup
        // Jika diperlukan, bisa tambahkan logic restore data lama
    }
};