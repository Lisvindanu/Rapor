<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;

class RaporController extends Controller
{
    function index()
    {
        $data = [
            'title' => 'How To Create PDF File In Laravel 10 - Leravio',
            'date' => date('d/m/Y'),
        ];
        // if ($request->has('download')) {
        $pdf = Pdf::loadView('pdf.document', $data);
        return $pdf->download('document.pdf');
        // }
        // return view('index', $data);
    }
}
