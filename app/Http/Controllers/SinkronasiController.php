<?php

namespace App\Http\Controllers;

use App\Models\Dosen;
use Illuminate\Http\Request;
use GuzzleHttp\Client;
use Exception;
use App\Models\Fakultas;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;

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

    function getDataDosen()
    {
        try {
            // Ambil access token yang sudah disimpan
            $accessToken = "eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJjaWQiOiJ1bnBhcyIsImlhdCI6MTcwNzUzOTg3MCwiZXhwIjoxNzA3NTQzNDcwfQ.TjQiYDCTrS6pmivQrs5t0QFbQZObJ5XjgGG3FMSUces";

            // Jika access token tidak ada, kembalikan pesan kesalahan
            if (!$accessToken) {
                return response()->json(['error' => 'Access token tidak tersedia'], 500);
            }

            // Parameter form yang akan dikirim
            $formData = [
                // 'homebase' => 'Teknik Informatika',
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

                // Dosen::create([
                //     'id' => Str::uuid(),
                //     'agama' => $dosenData['agama'],
                //     'alamat' => $dosenData['alamat'],
                //     'email' => $dosenData['email'],
                //     'golpangkat' => $dosenData['golpangkat'],
                //     'homebase' => $dosenData['homebase'],
                //     'jabatanfungsional' => $dosenData['jabatanfungsional'],
                //     'jabatanstruktural' => $dosenData['jabatanstruktural'],
                //     'jeniskelamin' => $dosenData['jeniskelamin'],
                //     'jenispegawai' => $dosenData['jenispegawai'],
                //     'nama' => $dosenData['nama'],
                //     'nidn' => $dosenData['nidn'],
                //     'nip' => $dosenData['nip'],
                //     'nohp' => $dosenData['nohp'],
                //     'pendidikanterakhir' => $dosenData['pendidikanterakhir'],
                //     'tanggallahir' => $dosenData['tanggallahir'],
                //     'tempatlahir' => $dosenData['tempatlahir'],
                // ]);
            }

            // Mendapatkan data dari respons
            // $body = $response->getBody()->getContents();
            // $responseData = json_encode($response['data']);
            // $body = $response->getBody()->getContents();

            // Mendapatkan data dari body respons
            // $data = json_encode($body, true);

            // print_r($response);
            // $data = $body['data'];

            // // Loop melalui setiap item data
            // foreach ($data as $item) {
            //     // Simpan data ke dalam tabel dengan menggunakan metode create()
            //     Dosen::create($item);
            // }

            // return $response;
            // Tampilkan data yang diperoleh dari request
            return response()->json(['message' => 'Data dosen berhasil didapatkan', 'data' => json_decode($body, true)]);
        } catch (Exception $e) {
            // Tangani kesalahan jika permintaan gagal
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
}
