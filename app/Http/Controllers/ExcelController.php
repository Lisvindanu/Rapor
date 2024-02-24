<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Exports\TemplateExport;
use Maatwebsite\Excel\Facades\Excel;


class ExcelController extends Controller
{
    public function downloadTemplate()
    {
        return Excel::download(new TemplateExport, 'template_dokumen.xlsx');
    }
}
