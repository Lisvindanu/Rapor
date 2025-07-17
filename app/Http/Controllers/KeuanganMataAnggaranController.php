<?php

namespace App\Http\Controllers;

use App\Models\KeuanganMataAnggaran;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Exception;

class KeuanganMataAnggaranController extends Controller
{
    public function index(Request $request)
    {
        try {
            Log::info('KeuanganMataAnggaran - Index accessed', [
                'user_id' => auth()->id(),
                'search' => $request->search ?? 'none'
            ]);

            $query = KeuanganMataAnggaran::with(['parentMataAnggaran', 'childMataAnggaran'])
                ->active();

            if ($request->filled('search')) {
                $search = $request->search;
                $query->where(function ($q) use ($search) {
                    $q->where('kode_mata_anggaran', 'like', "%{$search}%")
                        ->orWhere('nama_mata_anggaran', 'like', "%{$search}%")
                        ->orWhere('deskripsi', 'like', "%{$search}%");
                });
            }

            if ($request->filled('tahun_anggaran')) {
                $query->byTahunAnggaran($request->tahun_anggaran);
            }

            $mataAnggarans = $query->orderBy('kode_mata_anggaran')
                ->paginate(15)
                ->withQueryString();

            return view('keuangan.master.mata-anggaran.index', compact('mataAnggarans'));

        } catch (Exception $e) {
            Log::error('KeuanganMataAnggaran - Error in index:', [
                'message' => $e->getMessage(),
                'line' => $e->getLine()
            ]);

            return back()->with('error', 'Terjadi kesalahan saat memuat data mata anggaran.');
        }
    }

    public function create()
    {
        try {
            $parentOptions = KeuanganMataAnggaran::active()
                ->parents()
                ->orderBy('kode_mata_anggaran')
                ->get();

            $currentYear = date('Y');
            $tahunOptions = range($currentYear - 2, $currentYear + 2);

            return view('keuangan.master.mata-anggaran.create', compact('parentOptions', 'tahunOptions'));

        } catch (Exception $e) {
            Log::error('KeuanganMataAnggaran - Error in create form:', [
                'message' => $e->getMessage()
            ]);

            return back()->with('error', 'Terjadi kesalahan saat memuat form.');
        }
    }

    public function store(Request $request)
    {
        try {
            $validated = $request->validate([
                'kode_mata_anggaran' => 'required|string|max:20|unique:keuangan_mtang,kode_mata_anggaran',
                'nama_mata_anggaran' => 'required|string|max:255',
                'nama_mata_anggaran_en' => 'nullable|string|max:255',
                'deskripsi' => 'nullable|string',
                'parent_mata_anggaran' => 'nullable|uuid|exists:keuangan_mtang,id',
                'kategori' => 'nullable|string|max:100',
                'alokasi_anggaran' => 'nullable|numeric|min:0',
                'tahun_anggaran' => 'required|integer|min:2020|max:2030',
                'status_aktif' => 'boolean'
            ]);

            $validated['status_aktif'] = $request->has('status_aktif');
            $validated['sisa_anggaran'] = $validated['alokasi_anggaran'] ?? 0;

            $mataAnggaran = KeuanganMataAnggaran::create($validated);

            Log::info('KeuanganMataAnggaran - Created successfully:', [
                'id' => $mataAnggaran->id,
                'kode' => $mataAnggaran->kode_mata_anggaran,
                'user_id' => auth()->id()
            ]);

            return redirect()->route('keuangan.mata-anggaran.index')
                ->with('success', 'Mata anggaran berhasil ditambahkan.');

        } catch (Exception $e) {
            Log::error('KeuanganMataAnggaran - Error in store:', [
                'message' => $e->getMessage(),
                'request_data' => $request->all()
            ]);

            return back()->with('error', 'Terjadi kesalahan saat menyimpan mata anggaran.')
                ->withInput();
        }
    }

    public function show($id)
    {
        try {
            $mataAnggaran = KeuanganMataAnggaran::with([
                'parentMataAnggaran',
                'childMataAnggaran',
                'childrenRecursive'
            ])->findOrFail($id);

            return view('keuangan.master.mata-anggaran.show', compact('mataAnggaran'));

        } catch (Exception $e) {
            Log::error('KeuanganMataAnggaran - Error in show:', [
                'id' => $id,
                'message' => $e->getMessage()
            ]);

            return back()->with('error', 'Mata anggaran tidak ditemukan.');
        }
    }

    public function edit($id)
    {
        try {
            $mataAnggaran = KeuanganMataAnggaran::findOrFail($id);

            $parentOptions = KeuanganMataAnggaran::active()
                ->parents()
                ->where('id', '!=', $id)
                ->orderBy('kode_mata_anggaran')
                ->get();

            $currentYear = date('Y');
            $tahunOptions = range($currentYear - 2, $currentYear + 2);

            // FIXED: View path ke master folder
            return view('keuangan.master.mata-anggaran.edit', compact(
                'mataAnggaran', 'parentOptions', 'tahunOptions'
            ));

        } catch (Exception $e) {
            Log::error('KeuanganMataAnggaran - Error in edit form:', [
                'id' => $id,
                'message' => $e->getMessage()
            ]);

            return back()->with('error', 'Mata anggaran tidak ditemukan.');
        }
    }

    public function update(Request $request, $id)
    {
        try {
            $mataAnggaran = KeuanganMataAnggaran::findOrFail($id);

            $validated = $request->validate([
                'kode_mata_anggaran' => "required|string|max:20|unique:keuangan_mtang,kode_mata_anggaran,{$id}",
                'nama_mata_anggaran' => 'required|string|max:255',
                'nama_mata_anggaran_en' => 'nullable|string|max:255',
                'deskripsi' => 'nullable|string',
                'parent_mata_anggaran' => 'nullable|uuid|exists:keuangan_mtang,id',
                'kategori' => 'nullable|string|max:100',
                'alokasi_anggaran' => 'nullable|numeric|min:0',
                'tahun_anggaran' => 'required|integer|min:2020|max:2030',
                'status_aktif' => 'boolean'
            ]);

            $validated['status_aktif'] = $request->has('status_aktif');

            $mataAnggaran->update($validated);

            Log::info('KeuanganMataAnggaran - Updated successfully:', [
                'id' => $mataAnggaran->id,
                'kode' => $mataAnggaran->kode_mata_anggaran,
                'user_id' => auth()->id()
            ]);

            return redirect()->route('keuangan.mata-anggaran.index')
                ->with('success', 'Mata anggaran berhasil diperbarui.');

        } catch (Exception $e) {
            Log::error('KeuanganMataAnggaran - Error in update:', [
                'id' => $id,
                'message' => $e->getMessage(),
                'request_data' => $request->all()
            ]);

            return back()->with('error', 'Terjadi kesalahan saat memperbarui mata anggaran.')
                ->withInput();
        }
    }

    public function destroy($id)
    {
        try {
            $mataAnggaran = KeuanganMataAnggaran::findOrFail($id);

            if ($mataAnggaran->hasChildren()) {
                return back()->with('error', 'Tidak dapat menghapus mata anggaran yang memiliki sub mata anggaran.');
            }

            $kode = $mataAnggaran->kode_mata_anggaran;
            $mataAnggaran->delete();

            Log::info('KeuanganMataAnggaran - Deleted successfully:', [
                'id' => $id,
                'kode' => $kode,
                'user_id' => auth()->id()
            ]);

            return redirect()->route('keuangan.mata-anggaran.index')
                ->with('success', 'Mata anggaran berhasil dihapus.');

        } catch (Exception $e) {
            Log::error('KeuanganMataAnggaran - Error in destroy:', [
                'id' => $id,
                'message' => $e->getMessage()
            ]);

            return back()->with('error', 'Terjadi kesalahan saat menghapus mata anggaran.');
        }
    }
}
