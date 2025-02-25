<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\PresensiKuliah;
use App\Models\KelasKuliah;
use GuzzleHttp\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class GetDataPresensi extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:get-data-presensi';

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
        $periode = '20241';
        $programstudi = 'Ilmu Hukum';

        PresensiKuliah::where('periodeakademik', $periode)
            ->where('programstudi', 'ilike', '%' . $programstudi . '%')
            ->delete();

        $kelasKuliah = KelasKuliah::where('periodeakademik', $periode)
            // ->where('programstudi', 'ilike', '%' . $programstudi . '%')
            // // ->where('kodemk', 'HSW213182')
            // ->get();
            ->whereIn('programstudi', [
                'Teknik Industri',
                'Teknologi Pangan',
                'Teknik Mesin',
                'Teknik Informatika',
                'Teknik Lingkungan',
                'Perencanaan Wilayah dan Kota'
            ])
            ->get();

            
        $count_insert = 0;

        $accessToken = "eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJjaWQiOiJ1bnBhcyIsImlhdCI6MTc0MDQ0OTM5NCwiZXhwIjoxNzQwNDUyOTk0fQ.QOgjBG_6hDH8Yth2LDzIFJPQEiCDuRuhqXPVAyjJnJw"; // Ganti dengan token yang valid
        $limit = 1000;

        $formData = [];
        $formData['limit'] = $limit;

        $client = new Client();

        // Iterasi untuk mengakses data kelas kuliah
        foreach ($kelasKuliah as $kls) {
            $formData['periodeakademik'] = $kls->periodeakademik;
            $formData['kodemk'] = $kls->kodemk;
            $formData['kelas'] = $kls->namakelas;

            // Buat instance dari Guzzle Client
            $client = new Client();

            try {
                // Request data presensi menggunakan access token
                $response = $client->request('GET', 'https://unpas.siakadcloud.com/live/presensi', [
                    'query' => $formData,
                    'headers' => [
                        'Authorization' => 'Bearer ' . $accessToken
                    ]
                ]);

                // Ambil body response sebagai string
                $body = $response->getBody()->getContents();

                // Decode data dari body response
                $data = json_decode($body, true);

                // Jika data tidak null, lakukan penyimpanan batch
                if ($data != null) {
                    $chunks = array_chunk($data, 1000); // Misal setiap chunk berisi 1000 data
                    foreach ($chunks as $chunk) {
                        // generete uuid for id
                        foreach ($chunk as $key => $value) {
                            $chunk[$key]['id'] = Str::uuid();
                        }

                        PresensiKuliah::insert($chunk);
                        $count_insert += count($chunk);
                    }
                    $this->info($count_insert);
                }
            } catch (\Throwable $th) {
                $this->error('Error: ' . $th->getMessage());
            }
        }
    }
}
