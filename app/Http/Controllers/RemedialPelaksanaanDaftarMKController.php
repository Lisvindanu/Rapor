<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\UnitKerja;
use App\Helpers\UnitKerjaHelper;
use App\Models\RemedialPeriode;
use App\Models\RemedialAjuan;
use App\Models\ProgramStudi;
use App\Models\RemedialAjuanDetail;
use App\Models\RemedialKelas;
use Illuminate\Support\Facades\DB;


class RemedialPelaksanaanDaftarMKController extends Controller
{
    public function daftarMatakuliah(Request $request)
    {
        try {
            // untuk dropdown unit kerja
            $unitKerja = UnitKerja::with('childUnit')->where('id', session('selected_filter'))->first();

            if ($request->has('periodeTerpilih')) {
                $periodeTerpilih = RemedialPeriode::with('remedialperiodetarif')
                    ->where('id', $request->periodeTerpilih)
                    ->first();
            } else {
                $periodeTerpilih = RemedialPeriode::with('remedialperiodetarif')
                    ->where('is_aktif', 1)
                    ->orderBy('created_at', 'desc')
                    ->first();
            }

            $daftar_periode = RemedialPeriode::with('periode')
                ->where('unit_kerja_id', $unitKerja->id)
                ->orWhere('unit_kerja_id', $unitKerja->parent_unit)
                ->orderBy('created_at', 'desc')->take(10)->get();

            $query = RemedialAjuanDetail::with('kelasKuliah')
                // ->whereHas('kelasKuliah', function ($query) use ($unitKerjaNames) {
                //     $query->whereIn('programstudi', $unitKerjaNames);
                // })
                ->where('kode_periode', $periodeTerpilih->kode_periode)
                ->where('status_ajuan', 'Konfirmasi Kelas');


            //filter terkait dengan program studi 
            if ($request->has('programstudi')) {

                if ($request->get('programstudi') != 'all') {
                    $programstudis = UnitKerja::where('id', $request->get('programstudi'))->first();

                    if (!$programstudis) {
                        return redirect()->back()->with('message', 'Program Studi tidak ditemukan');
                    }

                    $query->whereHas('kelasKuliah', function ($query) use ($programstudis) {
                        $query->where('programstudi', $programstudis->nama_unit);
                    });

                    $programstuditerpilih = $programstudis;
                }
            }

            if ($request->has('search')) {
                if ($request->get('search') != null && $request->get('search') != '') {
                    $query->whereHas('kelasKuliah', function ($query) use ($request) {
                        $query->where('namamk', 'ilike', '%' . $request->get('search') . '%')
                            ->orWhere('kodemk', 'ilike', '%' . $request->get('search') . '%');
                    });
                }
            }

            $ajuandetail = $query->select('kode_periode', 'idmk', DB::raw('COUNT(idmk) as total_peserta'))
                ->groupBy('kode_periode', 'idmk')
                ->paginate($request->get('perPage', 10));


            // return response()->json($ajuandetail);
            $total = $ajuandetail->total();

            return view(
                'remedial.pelaksanaan.daftar-mk.index',
                [
                    'periodeTerpilih' => $periodeTerpilih,
                    'programstuditerpilih' => $programstuditerpilih ?? null,
                    'daftar_periode' => $daftar_periode,
                    'unitkerja' => $unitKerja,
                    'data' => $ajuandetail,
                    'total' => $total,
                ]
            );
        } catch (\Exception $e) {
            return back()->with('message', "Terjadi kesalahan" . $e->getMessage());
        }
    }

    // detail
    public function pesertaMatakuliah(Request $request)
    {
        try {

            $matakuliah = RemedialAjuanDetail::with('kelasKuliah', 'remedialajuan')
                ->where('kode_periode', $request->kode_periode)
                ->where('idmk', $request->idmk)
                ->where('status_ajuan', 'Konfirmasi Kelas')
                ->first();

            // return response()->json($request->all());
            $ajuandetail = RemedialAjuanDetail::with(['kelasKuliah', 'remedialajuan', 'krs'])
                ->where('kode_periode', $request->kode_periode)
                ->where('idmk', $request->idmk)
                ->where('status_ajuan', 'Konfirmasi Kelas')
                ->paginate($request->get('perPage', 10));

            // return response()->json($matakuliah);

            return view(
                'remedial.pelaksanaan.daftar-mk.detail.peserta',
                [
                    'matakuliah' => $matakuliah,
                    'data' => $ajuandetail,
                ]
            );
        } catch (\Exception $e) {
            return back()->with('message', "Terjadi kesalahan" . $e->getMessage());
        }
    }

    //kelasMatakuliah
    public function kelasMatakuliah(Request $request)
    {
        try {
            $matakuliah = RemedialAjuanDetail::with('kelasKuliah', 'remedialajuan')
                ->where('kode_periode', $request->kode_periode)
                ->where('idmk', $request->idmk)
                ->where('status_ajuan', 'Konfirmasi Kelas')
                ->first();

            // return response()->json($request->all());
            $kelas = RemedialKelas::with(['matakuliah', 'remedialperiode', 'peserta'])
                ->where('remedial_periode_id', $request->remedial_periode_id)
                ->where('kodemk', $request->idmk)
                ->get();

            return view(
                'remedial.pelaksanaan.daftar-mk.detail.kelas',
                [
                    'matakuliah' => $matakuliah,
                    'data' => $kelas,
                ]
            );
        } catch (\Exception $e) {
            return back()->with('message', "Terjadi kesalahan" . $e->getMessage());
        }
    }
}
