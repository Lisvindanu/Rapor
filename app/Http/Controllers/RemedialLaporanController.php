<?php

namespace App\Http\Controllers;

use App\Exports\RemedialAjuanExport;
use App\Models\RemedialPeriode;
use App\Models\UnitKerja;
use App\Helpers\UnitKerjaHelper;
use App\Models\RemedialAjuan;
use App\Models\RemedialAjuanDetail;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class RemedialLaporanController extends Controller
{
    // index
    function index()
    {
        $unitKerja = UnitKerja::with('childUnit')->where('id', session('selected_filter'))->first();

        $daftar_periode = RemedialPeriode::with('periode')
            ->where('unit_kerja_id', $unitKerja->id)
            ->orWhere('unit_kerja_id', $unitKerja->parent_unit)
            ->orderBy('created_at', 'desc')->take(10)->get();

        return view('remedial.laporan.index', [
            'daftar_periode' => $daftar_periode,
            'unitkerja' => $unitKerja,
        ]);
    }

    // print-laporan
    function printLaporan(Request $request)
    {
        $unitKerjaNames = UnitKerjaHelper::getUnitKerjaNamesV1($request->programstudi);

        $remedialAjuanDetail = RemedialAjuanDetail::with(['krs', 'remedialajuan', 'remedialajuan.remedialperiode', 'remedialajuan.mahasiswa'])
            ->whereHas('remedialajuan', function ($query) use ($request, $unitKerjaNames) {
                $query->where('remedial_periode_id', $request->remedial_periode_id)
                    ->whereIn('programstudi', $unitKerjaNames);
            })
            ->orderBy('idmk', 'asc')
            ->orderBy('namakelas', 'asc')
            ->get();

        return response()->json($remedialAjuanDetail);

        return Excel::download(new RemedialAjuanExport($remedialAjuanDetail), 'remedial-ajuan.xlsx');
    }

    function printLaporanAjuan(Request $request)
    {
        $unitKerjaNames = UnitKerjaHelper::getUnitKerjaNamesV1($request->programstudi);

        $remedialAjuanDetail = RemedialAjuanDetail::with(['krs', 'remedialajuan', 'remedialajuan.remedialperiode', 'remedialajuan.mahasiswa'])
            ->whereHas('remedialajuan', function ($query) use ($request, $unitKerjaNames) {
                $query->where('remedial_periode_id', $request->remedial_periode_id)
                    ->whereIn('programstudi', $unitKerjaNames);
            })
            ->orderBy('idmk', 'asc')
            ->orderBy('namakelas', 'asc')
            ->get();

        return Excel::download(new RemedialAjuanExport($remedialAjuanDetail), 'remedial-ajuan.xlsx');
    }
}
