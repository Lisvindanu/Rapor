<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\UnitKerja;
use App\Helpers\UnitKerjaHelper;
use App\Models\RemedialAjuan;
use App\Models\RemedialPeriode;


class RemedialController extends Controller
{
    public function index()
    {
        // echo session('selected_filter');
        if (session('selected_role') == 'Mahasiswa') {
            return redirect()->route('remedial.mahasiswa');
        } elseif (session('selected_role') == 'Admin' || session('selected_role') == 'Admin Fakultas' || session('selected_role') == 'Admin Prodi') {
            // return view('remedial.dashboard');
            // akses fungsi dashboard yang pada controller ini
            return $this->dashboard(new Request());
        } else {
            return redirect()->route('login');
        }
        // return view('remedial.mahasiswa.dashboard');
    }

    public function dashboard(Request $request)
    {
        try {

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

            // return response()->json($periodeTerpilih);

            $daftar_periode = RemedialPeriode::with('periode')
                ->whereIn('unit_kerja_id', $unitKerjaIds)
                ->orderBy('created_at', 'desc')->take(10)->get();

            $daftar_ajuan = RemedialAjuan::with('remedialajuandetail')
                ->where('remedial_periode_id', $periodeTerpilih->id)
                ->get()
                ->groupBy('programstudi')
                ->map(function ($items, $key) {
                    $totalBayar = $items->sum('total_bayar');
                    $totalAjuan = $items->count();
                    $jumlahAjuanDetail = $items->reduce(function ($carry, $item) {
                        return $carry + $item->remedialajuandetail->count();
                    }, 0);
                    return [
                        'data' => $items,
                        'total_bayar' => $totalBayar,
                        'total_ajuan' => $totalAjuan,
                        'jumlah_ajuan_detail' => $jumlahAjuanDetail
                    ];
                });


            // $daftar_ajuan = RemedialAjuan::with('remedialajuandetail')->where('remedial_periode_id', $periodeTerpilih->id)->get();

            // $daftar_ajuan_grouped = $daftar_ajuan->groupBy('programstudi')->map(function ($group) {
            //     $total_bayar = $group->sum('total_bayar');
            //     $total_ajuan = $group->count();
            //     return [
            //         'data' => $group,
            //         'total_bayar' => $total_bayar,
            //         'total_ajuan' => $total_ajuan,
            //     ];
            // });

            // return response()->json($daftar_ajuan);

            return view(
                'remedial.dashboard',
                [
                    'unitKerja' => $unitKerja,
                    'periodeTerpilih' => $periodeTerpilih,
                    'daftar_periode' => $daftar_periode,
                    'daftar_ajuan' => $daftar_ajuan,
                ]
            );
        } catch (\Throwable $th) {
            //throw $th;
        }
    }
}
