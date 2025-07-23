<?php

namespace App\Http\Controllers;

use App\Models\KeuanganPengeluaran;
use App\Models\KeuanganMataAnggaran;
use App\Models\KeuanganProgram;
use App\Models\KeuanganSumberDana;
use App\Models\KeuanganTahunAnggaran;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class KeuanganTransaksiDashboardController extends Controller
{
    public function index()
    {
        // Get statistics
        $statistics = $this->getTransactionStatistics();

        // Get recent transactions
        $recentTransactions = $this->getRecentTransactions();

        return view('keuangan.transaksi.transaksi-dashboard.index', compact(
            'statistics',
            'recentTransactions'
        ));
    }

    private function getTransactionStatistics()
    {
        $today = Carbon::today();
        $startOfMonth = Carbon::now()->startOfMonth();
        $endOfMonth = Carbon::now()->endOfMonth();

        return [
            // Total counts
            'total_pengeluaran' => KeuanganPengeluaran::count(),
            'pending_approval' => KeuanganPengeluaran::where('status', 'pending')->count(),
            'approved_today' => KeuanganPengeluaran::where('status', 'approved')
                ->whereDate('updated_at', $today)
                ->count(),
            'paid_today' => KeuanganPengeluaran::where('status', 'paid')
                ->whereDate('updated_at', $today)
                ->count(),

            // Monthly statistics
            'approved_month' => KeuanganPengeluaran::where('status', 'approved')
                ->whereBetween('updated_at', [$startOfMonth, $endOfMonth])
                ->count(),
            'paid_month' => KeuanganPengeluaran::where('status', 'paid')
                ->whereBetween('updated_at', [$startOfMonth, $endOfMonth])
                ->count(),

            // Status groupings
            'draft_pending' => KeuanganPengeluaran::whereIn('status', ['draft', 'pending'])->count(),
            'rejected' => KeuanganPengeluaran::where('status', 'rejected')->count(),

            // Financial metrics
            'total_value' => KeuanganPengeluaran::whereIn('status', ['approved', 'paid'])
                    ->sum('uang_sebanyak_angka') ?? 0,
            'average_value' => KeuanganPengeluaran::whereIn('status', ['approved', 'paid'])
                    ->avg('uang_sebanyak_angka') ?? 0,

            // Performance metrics
            'last_updated' => Carbon::now()->format('d/m/Y H:i'),
        ];
    }

    private function getRecentTransactions($limit = 10)
    {
        return KeuanganPengeluaran::with([
            'mataAnggaran',
            'program',
            'penerima'
        ])
            ->orderBy('created_at', 'desc')
            ->limit($limit)
            ->get();
    }

    public function getStatisticsJson()
    {
        return response()->json([
            'statistics' => $this->getTransactionStatistics(),
            'timestamp' => Carbon::now()->toISOString()
        ]);
    }

    public function getChartData(Request $request)
    {
        $period = $request->get('period', 'month'); // month, quarter, year

        switch ($period) {
            case 'month':
                return $this->getMonthlyChartData();
            case 'quarter':
                return $this->getQuarterlyChartData();
            case 'year':
                return $this->getYearlyChartData();
            default:
                return $this->getMonthlyChartData();
        }
    }

    private function getMonthlyChartData()
    {
        $startDate = Carbon::now()->startOfMonth();
        $endDate = Carbon::now()->endOfMonth();

        $dailyData = KeuanganPengeluaran::select(
            DB::raw('DATE(created_at) as date'),
            DB::raw('COUNT(*) as count'),
            DB::raw('SUM(uang_sebanyak_angka) as total_amount'),
            'status'
        )
            ->whereBetween('created_at', [$startDate, $endDate])
            ->groupBy('date', 'status')
            ->orderBy('date')
            ->get();

        return response()->json([
            'period' => 'month',
            'data' => $dailyData,
            'summary' => [
                'total_transactions' => $dailyData->sum('count'),
                'total_amount' => $dailyData->sum('total_amount'),
                'period_start' => $startDate->format('Y-m-d'),
                'period_end' => $endDate->format('Y-m-d')
            ]
        ]);
    }

    private function getQuarterlyChartData()
    {
        $startDate = Carbon::now()->startOfQuarter();
        $endDate = Carbon::now()->endOfQuarter();

        $monthlyData = KeuanganPengeluaran::select(
            DB::raw('EXTRACT(MONTH FROM created_at) as month'),
            DB::raw('COUNT(*) as count'),
            DB::raw('SUM(uang_sebanyak_angka) as total_amount'),
            'status'
        )
            ->whereBetween('created_at', [$startDate, $endDate])
            ->groupBy('month', 'status')
            ->orderBy('month')
            ->get();

        return response()->json([
            'period' => 'quarter',
            'data' => $monthlyData,
            'summary' => [
                'total_transactions' => $monthlyData->sum('count'),
                'total_amount' => $monthlyData->sum('total_amount'),
                'period_start' => $startDate->format('Y-m-d'),
                'period_end' => $endDate->format('Y-m-d')
            ]
        ]);
    }

    private function getYearlyChartData()
    {
        $startDate = Carbon::now()->startOfYear();
        $endDate = Carbon::now()->endOfYear();

        $monthlyData = KeuanganPengeluaran::select(
            DB::raw('EXTRACT(MONTH FROM created_at) as month'),
            DB::raw('COUNT(*) as count'),
            DB::raw('SUM(uang_sebanyak_angka) as total_amount'),
            'status'
        )
            ->whereBetween('created_at', [$startDate, $endDate])
            ->groupBy('month', 'status')
            ->orderBy('month')
            ->get();

        return response()->json([
            'period' => 'year',
            'data' => $monthlyData,
            'summary' => [
                'total_transactions' => $monthlyData->sum('count'),
                'total_amount' => $monthlyData->sum('total_amount'),
                'period_start' => $startDate->format('Y-m-d'),
                'period_end' => $endDate->format('Y-m-d')
            ]
        ]);
    }

    public function getTopMataAnggaran(Request $request)
    {
        $limit = $request->get('limit', 10);
        $period = $request->get('period', 'month');

        $startDate = match($period) {
            'week' => Carbon::now()->startOfWeek(),
            'month' => Carbon::now()->startOfMonth(),
            'quarter' => Carbon::now()->startOfQuarter(),
            'year' => Carbon::now()->startOfYear(),
            default => Carbon::now()->startOfMonth()
        };

        $topMataAnggaran = KeuanganPengeluaran::select(
            'mata_anggaran_id',
            DB::raw('COUNT(*) as transaction_count'),
            DB::raw('SUM(uang_sebanyak_angka) as total_amount')
        )
            ->with('mataAnggaran')
            ->where('created_at', '>=', $startDate)
            ->whereIn('status', ['approved', 'paid'])
            ->groupBy('mata_anggaran_id')
            ->orderBy('total_amount', 'desc')
            ->limit($limit)
            ->get();

        return response()->json([
            'period' => $period,
            'data' => $topMataAnggaran,
            'timestamp' => Carbon::now()->toISOString()
        ]);
    }

    public function getStatusDistribution()
    {
        $distribution = KeuanganPengeluaran::select(
            'status',
            DB::raw('COUNT(*) as count'),
            DB::raw('SUM(uang_sebanyak_angka) as total_amount')
        )
            ->groupBy('status')
            ->get();

        $statusLabels = [
            'draft' => 'Draft',
            'pending' => 'Menunggu Persetujuan',
            'approved' => 'Disetujui',
            'rejected' => 'Ditolak',
            'paid' => 'Dibayar'
        ];

        // FIX: Handle empty distribution case
        if ($distribution->isEmpty()) {
            return response()->json([
                'data' => [],
                'total_transactions' => 0,
                'total_amount' => 0,
                'timestamp' => Carbon::now()->toISOString()
            ]);
        }

        $totalCount = $distribution->sum('count');

        $formattedData = $distribution->map(function ($item) use ($statusLabels, $totalCount) {
            return [
                'status' => $item->status,
                'label' => $statusLabels[$item->status] ?? $item->status,
                'count' => $item->count,
                'total_amount' => $item->total_amount ?? 0,
                'percentage' => $totalCount > 0 ? round(($item->count / $totalCount) * 100, 2) : 0
            ];
        });

        return response()->json([
            'data' => $formattedData,
            'total_transactions' => $totalCount,
            'total_amount' => $distribution->sum('total_amount') ?? 0,
            'timestamp' => Carbon::now()->toISOString()
        ]);
    }

    public function export(Request $request)
    {
        $format = $request->get('format', 'excel'); // excel, pdf, csv
        $period = $request->get('period', 'month');

        // Implementation would depend on your export requirements
        // This is a placeholder for export functionality

        return response()->json([
            'message' => 'Export functionality will be implemented',
            'format' => $format,
            'period' => $period
        ]);
    }
}
