<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Krs;

class RemoveDuplicateKrs extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:remove-duplicate-krs';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        // Group by fields that should be unique and filter by idperiode
        $krs = Krs::select('idperiode', 'namakelas', 'nim', 'idmk')
            ->selectRaw('COUNT(*) as count, MIN(id) as min_id')
            ->where('idperiode', '20181')
            ->groupBy('idperiode', 'namakelas', 'nim', 'idmk')
            ->having('count', '>', 1)
            ->get();

        $deletedCount = 0;

        foreach ($krs as $record) {
            $duplicates = Krs::where('idperiode', $record->idperiode)
                ->where('namakelas', $record->namakelas)
                ->where('nim', $record->nim)
                ->where('idmk', $record->idmk)
                ->where('id', '!=', $record->min_id)
                ->get();

            foreach ($duplicates as $duplicate) {
                $duplicate->delete();
                $deletedCount++;
            }
        }

        $this->info("Removed $deletedCount duplicate records from KRS table with idperiode 20181.");
    }
}
