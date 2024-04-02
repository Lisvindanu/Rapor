<?php

namespace App\Http\Controllers;

use App\Models\KuesionerSDM;
use Illuminate\Http\Request;
use App\Models\Soal;
use App\Models\Periode;
use App\Models\Responden;
use App\Models\SoalKuesionerSDM;
use Svg\Tag\Rect;
use App\Models\Pegawai;
use App\Models\UnitKerja;

class KuesionerSDMController extends Controller
{
    //
    public function index(Request $request)
    {
        //cek apakah request kosong
        if ($request->has('periode')) {
            $periode = $request->periode;
        } else if ($request->session()->has('selected_periode')) {
            $periode = $request->session()->get('selected_periode');
        } else {
            //dapatkan data kode_periode dari model periode paling akhir
            $periode = Periode::orderBy('kode_periode', 'desc')->pluck('kode_periode')->first();
            // $periode = '20231';
        }

        $daftar_periode = Periode::orderBy('kode_periode', 'desc')->take(10)->get();
        $dataKuisonerSDM = KuesionerSDM::with('pegawai')->where('kode_periode', $periode)->paginate(10);
        $total = $dataKuisonerSDM->total(); // Mendapatkan total data

        return view('kuesioner.kuesioner-sdm.index', [
            'data' => $dataKuisonerSDM,
            'total' => $total,
            'daftar_periode' => $daftar_periode,
        ]);
    }

    public function aksi($id, Request $request)
    {
        // dapatkan 10 data paling akhir dari Periode
        $daftar_periode = Periode::orderBy('kode_periode', 'desc')->take(10)->get();
        // jika request has id kuesionerSDM
        if ($id) {
            $kuesioner = KuesionerSDM::find($id);
            echo $kuesioner;
            // return view('kuesioner.kuesioner-sdm.aksi', [
            //     'kuesioner' => $kuesioner,
            //     'daftar_periode' => $daftar_periode,
            // ]);
        } else {
            return view('kuesioner.kuesioner-sdm.aksi', [
                'daftar_periode' => $daftar_periode,
            ]);
        }
    }

    // create
    public function create()
    {
        // dapatkan 10 data paling akhir dari Periode
        $daftar_periode = Periode::orderBy('kode_periode', 'desc')->take(10)->get();
        return view('kuesioner.kuesioner-sdm.create', [
            'daftar_periode' => $daftar_periode,
        ]);
    }

    // store
    public function store(Request $request)
    {

        try {
            // Validasi data
            $request->validate([
                'kode_periode' => 'required',
                'nama_kuesioner' => 'required',
                'subjek_penilaian' => 'required',
                'jenis_kuesioner' => 'required',
                'jadwal_kegiatan' => 'required',
            ]);

            // // Simpan data kuesioner baru
            $kuesioner = new kuesionerSDM();
            $kuesioner->kode_periode = $request->kode_periode;
            $kuesioner->nama_kuesioner = $request->nama_kuesioner;
            $kuesioner->subjek_penilaian = $request->nip;
            $kuesioner->jenis_kuesioner = $request->jenis_kuesioner;
            $kuesioner->jadwal_kegiatan = $request->jadwal_kegiatan;
            $kuesioner->save();

            // return redirect()->route('kuesioner.kuesioner-sdm')->with('message', 'Kegiatan kuesioner SDM berhasil disimpan.');
            return back()->with('message', 'Kegiatan kuesioner SDM berhasil disimpan.');
        } catch (\Exception $e) {
            return back()->with('message', "Kegiatan Kuesioner SDM gagal disimpan." . $e);
        }
    }

    // edit
    public function edit($id)
    {
        // echo ("Hello World");
        $id = (string) $id;
        // dapatkan data paling akhir dari Periode
        $daftar_periode = Periode::orderBy('kode_periode', 'desc')->take(10)->get();
        $kuesioner = KuesionerSDM::find($id);
        // echo $kuesioner;
        return view('kuesioner.kuesioner-sdm.aksi', [
            'kuesioner' => $kuesioner,
            'daftar_periode' => $daftar_periode,
        ]);
    }

    //update
    public function update(Request $request)
    {
        // dd($request->all());
        // echo $request->all();
        try {
            // Validasi data
            $request->validate([
                'kode_periode' => 'required',
                'nama_kuesioner' => 'required',
                'subjek_penilaian' => 'required',
                'jenis_kuesioner' => 'required',
                'jadwal_kegiatan' => 'required',
            ]);

            // Simpan data kuesioner baru
            $kuesioner = KuesionerSDM::find($request->id);
            $kuesioner->kode_periode = $request->kode_periode;
            $kuesioner->nama_kuesioner = $request->nama_kuesioner;
            $kuesioner->subjek_penilaian = $request->nip;
            $kuesioner->jenis_kuesioner = $request->jenis_kuesioner;
            $kuesioner->jadwal_kegiatan = $request->jadwal_kegiatan;
            $kuesioner->save();

            // return redirect()->route('kuesioner.kuesioner-sdm')->with('message', 'Kegiatan kuesioner SDM berhasil diubah.');
            return back()->with('message', 'Kegiatan kuesioner SDM berhasil diubah.');
        } catch (\Exception $e) {
            return back()->with('message', "Kegiatan Kuesioner SDM gagal diubah." . $e);
        }
    }

    // getjsonkuesionersdm
    function getAllDataKuesionerSDM(Request $request)
    {
        // Menentukan jumlah data per halaman
        $perPage = $request->has('limit') ? $request->get('limit') : 10;

        // Mengambil data sesuai dengan request
        $dataKuesionerSDM = KuesionerSDM::when($request->has('search'), function ($query) use ($request) {
            $search = $request->get('search');
            $query->where(function ($query) use ($search) {
                $query->where('subjek_penilaian', 'ilike', "%$search%")
                    ->orWhere('nama_kuesioner', 'ilike', "%$search%")
                    ->orWhereHas('pegawai', function ($query) use ($search) {
                        $query->where('nama', 'ilike', "%$search%");
                    });
            });
        })->when($request->has('kode_periode'), function ($query) use ($request) {
            $kode_periode = $request->get('kode_periode');
            $request->session()->put('selected_periode', $kode_periode);
            $query->where('kode_periode', $kode_periode);
        })->with('pegawai')
            ->paginate($perPage); // Menggunakan paginate untuk pagination
        return response()->json($dataKuesionerSDM);
    }

    //destroy
    public function destroy($id)
    {
        // Temukan data indikator kinerja yang akan dihapus
        $dataKuesionerSDM = KuesionerSDM::findOrFail($id);

        // Data tidak ditemukan
        if (!$dataKuesionerSDM) {
            return response()->json(['message' => 'Data tidak ditemukan'], 404);
        }

        // Hapus data indikator kinerja
        $dataKuesionerSDM->delete();

        // Kirim respon berhasil
        return response()->json(['message' => 'Data berhasil dihapus'], 200);
    }

    //show
    public function show($id)
    {
        $kuesioner = KuesionerSDM::with(['periode', 'soal'])->find($id);
        $soalKuesionerSDM = SoalKuesionerSDM::where('kuesioner_sdm_id', $id)->get();

        // echo $kuesioner;
        return view('kuesioner.kuesioner-sdm.detail', [
            'data' => $kuesioner,
            'soalKuesionerSDM' => $soalKuesionerSDM,
        ]);
    }

    // createSoalKuesionerSDM
    public function createSoalKuesionerSDM(Request $request)
    {
        try {
            // Validasi data yang diterima
            $request->validate([
                'id_soal' => 'required',
                'id_kuesionerSDM' => 'required',
            ]);

            // Buat instance baru dari model SoalKuesionerSDM
            $soalKuesionerSDM = new SoalKuesionerSDM();
            $soalKuesionerSDM->soal_id = $request->id_soal;
            $soalKuesionerSDM->kuesioner_sdm_id = $request->id_kuesionerSDM;


            // Simpan data ke dalam database
            $soalKuesionerSDM->save();

            // Jika berhasil disimpan, kembalikan respons atau redirect ke halaman yang sesuai
            return response()->json(['message' => 'Data berhasil disimpan'], 200);
        } catch (\Exception $e) {
            // Jika terjadi kesalahan saat menyimpan data, kembalikan response error
            return response()->json(['message' => 'Gagal menyimpan data: ' . $e->getMessage()], 500);
        }
    }

    // deleteSoalKuesionerSDM
    public function deleteSoalKuesionerSDM($id)
    {
        // Temukan data soal kuesioner sdm yang akan dihapus
        $soalKuesionerSDM = SoalKuesionerSDM::findOrFail($id);

        // Data tidak ditemukan
        if (!$soalKuesionerSDM) {
            return response()->json(['message' => 'Data tidak ditemukan'], 404);
        }

        // Hapus data soal kuesioner sdm
        $soalKuesionerSDM->delete();

        // Kirim respon berhasil
        return response()->json(['message' => 'Data berhasil dihapus'], 200);
    }

    // responden
    public function responden($id)
    {
        $kuesioner = KuesionerSDM::with(['periode', 'soal'])->find($id);
        $responden = Responden::where('kuesioner_sdm_id', $id)->get();
        // $unitkerja = UnitKerja::all();

        // return response()->json($responden);

        // // echo $kuesioner;
        return view('kuesioner.kuesioner-sdm.responden', [
            'data' => $kuesioner,
            'responden' => $responden,
            // 'unitkerja' => $unitkerja,
        ]);
    }

    public function tambahResponden(Request $request)
    {
        // Lakukan validasi sesuai kebutuhan
        $request->validate([
            'nip_pegawai' => 'required|array',
            'kuesioner_sdm_id' => 'required|exists:kuesioner_sdm,id',
        ]);

        try {
            // Simpan data responden untuk setiap pegawai yang terpilih
            foreach ($request->nip_pegawai as $nip) {
                // Cari pegawai berdasarkan NIP
                $pegawai = Pegawai::where('nip', $nip)->first();

                // Jika pegawai ditemukan, simpan data responden
                if ($pegawai) {
                    $responden = new Responden();
                    $responden->pegawai_nip = $pegawai->nip;
                    $responden->kuesioner_sdm_id = $request->kuesioner_sdm_id;
                    $responden->save();
                }
            }

            return response()->json(['message' => 'Data responden berhasil ditambahkan'], 200);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Terjadi kesalahan saat menambahkan data responden'], 500);
        }
    }

    // fungsi deleteresponden
    public function deleteResponden($id)
    {
        // Temukan data responden yang akan dihapus
        $responden = Responden::findOrFail($id);

        // Data tidak ditemukan
        if (!$responden) {
            return response()->json(['message' => 'Data tidak ditemukan'], 404);
        }

        // Hapus data responden
        $responden->delete();

        // Kirim respon berhasil
        return response()->json(['message' => 'Data berhasil dihapus'], 200);
    }
}
