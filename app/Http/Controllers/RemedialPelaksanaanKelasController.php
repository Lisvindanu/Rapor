<?php

namespace App\Http\Controllers;

use App\Models\RemedialAjuan;
use App\Models\RemedialAjuanDetail;
use App\Models\RemedialKelas;
use Illuminate\Http\Request;
use App\Models\RemedialKelasPeserta;

class RemedialPelaksanaanKelasController extends Controller
{
    public function tambahPerMKAjax(Request $request)
    {
        $request->validate([
            'remedial_periode_id' => 'required',
            'kodemk' => 'required',
        ]);

        try {
            $mk = RemedialAjuanDetail::with(['kelasKuliah'])
                ->whereHas('RemedialAjuan', function ($query) use ($request) {
                    $query->where('remedial_periode_id', $request->remedial_periode_id);
                })
                ->where('idmk', $request->kodemk)
                ->first();

            if (!$mk) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Matakuliah tidak ditemukan',
                ]);
            }

            $kelas = RemedialKelas::create([
                'remedial_periode_id' => $request->remedial_periode_id,
                'programstudi' => $mk->kelasKuliah->programstudi,
                'kodemk' => $mk->idmk,
                'nip' => $mk->nip,
                'kode_edlink' => '',
            ]);

            return response()->json([
                'status' => 'success',
                'message' => 'Data berhasil disimpan',
                'data' => $kelas,
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

            // $mk = RemedialAjuanDetail::whereHas('RemedialAjuan', function ($query) use ($request) {
            //     $query->where('remedial_periode_id', $request->remedial_periode_id);
            // })
            //     ->where('idmk', $request->kodemk)
            //     ->where('kode_periode', $request->kode_periode)
            //     ->get();

            $mk = RemedialAjuanDetail::with('RemedialAjuan')
                ->whereHas('RemedialAjuan', function ($query) use ($request) {
                    $query->where('remedial_periode_id', $request->remedial_periode_id);
                })
                ->where('idmk', $request->kodemk)
                ->where('kode_periode', $request->kode_periode)
                ->where('status_ajuan', 'Konfirmasi Kelas')
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
