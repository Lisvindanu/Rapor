<?php

namespace App\Http\Controllers;

use App\Models\KeuanganMataAnggaran;
use App\Helpers\KeuanganValidationHelper;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Exception;

class KeuanganMataAnggaranController extends Controller
{
    public function index(Request $request)
    {
        try {
            $this->logRequest($request);

            $availableYears = $this->getAvailableYears();
            $query = $this->buildQuery($request, $availableYears);
            $perPage = $this->validatePerPage($request);

            $mataAnggarans = $query->orderBy('kode_mata_anggaran')
                ->paginate($perPage)
                ->withQueryString();

            $data = $this->prepareViewData($request, $mataAnggarans, $availableYears);

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
            $parentOptions = KeuanganMataAnggaran::active()
                ->parents()
                ->orderBy('kode_mata_anggaran')
                ->get();

            $tahunOptions = range(date('Y') - 2, date('Y') + 2);

            return view('keuangan.master.mata-anggaran.create', compact('parentOptions', 'tahunOptions'));

        } catch (Exception $e) {
            Log::error('KeuanganMataAnggaran - Error in create:', ['message' => $e->getMessage()]);
            return back()->with('error', 'Terjadi kesalahan saat memuat form.');
        }
    }

    public function store(Request $request)
    {
        try {
            // Clean and prepare data using helper
            $cleanData = KeuanganValidationHelper::prepareMataAnggaranData($request);
            $request->merge($cleanData);

            // Validate
            $validated = $request->validate(
                KeuanganValidationHelper::getMataAnggaranRules(),
                KeuanganValidationHelper::getMessages()
            );

            // Set defaults
            $parent = $validated['parent_mata_anggaran']
                ? KeuanganMataAnggaran::find($validated['parent_mata_anggaran'])
                : null;

            $validated = KeuanganValidationHelper::setMataAnggaranDefaults($validated, $parent);

            $mataAnggaran = KeuanganMataAnggaran::create($validated);

            Log::info('KeuanganMataAnggaran - Created:', [
                'id' => $mataAnggaran->id,
                'kode' => $mataAnggaran->kode_mata_anggaran
            ]);

            return redirect()->route('keuangan.mata-anggaran.index')
                ->with('success', 'Mata anggaran berhasil ditambahkan.');

        } catch (Exception $e) {
            Log::error('Store error:', [
                'message' => $e->getMessage(),
                'line' => $e->getLine()
            ]);

            return back()->with('error', 'Error: ' . $e->getMessage())->withInput();
        }
    }

    public function show($id)
    {
        try {
            $mataAnggaran = KeuanganMataAnggaran::with([
                'parentMataAnggaran', 'childMataAnggaran', 'childrenRecursive'
            ])->findOrFail($id);

            return view('keuangan.master.mata-anggaran.show', compact('mataAnggaran'));

        } catch (Exception $e) {
            Log::error('KeuanganMataAnggaran - Show error:', ['id' => $id, 'message' => $e->getMessage()]);
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
            $tahunOptions = range(date('Y') - 2, date('Y') + 2);

            return view('keuangan.master.mata-anggaran.edit', compact(
                'mataAnggaran', 'parentOptions', 'tahunOptions'
            ));

        } catch (Exception $e) {
            Log::error('KeuanganMataAnggaran - Edit error:', ['id' => $id, 'message' => $e->getMessage()]);
            return back()->with('error', 'Mata anggaran tidak ditemukan.');
        }
    }

    public function update(Request $request, $id)
    {
        try {
            $mataAnggaran = KeuanganMataAnggaran::findOrFail($id);

            // Clean and prepare data
            $cleanData = KeuanganValidationHelper::prepareMataAnggaranData($request);
            $request->merge($cleanData);

            $validated = $request->validate(
                KeuanganValidationHelper::getMataAnggaranRules($id),
                KeuanganValidationHelper::getMessages()
            );

            $mataAnggaran->update($validated);

            Log::info('KeuanganMataAnggaran - Updated:', [
                'id' => $id, 'kode' => $mataAnggaran->kode_mata_anggaran
            ]);

            return redirect()->route('keuangan.mata-anggaran.index')
                ->with('success', 'Mata anggaran berhasil diperbarui.');

        } catch (Exception $e) {
            Log::error('KeuanganMataAnggaran - Update error:', ['id' => $id, 'message' => $e->getMessage()]);
            return back()->with('error', 'Terjadi kesalahan saat memperbarui mata anggaran.')->withInput();
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

            Log::info('KeuanganMataAnggaran - Deleted:', ['id' => $id, 'kode' => $kode]);

            return redirect()->route('keuangan.mata-anggaran.index')
                ->with('success', 'Mata anggaran berhasil dihapus.');

        } catch (Exception $e) {
            Log::error('KeuanganMataAnggaran - Delete error:', ['id' => $id, 'message' => $e->getMessage()]);
            return back()->with('error', 'Terjadi kesalahan saat menghapus mata anggaran.');
        }
    }

    // Private helper methods
    private function logRequest(Request $request)
    {
        Log::info('KeuanganMataAnggaran - Index accessed', [
            'user_id' => auth()->id(),
            'search' => $request->search ?? 'none',
            'tahun_anggaran' => $request->tahun_anggaran ?? 'none'
        ]);
    }

    private function getAvailableYears()
    {
        return KeuanganMataAnggaran::active()
            ->distinct()
            ->orderBy('tahun_anggaran', 'desc')
            ->pluck('tahun_anggaran')
            ->toArray();
    }

    private function buildQuery(Request $request, array $availableYears)
    {
        $query = KeuanganMataAnggaran::with(['parentMataAnggaran'])->active();

        if ($request->filled('search')) {
            $search = trim($request->search);
            $query->where(function ($q) use ($search) {
                $q->where('kode_mata_anggaran', 'ilike', "%{$search}%")
                    ->orWhere('nama_mata_anggaran', 'ilike', "%{$search}%")
                    ->orWhere('deskripsi', 'ilike', "%{$search}%");
            });
        }

        if ($request->filled('tahun_anggaran') && in_array((int)$request->tahun_anggaran, $availableYears)) {
            $query->where('tahun_anggaran', (int)$request->tahun_anggaran);
        }

        return $query;
    }

    private function validatePerPage(Request $request)
    {
        $perPage = $request->get('per_page', 15);
        return in_array((int)$perPage, [10, 15, 25, 50, 100]) ? $perPage : 15;
    }

    private function prepareViewData(Request $request, $mataAnggarans, array $availableYears)
    {
        $selectedYear = $request->filled('tahun_anggaran') &&
        in_array((int)$request->tahun_anggaran, $availableYears) ?
            (int)$request->tahun_anggaran : null;

        $emptyMessage = 'Belum ada data mata anggaran.';
        if ($selectedYear) {
            $emptyMessage = "Tidak ada data mata anggaran untuk tahun {$selectedYear}.";
        } elseif ($request->filled('search')) {
            $emptyMessage = "Tidak ditemukan data yang sesuai dengan pencarian '{$request->search}'.";
        }

        return [
            'mataAnggarans' => $mataAnggarans,
            'availableYears' => $availableYears,
            'selectedYear' => $selectedYear,
            'emptyMessage' => $emptyMessage
        ];
    }
}
