<?php

namespace App\Http\Controllers;

use App\Models\RemedialAjuan;
use App\Models\RemedialAjuanDetail;
use App\Models\RemedialKelas;
use Illuminate\Http\Request;
use App\Models\RemedialKelasPeserta;
use App\Models\RemedialPeriode;
use App\Models\UnitKerja;
use App\Helpers\UnitKerjaHelper;
use Illuminate\Support\Facades\DB;

class RemedialPelaksanaanKelasController extends Controller
{
    public function daftarKelas(Request $request)
    {
        try {
            // untuk dropdown unit kerja
            $unitKerja = UnitKerja::with('childUnit')->where('id', session('selected_filter'))->first();
            $unitKerjaNames = UnitKerjaHelper::getUnitKerjaNames();

            if ($request->has('periodeTerpilih')) {
                $periodeTerpilih = RemedialPeriode::with('remedialperiodetarif')
                    ->where('id', $request->periodeTerpilih)
                    ->first();
            } else {
                $periodeTerpilih = RemedialPeriode::with('remedialperiodetarif')
                    ->where('is_aktif', 1)
                    ->where('unit_kerja_id', $unitKerja->id)
                    ->orWhere('unit_kerja_id', $unitKerja->parent_unit)
                    ->orderBy('created_at', 'desc')
                    ->first();
            }

            $daftar_periode = RemedialPeriode::with('periode')
                ->where('unit_kerja_id', $unitKerja->id)
                ->orWhere('unit_kerja_id', $unitKerja->parent_unit)
                ->orderBy('created_at', 'desc')->take(10)->get();

            $query = RemedialKelas::with(['remedialperiode', 'kelaskuliah', 'dosen'])
                ->where('remedial_periode_id', $periodeTerpilih->id);

            if ($request->filled('programstudi')) {

                $programstudis = UnitKerja::where('id', $request->get('programstudi'))->first();

                if (!$programstudis) {
                    return redirect()->back()->with('message', 'Program Studi tidak ditemukan');
                }

                $query->whereHas('matakuliah', function ($query) use ($programstudis, $unitKerjaNames) {
                    if ($programstudis->jenis_unit == 'Program Studi') {
                        $query->where('programstudi', $programstudis->nama_unit);
                    } else {
                        $query->whereIn('programstudi', $unitKerjaNames);
                    }
                });

                $programstuditerpilih = $programstudis;
            }

            if ($request->filled('search')) {
                $query->whereHas('matakuliah', function ($query) use ($request) {
                    $query->where('namamk', 'ilike', '%' . $request->get('search') . '%')
                        ->orWhere('kodemk', 'ilike', '%' . $request->get('search') . '%');
                });
            }

            $daftarkelas = $query->paginate($request->get('perPage', 10));

            // return response()->json($daftarkelas);

            $total = $daftarkelas->total();

            return view(
                'remedial.pelaksanaan.kelas.index',
                [
                    'periodeTerpilih' => $periodeTerpilih,
                    'programstuditerpilih' => $programstuditerpilih ?? null,
                    'daftar_periode' => $daftar_periode,
                    'unitkerja' => $unitKerja,
                    'data' => $daftarkelas,
                    'total' => $total,
                ]
            );
        } catch (\Exception $e) {
            return back()->with('message', "Terjadi kesalahan" . $e->getMessage());
        }
    }


    public function tambahPerMKAjax(Request $request)
    {
        $request->validate([
            'remedial_periode_id' => 'required',
            'kode_periode' => 'required',
            'kodemk' => 'required',
        ]);

        try {
            $mk = RemedialAjuanDetail::with('RemedialAjuan')
                ->whereHas('RemedialAjuan', function ($query) use ($request) {
                    $query->where('remedial_periode_id', $request->remedial_periode_id);
                })
                ->where('idmk', $request->kodemk)
                ->where('kode_periode', $request->kode_periode)
                ->where(function ($query) {
                    $query->where('status_ajuan', 'Konfirmasi Kelas')
                        ->orWhere('status_ajuan', 'Diterima')
                        ->orWhere('status_ajuan', 'Dibatalkan');
                })
                ->get();

            $grouped = $mk->groupBy(function ($item) {
                return $item->kode_periode . '-' . $item->idmk;
            });

            $data = $grouped->map(function ($items, $key) {
                $firstItem = $items->first();
                return [
                    'kode_periode' => $firstItem->kode_periode,
                    'idmk' => $firstItem->idmk,
                    'nip' => $firstItem->nip,
                    'detail' => $items->map(function ($item) {
                        return [
                            'id' => $item->id,
                            'remedial_ajuan_id' => $item->remedial_ajuan_id,
                            'programstudi' => $item->RemedialAjuan->programstudi,
                            'krs_id' => $item->krs_id,
                            'nim' => $item->RemedialAjuan->nim, // Assuming you have a 'nim' field in RemedialAjuan model
                            'namakelas' => $item->namakelas,
                            'harga_remedial' => $item->harga_remedial,
                            'created_at' => $item->created_at,
                            'updated_at' => $item->updated_at,
                            'status_ajuan' => $item->status_ajuan,
                        ];
                    })->toArray()
                ];
            })->values();

            // $daftarKelas = [];
            foreach ($data as $item) {
                $kelas = RemedialKelas::create([
                    'remedial_periode_id' => $request->remedial_periode_id,
                    'programstudi' => $item['detail'][0]['programstudi'],
                    'kodemk' => $item['idmk'],
                    'nip' => $item['nip'],
                    'kode_edlink' => '',
                ]);

                foreach ($item['detail'] as $detail) {
                    RemedialKelasPeserta::create([
                        'remedial_kelas_id' => $kelas->id,
                        'nim' => $detail['nim'],
                        'nnumerik' => 0,
                        'nhuruf' => '',
                    ]);
                }

                // $daftarKelas[] = $kelas;
            }

            // update status ajuan mk diterima
            $mk->each(function ($item) {
                $item->update([
                    'status_ajuan' => 'Diterima',
                ]);
            });


            return response()->json([
                'status' => 'success',
                'message' => 'Data berhasil disimpan',
                'data' => $data,
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Data gagal disimpan',
                'data' => $e->getMessage(),
            ]);
        }
    }

    // tambahPerDosenAjax
    public function tambahPerDosenAjax(Request $request)
    {
        $request->validate([
            'remedial_periode_id' => 'required',
            'kode_periode' => 'required',
            'kodemk' => 'required',
        ]);

        try {

            $mk = RemedialAjuanDetail::with('RemedialAjuan')
                ->whereHas('RemedialAjuan', function ($query) use ($request) {
                    $query->where('remedial_periode_id', $request->remedial_periode_id);
                })
                ->where('idmk', $request->kodemk)
                ->where('kode_periode', $request->kode_periode)
                ->where(function ($query) {
                    $query->where('status_ajuan', 'Konfirmasi Kelas')
                        ->orWhere('status_ajuan', 'Diterima')
                        ->orWhere('status_ajuan', 'Dibatalkan');
                })
                ->get();

            $grouped = $mk->groupBy(function ($item) {
                return $item->kode_periode . '-' . $item->idmk . '-' . $item->nip;
            });

            $data = $grouped->map(function ($items, $key) {
                $firstItem = $items->first();
                return [
                    'kode_periode' => $firstItem->kode_periode,
                    'idmk' => $firstItem->idmk,
                    'nip' => $firstItem->nip,
                    'detail' => $items->map(function ($item) {
                        return [
                            'id' => $item->id,
                            'remedial_ajuan_id' => $item->remedial_ajuan_id,
                            'programstudi' => $item->RemedialAjuan->programstudi,
                            'krs_id' => $item->krs_id,
                            'nim' => $item->RemedialAjuan->nim, // Assuming you have a 'nim' field in RemedialAjuan model
                            'namakelas' => $item->namakelas,
                            'harga_remedial' => $item->harga_remedial,
                            'created_at' => $item->created_at,
                            'updated_at' => $item->updated_at,
                            'status_ajuan' => $item->status_ajuan,
                        ];
                    })->toArray()
                ];
            })->values();

            // $daftarKelas = [];
            foreach ($data as $item) {
                $kelas = RemedialKelas::create([
                    'remedial_periode_id' => $request->remedial_periode_id,
                    'programstudi' => $item['detail'][0]['programstudi'],
                    'kodemk' => $item['idmk'],
                    'nip' => $item['nip'],
                    'kode_edlink' => '',
                ]);

                foreach ($item['detail'] as $detail) {
                    RemedialKelasPeserta::create([
                        'remedial_kelas_id' => $kelas->id,
                        'nim' => $detail['nim'],
                        'nnumerik' => 0,
                        'nhuruf' => '',
                    ]);
                }

                // $daftarKelas[] = $kelas;
            }

            // update status ajuan mk diterima
            $mk->each(function ($item) {
                $item->update([
                    'status_ajuan' => 'Diterima',
                ]);
            });


            return response()->json([
                'status' => 'success',
                'message' => 'Data berhasil disimpan',
                'data' => $data,
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Data gagal disimpan',
                'data' => $e->getMessage(),
            ]);
        }
    }
}
