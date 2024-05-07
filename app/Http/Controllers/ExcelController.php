<?php

namespace App\Http\Controllers;

use App\Exports\RaporExport;
use App\Models\Rapor;
use Illuminate\Http\Request;
use App\Exports\TemplateExport;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\PertanyaanExport;
use App\Exports\KuesionerSDMExport;


class ExcelController extends Controller
{
    public function downloadTemplate()
    {
        return Excel::download(new TemplateExport, 'template_dokumen.xlsx');
    }

    public function RaporTemplate(Request $request)
    {
        // Mendapatkan parameter periode dan program_studi dari request
        $periode = $request->input('periode');
        $programStudi = $request->input('program_studi');

        // Jika periode dan program_studi tidak ada, maka download template rapor tanpa data
        if (!$periode && !$programStudi) {
            return Excel::download(new RaporExport, 'template_rapor.xlsx');
        }

        $datarapor = Rapor::with('dosen')
            ->where('periode_rapor', $periode)
            ->where('programstudi', $programStudi)
            ->get();

        // return data rapor json
        // return response()->json($datarapor);

        // Jika periode dan program_studi ada, maka download template rapor dengan data
        return Excel::download(new RaporExport($datarapor), 'template_rapor.xlsx');
    }

    //templateuploadpertanyaan
    public function uploadTemplatePertanyaan()
    {
        return Excel::download(new PertanyaanExport, 'template_pertanyaan.xlsx');
    }

    public function downloadTemplateKuesionerSDM()
    {
        return Excel::download(new KuesionerSDMExport, 'template-upload-kuesionersdm.xlsx');
    }
}
