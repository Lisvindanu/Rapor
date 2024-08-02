<?php

namespace App\Http\Controllers;

use App\Models\JadwalPerkuliahan;
use App\Models\Mahasiswa;
use App\Models\RoleUser;
use App\Models\UnitKerja;
use App\Models\User;
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
use Maatwebsite\Excel\Facades\Excel;
use Maatwebsite\Excel\Excel as ExcelFormat;
use Illuminate\Support\Facades\Schema;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class TestController extends Controller
{
    public function index()
    {
        // get 5 top mahasiswa
        $listMahasiswa = Mahasiswa::whereHas('user')
            // ->limit(5)
            ->get();

        foreach ($listMahasiswa as $mahasiswa) {
            $unitKerjaId = UnitKerja::where('nama_unit', $mahasiswa->programstudi)->first()->id;

            // update unit_kerja_id pada roleuser
            $roleUser = RoleUser::where('user_id', $mahasiswa->user->id)->first();
            $roleUser->unit_kerja_id = $unitKerjaId;
            $roleUser->save();
            // echo $mahasiswa->nama . ' - ' . $unitKerjaId . '-' . $mahasiswa->programstudi . '<br>';
        }

        return response()->json([
            'message' => 'Success',
            'status' => 200
        ], 200);

        // try {
        //     // Create QR code
        //     $qrCode = QrCode::create('Life is too short to be generating QR codes');

        //     // Create FileWriter
        //     $writer = new PngWriter();

        //     // Write QR code to file
        //     $result = $writer->write($qrCode);

        //     // Validate the result (optional)
        //     // $writer->validateResult($result);

        //     // Set the response header
        //     header('Content-Type: ' . $result->getMimeType());

        //     // Output the QR code file contents
        //     echo $result->getString();

        //     exit; // Stop further execution of PHP code
        // } catch (\Exception $e) {
        //     // Tangani kesalahan jika terjadi
        //     // return $this->sendError($e->getMessage(), [], 500);
        //     return response()->json([
        //         'message' => $e->getMessage(),
        //         'status' => 500
        //     ], 500);
        // }
    }

    // auditData
    public function auditData()
    {
        $data = JadwalPerkuliahan::where('programstudi', 'S1 Teknik Informatika')
            ->orWhere('programstudi', 'S1 Teknik Mesin')
            ->orWhere('programstudi', 'S1 Teknik Industri')
            ->orWhere('programstudi', 'S1 Teknologi Pangan')
            ->orWhere('programstudi', 'S1 Teknik Lingkungan')
            ->orWhere('programstudi', 'S1 Perencanaan Wilayah dan Kota')
            ->where('periode', '20232')
            ->get();

        return response()->json([
            'message' => 'Success',
            'data' => $data,
            'status' => 200
        ], 200);
    }
}
