<?php

namespace App\Http\Controllers;

use App\Exports\SisipanAjuanExport;
use App\Models\SisipanPeriode;
use App\Models\UnitKerja;
use App\Helpers\UnitKerjaHelper;
use App\Models\SisipanAjuan;
use App\Models\SisipanAjuanDetail;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class SisipanLaporanController extends Controller
{
    // index
    function index()
    {
        $unitKerja = UnitKerja::with('childUnit')->where('id', session('selected_filter'))->first();

        $daftar_periode = SisipanPeriode::with('periode')
            ->where('unit_kerja_id', $unitKerja->id)
            ->orWhere('unit_kerja_id', $unitKerja->parent_unit)
            ->orderBy('created_at', 'desc')->take(10)->get();

        return view('sisipan.laporan.index', [
            'daftar_periode' => $daftar_periode,
            'unitkerja' => $unitKerja,
        ]);
    }

    // print-laporan
    function printLaporan(Request $request)
    {
        $unitKerjaNames = UnitKerjaHelper::getUnitKerjaNamesV1($request->programstudi);

        $sisipanAjuanDetail = SisipanAjuanDetail::with(['krs', 'sisipanajuan', 'sisipanajuan.sisipanperiode', 'sisipanajuan.mahasiswa'])
            ->whereHas('sisipanajuan', function ($query) use ($request, $unitKerjaNames) {
                $query->where('sisipan_periode_id', $request->sisipan_periode_id)
                    ->whereIn('programstudi', $unitKerjaNames);
            })
            ->orderBy('idmk', 'asc')
            ->orderBy('namakelas', 'asc')
            ->get();

        return Excel::download(new SisipanAjuanExport($sisipanAjuanDetail), 'sisipan-ajuan.xlsx');
    }
}
