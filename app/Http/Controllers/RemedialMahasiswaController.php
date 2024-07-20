<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\RemedialPeriode;
use App\Models\Krs;
use App\Models\RemedialAjuan;
use App\Helpers\UnitKerjaHelper;

class RemedialMahasiswaController extends Controller
{
    // index
    public function index(Request $request)
    {
        $user = auth()->user()->mahasiswa;

        $unitKerjaIds = UnitKerjaHelper::getUnitKerjaIds();

        // return response()->json($user);
        if ($request->has('periodeTerpilih')) {
            $periodeTerpilih = RemedialPeriode::with(
                [
                    'remedialperiodetarif' => function ($query) use ($user) {
                        $query->where('periode_angkatan', $user->periodemasuk);
                    },
                    'remedialperiodeprodi' => function ($query) use ($user) {
                        $query->where('unit_kerja_id', session('selected_filter'));
                    }
                ]
            )
                ->whereHas('remedialperiodetarif', function ($query) use ($user) {
                    $query->where('periode_angkatan', $user->periodemasuk);
                })
                ->whereHas('remedialperiodeprodi', function ($query) use ($user) {
                    $query->where('unit_kerja_id', session('selected_filter'));
                })
                ->where('kode_periode', $request->periodeTerpilih)
                ->first();
        } else {
            $periodeTerpilih = RemedialPeriode::with([
                'remedialperiodetarif' => function ($query) use ($user) {
                    $query->where('periode_angkatan', $user->periodemasuk);
                },
                'remedialperiodeprodi' => function ($query) use ($user) {
                    $query->where('unit_kerja_id', session('selected_filter'));
                }
            ])
                ->whereHas('remedialperiodetarif', function ($query) use ($user) {
                    $query->where('periode_angkatan', $user->periodemasuk);
                })
                ->whereHas('remedialperiodeprodi', function ($query) use ($user) {
                    $query->where('unit_kerja_id', session('selected_filter'));
                })
                ->orderBy('created_at', 'desc')
                ->first();
        }

        $daftar_periode = RemedialPeriode::with(['remedialperiodetarif', 'remedialperiodeprodi'])
            ->whereHas('remedialperiodetarif', function ($query) use ($user) {
                $query->where('periode_angkatan', $user->periodemasuk);
            })
            ->whereHas('remedialperiodeprodi', function ($query) use ($user) {
                $query->where('unit_kerja_id', session('selected_filter'));
            })
            // ->whereIn('unit_kerja_id', $unitKerjaIds)
            ->orderBy('created_at', 'desc')
            ->get();

        // return response()->json($daftar_periode);

        $data_krs = Krs::where('idperiode', $periodeTerpilih->kode_periode)
            ->where('nim', $user->nim)
            ->get()
            ->filter(function ($item) use ($periodeTerpilih) {
                return floatval($item->nnumerik) < $periodeTerpilih->remedialperiodeprodi->first()->nilai_batas
                    && floatval($item->presensi) >= floatval($periodeTerpilih->remedialperiodeprodi->first()->presensi_batas);
            });

        // return response()->json($periodeTerpilih);

        $data_ajuan = RemedialAjuan::with('remedialajuandetail')->where('nim', auth()->user()->username)
            ->where('remedial_periode_id', $periodeTerpilih->id)
            ->get();

        return view('remedial.mahasiswa.dashboard', [
            'daftar_periode' => $daftar_periode,
            'periodeTerpilih' => $periodeTerpilih,
            'data_krs' => $data_krs,
            'data_ajuan' => $data_ajuan,
        ]);
    }
}
