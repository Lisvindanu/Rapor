<?php

namespace App\Http\Controllers;

use App\Models\KeuanganMataAnggaran;
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
                $search = $request->search;
                $query->where(function ($q) use ($search) {
                    $q->where('kode_mata_anggaran', 'like', "%{$search}%")
                        ->orWhere('nama_mata_anggaran', 'like', "%{$search}%");
                });
            }

            $subMataAnggarans = $query->orderBy('kode_mata_anggaran')
                ->paginate(15)
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

            $validated = $request->validate([
                'kode_mata_anggaran' => 'required|string|max:20|unique:keuangan_mtang,kode_mata_anggaran',
                'nama_mata_anggaran' => 'required|string|max:255',
                'nama_mata_anggaran_en' => 'nullable|string|max:255',
                'deskripsi' => 'nullable|string',
                'kategori' => 'nullable|string|max:100',
                'alokasi_anggaran' => 'nullable|numeric|min:0',
                'status_aktif' => 'boolean'
            ]);

            $validated['parent_mata_anggaran'] = $parentId;
            $validated['tahun_anggaran'] = $parent->tahun_anggaran;
            $validated['status_aktif'] = $request->has('status_aktif');
            $validated['sisa_anggaran'] = $validated['alokasi_anggaran'] ?? 0;

            $subMataAnggaran = KeuanganMataAnggaran::create($validated);

            Log::info('KeuanganSubMataAnggaran - Created successfully:', [
                'id' => $subMataAnggaran->id,
                'parent_id' => $parentId,
                'kode' => $subMataAnggaran->kode_mata_anggaran,
                'user_id' => auth()->id()
            ]);

            return redirect()->route('keuangan.sub-mata-anggaran.index', $parentId)
                ->with('success', 'Sub mata anggaran berhasil ditambahkan.');

        } catch (Exception $e) {
            Log::error('KeuanganSubMataAnggaran - Error in store:', [
                'parentId' => $parentId,
                'message' => $e->getMessage(),
                'request_data' => $request->all()
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

            $validated = $request->validate([
                'kode_mata_anggaran' => "required|string|max:20|unique:keuangan_mtang,kode_mata_anggaran,{$id}",
                'nama_mata_anggaran' => 'required|string|max:255',
                'nama_mata_anggaran_en' => 'nullable|string|max:255',
                'deskripsi' => 'nullable|string',
                'kategori' => 'nullable|string|max:100',
                'alokasi_anggaran' => 'nullable|numeric|min:0',
                'status_aktif' => 'boolean'
            ]);

            $validated['status_aktif'] = $request->has('status_aktif');

            $subMataAnggaran->update($validated);

            Log::info('KeuanganSubMataAnggaran - Updated successfully:', [
                'id' => $subMataAnggaran->id,
                'parent_id' => $parentId,
                'kode' => $subMataAnggaran->kode_mata_anggaran,
                'user_id' => auth()->id()
            ]);

            return redirect()->route('keuangan.sub-mata-anggaran.index', $parentId)
                ->with('success', 'Sub mata anggaran berhasil diperbarui.');

        } catch (Exception $e) {
            Log::error('KeuanganSubMataAnggaran - Error in update:', [
                'parentId' => $parentId,
                'id' => $id,
                'message' => $e->getMessage(),
                'request_data' => $request->all()
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
                'kode' => $kode,
                'user_id' => auth()->id()
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
}
