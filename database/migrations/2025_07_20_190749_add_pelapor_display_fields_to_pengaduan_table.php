<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Cek apakah tabel whistle_pengaduan ada
        if (!Schema::hasTable('whistle_pengaduan')) {
            throw new \Exception('Tabel whistle_pengaduan tidak ditemukan.');
        }

        // Cek apakah field sudah ada untuk menghindari duplicate column error
        $columns = Schema::getColumnListing('whistle_pengaduan');
        
        Schema::table('whistle_pengaduan', function (Blueprint $table) use ($columns) {
            // Hanya tambahkan jika belum ada
            if (!in_array('nama_pelapor', $columns)) {
                $table->string('nama_pelapor')->nullable()->after('pelapor_id');
            }
            
            if (!in_array('email_pelapor', $columns)) {
                $table->string('email_pelapor')->nullable()->after('nama_pelapor');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('whistle_pengaduan', function (Blueprint $table) {
            $columns = Schema::getColumnListing('whistle_pengaduan');
            
            if (in_array('email_pelapor', $columns)) {
                $table->dropColumn('email_pelapor');
            }
            
            if (in_array('nama_pelapor', $columns)) {
                $table->dropColumn('nama_pelapor');
            }
        });
    }
};