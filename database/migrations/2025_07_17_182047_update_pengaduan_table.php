<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Cek apakah tabel whistle_pengaduan ada
        if (!Schema::hasTable('whistle_pengaduan')) {
            throw new \Exception('Tabel whistle_pengaduan tidak ditemukan. Pastikan migration create_pengaduan_table sudah dijalankan.');
        }

        // Step 1: Add nullable columns first
        Schema::table('whistle_pengaduan', function (Blueprint $table) {
            $table->string('status_pelapor')->nullable()->after('anonymous');
            $table->text('cerita_singkat_peristiwa')->nullable()->after('uraian_pengaduan');
            $table->date('tanggal_kejadian')->nullable()->after('cerita_singkat_peristiwa');
            $table->string('lokasi_kejadian')->nullable()->after('tanggal_kejadian');
            $table->boolean('memiliki_disabilitas')->default(false)->after('lokasi_kejadian');
            $table->text('jenis_disabilitas')->nullable()->after('memiliki_disabilitas');
            $table->json('alasan_pengaduan')->nullable()->after('jenis_disabilitas');
            $table->string('evidence_type')->nullable()->after('alasan_pengaduan');
            $table->text('evidence_gdrive_link')->nullable()->after('evidence_type');
            
            // Fields untuk display pelapor
            $table->string('nama_pelapor')->nullable()->after('pelapor_id');
            $table->string('email_pelapor')->nullable()->after('nama_pelapor');
        });

        // Step 2: Update existing data dengan default values
        $this->updateExistingData();

        // Step 3: Modify required columns
        $this->addConstraints();
    }

    private function updateExistingData()
    {
        try {
            // Update status_pelapor default
            DB::table('whistle_pengaduan')
                ->whereNull('status_pelapor')
                ->update(['status_pelapor' => 'saksi']);

            // Update cerita_singkat_peristiwa dengan data dari uraian_pengaduan
            DB::table('whistle_pengaduan')
                ->whereNull('cerita_singkat_peristiwa')
                ->update([
                    'cerita_singkat_peristiwa' => DB::raw('COALESCE(uraian_pengaduan, \'Deskripsi belum diisi\')')
                ]);

            // Update nama_pelapor dan email_pelapor untuk data existing non-anonim
            DB::table('whistle_pengaduan as wp')
                ->join('users as u', 'wp.pelapor_id', '=', 'u.id')
                ->where('wp.anonymous', false)
                ->whereNull('wp.nama_pelapor')
                ->update([
                    'wp.nama_pelapor' => DB::raw('u.name'),
                    'wp.email_pelapor' => DB::raw('u.email')
                ]);

            // Update untuk pengaduan anonim
            DB::table('whistle_pengaduan')
                ->where('anonymous', true)
                ->whereNull('nama_pelapor')
                ->update([
                    'nama_pelapor' => 'Anonim',
                    'email_pelapor' => null
                ]);

        } catch (\Exception $e) {
            Log::warning('Could not update existing data: ' . $e->getMessage());
        }
    }

    private function addConstraints()
    {
        try {
            // Add status_pelapor constraint
            DB::statement('ALTER TABLE whistle_pengaduan ADD CONSTRAINT whistle_pengaduan_status_pelapor_check CHECK (status_pelapor IN (\'saksi\', \'korban\'))');
            
            // Make status_pelapor and cerita_singkat_peristiwa NOT NULL
            DB::statement('ALTER TABLE whistle_pengaduan ALTER COLUMN status_pelapor SET NOT NULL');
            DB::statement('ALTER TABLE whistle_pengaduan ALTER COLUMN cerita_singkat_peristiwa SET NOT NULL');
            
            // Update status_pengaduan enum to include more statuses
            $this->updateStatusEnum();
            
        } catch (\Exception $e) {
            Log::warning('Could not add constraints: ' . $e->getMessage());
        }
    }

    private function updateStatusEnum()
    {
        try {
            // Drop existing constraint
            DB::statement('ALTER TABLE whistle_pengaduan DROP CONSTRAINT IF EXISTS whistle_pengaduan_status_pengaduan_check');
            
            // Add new constraint dengan status tambahan
            DB::statement("ALTER TABLE whistle_pengaduan ADD CONSTRAINT whistle_pengaduan_status_pengaduan_check CHECK (status_pengaduan IN ('pending', 'proses', 'selesai', 'ditolak', 'butuh_bukti', 'dibatalkan'))");
        } catch (\Exception $e) {
            Log::warning('Could not update status_pengaduan enum: ' . $e->getMessage());
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Drop constraints
        DB::statement('ALTER TABLE whistle_pengaduan DROP CONSTRAINT IF EXISTS whistle_pengaduan_status_pelapor_check');
        
        // Restore original status constraint
        DB::statement('ALTER TABLE whistle_pengaduan DROP CONSTRAINT IF EXISTS whistle_pengaduan_status_pengaduan_check');
        try {
            DB::statement("ALTER TABLE whistle_pengaduan ADD CONSTRAINT whistle_pengaduan_status_pengaduan_check CHECK (status_pengaduan IN ('pending', 'proses', 'selesai'))");
        } catch (\Exception $e) {
            // Ignore if original constraint structure is different
        }

        // Drop columns
        Schema::table('whistle_pengaduan', function (Blueprint $table) {
            $table->dropColumn([
                'status_pelapor',
                'cerita_singkat_peristiwa',
                'tanggal_kejadian', 
                'lokasi_kejadian',
                'memiliki_disabilitas',
                'jenis_disabilitas',
                'alasan_pengaduan',
                'evidence_type',
                'evidence_gdrive_link',
                'nama_pelapor',
                'email_pelapor'
            ]);
        });
    }
};