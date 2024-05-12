<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Endroid\QrCode\Color\Color;
use Endroid\QrCode\Encoding\Encoding;
use Endroid\QrCode\ErrorCorrectionLevel;
use Endroid\QrCode\QrCode;
use Endroid\QrCode\Label\Label;
use Endroid\QrCode\Logo\Logo;
use Endroid\QrCode\RoundBlockSizeMode;
use Endroid\QrCode\Writer\PngWriter;
use Endroid\QrCode\Writer\ValidationException;

class TestController extends Controller
{
    public function index()
    {
        try {
            // Create QR code
            $qrCode = QrCode::create('Life is too short to be generating QR codes');

            // Create FileWriter
            $writer = new PngWriter();

            // Write QR code to file
            $result = $writer->write($qrCode);

            // Validate the result (optional)
            // $writer->validateResult($result);

            // Set the response header
            header('Content-Type: ' . $result->getMimeType());

            // Output the QR code file contents
            echo $result->getString();

            exit; // Stop further execution of PHP code
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
