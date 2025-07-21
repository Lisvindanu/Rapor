<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Exception;
use App\Models\KeuanganMataAnggaran;
use App\Models\KeuanganProgram;
use App\Models\KeuanganSumberDana;
use App\Models\KeuanganTahunAnggaran;
use App\Models\KeuanganTandaTangan;

class KeuanganMasterDataController extends Controller
{
    /**
     * Display master data dashboard with statistics
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        try {
            $statistics = $this->getMasterDataStatistics();
            $recentActivity = $this->getRecentActivity();

            return view('keuangan.master.master-dashboard.index', [
                'statistics' => $statistics,
                'recentActivity' => $recentActivity
            ]);

        } catch (Exception $e) {
            return back()->with('message', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    /**
     * Get master data statistics from database (NO GROWTH DATA)
     */
    private function getMasterDataStatistics()
    {
        return [
            // Mata Anggaran - HANYA TOTAL
            'total_mata_anggaran' => KeuanganMataAnggaran::count(),
            'mata_anggaran_aktif' => KeuanganMataAnggaran::count(),
            'mata_anggaran_debet' => KeuanganMataAnggaran::where('kategori', 'debet')->count(),
            'mata_anggaran_kredit' => KeuanganMataAnggaran::where('kategori', 'kredit')->count(),

            // Program - HANYA TOTAL
            'total_program' => KeuanganProgram::count(),
            'program_aktif' => KeuanganProgram::count(),

            // Sumber Dana - HANYA TOTAL
            'total_sumber_dana' => KeuanganSumberDana::count(),
            'sumber_dana_aktif' => KeuanganSumberDana::count(),

            // Tahun Anggaran - HANYA TOTAL
            'total_tahun_anggaran' => KeuanganTahunAnggaran::count(),
            'tahun_anggaran_aktif' => KeuanganTahunAnggaran::aktif()->count(),

            // Tanda Tangan - HANYA TOTAL
            'total_tanda_tangan' => KeuanganTandaTangan::count(),
            'tanda_tangan_aktif' => KeuanganTandaTangan::whereNotNull('gambar_ttd')
                ->where('gambar_ttd', '!=', '')
                ->count(),

            'last_updated' => now()->format('d/m/Y H:i')
        ];
    }

    /**
     * Get recent activity from database
     */
    private function getRecentActivity()
    {
        $activities = [];

        // Get latest mata anggaran
        $latestMataAnggaran = KeuanganMataAnggaran::latest()->first();
        if ($latestMataAnggaran) {
            $activities[] = [
                'type' => 'mata_anggaran',
                'action' => 'Mata Anggaran Baru',
                'item_name' => $latestMataAnggaran->nama_mata_anggaran,
                'time_ago' => $latestMataAnggaran->created_at->diffForHumans(),
                'icon' => 'plus',
                'color' => 'success',
                'badge' => 'Baru'
            ];
        }

        // Get latest program
        $latestProgram = KeuanganProgram::latest()->first();
        if ($latestProgram) {
            $activities[] = [
                'type' => 'program',
                'action' => 'Program Diperbarui',
                'item_name' => $latestProgram->nama_program,
                'time_ago' => $latestProgram->updated_at->diffForHumans(),
                'icon' => 'edit',
                'color' => 'info',
                'badge' => 'Update'
            ];
        }

        // Get latest sumber dana
        $latestSumberDana = KeuanganSumberDana::latest()->first();
        if ($latestSumberDana) {
            $activities[] = [
                'type' => 'sumber_dana',
                'action' => 'Sumber Dana Ditambahkan',
                'item_name' => $latestSumberDana->nama_sumber_dana,
                'time_ago' => $latestSumberDana->created_at->diffForHumans(),
                'icon' => 'plus',
                'color' => 'warning',
                'badge' => 'Baru'
            ];
        }

        // Get latest tahun anggaran
        $latestTahunAnggaran = KeuanganTahunAnggaran::latest()->first();
        if ($latestTahunAnggaran) {
            $activities[] = [
                'type' => 'tahun_anggaran',
                'action' => 'Tahun Anggaran Diperbarui',
                'item_name' => $latestTahunAnggaran->tahun_anggaran,
                'time_ago' => $latestTahunAnggaran->updated_at->diffForHumans(),
                'icon' => 'calendar',
                'color' => 'success',
                'badge' => 'Update'
            ];
        }

        // Get latest tanda tangan
        $latestTandaTangan = KeuanganTandaTangan::latest()->first();
        if ($latestTandaTangan) {
            $activities[] = [
                'type' => 'tanda_tangan',
                'action' => 'Tanda Tangan Diperbarui',
                'item_name' => $latestTandaTangan->nama . ' (' . $latestTandaTangan->jabatan . ')',
                'time_ago' => $latestTandaTangan->updated_at->diffForHumans(),
                'icon' => 'signature',
                'color' => 'danger',
                'badge' => 'Update'
            ];
        }

        // Sort by latest and limit to 5
        return collect($activities)
            ->sortByDesc(function ($activity) {
                return strtotime($activity['time_ago']);
            })
            ->take(5)
            ->values()
            ->all();
    }

    /**
     * Get chart data for dashboard visualizations (if needed)
     */
    private function getChartData()
    {
        return [
            'mata_anggaran_by_kategori' => [
                'debet' => KeuanganMataAnggaran::where('kategori', 'debet')->count(),
                'kredit' => KeuanganMataAnggaran::where('kategori', 'kredit')->count()
            ],
            'tahun_anggaran_by_status' => [
                'aktif' => KeuanganTahunAnggaran::aktif()->count(),
                'nonaktif' => KeuanganTahunAnggaran::where('status', '!=', 'aktif')->count()
            ]
        ];
    }
}
