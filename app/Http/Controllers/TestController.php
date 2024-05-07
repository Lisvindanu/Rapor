<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use BaconQrCode\Renderer\ImageRenderer;
use BaconQrCode\Renderer\Image\ImagickImageBackEnd;
use BaconQrCode\Renderer\RendererStyle\RendererStyle;
use BaconQrCode\Writer;

class TestController extends Controller
{
    public function index()
    {
        try {
            $renderer = new ImageRenderer(
                new RendererStyle(400),
                new ImagickImageBackEnd()
            );
            $writer = new Writer($renderer);
            $writer->writeFile('Hello World!', 'qrcode.png');

            exit; // Penting: hentikan proses eksekusi kode PHP selanjutnya

        } catch (\Exception $e) {
            // Tangani kesalahan jika terjadi
            // return $this->sendError($e->getMessage(), [], 500);
            return response()->json([
                'message' => $e->getMessage(),
                'status' => 500
            ], 500);
        }
    }
}
