<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use GuzzleHttp\Client;
use Exception;

class SinkronasiController extends Controller
{
    function index()
    {
        return response()->json(['message' => 'Hello ini dari Sinkronasi Controller']);
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

    function getDataDosen(){
        try {
            // Ambil access token yang sudah disimpan
            $accessToken = $GLOBALS['access_token'] ?? null;

            // Jika access token tidak ada, kembalikan pesan kesalahan
            if (!$accessToken) {
                return response()->json(['error' => 'Access token tidak tersedia'], 500);
            }

            // Buat instance dari Guzzle Client
            $client = new Client();

            // Menggunakan access token untuk request mendapatkan data dosen
            $response = $client->request('GET', 'https://unpas.siakadcloud.com/live/dosen', [
                'headers' => [
                    'Authorization' => 'Bearer ' . $accessToken // Gunakan access token yang sudah ada
                ]
            ]);

            // Dapatkan body respons dalam bentuk string
            $body = $response->getBody();

            // Tampilkan data yang diperoleh dari request
            return response()->json(['message' => 'Data dosen berhasil didapatkan', 'data' => json_decode($body, true)]);
        } catch (Exception $e) {
            // Tangani kesalahan jika permintaan gagal
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
        
    }
}
