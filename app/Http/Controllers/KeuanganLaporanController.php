<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Periode;
use App\Models\UnitKerja;
use App\Helpers\UnitKerjaHelper;
// use App\Exports\KeuanganLaporanExport;
// use Maatwebsite\Excel\Facades\Excel;
use Exception;

class KeuanganLaporanController extends Controller
{
    /**
     * Display the laporan index page
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        try {
            // Get current unit kerja from session (following BTQ pattern)
            $unitKerja = UnitKerja::with('childUnit')->where('id', session('selected_filter'))->first();

            // Get available periods (following BTQ pattern)
            $daftar_periode = Periode::orderBy('kode_periode', 'desc')->take(10)->get();

            return view('keuangan.laporan.index', [
                'daftar_periode' => $daftar_periode,
                'unitkerja' => $unitKerja,
            ]);
        } catch (Exception $e) {
            return back()->with('message', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    /**
     * Generate and download laporan
     *
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function printLaporan(Request $request)
    {
        try {
            $validated = $request->validate([
                'kode_periode' => 'required|string',
                'nama_laporan' => 'required|string',
                'programstudi' => 'required|array',
                'format_export' => 'required|string|in:excel,pdf'
            ]);

            // Get unit kerja names (following BTQ pattern)
            $unitKerjaNames = UnitKerjaHelper::getUnitKerjaNamesV1($request->programstudi);

            // Handle different report types
            switch ($request->nama_laporan) {
                case 'jurnal-pengeluaran':
                    return $this->generateJurnalPengeluaran($request, $unitKerjaNames);

                case 'jurnal-per-mata-anggaran':
                    return $this->generateJurnalPerMataAnggaran($request, $unitKerjaNames);

                case 'buku-besar':
                    return $this->generateBukuBesar($request, $unitKerjaNames);

                case 'buku-kas':
                    return $this->generateBukuKas($request, $unitKerjaNames);

                case 'pembayaran-tugas-akhir':
                    return $this->generatePembayaranTugasAkhir($request, $unitKerjaNames);

                case 'honor-koreksi':
                    return $this->generateHonorKoreksi($request, $unitKerjaNames);

                case 'honor-vakasi':
                    return $this->generateHonorVakasi($request, $unitKerjaNames);

                case 'pengeluaran-fakultas':
                    return $this->generatePengeluaranFakultas($request, $unitKerjaNames);

                default:
                    throw new Exception('Tipe laporan tidak dikenali');
            }

        } catch (Exception $e) {
            return back()->with('message', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    /**
     * Generate Jurnal Pengeluaran Report
     */
    private function generateJurnalPengeluaran($request, $unitKerjaNames)
    {
        // TODO: Implement actual data fetching
        $mockData = $this->getMockJurnalPengeluaran();

        if ($request->format_export === 'excel') {
            // return Excel::download(new KeuanganJurnalPengeluaranExport($mockData), 'jurnal-pengeluaran.xlsx');
            return response()->json(['message' => 'Excel export belum diimplementasi'], 501);
        }

        return $this->generatePDF('jurnal-pengeluaran', $mockData, $request);
    }

    /**
     * Generate Jurnal Per Mata Anggaran Report
     */
    private function generateJurnalPerMataAnggaran($request, $unitKerjaNames)
    {
        // TODO: Implement actual data fetching
        $mockData = $this->getMockJurnalPerMataAnggaran();

        if ($request->format_export === 'excel') {
            return response()->json(['message' => 'Excel export belum diimplementasi'], 501);
        }

        return $this->generatePDF('jurnal-per-mata-anggaran', $mockData, $request);
    }

    /**
     * Generate Buku Besar Report
     */
    private function generateBukuBesar($request, $unitKerjaNames)
    {
        // TODO: Implement actual data fetching
        $mockData = $this->getMockBukuBesar();

        if ($request->format_export === 'excel') {
            return response()->json(['message' => 'Excel export belum diimplementasi'], 501);
        }

        return $this->generatePDF('buku-besar', $mockData, $request);
    }

    /**
     * Generate Buku Kas Report
     */
    private function generateBukuKas($request, $unitKerjaNames)
    {
        // TODO: Implement actual data fetching
        $mockData = $this->getMockBukuKas();

        if ($request->format_export === 'excel') {
            return response()->json(['message' => 'Excel export belum diimplementasi'], 501);
        }

        return $this->generatePDF('buku-kas', $mockData, $request);
    }

    /**
     * Generate Pembayaran Tugas Akhir Report
     */
    private function generatePembayaranTugasAkhir($request, $unitKerjaNames)
    {
        // TODO: Implement actual data fetching
        $mockData = $this->getMockPembayaranTugasAkhir();

        if ($request->format_export === 'excel') {
            return response()->json(['message' => 'Excel export belum diimplementasi'], 501);
        }

        return $this->generatePDF('pembayaran-tugas-akhir', $mockData, $request);
    }

    /**
     * Generate Honor Koreksi Report
     */
    private function generateHonorKoreksi($request, $unitKerjaNames)
    {
        // TODO: Implement actual data fetching
        $mockData = $this->getMockHonorKoreksi();

        if ($request->format_export === 'excel') {
            return response()->json(['message' => 'Excel export belum diimplementasi'], 501);
        }

        return $this->generatePDF('honor-koreksi', $mockData, $request);
    }

    /**
     * Generate Honor Vakasi Report
     */
    private function generateHonorVakasi($request, $unitKerjaNames)
    {
        // TODO: Implement actual data fetching
        $mockData = $this->getMockHonorVakasi();

        if ($request->format_export === 'excel') {
            return response()->json(['message' => 'Excel export belum diimplementasi'], 501);
        }

        return $this->generatePDF('honor-vakasi', $mockData, $request);
    }

    /**
     * Generate Pengeluaran Fakultas Report
     */
    private function generatePengeluaranFakultas($request, $unitKerjaNames)
    {
        // TODO: Implement actual data fetching
        $mockData = $this->getMockPengeluaranFakultas();

        if ($request->format_export === 'excel') {
            return response()->json(['message' => 'Excel export belum diimplementasi'], 501);
        }

        return $this->generatePDF('pengeluaran-fakultas', $mockData, $request);
    }

    /**
     * Generate PDF report
     */
    private function generatePDF($reportType, $data, $request)
    {
        // TODO: Implement PDF generation using DomPDF or similar
        return response()->json([
            'message' => "PDF untuk laporan {$reportType} belum diimplementasi",
            'data' => $data,
            'request' => $request->all()
        ], 501);
    }

    /**
     * Mock data methods - replace with actual database queries
     */
    private function getMockJurnalPengeluaran()
    {
        return [
            'title' => 'JURNAL PENGELUARAN ANGGARAN PROGRAM Reguler Pagi',
            'periode' => 'sampai',
            'total' => 'Rp 345.000.000',
            'data' => [
                [
                    'no' => 1,
                    'kwitansi' => 'P.2507.001',
                    'tanggal' => '01-07-2025',
                    'uraian' => 'Bantuan Pengobatan Dede Suherman anak dari bapak Rohman',
                    'jumlah' => 'Rp 6.400.000'
                ],
                // Add more mock data...
            ]
        ];
    }

    private function getMockJurnalPerMataAnggaran()
    {
        return [
            'title' => 'JURNAL PENGELUARAN ANGGARAN PROGRAM Reguler Pagi',
            'periode' => 'sampai',
            'mata_anggaran' => '1.2(Pendanaan Kegiatan Implementasi Visi dan Misi)',
            'total' => 'Rp 4.503.250',
            'data' => [
                [
                    'no' => 1,
                    'kwitansi' => 'P.2507.030',
                    'tanggal' => '04-07-2025',
                    'uraian' => 'Transport Kegiatan Festival Harmoni IIKU Unpas sabtu, 14 Juni 2025',
                    'jumlah' => 'Rp 3.300.000'
                ],
                // Add more mock data...
            ]
        ];
    }

    private function getMockBukuBesar()
    {
        return [
            'title' => 'BUKU BESAR',
            'periode' => 'sampai',
            'data' => []
        ];
    }

    private function getMockBukuKas()
    {
        return [
            'title' => 'BUKTI PENGELUARAN KAS',
            'nomor' => 'P.2507.001',
            'data' => [
                'sudah_terima' => 'Fakultas Teknik Universitas Pasundan',
                'uang_sebanyak' => 'DUA RATUS RIBU RUPIAH',
                'untuk_pembayaran' => 'Bantuan Pengobatan Dede Suherman anak dari bapak Rohman'
            ]
        ];
    }

    private function getMockPembayaranTugasAkhir()
    {
        return [
            'title' => 'LAPORAN PEMBAYARAN TUGAS AKHIR',
            'tanggal' => '12-10-2023',
            'total' => 'Rp 1.200.000',
            'data' => [
                [
                    'no' => 1,
                    'npm' => '223040038',
                    'nama' => 'Lisvindanu',
                    'program_studi' => 'Teknik Informatika',
                    'periode' => '20201',
                    'jumlah' => 'Rp 300.000'
                ],
                // Add more mock data...
            ]
        ];
    }

    private function getMockHonorKoreksi()
    {
        return [
            'title' => 'LAPORAN HONOR KOREKSI',
            'periode' => 'Juli 2025',
            'data' => []
        ];
    }

    private function getMockHonorVakasi()
    {
        return [
            'title' => 'LAPORAN HONOR VAKASI',
            'periode' => 'Juli 2025',
            'data' => []
        ];
    }

    private function getMockPengeluaranFakultas()
    {
        return [
            'title' => 'PENGELUARAN FAKULTAS PERIODE',
            'periode' => 'Juli 2025',
            'data' => []
        ];
    }
}
