<?php

namespace App\Http\Controllers;

use App\Exports\RaporExport;
use Illuminate\Http\Request;
use App\Exports\TemplateExport;
use Maatwebsite\Excel\Facades\Excel;


class ExcelController extends Controller
{
    public function downloadTemplate()
    {
        return Excel::download(new TemplateExport, 'template_dokumen.xlsx');
    }

    public function RaporTemplate()
    {
        return Excel::download(new RaporExport, 'template_rapor.xlsx');
    }
}
