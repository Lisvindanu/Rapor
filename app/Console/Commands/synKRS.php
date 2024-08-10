<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\KelasKuliah;
use GuzzleHttp\Client;
use App\Models\Krs;
use Illuminate\Support\Str;

class synKRS extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:syn-krs';

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
        $accessToken = "eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJjaWQiOiJ1bnBhcyIsImlhdCI6MTcyMzI2OTE2NSwiZXhwIjoxNzIzMjcyNzY1fQ.X3lPphFEtNSCAy37qYy8fHYIPBHpmr5P4kIRGjsXpiY";
        $limit = 1000;

        $formData = [];
        $formData['limit'] = $limit;

        //IDperiodelist
        $periodelist = [
            '20181',
            '20182',
            '20183',
            '20191',
            '20192',
            '20193',
            '20201',
            '20202',
            '20203',
            '20211',
            '20212',
            '20213',
            '20221',
            '20222',
            '20223',
            '20231'
        ];

        // $periodelist = [
        //     '20181'
        // ];

        // kelaskuliah where in idperiode
        $kelasKuliah = KelasKuliah::where('periodeakademik', '20232')
            ->where('programstudi', 'Ilmu Hukum')
            // ->orWhere('periodeakademik', '20182')
            // ->orWhere('periodeakademik', '20183')
            // ->orWhere('periodeakademik', '20191')
            // ->orWhere('periodeakademik', '20192')
            // ->orWhere('periodeakademik', '20193')
            // ->orWhere('periodeakademik', '20201')
            // ->orWhere('periodeakademik', '20202')
            // ->orWhere('periodeakademik', '20203')
            // ->orWhere('periodeakademik', '20211')
            // ->orWhere('periodeakademik', '20212')
            // ->orWhere('periodeakademik', '20213')
            // ->orWhere('periodeakademik', '20221')
            // ->orWhere('periodeakademik', '20222')
            // ->orWhere('periodeakademik', '20223')
            // ->orWhere('periodeakademik', '20231')
            ->get();

        foreach ($kelasKuliah as $kelas) {
            $formData['idperiode'] = $kelas->idperiode;
            $formData['namakelas'] = $kelas->namakelas;
            $formData['idmk'] = $kelas->kodemk;
            $formData['krsdiajukan'] = 'Ya';
            $formData['krsdisetujui'] = 'Ya';

            $client = new Client();

            // try {
            //     $response = $client->request('GET', 'https://unpas.siakadcloud.com/live/krsmahasiswa', [
            //         'query' => $formData,
            //         'headers' => [
            //             'Authorization' => 'Bearer ' . $accessToken // Gunakan access token yang sudah ada
            //         ]
            //     ]);

            //     $body = $response->getBody()->getContents();

            //     $data = json_decode($body, true);

            //     if ($data != null) {
            //         foreach ($data as $krsData) {
            //             $krs = Krs::where('idperiode', $krsData['idperiode'])
            //                 ->where('namakelas', $krsData['namakelas'])
            //                 ->where('nim', $krsData['nim'])
            //                 ->where('idmk', $krsData['idmk'])
            //                 ->first();

            //             // Jika data krs sudah ada, perbarui
            //             if ($krs) {
            //                 $this->info('KRS' . $krsData['nim'] . ' sudah ada, perbarui data');
            //             } else {
            //                 Krs::create($krsData);
            //             }
            //         }
            //     }
            // } catch (\Throwable $th) {
            //     $this->error('Error: ' . $th->getMessage());
            // }

            try {
                $response = $client->request('GET', 'https://unpas.siakadcloud.com/live/krsmahasiswa', [
                    'query' => $formData,
                    'headers' => [
                        'Authorization' => 'Bearer ' . $accessToken // Gunakan access token yang sudah ada
                    ]
                ]);

                $body = $response->getBody()->getContents();
                $data = json_decode($body, true);

                if ($data != null) {
                    // Menggunakan array asosiatif untuk mengelompokkan data dan menghapus duplikat
                    $groupedData = [];

                    foreach ($data as $item) {
                        // Kombinasi kunci untuk mengelompokkan data
                        $key = $item['idperiode'] . '-' . $item['namakelas'] . '-' . $item['nim'] . '-' . $item['idmk'] . '-' . $item['nhuruf'];

                        // Jika kunci belum ada dalam array, tambahkan item
                        if (!isset($groupedData[$key])) {
                            $groupedData[$key] = $item;
                        }
                    }

                    // Mengubah kembali array asosiatif menjadi array numerik
                    $uniqueData = array_values($groupedData);

                    foreach ($uniqueData as $krsData) {
                        // $krs = Krs::where('idperiode', $krsData['idperiode'])
                        //     ->where('namakelas', $krsData['namakelas'])
                        //     ->where('nim', $krsData['nim'])
                        //     ->where('idmk', $krsData['idmk'])
                        //     ->first();

                        // Jika data krs sudah ada, perbarui
                        // if ($krs) {
                        //     $this->info('KRS ' . $krsData['nim'] . ' - ' . $krsData['idmk'] . ' sudah ada, perbarui data');
                        //     // $krs->update($krsData);
                        // } else {
                        Krs::create($krsData);
                        $this->info('KRS ' . $krsData['nim'] . ' - ' . $krsData['idmk'] . ' berhasil disimpan');
                        // }
                    }
                }
            } catch (\Throwable $th) {
                $this->error('Error: ' . $th->getMessage());
            }
        }
    }
}
