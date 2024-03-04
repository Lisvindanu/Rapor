<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Exception;
use Maatwebsite\Excel\Facades\Excel;
use App\Models\Rapor;
use Maatwebsite\Excel\Row;

class ImportController extends Controller
{
    public function importRaporKinerja(Request $request)
    {
        $message = '';
        //validate file
        $validasi = $request->validate([
            'file' => 'required|mimes:xlsx,xls'
        ]);

        // Cek apakah file yang diupload adalah file excel
        if ($validasi) {
            try {
                $file = $request->file('file');
                $data = Excel::toArray([], $file);

                // Hapus baris pertama dan ke dua pada array
                array_shift($data[0]);
                array_shift($data[0]);

                foreach ($data[0] as $row) {
                    //update data Rapor
                    $rapor = Rapor::where('periode_rapor', $row[1])
                        //ilike %dosen_nip%
                        ->where('dosen_nip', 'ilike', '%' . $row[2] . '%')
                        ->where('programstudi', $row[5])
                        ->first();

                    // dd($rapor);
                    // print_r($rapor);

                    if ($rapor) {
                        $rapor->bkd_total = $row[6];
                        $rapor->edom_materipembelajaran = $row[7];
                        $rapor->edom_pengelolaankelas = $row[8];
                        $rapor->edom_prosespengajaran = $row[9];
                        $rapor->edom_penilaian = $row[10];
                        $rapor->edasep_atasan = $row[11];
                        $rapor->edasep_sejawat = $row[12];
                        $rapor->edasep_bawahan = $row[13];
                        $rapor->save();
                    } else {
                        //insert data Rapor
                        // $rapor = new Rapor();
                        // $rapor->periode_rapor = $row[1];
                        // $rapor->dosen_nip = $row[2];
                        // $rapor->programstudi = $row[5];
                        // $rapor->bkd_total = $row[6];
                        // $rapor->edom_materipembelajaran = $row[7];
                        // $rapor->edom_pengelolaankelas = $row[8];
                        // $rapor->edom_prosespengajaran = $row[9];
                        // $rapor->edom_penilaian = $row[10];
                        // $rapor->edasep_atasan = $row[11];
                        // $rapor->edasep_sejawat = $row[12];
                        // $rapor->edasep_bawahan = $row[13];
                        // $rapor->save();
                    }
                }
                $message = 'File berhasil diupload';
            } catch (\Exception $e) {
                //throw $th;
                $message = $e->getMessage();
            }
        } else {
            // Jika file yang diupload bukan file excel
            $message = 'File yang diupload bukan file excel';
        }

        return redirect()->back()->with('message', $message);
    }
}
