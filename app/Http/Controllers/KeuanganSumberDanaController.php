<?php

namespace App\Http\Controllers;

use App\Models\KeuanganSumberDana;
use App\Helpers\KeuanganSumberDanaValidationHelper;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Exception;

class KeuanganSumberDanaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        try {
            $request->validate(KeuanganSumberDanaValidationHelper::getSearchRules());

            $query = KeuanganSumberDana::query();

            // Apply search filter
            if ($request->filled('search')) {
                $query->byNama($request->search);
            }

            // Apply sorting
            $sortBy = $request->get('sort_by', 'nama_sumber_dana');
            $sortOrder = $request->get('sort_order', 'asc');

            if ($sortBy === 'nama_sumber_dana') {
                $query->orderByNama($sortOrder);
            } else {
                $query->orderBy($sortBy, $sortOrder);
            }

            $sumberDanas = $query->get();

            return view('keuangan.master.sumber-dana.index', compact('sumberDanas'));

        } catch (Exception $e) {
            Log::error('KeuanganSumberDana - Index error: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        try {
            return view('keuangan.master.sumber-dana.create');
        } catch (Exception $e) {
            Log::error('KeuanganSumberDana - Create form error: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Terjadi kesalahan saat memuat form.');
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            $request->validate(
                KeuanganSumberDanaValidationHelper::getSumberDanaRules(),
                KeuanganSumberDanaValidationHelper::getMessages()
            );

            DB::beginTransaction();

            $data = [
                'nama_sumber_dana' => KeuanganSumberDanaValidationHelper::formatNamaSumberDana(
                    $request->nama_sumber_dana
                )
            ];

            KeuanganSumberDana::create($data);

            DB::commit();

            return redirect()->route('keuangan.sumber-dana.index')
                ->with('message', 'Sumber dana berhasil ditambahkan');

        } catch (Exception $e) {
            DB::rollBack();
            Log::error('KeuanganSumberDana - Store error: ' . $e->getMessage());
            return back()->withErrors(['error' => 'Gagal menyimpan data: ' . $e->getMessage()])->withInput();
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        try {
            $sumberDana = KeuanganSumberDana::findOrFail($id);
            return view('keuangan.master.sumber-dana.show', compact('sumberDana'));

        } catch (Exception $e) {
            Log::error('KeuanganSumberDana - Show error: ' . $e->getMessage());
            return redirect()->route('keuangan.sumber-dana.index')
                ->with('error', 'Sumber dana tidak ditemukan.');
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        try {
            $sumberDana = KeuanganSumberDana::findOrFail($id);
            return view('keuangan.master.sumber-dana.edit', compact('sumberDana'));

        } catch (Exception $e) {
            Log::error('KeuanganSumberDana - Edit form error: ' . $e->getMessage());
            return redirect()->route('keuangan.sumber-dana.index')
                ->with('error', 'Sumber dana tidak ditemukan.');
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        try {
            $sumberDana = KeuanganSumberDana::findOrFail($id);

            $request->validate(
                KeuanganSumberDanaValidationHelper::getSumberDanaRules($id),
                KeuanganSumberDanaValidationHelper::getMessages()
            );

            DB::beginTransaction();

            $data = [
                'nama_sumber_dana' => KeuanganSumberDanaValidationHelper::formatNamaSumberDana(
                    $request->nama_sumber_dana
                )
            ];

            $sumberDana->update($data);

            DB::commit();

            return redirect()->route('keuangan.sumber-dana.index')
                ->with('message', 'Sumber dana berhasil diperbarui');

        } catch (Exception $e) {
            DB::rollBack();
            Log::error('KeuanganSumberDana - Update error: ' . $e->getMessage());
            return back()->withErrors(['error' => 'Gagal memperbarui data: ' . $e->getMessage()])->withInput();
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            $sumberDana = KeuanganSumberDana::findOrFail($id);

            if (!KeuanganSumberDanaValidationHelper::canBeDeleted($id)) {
                // Untuk AJAX request, return JSON error
                if (request()->expectsJson() || request()->ajax()) {
                    return response()->json([
                        'message' => 'Sumber dana tidak dapat dihapus karena masih digunakan dalam transaksi.'
                    ], 400);
                }

                return redirect()->route('keuangan.sumber-dana.index')
                    ->with('error', 'Sumber dana tidak dapat dihapus karena masih digunakan dalam transaksi.');
            }

            DB::beginTransaction();

            $namaSebelumHapus = $sumberDana->nama_sumber_dana;
            $sumberDana->delete();

            DB::commit();

            // Untuk AJAX request, return JSON success seperti tahun anggaran
            if (request()->expectsJson() || request()->ajax()) {
                return response()->json([
                    'message' => 'Sumber dana "' . $namaSebelumHapus . '" berhasil dihapus.'
                ], 200);
            }

            return redirect()->route('keuangan.sumber-dana.index')
                ->with('message', 'Sumber dana berhasil dihapus');

        } catch (Exception $e) {
            DB::rollBack();
            Log::error('KeuanganSumberDana - Delete error: ' . $e->getMessage());

            // Untuk AJAX request, return JSON error seperti tahun anggaran
            if (request()->expectsJson() || request()->ajax()) {
                return response()->json([
                    'message' => 'Terjadi kesalahan: ' . $e->getMessage()
                ], 500);
            }

            return redirect()->route('keuangan.sumber-dana.index')
                ->with('error', 'Gagal menghapus sumber dana: ' . $e->getMessage());
        }
    }
}
