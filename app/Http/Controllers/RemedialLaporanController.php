<?php

namespace App\Http\Controllers;

use App\Exports\RemedialAjuanExport;
use App\Exports\RemedialPembayaranExport;
use App\Models\RemedialPeriode;
use App\Models\UnitKerja;
use App\Helpers\UnitKerjaHelper;
use App\Models\RemedialAjuan;
use App\Models\RemedialAjuanDetail;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use Exception;

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
    // function printLaporan(Request $request)
    // {
    //     $unitKerjaNames = UnitKerjaHelper::getUnitKerjaNamesV1($request->programstudi);

    //     $remedialAjuanDetail = RemedialAjuanDetail::with(['krs', 'remedialajuan', 'remedialajuan.remedialperiode', 'remedialajuan.mahasiswa', 'remedialajuan.userverifikasi'])
    //         ->whereHas('remedialajuan', function ($query) use ($request, $unitKerjaNames) {
    //             $query->where('remedial_periode_id', $request->remedial_periode_id)
    //                 ->whereIn('programstudi', $unitKerjaNames);
    //         });


    //     // return response()->json($remedialAjuanDetail);

    //     if ($request->nama_laporan == 'ajuan') {
    //         $remedialAjuanDetail = $remedialAjuanDetail->orderBy('idmk', 'asc')
    //             ->orderBy('namakelas', 'asc')
    //             ->get();
    //         return Excel::download(new RemedialAjuanExport($remedialAjuanDetail), 'remedial-ajuan.xlsx');
    //     }

    //     if ($request->nama_laporan == 'pembayaran') {
    //         $remedialAjuanDetail->where('remedialajuan.status_pembayaran', 'Lunas')
    //             ->get();
    //         return Excel::download(new RemedialPembayaranExport($remedialAjuanDetail), 'remedial-pembayaran.xlsx');
    //     }

    //     // return Excel::download(new RemedialAjuanExport($remedialAjuanDetail), 'remedial-ajuan.xlsx');
    // }

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


    function printLaporanPembayaran(Request $request)
    {
        $unitKerjaNames = UnitKerjaHelper::getUnitKerjaNamesV1($request->programstudi);

        $remedialPembayaran = RemedialAjuan::with(['remedialperiode', 'remedialajuandetail'])
            ->where('remedial_periode_id', $request->remedial_periode_id)
            ->whereIn('programstudi', $unitKerjaNames)
            ->orderBy('nim', 'asc')
            ->get();

        // return response()->json($remedialPembayaran);


        return Excel::download(new RemedialPembayaranExport($remedialPembayaran), 'remedial-pembayaran.xlsx');
    }
}
