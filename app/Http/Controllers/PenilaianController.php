<?php

namespace App\Http\Controllers;

use App\Models\Responden;
use Illuminate\Http\Request;

class PenilaianController extends Controller
{
    //index
    public function index()
    {
        //responden
        $responden = Responden::with(['kuesionerSDM', 'pegawai'])->where('pegawai_nip', auth()->user()->username)->get();

        return view('kuesioner.penilaian.index', [
            'data_kuisioner' => $responden
        ]);
    }

    // mulai penilaian atau lanjutkan penilaian
    public function mulaiPenilaian($id)
    {
        //responden
        $responden = Responden::with(['kuesionerSDM', 'pegawai'])->where('id', $id)->first();

        return view('kuesioner.penilaian.mulai', [
            'data_kuisioner' => $responden
        ]);
    }
}
