<?php

namespace App\Http\Controllers;

use App\Models\ProgramStudi;
use Illuminate\Http\Request;
use App\Models\RemedialAjuan;
use App\Models\RemedialAjuanDetail;
use App\Models\RemedialPeriode;
use App\Models\UnitKerja;
use Illuminate\Support\Facades\Storage;
use App\Helpers\UnitKerjaHelper;

class RemedialAjuanController extends Controller
{
    // index
    public function index(Request $request)
    {
        try {
            // untuk dropdown unit kerja
            $unitKerja = UnitKerja::with('childUnit')->where('id', session('selected_filter'))->get();
            $unitKerjaIds = UnitKerjaHelper::getUnitKerjaIds();

            if ($request->has('periodeTerpilih')) {
                $periodeTerpilih = RemedialPeriode::with('remedialperiodetarif')
                    ->where('id', $request->periodeTerpilih)
                    // ->whereIn('unit_kerja_id', $unitKerjaIds)
                    ->first();
            } else {
                $periodeTerpilih = RemedialPeriode::with('remedialperiodetarif')
                    ->where('is_aktif', 1)
                    ->whereIn('unit_kerja_id', $unitKerjaIds)
                    ->orderBy('created_at', 'desc')
                    ->first();
            }

            // $periodeTerpilih_rest = $periodeTerpilih->pluck('id')->toArray();

            // return response()->json($periodeTerpilih_rest);

            $daftar_periode = RemedialPeriode::with('periode')
                ->whereIn('unit_kerja_id', $unitKerjaIds)
                ->orderBy('created_at', 'desc')->take(10)->get();

            $query = RemedialAjuan::with('remedialajuandetail')
                // ->whereIn('remedial_periode_id', $periodeTerpilih_rest)
                ->where('remedial_periode_id', $periodeTerpilih->id)
                ->where('status_pembayaran', 'Menunggu Konfirmasi');

            if ($request->has('programstudi')) {

                if ($request->get('programstudi') != 'all') {
                    $programstudis = ProgramStudi::where('id', $request->get('programstudi'))->first();

                    if (!$programstudis) {
                        return redirect()->back()->with('message', 'Program Studi tidak ditemukan');
                    }

                    $query->where('programstudi', $programstudis->nama);
                    $programstuditerpilih = $programstudis;
                }
            }

            $data_ajuan = $query->paginate($request->get('perPage', 10));

            // return response()->json($data_ajuan);

            $total = $data_ajuan->total();

            return view(
                'remedial.ajuan.index',
                [
                    'periodeTerpilih' => $periodeTerpilih,
                    'programstuditerpilih' => $programstuditerpilih ?? null,
                    'daftar_periode' => $daftar_periode,
                    // 'programstudi' => $programstudi,
                    'data' => $data_ajuan,
                    'total' => $total,
                ]
            );
        } catch (\Exception $e) {
            return back()->with('message', "Terjadi kesalahan" . $e->getMessage());
        }
    }
    // store
    public function store(Request $request)
    {
        try {
        } catch (\Exception $e) {
            //throw $th;
        }
    }

    // store via ajax
    public function storeAjax(Request $request)
    {
        try {
            // Lakukan validasi sesuai kebutuhan
            $request->validate([
                'krs' => 'required|array',
                'idmk' => 'required|array',
                'nama_kelas' => 'required|array',
                'remedial_periode_id' => 'required|exists:remedial_periode,id',
            ]);

            $user = auth()->user()->mahasiswa;

            $periode = RemedialPeriode::with('remedialperiodetarif')
                ->whereHas('remedialperiodetarif', function ($query) use ($user) {
                    $query->where('periode_angkatan', $user->periodemasuk);
                })
                ->where('id', $request->remedial_periode_id)
                ->first();

            if (!$periode) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Periode remedial tidak ditemukan',
                ]);
            }

            $totalKrs = count($request->krs);

            $va = $periode->format_va;
            if ($periode->add_nrp) {
                $va = $periode->format_va . auth()->user()->username;
            }


            // Lakukan proses penyimpanan data ke remedialajuan dan dapatkan id nya
            $remedialAjuan = RemedialAjuan::create([
                'remedial_periode_id' => $request->remedial_periode_id,
                'nim' => auth()->user()->username,
                'programstudi' => auth()->user()->mahasiswa->programstudi,
                'va' => $va,
                'total_bayar' => $totalKrs * $periode->remedialperiodetarif[0]->tarif,
                'tgl_pengajuan' => now(),
            ]);

            // Lakukan proses penyimpanan data ke remedialajuandetail
            for ($i = 0; $i < $totalKrs; $i++) {
                RemedialAjuanDetail::create([
                    'remedial_ajuan_id' => $remedialAjuan->id,
                    'kode_periode' => $periode->kode_periode,
                    'krs_id' => $request->krs[$i],
                    'idmk' => $request->idmk[$i],
                    'namakelas' => $request->nama_kelas[$i],
                    'harga_remedial' => $periode->remedialperiodetarif[0]->tarif,
                    'status_ajuan' => 'pending',
                ]);
            }

            return response()->json([
                'status' => 'success',
                'message' => 'Data berhasil disimpan',
                'data' => $remedialAjuan,
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Data gagal disimpan',
                'data' => $e->getMessage(),
            ]);
        }
    }

    // deleteAjax
    public function deleteAjax($id)
    {
        try {
            // Temukan data remedial ajuan yang akan dihapus
            $data = RemedialAjuan::findOrFail($id);

            // Data tidak ditemukan
            if (!$data) {
                return response()->json(['message' => 'Data tidak ditemukan'], 404);
            }

            // Hapus bukti pembayaran dari storage jika ada
            if ($data->bukti_pembayaran) {
                Storage::disk('public')->delete($data->bukti_pembayaran);
            }

            // delete juga remedialajuandetail
            $data->remedialajuandetail()->delete();
            $data->delete();

            // Kirim respon berhasil
            return response()->json(['message' => 'Data berhasil dihapus'], 200);
        } catch (\Exception $e) {
            // Kirim respon gagal
            return response()->json(['message' => 'Data gagal dihapus'], 500);
        }
    }

    //uploadBukti
    public function uploadBukti(Request $request)
    {
        try {
            // Lakukan validasi sesuai kebutuhan
            $request->validate([
                'remedial_ajuan_id' => 'required|exists:remedial_ajuan,id',
                'tgl_pembayaran' => 'required',
                'bukti_pembayaran' => 'required|image|mimes:png,jpg|max:1024',
            ]);

            // Temukan data remedial ajuan yang akan diupload bukti pembayaran
            $data = RemedialAjuan::findOrFail($request->remedial_ajuan_id);

            // Data tidak ditemukan
            if (!$data) {
                return response()->json(['message' => 'Data tidak ditemukan'], 404);
            }

            // Hapus file bukti pembayaran sebelumnya jika ada
            if ($data->bukti_pembayaran) {
                Storage::disk('public')->delete($data->bukti_pembayaran);
            }

            // Simpan file bukti pembayaran
            $file = $request->file('bukti_pembayaran');
            $fileName = time() . '.' . $file->extension();
            // $file->move(public_path('bukti_pembayaran'), $fileName);
            $path = $file->storeAs('bukti_pembayaran', $fileName, 'public');

            // Update data remedial ajuan dengan bukti pembayaran
            $data->update([
                'bukti_pembayaran' => $path,
                'status_pembayaran' => 'Menunggu Konfirmasi',
            ]);

            // Kirim respon berhasil
            return response()->json(['message' => 'Bukti pembayaran berhasil diupload'], 200);
        } catch (\Exception $e) {
            // Kirim respon gagal beserta $e->getMessage()
            return response()->json(['message' => 'Bukti pembayaran gagal diupload' .  $e->getMessage()], 500);
        }
    }

    //ajuandetail
    public function ajuandetail($id)
    {
        try {
            $data = RemedialAjuanDetail::with(['kelasKuliah', 'remedialajuan', 'krs'])
                ->where('remedial_ajuan_id', $id)
                ->get();
            return response()->json($data);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Data tidak ditemukan'], 404);
        }
    }

    // verifikasiajuan
    public function verifikasiAjuan(Request $request)
    {
        // validate data request
        $request->validate([
            'remedial_ajuan_id' => 'required',
        ]);

        // if validate fail return response
        if ($request->fails()) {
            return response()->json(['message' => 'Data tidak valid'], 400);
        }

        try {
            // get data remedial ajuan id
            $remedialAjuan = RemedialAjuan::findOrFail($request->remedial_ajuan_id);

            // if data not found return response
            if (!$remedialAjuan) {
                return response()->json(['message' => 'Data tidak ditemukan'], 404);
            }

            // update status pembayaran
            $remedialAjuan->update([
                'status_pembayaran' => 'Lunas',
                'is_lunas' => 1,
            ]);

            // update status_ajuan remedial ajuan detail where remedial ajuan id
            RemedialAjuanDetail::where('remedial_ajuan_id', $request->remedial_ajuan_id)
                ->update(['status_ajuan' => 'approved']);

            $data = request()->all();

            return response()->json($data);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Data gagal diverifikasi'], 500);
        }
    }
}
