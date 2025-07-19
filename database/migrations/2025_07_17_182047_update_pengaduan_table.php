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
        // Step 1: Add nullable columns first
        Schema::table('pengaduan', function (Blueprint $table) {
            $table->string('status_pelapor')->nullable();
            $table->text('cerita_singkat_peristiwa')->nullable();
            $table->date('tanggal_kejadian')->nullable();
            $table->string('lokasi_kejadian')->nullable();
            $table->boolean('memiliki_disabilitas')->default(false);
            $table->text('jenis_disabilitas')->nullable();
            $table->json('alasan_pengaduan')->nullable();
            $table->string('evidence_type')->nullable();
            $table->text('evidence_gdrive_link')->nullable();
        });

        // Step 2: Update existing data dengan default values
        $this->updateExistingData();

        // Step 3: Modify columns to NOT NULL setelah data diupdate
        try {
            DB::statement('ALTER TABLE pengaduan ALTER COLUMN status_pelapor SET NOT NULL');
            DB::statement('ALTER TABLE pengaduan ALTER COLUMN cerita_singkat_peristiwa SET NOT NULL');
        } catch (\Exception $e) {
            Log::warning('Could not set NOT NULL constraints: ' . $e->getMessage());
        }

        // Step 4: Add constraints
        $this->addConstraints();
    }

    private function updateExistingData()
    {
        try {
            // Update status_pelapor default
            DB::table('pengaduan')
                ->whereNull('status_pelapor')
                ->update(['status_pelapor' => 'saksi']);

            // Update cerita_singkat_peristiwa dengan data dari deskripsi
            DB::table('pengaduan')
                ->whereNull('cerita_singkat_peristiwa')
                ->update([
                    'cerita_singkat_peristiwa' => DB::raw('COALESCE(deskripsi_pengaduan, "Deskripsi belum diisi")')
                ]);

            // Set default evidence_type
            DB::table('pengaduan')
                ->whereNull('evidence_type')
                ->update(['evidence_type' => 'file']);

        } catch (\Exception $e) {
            Log::warning('Could not update existing data: ' . $e->getMessage());
        }
    }

    private function addConstraints()
    {
        try {
            // Add status_pelapor constraint
            DB::statement('ALTER TABLE pengaduan ADD CONSTRAINT pengaduan_status_pelapor_check CHECK (status_pelapor IN (\'saksi\', \'korban\'))');
            
            // Add evidence_type constraint
            DB::statement('ALTER TABLE pengaduan ADD CONSTRAINT pengaduan_evidence_type_check CHECK (evidence_type IN (\'file\', \'gdrive\'))');
            
            // Update status_pengaduan constraint
            $this->updateStatusEnum();
            
        } catch (\Exception $e) {
            Log::warning('Could not add constraints: ' . $e->getMessage());
        }
    }

    private function updateStatusEnum()
    {
        try {
            // Drop existing constraint
            DB::statement('ALTER TABLE pengaduan DROP CONSTRAINT IF EXISTS pengaduan_status_pengaduan_check');
            
            // Add new constraint dengan status tambahan
            DB::statement("ALTER TABLE pengaduan ADD CONSTRAINT pengaduan_status_pengaduan_check CHECK (status_pengaduan IN ('pending', 'proses', 'selesai', 'ditolak', 'butuh_bukti', 'dibatalkan'))");
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
        DB::statement('ALTER TABLE pengaduan DROP CONSTRAINT IF EXISTS pengaduan_status_pelapor_check');
        DB::statement('ALTER TABLE pengaduan DROP CONSTRAINT IF EXISTS pengaduan_evidence_type_check');
        
        // Restore original status constraint
        DB::statement('ALTER TABLE pengaduan DROP CONSTRAINT IF EXISTS pengaduan_status_pengaduan_check');
        try {
            DB::statement("ALTER TABLE pengaduan ADD CONSTRAINT pengaduan_status_pengaduan_check CHECK (status_pengaduan IN ('pending', 'proses', 'selesai', 'ditolak'))");
        } catch (\Exception $e) {
            // Ignore if original constraint structure is different
        }

        // Drop columns
        Schema::table('pengaduan', function (Blueprint $table) {
            $table->dropColumn([
                'status_pelapor',
                'cerita_singkat_peristiwa',
                'tanggal_kejadian', 
                'lokasi_kejadian',
                'memiliki_disabilitas',
                'jenis_disabilitas',
                'alasan_pengaduan',
                'evidence_type',
                'evidence_gdrive_link'
            ]);
        });
    }
};