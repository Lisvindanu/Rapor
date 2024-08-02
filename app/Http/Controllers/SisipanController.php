<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\UnitKerja;
use App\Helpers\UnitKerjaHelper;
use App\Models\SisipanPeriode;
use App\Models\SisipanAjuan;



class SisipanController extends Controller
{
    public function index()
    {
        // echo session('selected_filter');
        if (session('selected_role') == 'Mahasiswa') {
            return redirect()->route('sisipan.mahasiswa');
        } elseif (session('selected_role') == 'Admin' || session('selected_role') == 'Admin Fakultas') {
            return $this->dashboardFakultas(new Request());
        } elseif (session('selected_role') == 'Admin Prodi') {
            return $this->dashboardProdi(new Request());
        } else {
            return redirect()->route('login');
        }
    }

    public function dashboardFakultas(Request $request)
    {
        try {
            $unitKerja = UnitKerja::with('childUnit')->where('id', session('selected_filter'))->get();
            $unitKerjaIds = UnitKerjaHelper::getUnitKerjaIds();

            // return response()->json($unitKerjaIds);

            if ($request->has('periodeTerpilih')) {
                $periodeTerpilih = SisipanPeriode::with('sisipanperiodetarif')
                    ->where('id', $request->periodeTerpilih)
                    ->first();
            } else {
                $periodeTerpilih = SisipanPeriode::with('sisipanperiodetarif')
                    ->where('is_aktif', 1)
                    ->whereIn('unit_kerja_id', $unitKerjaIds)
                    ->orderBy('created_at', 'desc')
                    ->first();
            }

            // return response()->json($periodeTerpilih);

            $daftar_periode = SisipanPeriode::with('periode')
                ->whereIn('unit_kerja_id', $unitKerjaIds)
                ->orderBy('created_at', 'desc')->take(10)->get();

            $daftar_ajuan = SisipanAjuan::with('sisipanajuandetail')
                ->where('sisipan_periode_id',  $periodeTerpilih->id)
                ->get()
                ->groupBy('programstudi')
                ->map(function ($items, $key) {
                    $totalBayar = $items->sum('total_bayar');
                    $totalAjuan = $items->count();
                    $jumlahAjuanDetail = $items->reduce(function ($carry, $item) {
                        return $carry + $item->sisipanajuandetail->count();
                    }, 0);
                    $totalMenungguPembayaran = $items->where('status_pembayaran', 'Menunggu Pembayaran')->count();
                    $totalMenungguKonfirmasi = $items->where('status_pembayaran', 'Menunggu Konfirmasi')->count();
                    $totalLunas = $items->where('status_pembayaran', 'Lunas')->count();
                    $totalDitolak = $items->where('status_pembayaran', 'Ditolak')->count();
                    return [
                        'data' => $items,
                        'total_tagihan' => $totalBayar,
                        'total_bayar' => $items->sum('jumlah_bayar'),
                        'total_ajuan' => $totalAjuan,
                        'jumlah_ajuan_detail' => $jumlahAjuanDetail,
                        'total_menunggu_pembayaran' => $totalMenungguPembayaran,
                        'total_menunggu_konfirmasi' => $totalMenungguKonfirmasi,
                        'total_lunas' => $totalLunas,
                        'total_ditolak' => $totalDitolak
                    ];
                });

            // return response()->json($daftar_ajuan);

            return view(
                'sisipan.dashboard',
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

    public function dashboardProdi(Request $request)
    {
        try {
            $unitKerja = UnitKerja::with('childUnit')->where('id', session('selected_filter'))->get();
            $unitKerjaParentId = UnitKerjaHelper::getUnitKerjaParentId();

            if ($request->has('periodeTerpilih')) {
                $periodeTerpilih = SisipanPeriode::with('sisipanperiodetarif')
                    ->where('id', $request->periodeTerpilih)
                    ->first();
            } else {
                $periodeTerpilih = SisipanPeriode::with('sisipanperiodetarif')
                    ->where('is_aktif', 1)
                    ->where('unit_kerja_id', $unitKerjaParentId)
                    ->orderBy('created_at', 'desc')
                    ->first();
            }

            $daftar_periode = SisipanPeriode::with('periode')
                ->where('unit_kerja_id', $unitKerjaParentId)
                ->orderBy('created_at', 'desc')->take(10)->get();

            $daftar_ajuan = SisipanAjuan::with('sisipanajuandetail')
                ->where('sisipan_periode_id', $periodeTerpilih->id)
                ->where('programstudi', $unitKerja->first()->nama_unit)
                ->get()
                ->groupBy('programstudi')
                ->map(function ($items, $key) {
                    $totalBayar = $items->sum('total_bayar');
                    $totalAjuan = $items->count();
                    $jumlahAjuanDetail = $items->reduce(function ($carry, $item) {
                        return $carry + $item->sisipanajuandetail->count();
                    }, 0);
                    $totalMenungguPembayaran = $items->where('status_pembayaran', 'Menunggu Pembayaran')->count();
                    $totalMenungguKonfirmasi = $items->where('status_pembayaran', 'Menunggu Konfirmasi')->count();
                    $totalLunas = $items->where('status_pembayaran', 'Lunas')->count();
                    $totalDitolak = $items->where('status_pembayaran', 'Ditolak')->count();
                    return [
                        'data' => $items,
                        'total_tagihan' => $totalBayar,
                        'total_bayar' => $items->sum('jumlah_bayar'),
                        'total_ajuan' => $totalAjuan,
                        'jumlah_ajuan_detail' => $jumlahAjuanDetail,
                        'total_menunggu_pembayaran' => $totalMenungguPembayaran,
                        'total_menunggu_konfirmasi' => $totalMenungguKonfirmasi,
                        'total_lunas' => $totalLunas,
                        'total_ditolak' => $totalDitolak
                    ];
                });

            return view(
                'sisipan.dashboard',
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
