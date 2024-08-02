<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\SisipanPeriode;
use App\Models\Krs;
use App\Models\SisipanAjuan;
use App\Helpers\UnitKerjaHelper;

class SisipanMahasiswaController extends Controller
{
    // index
    public function index(Request $request)
    {
        $user = auth()->user()->mahasiswa;

        $unitKerjaIds = UnitKerjaHelper::getUnitKerjaIds();

        // return response()->json($user);
        if ($request->has('periodeTerpilih')) {
            $periodeTerpilih = SisipanPeriode::with(
                [
                    'sisipanperiodetarif' => function ($query) use ($user) {
                        $query->where('periode_angkatan', $user->periodemasuk);
                    },
                    'sisipanperiodeprodi' => function ($query) use ($user) {
                        $query->where('unit_kerja_id', session('selected_filter'));
                    }
                ]
            )
                ->whereHas('sisipanperiodetarif', function ($query) use ($user) {
                    $query->where('periode_angkatan', $user->periodemasuk);
                })
                ->whereHas('sisipanperiodeprodi', function ($query) use ($user) {
                    $query->where('unit_kerja_id', session('selected_filter'));
                })
                ->where('kode_periode', $request->periodeTerpilih)
                ->first();
        } else {
            $periodeTerpilih = SisipanPeriode::with([
                'sisipanperiodetarif' => function ($query) use ($user) {
                    $query->where('periode_angkatan', $user->periodemasuk);
                },
                'sisipanperiodeprodi' => function ($query) use ($user) {
                    $query->where('unit_kerja_id', session('selected_filter'));
                }
            ])
                ->whereHas('sisipanperiodetarif', function ($query) use ($user) {
                    $query->where('periode_angkatan', $user->periodemasuk);
                })
                ->whereHas('sisipanperiodeprodi', function ($query) use ($user) {
                    $query->where('unit_kerja_id', session('selected_filter'));
                })
                ->orderBy('created_at', 'desc')
                ->first();
        }

        $daftar_periode = SisipanPeriode::with(['sisipanperiodetarif', 'sisipanperiodeprodi'])
            ->whereHas('sisipanperiodetarif', function ($query) use ($user) {
                $query->where('periode_angkatan', $user->periodemasuk);
            })
            ->whereHas('sisipanperiodeprodi', function ($query) use ($user) {
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
                return floatval($item->nnumerik) < $periodeTerpilih->sisipanperiodeprodi->first()->nilai_batas
                    && floatval($item->presensi) >= floatval($periodeTerpilih->sisipanperiodeprodi->first()->presensi_batas);
            });

        // return response()->json($data_krs);
        // 
        $data_ajuan = SisipanAjuan::with('sisipanajuandetail')->where('nim', auth()->user()->username)
            ->where('sisipan_periode_id', $periodeTerpilih->id)
            ->get();

        return view('sisipan.mahasiswa.dashboard', [
            'daftar_periode' => $daftar_periode,
            'periodeTerpilih' => $periodeTerpilih,
            'data_krs' => $data_krs,
            'data_ajuan' => $data_ajuan,
        ]);
    }
}
