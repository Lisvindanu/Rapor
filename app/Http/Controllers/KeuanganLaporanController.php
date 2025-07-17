<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Periode;
use App\Models\UnitKerja;
use App\Helpers\UnitKerjaHelper;
use Exception;
use Illuminate\Support\Facades\Log;

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

            // Enhanced debugging
            Log::info('KeuanganLaporan - Session Data:', [
                'selected_filter' => session('selected_filter'),
                'unit_kerja_found' => $unitKerja ? true : false,
                'unit_kerja_id' => $unitKerja ? $unitKerja->id : null,
                'unit_kerja_nama' => $unitKerja ? $unitKerja->nama_unit : null,
                'child_count' => $unitKerja && $unitKerja->childUnit ? $unitKerja->childUnit->count() : 0
            ]);

            // Check if unit kerja exists - provide fallback
            if (!$unitKerja) {
                // Try to get any available unit kerja as fallback
                $unitKerja = UnitKerja::with('childUnit')
                    ->whereIn('jenis_unit', ['FAKULTAS', 'Program Studi'])
                    ->first();

                if ($unitKerja) {
                    Log::warning('Using fallback unit kerja:', ['id' => $unitKerja->id, 'nama' => $unitKerja->nama_unit]);
                } else {
                    return back()->with('error', 'Unit kerja tidak ditemukan. Silakan pilih unit kerja terlebih dahulu melalui menu profil.');
                }
            }

            // Get available periods
            $daftar_periode = Periode::orderBy('kode_periode', 'desc')->take(10)->get();

            // Log periode data for debugging
            Log::info('KeuanganLaporan - Periode Data:', [
                'count' => $daftar_periode->count(),
                'first_periode' => $daftar_periode->first() ? $daftar_periode->first()->kode_periode : null
            ]);

            return view('keuangan.laporan.index', [
                'daftar_periode' => $daftar_periode,
                'unitkerja' => $unitKerja,
            ]);

        } catch (Exception $e) {
            Log::error('KeuanganLaporan - Error in index:', [
                'message' => $e->getMessage(),
                'file' => $e->getFile(),
                'line' => $e->getLine(),
                'session_data' => session()->all()
            ]);

            return back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
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
            // Enhanced validation - FIXED for single select
            $validated = $request->validate([
                'kode_periode' => 'required|string',
                'nama_laporan' => 'required|string',
                'programstudi' => 'required|string', // Changed from array to string
                'format_export' => 'required|string|in:excel,pdf'
            ], [
                'kode_periode.required' => 'Periode harus dipilih.',
                'nama_laporan.required' => 'Jenis laporan harus dipilih.',
                'programstudi.required' => 'Program studi harus dipilih.',
                'format_export.required' => 'Format export harus dipilih.',
                'format_export.in' => 'Format export harus Excel atau PDF.'
            ]);

            // Log request data for debugging
            Log::info('KeuanganLaporan - Print Request:', [
                'kode_periode' => $request->kode_periode,
                'nama_laporan' => $request->nama_laporan,
                'programstudi' => $request->programstudi,
                'format_export' => $request->format_export,
                'user_id' => auth()->id() ?? 'guest'
            ]);

            // Convert single programstudi to array for helper compatibility
            $programStudiArray = [$request->programstudi];

            // Get unit kerja names (following BTQ pattern)
            $unitKerjaNames = UnitKerjaHelper::getUnitKerjaNamesV1($programStudiArray);

            Log::info('KeuanganLaporan - Unit Kerja Names:', [
                'input_id' => $request->programstudi,
                'converted_array' => $programStudiArray,
                'unit_kerja_names' => $unitKerjaNames
            ]);

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
                    throw new Exception('Tipe laporan tidak dikenali: ' . $request->nama_laporan);
            }

        } catch (\Illuminate\Validation\ValidationException $e) {
            return back()->withErrors($e->errors())->withInput();

        } catch (Exception $e) {
            Log::error('KeuanganLaporan - Error in printLaporan:', [
                'message' => $e->getMessage(),
                'file' => $e->getFile(),
                'line' => $e->getLine(),
                'request_data' => $request->all()
            ]);

            return back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage())->withInput();
        }
    }

    /**
     * Generate Jurnal Pengeluaran Report
     */
    private function generateJurnalPengeluaran($request, $unitKerjaNames)
    {
        Log::info('Generating Jurnal Pengeluaran Report');

        // TODO: Implement actual data fetching
        $mockData = $this->getMockJurnalPengeluaran();

        if ($request->format_export === 'excel') {
            // return Excel::download(new KeuanganJurnalPengeluaranExport($mockData), 'jurnal-pengeluaran.xlsx');
            return response()->json([
                'status' => 'development',
                'message' => 'Excel export untuk Jurnal Pengeluaran sedang dalam pengembangan',
                'data' => $mockData
            ], 501);
        }

        return $this->generatePDF('jurnal-pengeluaran', $mockData, $request);
    }

    /**
     * Generate Jurnal Per Mata Anggaran Report
     */
    private function generateJurnalPerMataAnggaran($request, $unitKerjaNames)
    {
        Log::info('Generating Jurnal Per Mata Anggaran Report');

        // TODO: Implement actual data fetching
        $mockData = $this->getMockJurnalPerMataAnggaran();

        if ($request->format_export === 'excel') {
            return response()->json([
                'status' => 'development',
                'message' => 'Excel export untuk Jurnal Per Mata Anggaran sedang dalam pengembangan',
                'data' => $mockData
            ], 501);
        }

        return $this->generatePDF('jurnal-per-mata-anggaran', $mockData, $request);
    }

    /**
     * Generate Buku Besar Report
     */
    private function generateBukuBesar($request, $unitKerjaNames)
    {
        Log::info('Generating Buku Besar Report');

        // TODO: Implement actual data fetching
        $mockData = $this->getMockBukuBesar();

        if ($request->format_export === 'excel') {
            return response()->json([
                'status' => 'development',
                'message' => 'Excel export untuk Buku Besar sedang dalam pengembangan',
                'data' => $mockData
            ], 501);
        }

        return $this->generatePDF('buku-besar', $mockData, $request);
    }

    /**
     * Generate Buku Kas Report
     */
    private function generateBukuKas($request, $unitKerjaNames)
    {
        Log::info('Generating Buku Kas Report');

        // TODO: Implement actual data fetching
        $mockData = $this->getMockBukuKas();

        if ($request->format_export === 'excel') {
            return response()->json([
                'status' => 'development',
                'message' => 'Excel export untuk Buku Kas sedang dalam pengembangan',
                'data' => $mockData
            ], 501);
        }

        return $this->generatePDF('buku-kas', $mockData, $request);
    }

    /**
     * Generate Pembayaran Tugas Akhir Report
     */
    private function generatePembayaranTugasAkhir($request, $unitKerjaNames)
    {
        Log::info('Generating Pembayaran Tugas Akhir Report');

        // TODO: Implement actual data fetching
        $mockData = $this->getMockPembayaranTugasAkhir();

        if ($request->format_export === 'excel') {
            return response()->json([
                'status' => 'development',
                'message' => 'Excel export untuk Pembayaran Tugas Akhir sedang dalam pengembangan',
                'data' => $mockData
            ], 501);
        }

        return $this->generatePDF('pembayaran-tugas-akhir', $mockData, $request);
    }

    /**
     * Generate Honor Koreksi Report
     */
    private function generateHonorKoreksi($request, $unitKerjaNames)
    {
        Log::info('Generating Honor Koreksi Report');

        // TODO: Implement actual data fetching
        $mockData = $this->getMockHonorKoreksi();

        if ($request->format_export === 'excel') {
            return response()->json([
                'status' => 'development',
                'message' => 'Excel export untuk Honor Koreksi sedang dalam pengembangan',
                'data' => $mockData
            ], 501);
        }

        return $this->generatePDF('honor-koreksi', $mockData, $request);
    }

    /**
     * Generate Honor Vakasi Report
     */
    private function generateHonorVakasi($request, $unitKerjaNames)
    {
        Log::info('Generating Honor Vakasi Report');

        // TODO: Implement actual data fetching
        $mockData = $this->getMockHonorVakasi();

        if ($request->format_export === 'excel') {
            return response()->json([
                'status' => 'development',
                'message' => 'Excel export untuk Honor Vakasi sedang dalam pengembangan',
                'data' => $mockData
            ], 501);
        }

        return $this->generatePDF('honor-vakasi', $mockData, $request);
    }

    /**
     * Generate Pengeluaran Fakultas Report
     */
    private function generatePengeluaranFakultas($request, $unitKerjaNames)
    {
        Log::info('Generating Pengeluaran Fakultas Report');

        // TODO: Implement actual data fetching
        $mockData = $this->getMockPengeluaranFakultas();

        if ($request->format_export === 'excel') {
            return response()->json([
                'status' => 'development',
                'message' => 'Excel export untuk Pengeluaran Fakultas sedang dalam pengembangan',
                'data' => $mockData
            ], 501);
        }

        return $this->generatePDF('pengeluaran-fakultas', $mockData, $request);
    }

    /**
     * Generate PDF report
     */
    private function generatePDF($reportType, $data, $request)
    {
        Log::info('Generating PDF for: ' . $reportType);

        // TODO: Implement PDF generation using DomPDF or similar
        return response()->json([
            'status' => 'development',
            'message' => "PDF untuk laporan {$reportType} sedang dalam pengembangan",
            'data' => $data,
            'periode' => $request->kode_periode,
            'format' => $request->format_export,
            'timestamp' => now()->toISOString()
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
                [
                    'no' => 2,
                    'kwitansi' => 'P.2507.002',
                    'tanggal' => '01-07-2025',
                    'uraian' => 'Transport Membantu Pelaksanaan Kegiatan Tata Usaha',
                    'jumlah' => 'Rp 6.600.000'
                ],
                // Add more mock data as needed...
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
            'periode' => date('Y'),
            'data' => [
                // Add mock data for buku besar
            ]
        ];
    }

    private function getMockBukuKas()
    {
        return [
            'title' => 'BUKTI PENGELUARAN KAS',
            'nomor' => 'P.2507.001',
            'tanggal' => date('d-m-Y'),
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
                [
                    'no' => 2,
                    'npm' => '223040038',
                    'nama' => 'Lisvindanu',
                    'program_studi' => 'Teknik Informatika',
                    'periode' => '20202',
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
            'data' => [
                // Add mock data for honor koreksi
            ]
        ];
    }

    private function getMockHonorVakasi()
    {
        return [
            'title' => 'LAPORAN HONOR VAKASI',
            'periode' => 'Juli 2025',
            'data' => [
                // Add mock data for honor vakasi
            ]
        ];
    }

    private function getMockPengeluaranFakultas()
    {
        return [
            'title' => 'PENGELUARAN FAKULTAS PERIODE',
            'periode' => 'Juli 2025',
            'data' => [
                // Add mock data for pengeluaran fakultas
            ]
        ];
    }
}
