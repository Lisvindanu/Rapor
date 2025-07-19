<?php

namespace App\Http\Controllers;

use App\Models\KeuanganTandaTangan;
use App\Helpers\KeuanganTandaTanganValidationHelper;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Exception;

class KeuanganTandaTanganController extends Controller
{
    public function index(Request $request)
    {
        try {
            $request->validate(KeuanganTandaTanganValidationHelper::getSearchRules());

            $search = $request->get('search');
            $perPage = $request->get('per_page', 20);
            $sortBy = $request->get('sort_by', 'created_at');
            $sortOrder = $request->get('sort_order', 'desc');

            $query = KeuanganTandaTangan::query();

            if ($search) {
                $query->where(function ($q) use ($search) {
                    $q->where('nomor_ttd', 'ILIKE', "%{$search}%")
                        ->orWhere('nama', 'ILIKE', "%{$search}%")
                        ->orWhere('jabatan', 'ILIKE', "%{$search}%");
                });
            }

            $tandaTangans = $query->orderBy($sortBy, $sortOrder)
                ->paginate($perPage)
                ->withQueryString();

            return view('keuangan.master.tanda-tangan.index', compact('tandaTangans'));

        } catch (Exception $e) {
            Log::error('KeuanganTandaTangan - Index error: ' . $e->getMessage());
            return back()->with('error', 'Terjadi kesalahan saat memuat data.');
        }
    }

    public function create()
    {
        try {
            return view('keuangan.master.tanda-tangan.create');
        } catch (Exception $e) {
            Log::error('KeuanganTandaTangan - Create form error: ' . $e->getMessage());
            return back()->with('error', 'Terjadi kesalahan saat memuat form.');
        }
    }

    public function store(Request $request)
    {
        try {
            $request->validate(
                KeuanganTandaTanganValidationHelper::getTandaTanganRules(),
                KeuanganTandaTanganValidationHelper::getMessages()
            );

            if ($request->gambar_ttd && !KeuanganTandaTanganValidationHelper::validateImageFormat($request->gambar_ttd)) {
                return back()->withErrors(['gambar_ttd' => 'Format gambar tidak valid'])->withInput();
            }

            DB::beginTransaction();

            $data = [
                'nomor_ttd' => KeuanganTandaTanganValidationHelper::formatNomorTtd($request->nomor_ttd),
                'jabatan' => KeuanganTandaTanganValidationHelper::formatJabatan($request->jabatan),
                'nama' => KeuanganTandaTanganValidationHelper::formatNama($request->nama),
                'gambar_ttd' => $request->gambar_ttd,
            ];

            KeuanganTandaTangan::create($data);

            DB::commit();

            return redirect()->route('keuangan.tanda-tangan.index')
                ->with('success', 'Tanda tangan berhasil ditambahkan');

        } catch (Exception $e) {
            DB::rollBack();
            Log::error('KeuanganTandaTangan - Store error: ' . $e->getMessage());
            return back()->withErrors(['error' => 'Gagal menyimpan data: ' . $e->getMessage()])->withInput();
        }
    }

    public function show(string $id)
    {
        try {
            $tandaTangan = KeuanganTandaTangan::findOrFail($id);
            return view('keuangan.master.tanda-tangan.show', compact('tandaTangan'));
        } catch (Exception $e) {
            Log::error('KeuanganTandaTangan - Show error: ' . $e->getMessage());
            return redirect()->route('keuangan.tanda-tangan.index')
                ->with('error', 'Tanda tangan tidak ditemukan.');
        }
    }

    public function edit(string $id)
    {
        try {
            $tandaTangan = KeuanganTandaTangan::findOrFail($id);
            return view('keuangan.master.tanda-tangan.edit', compact('tandaTangan'));
        } catch (Exception $e) {
            Log::error('KeuanganTandaTangan - Edit form error: ' . $e->getMessage());
            return redirect()->route('keuangan.tanda-tangan.index')
                ->with('error', 'Tanda tangan tidak ditemukan.');
        }
    }

    public function update(Request $request, string $id)
    {
        try {
            $tandaTangan = KeuanganTandaTangan::findOrFail($id);

            $request->validate(
                KeuanganTandaTanganValidationHelper::getTandaTanganRules($id),
                KeuanganTandaTanganValidationHelper::getMessages()
            );

            if ($request->gambar_ttd && !KeuanganTandaTanganValidationHelper::validateImageFormat($request->gambar_ttd)) {
                return back()->withErrors(['gambar_ttd' => 'Format gambar tidak valid'])->withInput();
            }

            DB::beginTransaction();

            $data = [
                'nomor_ttd' => KeuanganTandaTanganValidationHelper::formatNomorTtd($request->nomor_ttd),
                'jabatan' => KeuanganTandaTanganValidationHelper::formatJabatan($request->jabatan),
                'nama' => KeuanganTandaTanganValidationHelper::formatNama($request->nama),
            ];

            if ($request->gambar_ttd) {
                $data['gambar_ttd'] = $request->gambar_ttd;
            }

            $tandaTangan->update($data);

            DB::commit();

            return redirect()->route('keuangan.tanda-tangan.index')
                ->with('success', 'Tanda tangan berhasil diperbarui');

        } catch (Exception $e) {
            DB::rollBack();
            Log::error('KeuanganTandaTangan - Update error: ' . $e->getMessage());
            return back()->withErrors(['error' => 'Gagal memperbarui data: ' . $e->getMessage()])->withInput();
        }
    }

    public function destroy(string $id)
    {
        try {
            $tandaTangan = KeuanganTandaTangan::findOrFail($id);

            if (!KeuanganTandaTanganValidationHelper::canBeDeleted($id)) {
                if (request()->expectsJson() || request()->ajax()) {
                    return response()->json([
                        'message' => 'Tanda tangan tidak dapat dihapus karena masih digunakan dalam dokumen.'
                    ], 422);
                }
                return back()->with('error', 'Tanda tangan tidak dapat dihapus karena masih digunakan dalam dokumen.');
            }

            DB::beginTransaction();
            $tandaTangan->delete();
            DB::commit();

            if (request()->expectsJson() || request()->ajax()) {
                return response()->json([
                    'message' => 'Tanda tangan berhasil dihapus'
                ], 200);
            }

            return redirect()->route('keuangan.tanda-tangan.index')
                ->with('success', 'Tanda tangan berhasil dihapus');

        } catch (Exception $e) {
            DB::rollBack();
            Log::error('KeuanganTandaTangan - Delete error: ' . $e->getMessage());

            if (request()->expectsJson() || request()->ajax()) {
                return response()->json([
                    'message' => 'Terjadi kesalahan saat menghapus tanda tangan'
                ], 500);
            }

            return back()->with('error', 'Terjadi kesalahan saat menghapus tanda tangan');
        }
    }
}
