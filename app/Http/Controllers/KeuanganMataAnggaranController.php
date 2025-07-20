<?php

namespace App\Http\Controllers;

use App\Models\KeuanganMataAnggaran;
use App\Helpers\KeuanganValidationHelper;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Exception;

class KeuanganMataAnggaranController extends Controller
{
    public function index(Request $request)
    {
        try {
            $query = KeuanganMataAnggaran::with(['parentMataAnggaran', 'childMataAnggaran']);

            // Search
            if ($request->filled('search')) {
                $search = trim($request->search);
                $query->where(function ($q) use ($search) {
                    $q->where('kode_mata_anggaran', 'ilike', "%{$search}%")
                        ->orWhere('nama_mata_anggaran', 'ilike', "%{$search}%");
                });
            }

            // Filter kategori
            if ($request->filled('kategori')) {
                $query->where('kategori', $request->kategori);
            }

            // Show only parent by default, unless searching
            if (!$request->filled('search')) {
                $query->whereNull('parent_mata_anggaran');
            }

            // Order by Roman numeral for parent
            $query->orderByRaw("
                CASE
                    WHEN kode_mata_anggaran = 'I' THEN 1
                    WHEN kode_mata_anggaran = 'II' THEN 2
                    WHEN kode_mata_anggaran = 'III' THEN 3
                    WHEN kode_mata_anggaran = 'V' THEN 5
                    WHEN kode_mata_anggaran = 'VI' THEN 6
                    WHEN kode_mata_anggaran = 'VII' THEN 7
                    WHEN kode_mata_anggaran = 'VIII' THEN 8
                    ELSE 999
                END, kode_mata_anggaran
            ");

            $perPage = in_array($request->per_page, [10, 15, 25, 50]) ? $request->per_page : 15;
            $mataAnggarans = $query->paginate($perPage)->withQueryString();

            // Empty message
            $emptyMessage = 'Belum ada data mata anggaran.';
            if ($request->filled('search')) {
                $emptyMessage = "Tidak ditemukan data yang sesuai dengan pencarian '{$request->search}'.";
            }

            return view('keuangan.master.mata-anggaran.index', compact('mataAnggarans', 'emptyMessage'));

        } catch (Exception $e) {
            Log::error('KeuanganMataAnggaran - Index error: ' . $e->getMessage());
            return back()->with('error', 'Terjadi kesalahan saat memuat data.');
        }
    }

    // API untuk ambil children via AJAX
    public function getChildren($parentId)
    {
        try {
            $children = KeuanganMataAnggaran::where('parent_mata_anggaran', $parentId)
                ->orderBy('kode_mata_anggaran')
                ->get();

            return response()->json([
                'success' => true,
                'data' => $children
            ]);

        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 500);
        }
    }

    public function create()
    {
        try {
            $parentOptions = KeuanganMataAnggaran::whereNull('parent_mata_anggaran')
                ->orderByRaw("
                    CASE
                        WHEN kode_mata_anggaran = 'I' THEN 1
                        WHEN kode_mata_anggaran = 'II' THEN 2
                        WHEN kode_mata_anggaran = 'III' THEN 3
                        WHEN kode_mata_anggaran = 'V' THEN 5
                        WHEN kode_mata_anggaran = 'VI' THEN 6
                        WHEN kode_mata_anggaran = 'VII' THEN 7
                        WHEN kode_mata_anggaran = 'VIII' THEN 8
                        ELSE 999
                    END
                ")
                ->get();

            return view('keuangan.master.mata-anggaran.create', compact('parentOptions'));

        } catch (Exception $e) {
            Log::error('KeuanganMataAnggaran - Create error: ' . $e->getMessage());
            return back()->with('error', 'Terjadi kesalahan saat memuat form.');
        }
    }

    public function store(Request $request)
    {

        try {
            $request->validate(
                KeuanganValidationHelper::getMataAnggaranRules(),
                KeuanganValidationHelper::getMessages()
            );

            if ($request->parent_mata_anggaran) {
                if (!KeuanganValidationHelper::validateParentChild($request->parent_mata_anggaran)) {
                    return back()->withErrors(['parent_mata_anggaran' => 'Parent tidak valid'])->withInput();
                }
            }

            DB::beginTransaction();

            $data = $request->only(['kode_mata_anggaran', 'nama_mata_anggaran', 'parent_mata_anggaran', 'kategori']);
            $data['kode_mata_anggaran'] = KeuanganValidationHelper::formatKodeMataAnggaran($data['kode_mata_anggaran']);

            KeuanganMataAnggaran::create($data);

            DB::commit();

            return redirect()->route('keuangan.mata-anggaran.index')
                ->with('success', 'Mata anggaran berhasil ditambahkan');

        } catch (Exception $e) {
            DB::rollBack();
            Log::error('KeuanganMataAnggaran - Store error: ' . $e->getMessage());
            return back()->withErrors(['error' => 'Gagal menyimpan data: ' . $e->getMessage()])->withInput();
        }
    }

    public function show($id)
    {
        try {
            $mataAnggaran = KeuanganMataAnggaran::with(['parentMataAnggaran', 'childMataAnggaran'])
                ->findOrFail($id);

            return view('keuangan.master.mata-anggaran.show', compact('mataAnggaran'));

        } catch (Exception $e) {
            Log::error('KeuanganMataAnggaran - Show error: ' . $e->getMessage());
            return back()->with('error', 'Mata anggaran tidak ditemukan.');
        }
    }

    public function edit($id)
    {
        try {
            $mataAnggaran = KeuanganMataAnggaran::findOrFail($id);

            $parentOptions = KeuanganMataAnggaran::whereNull('parent_mata_anggaran')
                ->where('id', '!=', $id)
                ->orderByRaw("
                    CASE
                        WHEN kode_mata_anggaran = 'I' THEN 1
                        WHEN kode_mata_anggaran = 'II' THEN 2
                        WHEN kode_mata_anggaran = 'III' THEN 3
                        WHEN kode_mata_anggaran = 'V' THEN 5
                        WHEN kode_mata_anggaran = 'VI' THEN 6
                        WHEN kode_mata_anggaran = 'VII' THEN 7
                        WHEN kode_mata_anggaran = 'VIII' THEN 8
                        ELSE 999
                    END
                ")
                ->get();

            return view('keuangan.master.mata-anggaran.edit', compact('mataAnggaran', 'parentOptions'));

        } catch (Exception $e) {
            Log::error('KeuanganMataAnggaran - Edit error: ' . $e->getMessage());
            return back()->with('error', 'Mata anggaran tidak ditemukan.');
        }
    }

    public function update(Request $request, $id)
    {
        try {
            $mataAnggaran = KeuanganMataAnggaran::findOrFail($id);

            $request->validate(
                KeuanganValidationHelper::getMataAnggaranRules($id),
                KeuanganValidationHelper::getMessages()
            );

            if ($request->parent_mata_anggaran) {
                if (!KeuanganValidationHelper::validateParentChild($request->parent_mata_anggaran, $id)) {
                    return back()->withErrors(['parent_mata_anggaran' => 'Parent tidak valid'])->withInput();
                }
            }

            DB::beginTransaction();

            $data = $request->only(['kode_mata_anggaran', 'nama_mata_anggaran', 'parent_mata_anggaran', 'kategori']);
            $data['kode_mata_anggaran'] = KeuanganValidationHelper::formatKodeMataAnggaran($data['kode_mata_anggaran']);

            $mataAnggaran->update($data);

            DB::commit();

            return redirect()->route('keuangan.mata-anggaran.index')
                ->with('success', 'Mata anggaran berhasil diperbarui');

        } catch (Exception $e) {
            DB::rollBack();
            Log::error('KeuanganMataAnggaran - Update error: ' . $e->getMessage());
            return back()->withErrors(['error' => 'Gagal memperbarui data: ' . $e->getMessage()])->withInput();
        }
    }

    public function destroy($id)
    {
        try {
            $mataAnggaran = KeuanganMataAnggaran::findOrFail($id);

            if ($mataAnggaran->childMataAnggaran()->exists()) {
                return back()->with('error', 'Tidak dapat menghapus mata anggaran yang masih memiliki sub mata anggaran');
            }

            DB::beginTransaction();
            $mataAnggaran->delete();
            DB::commit();

            return redirect()->route('keuangan.mata-anggaran.index')
                ->with('success', 'Mata anggaran berhasil dihapus');

        } catch (Exception $e) {
            DB::rollBack();
            Log::error('KeuanganMataAnggaran - Delete error: ' . $e->getMessage());
            return back()->with('error', 'Terjadi kesalahan saat menghapus mata anggaran');
        }
    }
}
