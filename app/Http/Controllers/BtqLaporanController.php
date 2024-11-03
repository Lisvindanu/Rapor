<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\UnitKerja;
use App\Models\RemedialPeriode;
use App\Exports\RemedialAjuanExport;
use App\Exports\RemedialPembayaranExport;
use App\Models\RemedialAjuanDetail;
use App\Helpers\UnitKerjaHelper;
use Maatwebsite\Excel\Facades\Excel;
use Exception;

class BtqLaporanController extends Controller
{
    // index
    function index()
    {
        $unitKerja = UnitKerja::with('childUnit')->where('id', session('selected_filter'))->first();

        $daftar_periode = RemedialPeriode::with('periode')
            ->where('unit_kerja_id', $unitKerja->id)
            ->orWhere('unit_kerja_id', $unitKerja->parent_unit)
            ->orderBy('created_at', 'desc')->take(10)->get();

        return view('btq.laporan.index', [
            'daftar_periode' => $daftar_periode,
            'unitkerja' => $unitKerja,
        ]);
    }

    function printLaporan(Request $request)
    {
        try {
            $unitKerjaNames = UnitKerjaHelper::getUnitKerjaNamesV1($request->programstudi);

            $remedialAjuanDetail = RemedialAjuanDetail::with(['krs', 'remedialajuan', 'remedialajuan.remedialperiode', 'remedialajuan.mahasiswa', 'remedialajuan.userverifikasi'])
                ->whereHas('remedialajuan', function ($query) use ($request, $unitKerjaNames) {
                    $query->where('remedial_periode_id', $request->remedial_periode_id)
                        ->whereIn('programstudi', $unitKerjaNames);
                });

            // Menangani laporan ajuan
            if ($request->nama_laporan == 'ajuan') {
                $remedialAjuanDetail = $remedialAjuanDetail->orderBy('idmk', 'asc')
                    ->orderBy('namakelas', 'asc')
                    ->get(); // Memastikan pemanggilan get() sebelum diekspor
                return Excel::download(new RemedialAjuanExport($remedialAjuanDetail), 'remedial-ajuan.xlsx');
            }

            // Menangani laporan pembayaran
            if ($request->nama_laporan == 'pembayaran') {
                return $this->printLaporanPembayaran($request);
                // $remedialAjuanDetail = $remedialAjuanDetail->where('remedialajuan.status_pembayaran', 'Lunas')
                // return Excel::download(new RemedialPembayaranExport($remedialAjuanDetail), 'remedial-pembayaran.xlsx');

            }
        } catch (Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
}
