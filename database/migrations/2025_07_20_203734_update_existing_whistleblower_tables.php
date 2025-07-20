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
        try {
            // 1. Update whistle_pengaduan table - step by step
            $this->updateWhistlePengaduanTable();
            
            // 2. Handle pengaduan_terlapor table
            $this->handlePengaduanTerlaporTable();
            
        } catch (\Exception $e) {
            \Illuminate\Support\Facades\Log::error('Migration error: ' . $e->getMessage());
            throw $e;
        }
    }

    /**
     * Update whistle_pengaduan table step by step
     */
    private function updateWhistlePengaduanTable()
    {
        // Check if table exists
        if (!Schema::hasTable('whistle_pengaduan')) {
            throw new \Exception('Tabel whistle_pengaduan tidak ditemukan.');
        }

        $columns = Schema::getColumnListing('whistle_pengaduan');
        
        // Add columns one by one with try-catch
        $newColumns = [
            'nama_pelapor' => 'string',
            'email_pelapor' => 'string',
            'status_pelapor' => 'string',
            'cerita_singkat_peristiwa' => 'text',
            'tanggal_kejadian' => 'date',
            'lokasi_kejadian' => 'string',
            'memiliki_disabilitas' => 'boolean',
            'jenis_disabilitas' => 'string',
            'alasan_pengaduan' => 'json',
            'evidence_type' => 'string',
            'evidence_gdrive_link' => 'text'
        ];

        foreach ($newColumns as $columnName => $columnType) {
            if (!in_array($columnName, $columns)) {
                try {
                    Schema::table('whistle_pengaduan', function (Blueprint $table) use ($columnName, $columnType) {
                        switch ($columnType) {
                            case 'string':
                                $table->string($columnName)->nullable();
                                break;
                            case 'text':
                                $table->text($columnName)->nullable();
                                break;
                            case 'date':
                                $table->date($columnName)->nullable();
                                break;
                            case 'boolean':
                                $table->boolean($columnName)->default(false);
                                break;
                            case 'json':
                                $table->json($columnName)->nullable();
                                break;
                        }
                    });
                    
                    \Illuminate\Support\Facades\Log::info("Added column: {$columnName}");
                } catch (\Exception $e) {
                    \Illuminate\Support\Facades\Log::warning("Failed to add column {$columnName}: " . $e->getMessage());
                }
            }
        }

        // Update existing records with safe default values
        $this->updateExistingRecords();
    }

    /**
     * Handle pengaduan_terlapor table
     */
    private function handlePengaduanTerlaporTable()
    {
        // Check if table already exists
        if (Schema::hasTable('pengaduan_terlapor')) {
            \Illuminate\Support\Facades\Log::info('pengaduan_terlapor table already exists, skipping creation');
            return;
        }

        // Create pengaduan_terlapor table
        try {
            Schema::create('pengaduan_terlapor', function (Blueprint $table) {
                $table->id();
                $table->uuid('pengaduan_id');
                $table->string('nama_terlapor');
                $table->string('status_terlapor'); // Will add constraint later
                $table->string('nomor_identitas')->nullable();
                $table->string('unit_kerja_fakultas')->nullable();
                $table->string('kontak_terlapor');
                $table->timestamps();

                // Add index
                $table->index(['pengaduan_id']);
                $table->index(['status_terlapor']);
            });

            // Add foreign key constraint separately
            try {
                Schema::table('pengaduan_terlapor', function (Blueprint $table) {
                    $table->foreign('pengaduan_id')->references('id')->on('whistle_pengaduan')->onDelete('cascade');
                });
            } catch (\Exception $e) {
                \Illuminate\Support\Facades\Log::warning('Could not add foreign key: ' . $e->getMessage());
            }

            // Add enum constraint for status_terlapor
            try {
                DB::statement("ALTER TABLE pengaduan_terlapor ADD CONSTRAINT pengaduan_terlapor_status_check CHECK (status_terlapor IN ('mahasiswa', 'pegawai'))");
            } catch (\Exception $e) {
                \Illuminate\Support\Facades\Log::warning('Could not add status constraint: ' . $e->getMessage());
            }

            \Illuminate\Support\Facades\Log::info('pengaduan_terlapor table created successfully');
        } catch (\Exception $e) {
            \Illuminate\Support\Facades\Log::error('Failed to create pengaduan_terlapor table: ' . $e->getMessage());
            throw $e;
        }
    }

    /**
     * Update existing records with safe defaults
     */
    private function updateExistingRecords()
    {
        try {
            // Get columns that exist
            $columns = Schema::getColumnListing('whistle_pengaduan');
            
            // Only update if columns exist
            if (in_array('status_pelapor', $columns)) {
                DB::table('whistle_pengaduan')
                    ->whereNull('status_pelapor')
                    ->update(['status_pelapor' => 'saksi']);
            }
            
            if (in_array('cerita_singkat_peristiwa', $columns)) {
                DB::table('whistle_pengaduan')
                    ->whereNull('cerita_singkat_peristiwa')
                    ->update(['cerita_singkat_peristiwa' => DB::raw('COALESCE(uraian_pengaduan, \'Tidak ada detail peristiwa\')')]);
            }
            
            if (in_array('nama_pelapor', $columns)) {
                DB::statement('
                    UPDATE whistle_pengaduan 
                    SET nama_pelapor = COALESCE(
                        (SELECT name FROM users WHERE users.id = whistle_pengaduan.pelapor_id LIMIT 1),
                        \'Pelapor\'
                    )
                    WHERE nama_pelapor IS NULL
                ');
            }
            
            if (in_array('email_pelapor', $columns)) {
                DB::statement('
                    UPDATE whistle_pengaduan 
                    SET email_pelapor = COALESCE(
                        (SELECT email FROM users WHERE users.id = whistle_pengaduan.pelapor_id LIMIT 1),
                        \'unknown@unjaya.ac.id\'
                    )
                    WHERE email_pelapor IS NULL
                ');
            }
            
            \Illuminate\Support\Facades\Log::info('Updated existing records with default values');
        } catch (\Exception $e) {
            \Illuminate\Support\Facades\Log::warning('Could not update existing records: ' . $e->getMessage());
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Drop pengaduan_terlapor table if exists
        Schema::dropIfExists('pengaduan_terlapor');

        // Remove added columns from whistle_pengaduan
        if (Schema::hasTable('whistle_pengaduan')) {
            $columnsToRemove = [
                'nama_pelapor',
                'email_pelapor',
                'status_pelapor',
                'cerita_singkat_peristiwa',
                'tanggal_kejadian',
                'lokasi_kejadian',
                'memiliki_disabilitas',
                'jenis_disabilitas',
                'alasan_pengaduan',
                'evidence_type',
                'evidence_gdrive_link'
            ];

            Schema::table('whistle_pengaduan', function (Blueprint $table) use ($columnsToRemove) {
                foreach ($columnsToRemove as $column) {
                    if (Schema::hasColumn('whistle_pengaduan', $column)) {
                        $table->dropColumn($column);
                    }
                }
            });
        }
    }
};