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
        $accessToken = "eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJjaWQiOiJ1bnBhcyIsImlhdCI6MTc0MDcxMDUzOCwiZXhwIjoxNzQwNzE0MTM4fQ.yxcIw_fZR2igZM18qMm2DgRhMEKcFLpeDsX-QRGy8yQ";
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
        $kelasKuliah = KelasKuliah::where('periodeakademik', '20241')
            ->whereIn('programstudi', [
                'Teknik Industri',
                'Teknologi Pangan',
                'Teknik Mesin',
                'Teknik Informatika',
                'Teknik Lingkungan',
                'Perencanaan Wilayah dan Kota'
            ])
            // ->where('programstudi', 'Teknik Informatika')
            // ->where('kodemk', 'IF21W0705')
            ->get();

        foreach ($kelasKuliah as $kelas) {
            $formData['idperiode'] = '20241';
            $formData['namakelas'] = $kelas->namakelas;
            $formData['idmk'] = $kelas->kodemk;
            $formData['krsdiajukan'] = 'Ya';
            $formData['krsdisetujui'] = 'Ya';

            $client = new Client();

            try {
                $response = $client->request('GET', 'https://unpas.siakadcloud.com/live/krsmahasiswa', [
                    'query' => $formData,
                    'headers' => [
                        'Authorization' => 'Bearer ' . $accessToken // Gunakan access token yang sudah ada
                    ]
                ]);

                $body = $response->getBody()->getContents();
                $data = json_decode($body, true);

                // info
                // $this->info($data);
                // $this->info(json_encode($data, JSON_PRETTY_PRINT));


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
                        $krs = Krs::where('idperiode', $krsData['idperiode'])
                            ->where('namakelas', $krsData['namakelas'])
                            ->where('nim', $krsData['nim'])
                            ->where('idmk', $krsData['idmk'])
                            ->first();

                        // Jika data krs sudah ada, perbarui
                        if ($krs) {
                            $this->info('KRS ' . $krsData['nim'] . ' - ' . $krsData['idmk'] . ' sudah ada, perbarui data');
                            // $krs->update($krsData);
                        } else {
                            Krs::create($krsData);
                            $this->info('KRS ' . $krsData['nim'] . ' - ' . $krsData['idmk'] . ' berhasil disimpan');
                        }

                        // $this->info($krs);
                    }
                }
            } catch (\Throwable $th) {
                $this->error('Error: ' . $th->getMessage());
            }
        }
    }
}
