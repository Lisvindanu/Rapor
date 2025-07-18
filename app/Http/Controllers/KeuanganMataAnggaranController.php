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
            $this->logRequest($request);

            $query = $this->buildQuery($request);
            $perPage = $this->validatePerPage($request);

            $mataAnggarans = $query->orderBy('kode_mata_anggaran')
                ->paginate($perPage)
                ->withQueryString();

            $data = $this->prepareViewData($request, $mataAnggarans);

            return view('keuangan.master.mata-anggaran.index', $data);

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
            $parentOptions = KeuanganMataAnggaran::parents()
                ->orderBy('kode_mata_anggaran')
                ->get();

            return view('keuangan.master.mata-anggaran.create', compact('parentOptions'));

        } catch (Exception $e) {
            Log::error('KeuanganMataAnggaran - Error in create:', ['message' => $e->getMessage()]);
            return back()->with('error', 'Terjadi kesalahan saat memuat form.');
        }
    }

    public function store(Request $request)
    {
        try {
            $rules = KeuanganValidationHelper::getMataAnggaranRules();
            $messages = KeuanganValidationHelper::getMessages();

            $request->validate($rules, $messages);

            // Validasi parent-child relationship
            if ($request->parent_mata_anggaran) {
                if (!KeuanganValidationHelper::validateParentChild($request->parent_mata_anggaran)) {
                    return back()->withErrors(['parent_mata_anggaran' => 'Parent tidak valid'])
                        ->withInput();
                }
            }

            DB::beginTransaction();

            $data = $request->only([
                'kode_mata_anggaran',
                'nama_mata_anggaran',
                'parent_mata_anggaran',
                'kategori'
            ]);

            $data['kode_mata_anggaran'] = KeuanganValidationHelper::formatKodeMataAnggaran($data['kode_mata_anggaran']);

            $mataAnggaran = KeuanganMataAnggaran::create($data);

            DB::commit();

            Log::info('KeuanganMataAnggaran - Created:', [
                'id' => $mataAnggaran->id,
                'kode' => $mataAnggaran->kode_mata_anggaran
            ]);

            return redirect()->route('keuangan.mata-anggaran.index')
                ->with('success', 'Mata anggaran berhasil ditambahkan');

        } catch (Exception $e) {
            DB::rollBack();
            Log::error('KeuanganMataAnggaran - Store error:', [
                'message' => $e->getMessage(),
                'line' => $e->getLine()
            ]);
            return back()->withErrors(['error' => 'Gagal menyimpan data: ' . $e->getMessage()])
                ->withInput();
        }
    }

    public function show($id)
    {
        $mataAnggaran = KeuanganMataAnggaran::with(['parentMataAnggaran', 'childMataAnggaran'])
            ->findOrFail($id);

        return view('keuangan.master.mata-anggaran.show', compact('mataAnggaran'));
    }

    public function edit($id)
    {
        try {
            $mataAnggaran = KeuanganMataAnggaran::findOrFail($id);

            $parentOptions = KeuanganMataAnggaran::parents()
                ->where('id', '!=', $id)
                ->orderBy('kode_mata_anggaran')
                ->get();

            return view('keuangan.master.mata-anggaran.edit', compact('mataAnggaran', 'parentOptions'));

        } catch (Exception $e) {
            Log::error('KeuanganMataAnggaran - Edit error:', ['id' => $id, 'message' => $e->getMessage()]);
            return back()->with('error', 'Mata anggaran tidak ditemukan.');
        }
    }

    public function update(Request $request, $id)
    {
        try {
            $mataAnggaran = KeuanganMataAnggaran::findOrFail($id);

            $rules = KeuanganValidationHelper::getMataAnggaranRules($id);
            $messages = KeuanganValidationHelper::getMessages();

            $request->validate($rules, $messages);

            // Validasi parent-child relationship
            if ($request->parent_mata_anggaran) {
                if (!KeuanganValidationHelper::validateParentChild($request->parent_mata_anggaran, $id)) {
                    return back()->withErrors(['parent_mata_anggaran' => 'Parent tidak valid'])
                        ->withInput();
                }
            }

            DB::beginTransaction();

            $data = $request->only([
                'kode_mata_anggaran',
                'nama_mata_anggaran',
                'parent_mata_anggaran',
                'kategori'
            ]);

            $data['kode_mata_anggaran'] = KeuanganValidationHelper::formatKodeMataAnggaran($data['kode_mata_anggaran']);

            $mataAnggaran->update($data);

            DB::commit();

            Log::info('KeuanganMataAnggaran - Updated:', [
                'id' => $id, 'kode' => $mataAnggaran->kode_mata_anggaran
            ]);

            return redirect()->route('keuangan.mata-anggaran.index')
                ->with('success', 'Mata anggaran berhasil diperbarui');

        } catch (Exception $e) {
            DB::rollBack();
            Log::error('KeuanganMataAnggaran - Update error:', ['id' => $id, 'message' => $e->getMessage()]);
            return back()->withErrors(['error' => 'Gagal memperbarui data: ' . $e->getMessage()])
                ->withInput();
        }
    }

    public function destroy($id)
    {
        try {
            $mataAnggaran = KeuanganMataAnggaran::findOrFail($id);

            // Cek apakah masih memiliki child
            if ($mataAnggaran->hasChildren()) {
                return back()->with('error', 'Tidak dapat menghapus mata anggaran yang masih memiliki sub mata anggaran');
            }

            DB::beginTransaction();

            $kode = $mataAnggaran->kode_mata_anggaran;
            $mataAnggaran->delete();

            DB::commit();

            Log::info('KeuanganMataAnggaran - Deleted:', ['id' => $id, 'kode' => $kode]);

            return redirect()->route('keuangan.mata-anggaran.index')
                ->with('success', 'Mata anggaran berhasil dihapus');

        } catch (Exception $e) {
            DB::rollBack();
            Log::error('KeuanganMataAnggaran - Delete error:', ['id' => $id, 'message' => $e->getMessage()]);
            return back()->with('error', 'Terjadi kesalahan saat menghapus mata anggaran');
        }
    }

    // Private helper methods
    private function logRequest(Request $request)
    {
        Log::info('KeuanganMataAnggaran - Index accessed', [
            'user_id' => auth()->id(),
            'search' => $request->search ?? 'none',
            'kategori' => $request->kategori ?? 'none'
        ]);
    }

    private function buildQuery(Request $request)
    {
        $query = KeuanganMataAnggaran::with(['parentMataAnggaran', 'childMataAnggaran']);

        if ($request->filled('search')) {
            $search = trim($request->search);
            $query->where(function ($q) use ($search) {
                $q->where('kode_mata_anggaran', 'ilike', "%{$search}%")
                    ->orWhere('nama_mata_anggaran', 'ilike', "%{$search}%");
            });
        }

        if ($request->filled('kategori')) {
            $query->where('kategori', $request->kategori);
        }

        // Show only parent mata anggaran by default, unless searching
        if (!$request->filled('search')) {
            $query->parents();
        }

        return $query;
    }

    private function validatePerPage(Request $request)
    {
        $perPage = $request->get('per_page', 15);
        return in_array((int)$perPage, [10, 15, 25, 50, 100]) ? $perPage : 15;
    }

    private function prepareViewData(Request $request, $mataAnggarans)
    {
        $emptyMessage = 'Belum ada data mata anggaran.';

        if ($request->filled('kategori')) {
            $kategori = $request->kategori;
            $emptyMessage = "Tidak ada data mata anggaran untuk kategori {$kategori}.";
        }

        if ($request->filled('search')) {
            $emptyMessage = "Tidak ditemukan data yang sesuai dengan pencarian '{$request->search}'.";
        }

        return [
            'mataAnggarans' => $mataAnggarans,
            'emptyMessage' => $emptyMessage
        ];
    }
}
