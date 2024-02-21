<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Models\Rapor;
use App\Models\KelasKuliah;

class RaporController extends Controller
{
    function index()
    {
        $data = [
            'title' => 'RAPOR KINERJA INDIVIDU',
            'subtitle' => 'SEMESTER GANJIL 2023/2024',
            'date' => date('d/m/Y'),
        ];

        // if ($request->has('download')) {

        $pdf = Pdf::loadView('pdf.rapor',);
        // $pdf = Pdf::loadView('pdf.document', $data);
        return $pdf->download('document.pdf');
        // }
        // return view('index', $data);
    }

    function dashboard()
    {
        return view('rapor-kinerja.index');
    }

    // fungsi generated data model rapor berdasarkan periode dan program studi
    function generateDataRapor(Request $request)
    {
        // ambil data dari post request
        $periodeakademik = $request->periodeakademik;
        $programstudi = $request->programstudi;

        //dapatkan kode nip dosen dari kelas kuliah berdasarkan periode dan prodi dan grouping berdasarkan nip
        $dosens = KelasKuliah::where('periodeakademik', $periodeakademik)
            ->where('programstudi', $programstudi)
            ->select('nip') // Pilih kolom nip
            ->groupBy('nip')
            ->get();

        $dataRapor = [];
        // buat data rapor berdasarkan data dosens 
        foreach ($dosens as $dosen) {

            // jika data nip dosen null maka lewati
            if ($dosen->nip !== null) {
                // Ambil NIP dari setiap entri
                $nip = $dosen->nip;

                // jika nip dosen sudah ada pada tabel rapor maka lewati
                $rapor = Rapor::where('periode_rapor', $periodeakademik)
                    ->where('dosen_nip', $nip)
                    ->first();

                if (!$rapor) {
                    $rapor = new Rapor();
                    $rapor->periode_rapor = $periodeakademik;
                    $rapor->dosen_nip = $nip;
                    $rapor->save();
                    $dataRapor[] = $rapor;
                }
            }
        }

        return response()->json($dataRapor);
    }
}
