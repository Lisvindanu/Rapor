<?php

namespace App\Http\Controllers;

use App\Models\KeuanganTahunAnggaran;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Carbon\Carbon;
use Exception;

class KeuanganTahunAnggaranController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        try {
            $query = KeuanganTahunAnggaran::query();

            // Filter berdasarkan tahun jika ada
            if ($request->filled('tahun')) {
                $query->byTahun($request->tahun);
            }

            // Filter berdasarkan status jika ada
            if ($request->filled('status')) {
                $today = Carbon::now()->format('Y-m-d');
                switch ($request->status) {
                    case 'aktif':
                        $query->aktif();
                        break;
                    case 'belum_dimulai':
                        $query->where('tgl_awal_anggaran', '>', $today);
                        break;
                    case 'selesai':
                        $query->where('tgl_akhir_anggaran', '<', $today);
                        break;
                }
            }

            $tahunAnggarans = $query->orderBy('tahun_anggaran', 'desc')->get();

            return view('keuangan.master.tahun-anggaran.index', compact('tahunAnggarans'));

        } catch (Exception $e) {
            return redirect()->back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        try {
            return view('keuangan.master.tahun-anggaran.create');
        } catch (Exception $e) {
            return redirect()->back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'tahun_anggaran' => 'required|string|max:10|unique:keuangan_tahun_anggaran,tahun_anggaran',
                'tgl_awal_anggaran' => 'required|date',
                'tgl_akhir_anggaran' => 'required|date|after:tgl_awal_anggaran'
            ], [
                'tahun_anggaran.required' => 'Tahun anggaran wajib diisi.',
                'tahun_anggaran.unique' => 'Tahun anggaran sudah ada.',
                'tgl_awal_anggaran.required' => 'Tanggal awal anggaran wajib diisi.',
                'tgl_akhir_anggaran.required' => 'Tanggal akhir anggaran wajib diisi.',
                'tgl_akhir_anggaran.after' => 'Tanggal akhir harus setelah tanggal awal.'
            ]);

            if ($validator->fails()) {
                return redirect()->back()
                    ->withErrors($validator)
                    ->withInput();
            }

            // Validasi tambahan untuk overlap tanggal
            $overlap = KeuanganTahunAnggaran::where(function ($query) use ($request) {
                $query->whereBetween('tgl_awal_anggaran', [$request->tgl_awal_anggaran, $request->tgl_akhir_anggaran])
                    ->orWhereBetween('tgl_akhir_anggaran', [$request->tgl_awal_anggaran, $request->tgl_akhir_anggaran])
                    ->orWhere(function ($q) use ($request) {
                        $q->where('tgl_awal_anggaran', '<=', $request->tgl_awal_anggaran)
                            ->where('tgl_akhir_anggaran', '>=', $request->tgl_akhir_anggaran);
                    });
            })->exists();

            if ($overlap) {
                return redirect()->back()
                    ->withErrors(['overlap' => 'Periode tahun anggaran tidak boleh overlap dengan yang sudah ada.'])
                    ->withInput();
            }

            KeuanganTahunAnggaran::create($request->only([
                'tahun_anggaran',
                'tgl_awal_anggaran',
                'tgl_akhir_anggaran'
            ]));

            return redirect()->route('keuangan.tahun-anggaran.index')
                ->with('message', 'Tahun anggaran berhasil ditambahkan.');

        } catch (Exception $e) {
            return redirect()->back()
                ->with('error', 'Terjadi kesalahan: ' . $e->getMessage())
                ->withInput();
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        try {
            $tahunAnggaran = KeuanganTahunAnggaran::findOrFail($id);
            return view('keuangan.master.tahun-anggaran.show', compact('tahunAnggaran'));
        } catch (Exception $e) {
            return redirect()->back()->with('error', 'Data tidak ditemukan.');
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        try {
            $tahunAnggaran = KeuanganTahunAnggaran::findOrFail($id);
            return view('keuangan.master.tahun-anggaran.edit', compact('tahunAnggaran'));
        } catch (Exception $e) {
            return redirect()->back()->with('error', 'Data tidak ditemukan.');
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        try {
            $tahunAnggaran = KeuanganTahunAnggaran::findOrFail($id);

            $validator = Validator::make($request->all(), [
                'tahun_anggaran' => 'required|string|max:10|unique:keuangan_tahun_anggaran,tahun_anggaran,' . $id,
                'tgl_awal_anggaran' => 'required|date',
                'tgl_akhir_anggaran' => 'required|date|after:tgl_awal_anggaran'
            ], [
                'tahun_anggaran.required' => 'Tahun anggaran wajib diisi.',
                'tahun_anggaran.unique' => 'Tahun anggaran sudah ada.',
                'tgl_awal_anggaran.required' => 'Tanggal awal anggaran wajib diisi.',
                'tgl_akhir_anggaran.required' => 'Tanggal akhir anggaran wajib diisi.',
                'tgl_akhir_anggaran.after' => 'Tanggal akhir harus setelah tanggal awal.'
            ]);

            if ($validator->fails()) {
                return redirect()->back()
                    ->withErrors($validator)
                    ->withInput();
            }

            // Validasi tambahan untuk overlap tanggal (exclude current record)
            $overlap = KeuanganTahunAnggaran::where('id', '!=', $id)
                ->where(function ($query) use ($request) {
                    $query->whereBetween('tgl_awal_anggaran', [$request->tgl_awal_anggaran, $request->tgl_akhir_anggaran])
                        ->orWhereBetween('tgl_akhir_anggaran', [$request->tgl_awal_anggaran, $request->tgl_akhir_anggaran])
                        ->orWhere(function ($q) use ($request) {
                            $q->where('tgl_awal_anggaran', '<=', $request->tgl_awal_anggaran)
                                ->where('tgl_akhir_anggaran', '>=', $request->tgl_akhir_anggaran);
                        });
                })->exists();

            if ($overlap) {
                return redirect()->back()
                    ->withErrors(['overlap' => 'Periode tahun anggaran tidak boleh overlap dengan yang sudah ada.'])
                    ->withInput();
            }

            $tahunAnggaran->update($request->only([
                'tahun_anggaran',
                'tgl_awal_anggaran',
                'tgl_akhir_anggaran'
            ]));

            return redirect()->route('keuangan.tahun-anggaran.index')
                ->with('message', 'Tahun anggaran berhasil diperbarui.');

        } catch (Exception $e) {
            return redirect()->back()
                ->with('error', 'Terjadi kesalahan: ' . $e->getMessage())
                ->withInput();
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            $tahunAnggaran = KeuanganTahunAnggaran::findOrFail($id);

            // Cek apakah tahun anggaran sedang aktif
            if ($tahunAnggaran->is_aktif) {
                return response()->json([
                    'message' => 'Tidak dapat menghapus tahun anggaran yang sedang aktif.'
                ], 400);
            }

            $tahunAnggaran->delete();

            return response()->json([
                'message' => 'Tahun anggaran berhasil dihapus.'
            ], 200);

        } catch (Exception $e) {
            return response()->json([
                'message' => 'Terjadi kesalahan: ' . $e->getMessage()
            ], 500);
        }
    }
}
