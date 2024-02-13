<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;

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
}
