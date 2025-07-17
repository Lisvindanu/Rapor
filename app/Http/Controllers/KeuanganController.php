<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Exception;

class KeuanganController extends Controller
{
    /**
     * Display the main keuangan dashboard
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        try {
            // TODO: Implement proper data fetching from database
            // For now, return mock data following BTQ pattern

            $mockData = $this->getMockDashboardData();

            return view('keuangan.index', [
                'totalPemasukan' => $mockData['totalPemasukan'],
                'totalPengeluaran' => $mockData['totalPengeluaran'],
                'saldo' => $mockData['saldo'],
                'totalTransaksi' => $mockData['totalTransaksi'],
                'recentTransactions' => $mockData['recentTransactions'],
                'kategoriStats' => $mockData['kategoriStats']
            ]);

        } catch (Exception $e) {
            return back()->with('message', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    /**
     * Get mock data for dashboard (temporary)
     * TODO: Replace with actual database queries
     */
    private function getMockDashboardData()
    {
        return [
            'totalPemasukan' => 15750000,
            'totalPengeluaran' => 12300000,
            'saldo' => 3450000,
            'totalTransaksi' => 47,
            'recentTransactions' => [
                [
                    'tanggal' => '15/07/2025',
                    'no_transaksi' => 'TRX20250715001',
                    'kategori' => 'Pembayaran TA',
                    'kategori_class' => 'success',
                    'penerima' => 'Rizky Hidayah Aminullah',
                    'jumlah' => 300000,
                    'jumlah_class' => 'success',
                    'jumlah_prefix' => '+',
                    'status' => 'Paid',
                    'status_class' => 'success',
                    'action_type' => 'view',
                    'action_class' => 'outline-primary',
                    'action_icon' => 'eye'
                ],
                [
                    'tanggal' => '14/07/2025',
                    'no_transaksi' => 'TRX20250714001',
                    'kategori' => 'Honor Koreksi',
                    'kategori_class' => 'warning',
                    'penerima' => 'Dr. Ahmad Sutisna',
                    'jumlah' => 2500000,
                    'jumlah_class' => 'danger',
                    'jumlah_prefix' => '-',
                    'status' => 'Pending',
                    'status_class' => 'warning',
                    'action_type' => 'approve',
                    'action_class' => 'outline-success',
                    'action_icon' => 'check'
                ],
                [
                    'tanggal' => '13/07/2025',
                    'no_transaksi' => 'TRX20250713001',
                    'kategori' => 'Pengeluaran',
                    'kategori_class' => 'info',
                    'penerima' => 'Administrasi Umum',
                    'jumlah' => 850000,
                    'jumlah_class' => 'danger',
                    'jumlah_prefix' => '-',
                    'status' => 'Paid',
                    'status_class' => 'success',
                    'action_type' => 'download',
                    'action_class' => 'outline-secondary',
                    'action_icon' => 'download'
                ]
            ],
            'kategoriStats' => [
                [
                    'nama' => 'Pembayaran Tugas Akhir',
                    'icon' => 'graduation-cap',
                    'icon_class' => 'primary',
                    'count' => 12
                ],
                [
                    'nama' => 'Honor Koreksi',
                    'icon' => 'edit',
                    'icon_class' => 'success',
                    'count' => 8
                ],
                [
                    'nama' => 'Pengeluaran Fakultas',
                    'icon' => 'university',
                    'icon_class' => 'warning',
                    'count' => 5
                ],
                [
                    'nama' => 'Honor & Vakasi',
                    'icon' => 'money-bill',
                    'icon_class' => 'info',
                    'count' => 15
                ]
            ]
        ];
    }
}
