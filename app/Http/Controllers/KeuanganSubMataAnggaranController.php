<?php

namespace App\Http\Controllers;

use App\Models\KeuanganMataAnggaran;
use App\Helpers\KeuanganValidationHelper;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Exception;

class KeuanganSubMataAnggaranController extends Controller
{
    public function index($parentId, Request $request)
    {
        try {
            $parent = KeuanganMataAnggaran::findOrFail($parentId);

            $query = KeuanganMataAnggaran::with(['parentMataAnggaran', 'childMataAnggaran'])
                ->where('parent_mata_anggaran', $parentId)
                ->active();

            if ($request->filled('search')) {
                $search = trim($request->search);
                $query->where(function ($q) use ($search) {
                    $q->where('kode_mata_anggaran', 'ilike', "%{$search}%")
                        ->orWhere('nama_mata_anggaran', 'ilike', "%{$search}%")
                        ->orWhere('deskripsi', 'ilike', "%{$search}%");
                });
            }

            $perPage = $this->validatePerPage($request);
            $subMataAnggarans = $query->orderBy('kode_mata_anggaran')
                ->paginate($perPage)
                ->withQueryString();

            return view('keuangan.master.sub-mata-anggaran.index', compact('parent', 'subMataAnggarans'));

        } catch (Exception $e) {
            Log::error('KeuanganSubMataAnggaran - Error in index:', [
                'parentId' => $parentId,
                'message' => $e->getMessage()
            ]);

            return back()->with('error', 'Terjadi kesalahan saat memuat data sub mata anggaran.');
        }
    }

    public function create($parentId)
    {
        try {
            $parent = KeuanganMataAnggaran::findOrFail($parentId);
            return view('keuangan.master.sub-mata-anggaran.create', compact('parent'));

        } catch (Exception $e) {
            Log::error('KeuanganSubMataAnggaran - Error in create:', [
                'parentId' => $parentId,
                'message' => $e->getMessage()
            ]);

            return back()->with('error', 'Parent mata anggaran tidak ditemukan.');
        }
    }

    public function store(Request $request, $parentId)
    {
        try {
            $parent = KeuanganMataAnggaran::findOrFail($parentId);

            // Clean and prepare data
            $cleanData = KeuanganValidationHelper::prepareMataAnggaranData($request);
            $request->merge($cleanData);

            // Get validation rules (without tahun_anggaran since it comes from parent)
            $rules = KeuanganValidationHelper::getMataAnggaranRules();
            unset($rules['tahun_anggaran']); // Remove since it's set from parent

            $validated = $request->validate($rules, KeuanganValidationHelper::getMessages());

            // Set sub mata anggaran specific data
            $validated['parent_mata_anggaran'] = $parentId;
            $validated = KeuanganValidationHelper::setMataAnggaranDefaults($validated, $parent);

            $subMataAnggaran = KeuanganMataAnggaran::create($validated);

            Log::info('KeuanganSubMataAnggaran - Created successfully:', [
                'id' => $subMataAnggaran->id,
                'parent_id' => $parentId,
                'kode' => $subMataAnggaran->kode_mata_anggaran
            ]);

            return redirect()->route('keuangan.sub-mata-anggaran.index', $parentId)
                ->with('success', 'Sub mata anggaran berhasil ditambahkan.');

        } catch (Exception $e) {
            Log::error('KeuanganSubMataAnggaran - Error in store:', [
                'parentId' => $parentId,
                'message' => $e->getMessage()
            ]);

            return back()->with('error', 'Terjadi kesalahan saat menyimpan sub mata anggaran.')
                ->withInput();
        }
    }

    public function edit($parentId, $id)
    {
        try {
            $parent = KeuanganMataAnggaran::findOrFail($parentId);
            $subMataAnggaran = KeuanganMataAnggaran::where('parent_mata_anggaran', $parentId)
                ->findOrFail($id);

            return view('keuangan.master.sub-mata-anggaran.edit', compact('parent', 'subMataAnggaran'));

        } catch (Exception $e) {
            Log::error('KeuanganSubMataAnggaran - Error in edit:', [
                'parentId' => $parentId,
                'id' => $id,
                'message' => $e->getMessage()
            ]);

            return back()->with('error', 'Sub mata anggaran tidak ditemukan.');
        }
    }

    public function update(Request $request, $parentId, $id)
    {
        try {
            $parent = KeuanganMataAnggaran::findOrFail($parentId);
            $subMataAnggaran = KeuanganMataAnggaran::where('parent_mata_anggaran', $parentId)
                ->findOrFail($id);

            // Clean and prepare data
            $cleanData = KeuanganValidationHelper::prepareMataAnggaranData($request);
            $request->merge($cleanData);

            // Get validation rules (without tahun_anggaran)
            $rules = KeuanganValidationHelper::getMataAnggaranRules($id);
            unset($rules['tahun_anggaran']);

            $validated = $request->validate($rules, KeuanganValidationHelper::getMessages());

            $subMataAnggaran->update($validated);

            Log::info('KeuanganSubMataAnggaran - Updated successfully:', [
                'id' => $subMataAnggaran->id,
                'parent_id' => $parentId,
                'kode' => $subMataAnggaran->kode_mata_anggaran
            ]);

            return redirect()->route('keuangan.sub-mata-anggaran.index', $parentId)
                ->with('success', 'Sub mata anggaran berhasil diperbarui.');

        } catch (Exception $e) {
            Log::error('KeuanganSubMataAnggaran - Error in update:', [
                'parentId' => $parentId,
                'id' => $id,
                'message' => $e->getMessage()
            ]);

            return back()->with('error', 'Terjadi kesalahan saat memperbarui sub mata anggaran.')
                ->withInput();
        }
    }

    public function destroy($parentId, $id)
    {
        try {
            $parent = KeuanganMataAnggaran::findOrFail($parentId);
            $subMataAnggaran = KeuanganMataAnggaran::where('parent_mata_anggaran', $parentId)
                ->findOrFail($id);

            if ($subMataAnggaran->hasChildren()) {
                return back()->with('error', 'Tidak dapat menghapus sub mata anggaran yang memiliki anak.');
            }

            $kode = $subMataAnggaran->kode_mata_anggaran;
            $subMataAnggaran->delete();

            Log::info('KeuanganSubMataAnggaran - Deleted successfully:', [
                'id' => $id,
                'parent_id' => $parentId,
                'kode' => $kode
            ]);

            return redirect()->route('keuangan.sub-mata-anggaran.index', $parentId)
                ->with('success', 'Sub mata anggaran berhasil dihapus.');

        } catch (Exception $e) {
            Log::error('KeuanganSubMataAnggaran - Error in destroy:', [
                'parentId' => $parentId,
                'id' => $id,
                'message' => $e->getMessage()
            ]);

            return back()->with('error', 'Terjadi kesalahan saat menghapus sub mata anggaran.');
        }
    }

    public function getByParent($parentId)
    {
        try {
            $subMataAnggarans = KeuanganMataAnggaran::where('parent_mata_anggaran', $parentId)
                ->active()
                ->orderBy('kode_mata_anggaran')
                ->get();

            return response()->json([
                'status' => 'success',
                'data' => $subMataAnggarans
            ]);

        } catch (Exception $e) {
            Log::error('KeuanganSubMataAnggaran - Error in getByParent:', [
                'parentId' => $parentId,
                'message' => $e->getMessage()
            ]);

            return response()->json([
                'status' => 'error',
                'message' => 'Gagal memuat sub mata anggaran.'
            ], 500);
        }
    }

    private function validatePerPage(Request $request)
    {
        $perPage = $request->get('per_page', 15);
        return in_array((int)$perPage, [10, 15, 25, 50, 100]) ? $perPage : 15;
    }
}
