<?php

namespace App\Http\Controllers;

use App\Models\ProgramStudi;
use Illuminate\Http\Request;
use App\Models\SisipanAjuan;
use App\Models\SisipanAjuanDetail;
use App\Models\SisipanPeriode;
use App\Models\UnitKerja;
use Illuminate\Support\Facades\Storage;
use App\Helpers\UnitKerjaHelper;

class SisipanAjuanController extends Controller
{
    // index
    public function index(Request $request)
    {
        try {
            // untuk dropdown unit kerja
            $unitKerja = UnitKerja::with('childUnit')->where('id', session('selected_filter'))->get();
            $unitKerjaIds = UnitKerjaHelper::getUnitKerjaIds();

            //list unit kerja nama
            $unitKerjaNames = UnitKerjaHelper::getUnitKerjaNames();

            if ($request->has('periodeTerpilih')) {
                $periodeTerpilih = SisipanPeriode::with('sisipanperiodetarif')
                    ->where('id', $request->periodeTerpilih)
                    ->first();
            } else {
                $periodeTerpilih = SisipanPeriode::with('sisipanperiodetarif')
                    ->where('is_aktif', 1)
                    // ->whereIn('unit_kerja_id', $unitKerjaIds)
                    // ->orWhere('unit_kerja_id', session('selected_filter'))
                    ->orderBy('created_at', 'desc')
                    ->first();
            }

            $daftar_periode = SisipanPeriode::with('periode')
                ->whereIn('unit_kerja_id', $unitKerjaIds)
                ->orderBy('created_at', 'desc')->take(10)->get();

            $query = SisipanAjuan::with('sisipanajuandetail')
                ->whereIn('programstudi', $unitKerjaNames)
                ->where('sisipan_periode_id', $periodeTerpilih->id)
                ->where('status_pembayaran', 'Menunggu Konfirmasi');

            //filter terkait dengan program studi 
            if ($request->has('programstudi')) {

                if ($request->get('programstudi') != 'all') {
                    $programstudis = UnitKerja::where('id', $request->get('programstudi'))->first();

                    if (!$programstudis) {
                        return redirect()->back()->with('message', 'Program Studi tidak ditemukan');
                    }

                    $query->where('programstudi', $programstudis->nama_unit);
                    $programstuditerpilih = $programstudis;
                }
            }

            if ($request->has('search')) {
                if ($request->get('search') != null && $request->get('search') != '') {
                    $query->where('nim', 'like', '%' . $request->get('search') . '%')
                        ->orWhere('va', 'like', '%' . $request->get('search') . '%');
                }
            }

            $data_ajuan = $query->paginate($request->get('perPage', 10));

            $total = $data_ajuan->total();

            return view(
                'sisipan.ajuan.verifikasi',
                [
                    'periodeTerpilih' => $periodeTerpilih,
                    'programstuditerpilih' => $programstuditerpilih ?? null,
                    'daftar_periode' => $daftar_periode,
                    // 'programstudi' => $programstudi,
                    'unitkerja' => $unitKerja,
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
                'nip' => 'required|array',
                'sisipan_periode_id' => 'required|exists:sisipan_periode,id',
            ]);

            $user = auth()->user()->mahasiswa;

            $periode = SisipanPeriode::with([
                'sisipanperiodetarif' => function ($query) use ($user) {
                    $query->where('periode_angkatan', $user->periodemasuk);
                }
            ])
                ->whereHas('sisipanperiodetarif', function ($query) use ($user) {
                    $query->where('periode_angkatan', $user->periodemasuk);
                })
                ->where('id', $request->sisipan_periode_id)
                ->first();

            if (!$periode) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Periode sisipan tidak ditemukan',
                ]);
            }

            $totalKrs = count($request->krs);

            $va = $periode->format_va;
            if ($periode->add_nrp) {
                $va = $periode->format_va . auth()->user()->username;
            }


            // Lakukan proses penyimpanan data ke sisipanajuan dan dapatkan id nya
            $sisipanAjuan = SisipanAjuan::create([
                'sisipan_periode_id' => $request->sisipan_periode_id,
                'nim' => auth()->user()->username,
                'programstudi' => auth()->user()->mahasiswa->programstudi,
                'va' => $va,
                'total_bayar' => $totalKrs * $periode->sisipanperiodetarif[0]->tarif,
                'tgl_pengajuan' => now(),
            ]);

            // Lakukan proses penyimpanan data ke sisipanajuandetail
            for ($i = 0; $i < $totalKrs; $i++) {
                SisipanAjuanDetail::create([
                    'sisipan_ajuan_id' => $sisipanAjuan->id,
                    'kode_periode' => $periode->kode_periode,
                    'krs_id' => $request->krs[$i],
                    'idmk' => $request->idmk[$i],
                    'namakelas' => $request->nama_kelas[$i],
                    'nip'  => $request->nip[$i],
                    'harga_sisipan' => $periode->sisipanperiodetarif[0]->tarif,
                    'status_ajuan' => 'Konfirmasi Pembayaran',
                ]);
            }

            return response()->json([
                'status' => 'success',
                'message' => 'Data berhasil disimpan',
                'data' => $sisipanAjuan,
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
            // Temukan data sisipan ajuan yang akan dihapus
            $data = SisipanAjuan::findOrFail($id);

            // Data tidak ditemukan
            if (!$data) {
                return response()->json(['message' => 'Data tidak ditemukan'], 404);
            }

            // Hapus bukti pembayaran dari storage jika ada
            if ($data->bukti_pembayaran) {
                Storage::disk('public')->delete($data->bukti_pembayaran);
            }

            // delete juga sisipanajuandetail
            $data->sisipanajuandetail()->delete();
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
                'sisipan_ajuan_id' => 'required|exists:sisipan_ajuan,id',
                'tgl_pembayaran' => 'required',
                'bukti_pembayaran' => 'required|image|mimes:png,jpg|max:1024',
            ]);

            // Temukan data sisipan ajuan yang akan diupload bukti pembayaran
            $data = SisipanAjuan::findOrFail($request->sisipan_ajuan_id);

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

            // Update data sisipan ajuan dengan bukti pembayaran
            $data->update([
                'bukti_pembayaran' => $path,
                'status_pembayaran' => 'Menunggu Konfirmasi',
                'tgl_pembayaran' => $request->tgl_pembayaran,
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
            $data = SisipanAjuanDetail::with(['kelasKuliah', 'sisipanajuan', 'krs'])
                ->where('sisipan_ajuan_id', $id)
                ->get();
            return response()->json($data);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Data tidak ditemukan'], 404);
        }
    }

    // verifikasiajuan
    public function verifikasiAjuan(Request $request)
    {
        $validatedData = $request->validate([
            'sisipan_ajuan_id' => 'required',
            'jumlah_bayar' => 'required',
        ]);

        try {
            // get data sisipan ajuan id
            $sisipanAjuan = SisipanAjuan::find($request->sisipan_ajuan_id);

            // if data not found return response
            if (!$sisipanAjuan) {
                return response()->json(['message' => 'Data tidak ditemukan'], 404);
            }

            // update status pembayaran
            $sisipanAjuan->update([
                'jumlah_bayar' => $request->jumlah_bayar,
                'status_pembayaran' => 'Lunas',
                'is_lunas' => 1,
                'verified_by' => auth()->user()->username,
            ]);

            // update status_ajuan sisipan ajuan detail where sisipan ajuan id
            SisipanAjuanDetail::where('sisipan_ajuan_id', $request->sisipan_ajuan_id)
                ->update([
                    'status_ajuan' => 'Konfirmasi Kelas',
                ]);

            return response()->json(['message' => 'Data berhasil diverifikasi'], 200);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Data gagal diverifikasi'], 500);
        }
    }

    // daftar ajuan
    public function daftarAjuan(Request $request)
    {
        try {
            // untuk dropdown unit kerja
            $unitKerja = UnitKerja::with('childUnit')->where('id', session('selected_filter'))->get();
            $unitKerjaIds = UnitKerjaHelper::getUnitKerjaIds();

            //list unit kerja nama
            $unitKerjaNames = UnitKerjaHelper::getUnitKerjaNames();

            if ($request->has('periodeTerpilih')) {
                $periodeTerpilih = SisipanPeriode::with('sisipanperiodetarif')
                    ->where('id', $request->periodeTerpilih)
                    ->first();
            } else {
                $periodeTerpilih = SisipanPeriode::with('sisipanperiodetarif')
                    ->where('is_aktif', 1)
                    // ->whereIn('unit_kerja_id', $unitKerjaIds)
                    // ->orWhere('unit_kerja_id', session('selected_filter'))
                    ->orderBy('created_at', 'desc')
                    ->first();
            }

            $daftar_periode = SisipanPeriode::with('periode')
                ->whereIn('unit_kerja_id', $unitKerjaIds)
                ->orderBy('created_at', 'desc')->take(10)->get();

            $query = SisipanAjuan::with('sisipanajuandetail')
                ->whereIn('programstudi', $unitKerjaNames)
                ->where('sisipan_periode_id', $periodeTerpilih->id);

            //filter terkait dengan program studi 
            if ($request->has('programstudi')) {

                if ($request->get('programstudi') != 'all') {
                    $programstudis = UnitKerja::where('id', $request->get('programstudi'))->first();

                    if (!$programstudis) {
                        return redirect()->back()->with('message', 'Program Studi tidak ditemukan');
                    }

                    $query->where('programstudi', $programstudis->nama_unit);
                    $programstuditerpilih = $programstudis;
                }
            }

            if ($request->has('search')) {
                if ($request->get('search') != null && $request->get('search') != '') {
                    $query->where('nim', 'ilike', '%' . $request->get('search') . '%')
                        ->orWhere('va', 'ilike', '%' . $request->get('search') . '%');
                }
            }

            if ($request->has('status_pembayaran')) {
                if ($request->get('status_pembayaran') != 'all') {
                    $query->where('status_pembayaran', $request->get('status_pembayaran'));
                }
            }

            $data_ajuan = $query->paginate($request->get('perPage', 10));

            // return response()->json($data_ajuan);

            $total = $data_ajuan->total();

            return view(
                'sisipan.ajuan.daftar-ajuan',
                [
                    'periodeTerpilih' => $periodeTerpilih,
                    'programstuditerpilih' => $programstuditerpilih ?? null,
                    'daftar_periode' => $daftar_periode,
                    // 'programstudi' => $programstudi,
                    'unitkerja' => $unitKerja,
                    'data' => $data_ajuan,
                    'total' => $total,
                ]
            );
        } catch (\Exception $e) {
            return back()->with('message', "Terjadi kesalahan" . $e->getMessage());
        }
    }
}
