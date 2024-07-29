<?php

namespace App\Http\Controllers;

use App\Models\RemedialAjuan;
use App\Models\RemedialAjuanDetail;
use Illuminate\Http\Request;

class RemedialPelaksanaanKelasController extends Controller
{
    public function tambahPerMKAjax(Request $request)
    {
        $request->validate([
            'remedial_periode_id' => 'required',
            'kodemk' => 'required',
        ]);

        try {
            $mk = RemedialAjuanDetail::whereHas('RemedialAjuan', function ($query) use ($request) {
                $query->where('remedial_periode_id', $request->remedial_periode_id);
            })
                ->where('idmk', $request->kodemk)
                ->first();

            return redirect()->route('remedial.pelaksanaan.daftar-mk.peserta', [
                'kodemk' => $request->kodemk,
                'remedial_periode_id' => $request->remedial_periode_id
            ])->with('success', 'Data berhasil ditemukan');
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Data gagal disimpan',
                'data' => $e->getMessage(),
            ]);
        }
    }
}
