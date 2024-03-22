<?php

namespace App\Http\Controllers;

use App\Models\Responden;
use App\Models\Penilaian;
use App\Models\Soal;
use Illuminate\Http\Request;
use App\Models\SoalKuesionerSDM;

class PenilaianController extends Controller
{
    //index
    public function index()
    {
        $responden = Responden::with(['kuesionerSDM', 'pegawai', 'penilaian'])->where('pegawai_nip', auth()->user()->username)->get();

        return view('kuesioner.penilaian.index', [
            'data_kuisioner' => $responden
        ]);
    }

    // generate penilaian
    public function mulaiPenilaian($id)
    {
        $responden = Responden::with(['kuesionerSDM', 'pegawai', 'penilaian'])->where('pegawai_nip', auth()->user()->username)->get();

        // dd($responden);
        // return responden json format
        // return response()->json($responden);

        // return view('kuesioner.penilaian.penilaian', [
        //     'data' => $responden
        // ]);
        // $responden = Responden::with('penilaian')->find($id);

        // // cek jika penilaian sudah di generate
        // if ($responden->penilaian->count() == 0) {
        //     // echo "penilaian belum di generate";
        //     $this->generatePertanyaan($responden);
        // }

        // $penilaian = Penilaian::with(['pertanyaan'])->where('responden_id', $id)->get();

        return view('kuesioner.penilaian.penilaian', [
            'data' => $responden
        ]);
        return response()->json($responden);
    }

    // fungsi generate pertanyaan
    private function generatePertanyaan(Responden $responden)
    {
        // ambil dulu kuisoner_sdm_id dari model Responden where id
        $kuesioner_sdm_id = $responden->kuesioner_sdm_id;

        // ambil soal_id dari model SoalKuesionerSDM where kuesioner_sdm_id
        $daftarsoal = SoalKuesionerSDM::with('soal')->where('kuesioner_sdm_id', $kuesioner_sdm_id)->get();

        // Iterasi melalui data_soal
        foreach ($daftarsoal as $soal) {
            // Iterasi melalui pertanyaan pada setiap soal
            foreach ($soal['soal']['pertanyaan'] as $pertanyaan) {
                // buat data penilaian dengan $id dan  $pertanyaan['id'];
                $penilaian = new Penilaian();
                $penilaian->responden_id = $responden->id;
                $penilaian->pertanyaan_id = $pertanyaan['id'];
                $penilaian->save();
            }
        }
    }

    // store penilaian
    public function store(Request $request)
    {
        // tampilkan semua request
        dd($request->all());
    }
}
