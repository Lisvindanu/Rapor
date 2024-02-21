<?php

namespace App\Http\Controllers;

use App\Models\Dosen;
use Illuminate\Http\Request;
use GuzzleHttp\Client;
use Exception;
use App\Models\Fakultas;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;
use App\Models\Periode;
use App\Models\KelasKuliah;

class SinkronasiController extends Controller
{
    function index()
    {
        // return response()->json(['message' => 'Hello ini dari Sinkronasi Controller']);
        $fakultas_id = Fakultas::with('programStudis')->get();

        // Mengembalikan respons dalam format JSON
        return response()->json($fakultas_id);
        // echo $fakultas_id;
    }

    function getToken()
    {
        // Buat instance dari Guzzle Client
        $client = new Client();

        // URL target untuk mendapatkan access token
        $tokenUrl = 'https://unpas.siakadcloud.com/live/token';

        try {
            // Lakukan permintaan POST untuk mendapatkan access token
            $response = $client->request('POST', $tokenUrl, [
                'form_params' => [
                    'grant_type' => 'client_credentials',
                    'client_id' => 'unpas',
                    'client_secret' => 'gM5S5N%4'
                ]
            ]);

            // Dapatkan body respons dalam bentuk string
            $body = $response->getBody();

            // Ubah body respons dari JSON menjadi array asosiatif
            $data = json_decode($body, true);

            // Ambil access token dari data respons
            $accessToken = $data['access_token'];

            // Menyimpan access token dalam variabel global
            $GLOBALS['access_token'] = $accessToken;

            // Tampilkan access token
            return response()->json(['access_token' => $accessToken]);
        } catch (Exception $e) {
            // Tangani kesalahan jika permintaan gagal
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    function getDataDosen(Request $request)
    {
        try {
            // Ambil access token yang sudah disimpan
            $accessToken = $request->get("access_token");
            $homebase = $request->get("homebase");

            // Jika access token tidak ada, kembalikan pesan kesalahan
            if (!$accessToken) {
                return response()->json(['error' => 'Access token tidak tersedia'], 500);
            }

            // Parameter form yang akan dikirim
            $formData = [
                // 'homebase' => 'Teknik Informatika',
                'homebase' => $homebase,
                'limit' => 10000,
            ];

            // Buat instance dari Guzzle Client
            $client = new Client();

            // Menggunakan access token untuk request mendapatkan data dosen
            $response = $client->request('GET', 'https://unpas.siakadcloud.com/live/dosen', [
                'query' => $formData,
                'headers' => [
                    'Authorization' => 'Bearer ' . $accessToken // Gunakan access token yang sudah ada
                ]
            ]);

            // Mendapatkan body respons sebagai string
            $body = $response->getBody()->getContents();

            // Mendapatkan data dari body respons
            $data = json_decode($body, true);

            // Simpan data dosen ke dalam tabel Dosen
            foreach ($data as $dosenData) {

                $dosen = Dosen::where('nip', $dosenData['nip'])->first();

                // Jika data dosen sudah ada, perbarui
                if ($dosen) {
                    $dosen->update($dosenData);
                } else {
                    // Jika tidak, buat data dosen baru
                    $dosenData['id'] = Str::uuid();
                    Dosen::create($dosenData);
                }
            }
            // Tampilkan data yang diperoleh dari request
            return response()->json(['message' => 'Data dosen berhasil disinkronkan', 'data' => json_decode($body, true)]);
        } catch (Exception $e) {
            // Tangani kesalahan jika permintaan gagal
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    // fungsi getdataperiode
    function getDataPeriode(Request $request)
    {
        try {
            // Ambil access token yang sudah disimpan
            $accessToken = $request->get("access_token");

            // Jika access token tidak ada, kembalikan pesan kesalahan
            if (!$accessToken) {
                return response()->json(['error' => 'Access token tidak tersedia'], 500);
            }

            // Parameter form yang akan dikirim
            $formData = [
                'limit' => 10000,
            ];

            // Buat instance dari Guzzle Client
            $client = new Client();

            // Menggunakan access token untuk request mendapatkan data periode
            $response = $client->request('GET', 'https://unpas.siakadcloud.com/live/dataperiode', [
                'query' => $formData,
                'headers' => [
                    'Authorization' => 'Bearer ' . $accessToken // Gunakan access token yang sudah ada
                ]
            ]);

            // Mendapatkan body respons sebagai string
            $body = $response->getBody()->getContents();

            // Mendapatkan data dari body respons
            $data = json_decode($body, true);

            // Simpan data periode ke dalam tabel Periode
            foreach ($data as $periodeData) {
                $periode = Periode::where('kode_periode', $periodeData['kode_periode'])->first();

                // Jika data periode sudah ada, perbarui
                if ($periode) {
                    $periode->update($periodeData);
                } else {
                    // Jika tidak, buat data periode baru
                    $periodeData['id'] = Str::uuid();
                    Periode::create($periodeData);
                }
            }
            // Tampilkan data yang diperoleh dari request
            return response()->json(['message' => 'Data periode berhasil disinkronkan', 'data' => json_decode($body, true)]);
        } catch (Exception $e) {
            // Tangani kesalahan jika permintaan gagal
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    // fungsi get data kelas kuliah
    function getDataKelasKuliah(Request $request)
    {
        try {
            // Ambil access token yang sudah disimpan
            $accessToken = $request->get("access_token");
            $programstudi = $request->get("programstudi");
            $periodeakademik = $request->get("periodeakademik");

            // Jika access token tidak ada, kembalikan pesan kesalahan
            if (!$accessToken) {
                return response()->json(['error' => 'Access token tidak tersedia'], 500);
            }

            // Parameter form yang akan dikirim
            $formData = [
                'limit' => 10000,
                'programstudi' => $programstudi,
                'periodeakademik' => $periodeakademik,
            ];

            // Buat instance dari Guzzle Client
            $client = new Client();

            // Menggunakan access token untuk request mendapatkan data kelas kuliah
            $response = $client->request('GET', 'https://unpas.siakadcloud.com/live/kelaskuliah', [
                'query' => $formData,
                'headers' => [
                    'Authorization' => 'Bearer ' . $accessToken // Gunakan access token yang sudah ada
                ]
            ]);

            // Mendapatkan body respons sebagai string
            $body = $response->getBody()->getContents();

            // Mendapatkan data dari body respons
            $data = json_decode($body, true);

            // Simpan data kelas kuliah ke dalam tabel KelasKuliah
            foreach ($data as $kelasKuliahData) {
                $kelasKuliah = KelasKuliah::where('kelasid', $kelasKuliahData['kelasid'])
                    ->where('nip', $kelasKuliahData['nip'])
                    ->first();

                // Jika data kelas kuliah sudah ada, perbarui
                if ($kelasKuliah) {
                    $kelasKuliah->update($kelasKuliahData);
                } else {
                    // Jika tidak, buat data kelas kuliah baru
                    $kelasKuliahData['id'] = Str::uuid();
                    KelasKuliah::create($kelasKuliahData);
                }
            }
            // Tampilkan data yang diperoleh dari request
            return response()->json(['message' => 'Data kelas kuliah berhasil disinkronkan', 'data' => json_decode($body, true)]);
        } catch (Exception $e) {
            // Tangani kesalahan jika permintaan gagal
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
}
