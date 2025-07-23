<?php

namespace App\Http\Controllers;

use App\Models\KeuanganPengeluaran;
use App\Models\KeuanganMataAnggaran;
use App\Models\KeuanganProgram;
use App\Models\KeuanganSumberDana;
use App\Models\KeuanganTahunAnggaran;
use App\Models\KeuanganTandaTangan;
use App\Helpers\KeuanganPengeluaranValidationHelper;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Exception;

class KeuanganPengeluaranController extends Controller
{
    public function index(Request $request)
    {
        $pengeluarans = KeuanganPengeluaran::with(['mataAnggaran', 'program', 'penerima'])
            ->when($request->search, function ($query, $search) {
                return $query->where('nomor_bukti', 'ILIKE', "%{$search}%")
                    ->orWhere('sudah_terima_dari', 'ILIKE', "%{$search}%");
            })
            ->when($request->status, fn($query, $status) => $query->byStatus($status))
            ->when($request->mata_anggaran_id, fn($query, $id) => $query->where('mata_anggaran_id', $id))
            ->orderBy('created_at', 'desc')
            ->paginate(15);

        $filterOptions = $this->getFilterOptions();

        return view('keuangan.transaksi.pengeluaran.index', compact('pengeluarans', 'filterOptions'));
    }

    public function create()
    {
        $tahunAktif = KeuanganTahunAnggaran::where('is_active', true)->first();

        if (!$tahunAktif) {
            return back()->with('error', 'Tidak ada tahun anggaran aktif.');
        }

        $formOptions = $this->getFormOptions();
        $formOptions['tahunAktif'] = $tahunAktif;

        return view('keuangan.transaksi.pengeluaran.create', compact('formOptions'));
    }

    // NEW: AJAX Create - untuk modal
    public function createModal()
    {
        $tahunAktif = KeuanganTahunAnggaran::where('is_active', true)->first();

        if (!$tahunAktif) {
            return response()->json(['error' => 'Tidak ada tahun anggaran aktif.'], 400);
        }

        $formOptions = $this->getFormOptions();
        $formOptions['tahunAktif'] = $tahunAktif;

        return response()->json([
            'success' => true,
            'formOptions' => $formOptions
        ]);
    }

    public function store(Request $request)
    {
        $request->validate(
            KeuanganPengeluaranValidationHelper::getPengeluaranRules(),
            KeuanganPengeluaranValidationHelper::getMessages()
        );

        DB::beginTransaction();
        try {
            $pengeluaran = KeuanganPengeluaran::create($request->all());
            DB::commit();

            // Check if AJAX request for modal
            if ($request->ajax()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Bukti pengeluaran kas berhasil dibuat.',
                    'data' => $pengeluaran->load(['mataAnggaran', 'program', 'penerima'])
                ]);
            }

            return redirect()->route('keuangan.pengeluaran.show', $pengeluaran->id)
                ->with('message', 'Bukti pengeluaran kas berhasil dibuat.');
        } catch (Exception $e) {
            DB::rollBack();

            if ($request->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Gagal menyimpan: ' . $e->getMessage()
                ], 500);
            }

            return back()->with('error', 'Gagal menyimpan: ' . $e->getMessage())->withInput();
        }
    }

    public function show($id)
    {
        $pengeluaran = KeuanganPengeluaran::with([
            'mataAnggaran', 'program', 'sumberDana', 'tahunAnggaran',
            'dekan', 'wakilDekanII', 'ksbKeuangan', 'penerima'
        ])->findOrFail($id);

        return view('keuangan.transaksi.pengeluaran.show', compact('pengeluaran'));
    }

    public function edit($id)
    {
        $pengeluaran = KeuanganPengeluaran::findOrFail($id);

        if (!$pengeluaran->canBeEdited()) {
            return back()->with('error', 'Data tidak dapat diedit pada status ini.');
        }

        $formOptions = $this->getFormOptions();

        return view('keuangan.transaksi.pengeluaran.edit', compact('pengeluaran', 'formOptions'));
    }

    // NEW: AJAX Edit - untuk modal
    public function editModal($id)
    {
        $pengeluaran = KeuanganPengeluaran::findOrFail($id);

        if (!$pengeluaran->canBeEdited()) {
            return response()->json(['error' => 'Data tidak dapat diedit pada status ini.'], 400);
        }

        $formOptions = $this->getFormOptions();

        return response()->json([
            'success' => true,
            'data' => $pengeluaran,
            'formOptions' => $formOptions
        ]);
    }

    public function update(Request $request, $id)
    {
        $pengeluaran = KeuanganPengeluaran::findOrFail($id);

        if (!$pengeluaran->canBeEdited()) {
            if ($request->ajax()) {
                return response()->json(['error' => 'Data tidak dapat diedit pada status ini.'], 400);
            }
            return back()->with('error', 'Data tidak dapat diedit pada status ini.');
        }

        $request->validate(
            KeuanganPengeluaranValidationHelper::getPengeluaranRules($id),
            KeuanganPengeluaranValidationHelper::getMessages()
        );

        DB::beginTransaction();
        try {
            $pengeluaran->update($request->all());
            DB::commit();

            // Check if AJAX request for modal
            if ($request->ajax()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Bukti pengeluaran kas berhasil diperbarui.',
                    'data' => $pengeluaran->load(['mataAnggaran', 'program', 'penerima'])
                ]);
            }

            return redirect()->route('keuangan.pengeluaran.show', $pengeluaran->id)
                ->with('message', 'Bukti pengeluaran kas berhasil diperbarui.');
        } catch (Exception $e) {
            DB::rollBack();

            if ($request->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Gagal memperbarui: ' . $e->getMessage()
                ], 500);
            }

            return back()->with('error', 'Gagal memperbarui: ' . $e->getMessage())->withInput();
        }
    }

    public function destroy($id)
    {
        $pengeluaran = KeuanganPengeluaran::findOrFail($id);

        if (!$pengeluaran->canBeDeleted()) {
            return response()->json(['message' => 'Data tidak dapat dihapus pada status ini.'], 400);
        }

        DB::beginTransaction();
        try {
            $pengeluaran->delete();
            DB::commit();
            return response()->json(['message' => 'Bukti pengeluaran kas berhasil dihapus.']);
        } catch (Exception $e) {
            DB::rollBack();
            return response()->json(['message' => 'Gagal menghapus: ' . $e->getMessage()], 500);
        }
    }

    public function print($id)
    {
        $pengeluaran = KeuanganPengeluaran::with([
            'mataAnggaran', 'program', 'sumberDana', 'tahunAnggaran',
            'dekan', 'wakilDekanII', 'ksbKeuangan', 'penerima'
        ])->findOrFail($id);

        return view('keuangan.transaksi.pengeluaran.print', compact('pengeluaran'));
    }

    public function pdf($id)
    {
        $pengeluaran = KeuanganPengeluaran::with([
            'mataAnggaran', 'program', 'sumberDana', 'tahunAnggaran',
            'dekan', 'wakilDekanII', 'ksbKeuangan', 'penerima'
        ])->findOrFail($id);

        $pdf = app('dompdf.wrapper');
        $pdf->loadView('keuangan.transaksi.pengeluaran.pdf', compact('pengeluaran'));
        $pdf->setPaper('A4', 'portrait');

        return $pdf->download('Bukti_Pengeluaran_' . $pengeluaran->nomor_bukti . '.pdf');
    }

    private function getFormOptions()
    {
        return [
            'mataAnggarans' => KeuanganMataAnggaran::orderBy('kode_mata_anggaran')->get(),
            'programs' => KeuanganProgram::orderBy('nama_program')->get(),
            'sumberDanas' => KeuanganSumberDana::orderBy('nama_sumber_dana')->get(),
            'tandaTangans' => KeuanganTandaTangan::orderBy('nama')->get(),
            'statusOptions' => [
                'draft' => 'Draft',
                'pending' => 'Menunggu Persetujuan',
                'approved' => 'Disetujui',
                'rejected' => 'Ditolak',
                'paid' => 'Dibayar'
            ]
        ];
    }

    private function getFilterOptions()
    {
        return [
            'mataAnggarans' => KeuanganMataAnggaran::orderBy('kode_mata_anggaran')->get(),
            'programs' => KeuanganProgram::orderBy('nama_program')->get(),
            'statusOptions' => [
                'draft' => 'Draft',
                'pending' => 'Menunggu Persetujuan',
                'approved' => 'Disetujui',
                'rejected' => 'Ditolak',
                'paid' => 'Dibayar'
            ]
        ];
    }
}
