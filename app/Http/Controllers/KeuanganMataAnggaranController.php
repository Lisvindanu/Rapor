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
            $this->logRequest($request);

            $availableYears = $this->getAvailableYears();
            $query = $this->buildQuery($request, $availableYears);
            $perPage = $this->validatePerPage($request);

            // Quick fix: Check if page is beyond available data
            $totalRecords = $query->count();
            $requestedPage = max(1, (int) $request->get('page', 1));
            $maxPage = max(1, (int) ceil($totalRecords / $perPage));

            // Redirect to valid page if needed
            if ($requestedPage > $maxPage && $totalRecords > 0) {
                $params = $request->query();
                $params['page'] = $maxPage;
                return redirect()->route('keuangan.mata-anggaran.index', $params);
            }

            $mataAnggarans = $query->orderBy('kode_mata_anggaran')
                ->paginate($perPage)
                ->withQueryString();

            $data = $this->prepareViewData($request, $mataAnggarans, $availableYears);
            $this->logResults($mataAnggarans, $availableYears, $data['selectedYear']);

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
            $validated = $this->validateMataAnggaran($request);
            $validated['status_aktif'] = $request->has('status_aktif');
            $validated['sisa_anggaran'] = $validated['alokasi_anggaran'] ?? 0;

            $mataAnggaran = KeuanganMataAnggaran::create($validated);

            Log::info('KeuanganMataAnggaran - Created:', [
                'id' => $mataAnggaran->id,
                'kode' => $mataAnggaran->kode_mata_anggaran
            ]);

            return redirect()->route('keuangan.mata-anggaran.index')
                ->with('success', 'Mata anggaran berhasil ditambahkan.');

        } catch (Exception $e) {
            Log::error('KeuanganMataAnggaran - Store error:', ['message' => $e->getMessage()]);
            return back()->with('error', 'Terjadi kesalahan saat menyimpan mata anggaran.')->withInput();
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
            $validated = $this->validateMataAnggaran($request, $id);
            $validated['status_aktif'] = $request->has('status_aktif');

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
            'tahun_anggaran' => $request->tahun_anggaran ?? 'none',
            'per_page' => $request->per_page ?? 'default'
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

        // Search filter
        if ($request->filled('search')) {
            $query = $this->applySearchFilter($query, $request->search);
        }

        // Year filter
        if ($request->filled('tahun_anggaran') && $request->tahun_anggaran !== '') {
            $this->applyYearFilter($query, $request, $availableYears);
        }

        return $query;
    }

    private function applySearchFilter($query, $search)
    {
        $search = trim(preg_replace('/\s+/', ' ', $search));
        $searchTerms = array_filter(explode(' ', $search));

        return $query->where(function ($q) use ($searchTerms, $search) {
            $q->where('kode_mata_anggaran', 'ilike', "%{$search}%")
                ->orWhere('nama_mata_anggaran', 'ilike', "%{$search}%")
                ->orWhere('deskripsi', 'ilike', "%{$search}%")
                ->orWhere('kategori', 'ilike', "%{$search}%");

            if (count($searchTerms) > 1) {
                $q->orWhere(function ($subQuery) use ($searchTerms) {
                    foreach ($searchTerms as $term) {
                        $subQuery->where(function ($termQuery) use ($term) {
                            $termQuery->where('kode_mata_anggaran', 'ilike', "%{$term}%")
                                ->orWhere('nama_mata_anggaran', 'ilike', "%{$term}%");
                        });
                    }
                });
            }

            $q->orWhereHas('parentMataAnggaran', function ($parentQuery) use ($search) {
                $parentQuery->where('kode_mata_anggaran', 'ilike', "%{$search}%")
                    ->orWhere('nama_mata_anggaran', 'ilike', "%{$search}%");
            });
        });
    }

    private function applyYearFilter($query, Request $request, array $availableYears)
    {
        $tahun = (int) $request->tahun_anggaran;

        if (in_array($tahun, $availableYears)) {
            $query->where('tahun_anggaran', $tahun);
        } else {
            session()->flash('warning', "Data untuk tahun {$tahun} tidak ditemukan. Menampilkan semua data.");
        }
    }

    private function validatePerPage(Request $request)
    {
        $perPage = $request->get('per_page', 15);
        $allowedPerPage = [10, 15, 25, 50, 100];
        return in_array((int)$perPage, $allowedPerPage) ? $perPage : 15;
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

    private function logResults($mataAnggarans, array $availableYears, $selectedYear)
    {
        Log::info('Query results', [
            'total' => $mataAnggarans->total(),
            'current_page' => $mataAnggarans->currentPage(),
            'per_page' => $mataAnggarans->perPage(),
            'available_years' => $availableYears,
            'selected_year' => $selectedYear
        ]);
    }

    private function validateMataAnggaran(Request $request, $id = null)
    {
        $uniqueRule = $id ? "unique:keuangan_mtang,kode_mata_anggaran,{$id}" : 'unique:keuangan_mtang,kode_mata_anggaran';

        return $request->validate([
            'kode_mata_anggaran' => "required|string|max:20|{$uniqueRule}",
            'nama_mata_anggaran' => 'required|string|max:255',
            'nama_mata_anggaran_en' => 'nullable|string|max:255',
            'deskripsi' => 'nullable|string',
            'parent_mata_anggaran' => 'nullable|uuid|exists:keuangan_mtang,id',
            'kategori' => 'nullable|string|max:100',
            'alokasi_anggaran' => 'nullable|numeric|min:0',
            'tahun_anggaran' => 'required|integer|min:2020|max:2030',
            'status_aktif' => 'boolean'
        ]);
    }
}
