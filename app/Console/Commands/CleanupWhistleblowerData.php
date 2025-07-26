<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class CleanupWhistleblowerData extends Command
{
    protected $signature = 'whistleblower:cleanup {--force : Force cleanup without confirmation}';
    protected $description = 'Cleanup whistleblower test data and reset categories';

    public function handle()
    {
        if (!$this->option('force')) {
            if (!$this->confirm('This will delete ALL whistleblower data and reset categories. Continue?')) {
                $this->info('Cleanup cancelled.');
                return;
            }
        }

        $this->info('Starting cleanup...');

        try {
            DB::beginTransaction();

            // 1. Delete existing data
            $terlamorCount = DB::table('pengaduan_terlapor')->count();
            DB::table('pengaduan_terlapor')->delete();
            $this->info("Deleted {$terlamorCount} terlapor records");

            $pengaduanCount = DB::table('whistle_pengaduan')->count();
            DB::table('whistle_pengaduan')->delete();
            $this->info("Deleted {$pengaduanCount} pengaduan records");

            // 2. Reset categories
            DB::table('ref_kategori_pengaduan')->delete();
            
            $kategoris = [
                [
                    'id' => Str::uuid()->toString(),
                    'nama_kategori' => 'Kekerasan/Pelecehan',
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
                [
                    'id' => Str::uuid()->toString(),
                    'nama_kategori' => 'Diskriminasi',
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
                [
                    'id' => Str::uuid()->toString(),
                    'nama_kategori' => 'Bullying/Perundungan',
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
            ];

            DB::table('ref_kategori_pengaduan')->insert($kategoris);
            $this->info('Inserted 3 new categories');

            DB::commit();
            
            $this->info('✅ Cleanup completed successfully!');
            
            // Show new categories
            $categories = DB::table('ref_kategori_pengaduan')->select('nama_kategori')->get();
            $this->info('New categories:');
            foreach ($categories as $cat) {
                $this->line("- {$cat->nama_kategori}");
            }

        } catch (\Exception $e) {
            DB::rollback();
            $this->error('❌ Cleanup failed: ' . $e->getMessage());
            return 1;
        }

        return 0;
    }
}