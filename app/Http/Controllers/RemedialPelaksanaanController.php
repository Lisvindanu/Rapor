<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\UnitKerja;
use App\Helpers\UnitKerjaHelper;
use App\Models\RemedialPeriode;
use App\Models\RemedialAjuan;
use App\Models\ProgramStudi;

class RemedialPelaksanaanController extends Controller
{
    // index
    public function daftarMatakuliah(Request $request)
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
                'remedial.pelaksanaan.daftar-mk',
                [
                    'periodeTerpilih' => $periodeTerpilih,
                    'programstuditerpilih' => $programstuditerpilih ?? null,
                    'daftar_periode' => $daftar_periode,
                    'programstudi' => $unitKerja,
                    'data' => $data_ajuan,
                    'total' => $total,
                ]
            );
        } catch (\Exception $e) {
            return back()->with('message', "Terjadi kesalahan" . $e->getMessage());
        }
    }
}
