<?php

namespace App\Http\Controllers;

use App\Models\KeuanganTahunAnggaran;
use App\Helpers\KeuanganTahunAnggaranValidationHelper;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
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
            Log::error('KeuanganTahunAnggaran - Index error: ' . $e->getMessage());
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
            Log::error('KeuanganTahunAnggaran - Create form error: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            $request->validate(
                KeuanganTahunAnggaranValidationHelper::getTahunAnggaranRules(),
                KeuanganTahunAnggaranValidationHelper::getMessages()
            );

            // Validasi overlap menggunakan helper
            if (KeuanganTahunAnggaranValidationHelper::validateOverlap($request)) {
                return redirect()->back()
                    ->withErrors(['overlap' => 'Periode tahun anggaran tidak boleh overlap dengan yang sudah ada.'])
                    ->withInput();
            }

            DB::beginTransaction();

            KeuanganTahunAnggaran::create($request->only([
                'tahun_anggaran',
                'tgl_awal_anggaran',
                'tgl_akhir_anggaran'
            ]));

            DB::commit();

            return redirect()->route('keuangan.tahun-anggaran.index')
                ->with('message', 'Tahun anggaran berhasil ditambahkan.');

        } catch (Exception $e) {
            DB::rollBack();
            Log::error('KeuanganTahunAnggaran - Store error: ' . $e->getMessage());
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
            Log::error('KeuanganTahunAnggaran - Show error: ' . $e->getMessage());
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
            Log::error('KeuanganTahunAnggaran - Edit form error: ' . $e->getMessage());
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

            $request->validate(
                KeuanganTahunAnggaranValidationHelper::getTahunAnggaranRules($id),
                KeuanganTahunAnggaranValidationHelper::getMessages()
            );

            // Validasi overlap menggunakan helper (exclude current record)
            if (KeuanganTahunAnggaranValidationHelper::validateOverlap($request, $id)) {
                return redirect()->back()
                    ->withErrors(['overlap' => 'Periode tahun anggaran tidak boleh overlap dengan yang sudah ada.'])
                    ->withInput();
            }

            DB::beginTransaction();

            $tahunAnggaran->update($request->only([
                'tahun_anggaran',
                'tgl_awal_anggaran',
                'tgl_akhir_anggaran'
            ]));

            DB::commit();

            return redirect()->route('keuangan.tahun-anggaran.index')
                ->with('message', 'Tahun anggaran berhasil diperbarui.');

        } catch (Exception $e) {
            DB::rollBack();
            Log::error('KeuanganTahunAnggaran - Update error: ' . $e->getMessage());
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

            DB::beginTransaction();
            $tahunAnggaran->delete();
            DB::commit();

            return response()->json([
                'message' => 'Tahun anggaran berhasil dihapus.'
            ], 200);

        } catch (Exception $e) {
            DB::rollBack();
            Log::error('KeuanganTahunAnggaran - Delete error: ' . $e->getMessage());
            return response()->json([
                'message' => 'Terjadi kesalahan: ' . $e->getMessage()
            ], 500);
        }
    }
}
