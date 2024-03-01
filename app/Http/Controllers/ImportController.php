<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Exception;

class ImportController extends Controller
{
    public function importRaporKinerja(Request $request)
    {

        $message = '';

        // Cek apakah file yang diupload adalah file excel
        if ($request->file('fileUpload')->getClientOriginalExtension() == 'xlsx' || $request->file('fileUpload')->getClientOriginalExtension() == 'xls') {
            $message = 'File berhasil diupload';
        } else {
            // Jika file yang diupload bukan file excel
            $message = 'File yang diupload bukan file excel';
        }

        return redirect()->back()->with('message', $message);
    }
}
