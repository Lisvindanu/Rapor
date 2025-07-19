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
        // Langkah 1: Tambah kolom sebagai nullable terlebih dahulu
        Schema::table('pengaduan', function (Blueprint $table) {
            // Field baru untuk whistleblower
            $table->string('status_pelapor')->nullable()->after('status_pengaduan');
            $table->text('cerita_singkat_peristiwa')->nullable()->after('deskripsi_pengaduan');
            $table->date('tanggal_kejadian')->nullable()->after('cerita_singkat_peristiwa');
            $table->string('lokasi_kejadian')->nullable()->after('tanggal_kejadian');
            $table->boolean('memiliki_disabilitas')->default(false)->after('lokasi_kejadian');
            $table->text('jenis_disabilitas')->nullable()->after('memiliki_disabilitas');
            $table->json('alasan_pengaduan')->nullable()->after('jenis_disabilitas');
            $table->string('evidence_type')->nullable()->after('evidence_path');
            $table->text('evidence_gdrive_link')->nullable()->after('evidence_type');
        });

        // Langkah 2: Update data existing dengan nilai default
        $this->updateExistingData();

        // Langkah 3: Ubah kolom yang required menjadi NOT NULL
        $this->makeColumnsRequired();

        // Langkah 4: Update enum status_pengaduan
        $this->updateStatusEnum();
    }

    private function updateExistingData()
    {
        // Update existing records dengan default values
        DB::table('pengaduan')->whereNull('status_pelapor')->update([
            'status_pelapor' => 'saksi'
        ]);

        // Copy deskripsi_pengaduan ke cerita_singkat_peristiwa untuk data existing
        DB::table('pengaduan')->whereNull('cerita_singkat_peristiwa')->update([
            'cerita_singkat_peristiwa' => DB::raw('deskripsi_pengaduan')
        ]);

        // Set default evidence_type
        DB::table('pengaduan')->whereNull('evidence_type')->update([
            'evidence_type' => 'file'
        ]);
    }

    private function makeColumnsRequired()
    {
        try {
            // PostgreSQL specific constraints
            DB::statement("ALTER TABLE pengaduan ADD CONSTRAINT pengaduan_status_pelapor_check CHECK (status_pelapor IN ('saksi', 'korban'))");
            DB::statement('ALTER TABLE pengaduan ALTER COLUMN status_pelapor SET NOT NULL');
            DB::statement('ALTER TABLE pengaduan ALTER COLUMN cerita_singkat_peristiwa SET NOT NULL');
        } catch (\Exception $e) {
            // Fallback for other databases or if constraints fail
            Log::warning('Could not add NOT NULL constraints: ' . $e->getMessage());
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
            // Log error jika constraint gagal ditambahkan
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