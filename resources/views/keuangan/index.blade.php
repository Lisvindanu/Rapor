@extends('layouts.main2')

@section('css-tambahan')
    <style>
        .under-development {
            border: 2px dashed #6c757d;
            padding: 2rem;
            text-align: center;
            background-color: #f8f9fa;
            margin: 1rem 0;
        }

        .feature-card {
            opacity: 0.6;
            transition: opacity 0.3s;
        }

        .feature-card:hover {
            opacity: 1;
        }
    </style>
@endsection

@section('navbar')
    @include('keuangan.navbar')
@endsection

@section('konten')
    <div class="container">
        <div class="row justify-content-md-center">
            <div class="container">
                <div class="judul-modul">
                    <span>
                        <h3>Modul Keuangan</h3>
                        <p>Sistem Pencatatan Keuangan Masuk dan Keluar</p>
                    </span>
                </div>
            </div>
        </div>

        {{-- Development Status Alert --}}
        <div class="alert alert-warning" role="alert">
            <i class="fas fa-exclamation-triangle"></i>
            <strong>Status:</strong> Modul sedang dalam tahap pengembangan.
            Beberapa fitur masih dalam proses implementasi dan testing.
        </div>

        {{-- Statistics Cards (BTQ Pattern) --}}
        <div class="" style="margin-top: 15px">
            <div class="row justify-content-md-center">
                <div class="col-3">
                    <div class="card bg-success text-white mb-3">
                        <div class="card-body">
                            <h3 class="card-title">Rp 15.750.000</h3>
                            <p class="card-text">Total Pemasukan</p>
                        </div>
                    </div>
                </div>
                <div class="col-3">
                    <div class="card bg-danger text-white mb-3">
                        <div class="card-body">
                            <h3 class="card-title">Rp 12.300.000</h3>
                            <p class="card-text">Total Pengeluaran</p>
                        </div>
                    </div>
                </div>
                <div class="col-3">
                    <div class="card bg-primary text-white mb-3">
                        <div class="card-body">
                            <h3 class="card-title">Rp 3.450.000</h3>
                            <p class="card-text">Saldo</p>
                        </div>
                    </div>
                </div>
                <div class="col-3">
                    <div class="card bg-info text-white mb-3">
                        <div class="card-body">
                            <h3 class="card-title">47</h3>
                            <p class="card-text">Total Transaksi</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Main Content Area --}}
        <div class="isi-konten">
            <div class="row">
                {{-- Quick Actions Card --}}
                <div class="col-6">
                    <div class="card">
                        <div class="card-header" style="background-color: #fff; margin-top:10px">
                            <div class="row">
                                <div class="col-12">
                                    <h5 class="card-title">Aksi Cepat</h5>
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6 mb-2">
                                    <button class="btn btn-primary w-100" onclick="demoAlert('Input Transaksi')">
                                        <i class="fas fa-plus"></i> Input Transaksi
                                    </button>
                                </div>
                                <div class="col-md-6 mb-2">
                                    <button class="btn btn-info w-100" onclick="demoAlert('Review Transaksi')">
                                        <i class="fas fa-list"></i> Review Transaksi
                                    </button>
                                </div>
                                <div class="col-md-6 mb-2">
                                    <button class="btn btn-success w-100" onclick="demoAlert('Generate Laporan')">
                                        <i class="fas fa-file-alt"></i> Laporan
                                    </button>
                                </div>
                                <div class="col-md-6 mb-2">
                                    <button class="btn btn-warning w-100" onclick="demoAlert('Master Data')">
                                        <i class="fas fa-cog"></i> Master Data
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Categories Card --}}
                <div class="col-6">
                    <div class="card">
                        <div class="card-header" style="background-color: #fff; margin-top:10px">
                            <div class="row">
                                <div class="col-12">
                                    <h5 class="card-title">Kategori Transaksi</h5>
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="list-group">
                                <button class="list-group-item list-group-item-action d-flex justify-content-between align-items-center"
                                        onclick="demoAlert('Pembayaran TA')">
                                    <span><i class="fas fa-graduation-cap text-primary me-2"></i> Pembayaran Tugas Akhir</span>
                                    <span class="badge bg-primary rounded-pill">12</span>
                                </button>
                                <button class="list-group-item list-group-item-action d-flex justify-content-between align-items-center"
                                        onclick="demoAlert('Honor Koreksi')">
                                    <span><i class="fas fa-edit text-success me-2"></i> Honor Koreksi</span>
                                    <span class="badge bg-success rounded-pill">8</span>
                                </button>
                                <button class="list-group-item list-group-item-action d-flex justify-content-between align-items-center"
                                        onclick="demoAlert('Pengeluaran Fakultas')">
                                    <span><i class="fas fa-university text-warning me-2"></i> Pengeluaran Fakultas</span>
                                    <span class="badge bg-warning rounded-pill">5</span>
                                </button>
                                <button class="list-group-item list-group-item-action d-flex justify-content-between align-items-center"
                                        onclick="demoAlert('Honor Vakasi')">
                                    <span><i class="fas fa-money-bill text-info me-2"></i> Honor & Vakasi</span>
                                    <span class="badge bg-info rounded-pill">15</span>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Transactions Preview Table --}}
            <div class="row mt-3">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header" style="background-color: #fff; margin-top:10px">
                            <div class="row">
                                <div class="col-8">
                                    <h5 class="card-title">Preview Transaksi Terbaru</h5>
                                </div>
                                <div class="col-4">
                                    <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                                        <button class="btn btn-primary" onclick="demoAlert('View All Transactions')">
                                            Lihat Semua
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-hover">
                                    <thead class="table-light">
                                    <tr>
                                        <th>Tanggal</th>
                                        <th>No. Transaksi</th>
                                        <th>Kategori</th>
                                        <th>Penerima</th>
                                        <th>Jumlah</th>
                                        <th>Status</th>
                                        <th>Aksi</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <tr style="opacity: 0.7;">
                                        <td>15/07/2025</td>
                                        <td>TRX20250715001</td>
                                        <td><span class="badge bg-success">Pembayaran TA</span></td>
                                        <td>Rizky Hidayah Aminullah</td>
                                        <td class="text-success">+Rp 300.000</td>
                                        <td><span class="badge bg-success">Paid</span></td>
                                        <td>
                                            <button class="btn btn-sm btn-outline-primary" onclick="demoAlert('View Detail')">
                                                <i class="fas fa-eye"></i>
                                            </button>
                                        </td>
                                    </tr>
                                    <tr style="opacity: 0.7;">
                                        <td>14/07/2025</td>
                                        <td>TRX20250714001</td>
                                        <td><span class="badge bg-warning">Honor Koreksi</span></td>
                                        <td>Dr. Ahmad Sutisna</td>
                                        <td class="text-danger">-Rp 2.500.000</td>
                                        <td><span class="badge bg-warning">Pending</span></td>
                                        <td>
                                            <button class="btn btn-sm btn-outline-success" onclick="demoAlert('Approve')">
                                                <i class="fas fa-check"></i>
                                            </button>
                                        </td>
                                    </tr>
                                    <tr style="opacity: 0.7;">
                                        <td>13/07/2025</td>
                                        <td>TRX20250713001</td>
                                        <td><span class="badge bg-info">Pengeluaran</span></td>
                                        <td>Administrasi Umum</td>
                                        <td class="text-danger">-Rp 850.000</td>
                                        <td><span class="badge bg-success">Paid</span></td>
                                        <td>
                                            <button class="btn btn-sm btn-outline-secondary" onclick="demoAlert('Download Bukti')">
                                                <i class="fas fa-download"></i>
                                            </button>
                                        </td>
                                    </tr>
                                    </tbody>
                                </table>
                            </div>
                            <small class="text-muted">Showing 3 of 47 entries (mock data)</small>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('js-tambahan')
    <script>
        // Demo alert function for presentation
        function demoAlert(feature) {
            const messages = {
                'Input Transaksi': 'Form untuk input transaksi baru dengan validasi dan auto-generate nomor.',
                'Review Transaksi': 'Table dengan search, filter, pagination, dan bulk actions.',
                'Generate Laporan': 'Dashboard laporan dengan berbagai template dan export options.',
                'Master Data': 'Management kategori transaksi dan periode akademik.',
                'Pembayaran TA': 'Form khusus pembayaran tugas akhir mahasiswa.',
                'Honor Koreksi': 'Form honor koreksi dosen dengan approval workflow.',
                'Pengeluaran Fakultas': 'Tracking pengeluaran operasional fakultas.',
                'Honor Vakasi': 'Pencatatan honor dan vakasi dosen.',
                'View All Transactions': 'Full table dengan DataTables dan server-side processing.',
                'View Detail': 'Detail transaksi dengan attachment dan approval history.',
                'Approve': 'Approval workflow dengan digital signature.',
                'Download Bukti': 'Download bukti transaksi format PDF.'
            };

            const message = messages[feature] || 'Fitur dalam development.';
            alert(feature + ':\n\n' + message);
        }

        $(document).ready(function() {
            console.log('🔧 Keuangan Module v0.1.0-alpha');
            console.log('📋 Following BTQ module pattern...');
        });
    </script>
@endsection
