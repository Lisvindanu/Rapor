<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Periode;
use App\Models\ProgramStudi;
use App\Models\Rapor;
use App\Models\Soal;


class BankSoalController extends Controller
{
    public function index(Request $request)
    {
        //cek apakah request kosong
        if ($request->has('periodeakademik') && $request->has('programstudi')) {
            $periodeakademik = $request->periodeakademik;
            $programstudi = $request->programstudi;
        } else {
            //dapatkan data kode_periode dari model periode paling akhir
            // $periode = Periode::orderBy('kode_periode', 'desc')->pluck('kode_periode')->first();

            // dapatkan 10 data paling akhir dari Periode
            $daftar_periode = Periode::orderBy('kode_periode', 'desc')->take(10)->get();

            // dapatkan data dari model Program Studi
            $daftar_programstudi = ProgramStudi::all();
            $periode = 20231;

            $dataRapor = Rapor::with('dosen')
                ->where('periode_rapor', $periode)
                ->paginate(10);

            $total = $dataRapor->total(); // Mendapatkan total data

            // return response()->json($dataRapor);
            return view('kuisioner.banksoal.index', [
                'data' => $dataRapor,
                'daftar_periode' => $daftar_periode,
                'daftar_programstudi' => $daftar_programstudi,
                'total' => $total,
            ]);
        }

        return view('kuisioner.banksoal.index');
    }

    public function create()
    {
        return view('kuisioner.banksoal.create');
    }

    public function store(Request $request)
    {
        // Validasi data yang diterima dari form
        $validatedData = $request->validate([
            'nama_soal' => 'required|string|max:255',
            'keterangan' => 'required|string',
        ]);

        try {
            // Simpan data ke dalam database
            $soal = new Soal();
            $soal->nama_soal = $validatedData['nama_soal'];
            $soal->keterangan = $validatedData['keterangan'];
            $soal->soal_acak = $request->has('soal_acak'); // Mengambil nilai boolean dari checkbox 'soal_acak'
            $soal->publik = $request->has('publik'); // Mengambil nilai boolean dari checkbox 'publik'
            $soal->save();

            // Jika berhasil disimpan, kembalikan response
            return back()->with('message', "Data soal berhasil disimpan");
        } catch (\Exception $e) {
            // Jika terjadi kesalahan saat menyimpan data, kembalikan response error
            return back()->with('message', "Gagal menyimpan data soal: ");
        }
    }

    public function show($id)
    {
        // $id to string
        $id = (string) $id;
        try {
            $soal = Soal::find($id);
            if ($soal) {
                return view('kuisioner.banksoal.show', [
                    'data' => $soal,
                ]);
            }
        } catch (\Throwable $th) {
            return back();
        }


        // return view('kuisioner.banksoal.create');
        // echo "show";
        // $soal = Soal::find($id);
        // return view('kuisioner.banksoal.show', ['soal' => $soal]);
    }
}
