{{-- F:\rapor-dosen\resources\views\keuangan\transaksi\transaksi-dashboard\index.blade.php --}}
@extends('layouts.main2')

@section('css-tambahan')
    @include('keuangan.transaksi.transaksi-dashboard.partials.styles')
@endsection

@section('navbar')
    @include('keuangan.navbar')
@endsection

@section('konten')
    <div class="container">
        {{-- Header --}}
        <div class="row justify-content-md-center">
            <div class="container">
                <div class="judul-modul">
                    <span>
                        <h3>Dashboard Transaksi Keuangan</h3>
                        <p>Overview dan Statistik Transaksi Keuangan Fakultas</p>
                    </span>
                </div>
            </div>
        </div>

        @include('komponen.message-alert')

        {{-- Development Alert --}}
        <div class="alert alert-info alert-dismissible fade show" role="alert">
            <div class="d-flex align-items-center">
                <i class="fas fa-exchange-alt me-2"></i>
                <div class="flex-grow-1">
                    <strong>Dashboard Transaksi:</strong>
                    Overview dan statistik untuk semua transaksi keuangan dalam satu tempat.
                    <small class="d-block mt-1">
                        Versi: v1.0.0 | Pattern: Clean Architecture | Status: Production Ready
                    </small>
                </div>
            </div>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>

        {{-- Statistics Cards --}}
        <div class="statistics-section" style="margin-top: 15px">
            <div class="row justify-content-md-center">
                <div class="col-md-2 col-sm-6 col-6">
                    <div class="card bg-primary text-white mb-3 stats-card" data-transaksi="pengeluaran">
                        <div class="card-body text-center">
                            <h3 class="card-title mb-1">{{ $statistics['total_pengeluaran'] ?? 0 }}</h3>
                            <p class="card-text mb-0">Total Pengeluaran</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-2 col-sm-6 col-6">
                    <div class="card bg-warning text-white mb-3 stats-card" data-transaksi="pending">
                        <div class="card-body text-center">
                            <h3 class="card-title mb-1">{{ $statistics['pending_approval'] ?? 0 }}</h3>
                            <p class="card-text mb-0">Menunggu Approval</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-2 col-sm-6 col-6">
                    <div class="card bg-success text-white mb-3 stats-card" data-transaksi="approved">
                        <div class="card-body text-center">
                            <h3 class="card-title mb-1">{{ $statistics['approved_today'] ?? 0 }}</h3>
                            <p class="card-text mb-0">Disetujui Hari Ini</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-2 col-sm-6 col-6">
                    <div class="card bg-info text-white mb-3 stats-card" data-transaksi="paid">
                        <div class="card-body text-center">
                            <h3 class="card-title mb-1">{{ $statistics['paid_today'] ?? 0 }}</h3>
                            <p class="card-text mb-0">Dibayar Hari Ini</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-2 col-sm-6 col-6">
                    <div class="card bg-danger text-white mb-3 stats-card" data-transaksi="value">
                        <div class="card-body text-center">
                            <h3 class="card-title mb-1" style="font-size: 1rem;">
                                Rp {{ number_format(($statistics['total_value'] ?? 0) / 1000000, 1) }}M
                            </h3>
                            <p class="card-text mb-0">Total Nilai</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Main Content --}}
        <div class="isi-konten">
            <div class="row">
                {{-- Quick Access --}}
                <div class="col-6">
                    <div class="card">
                        <div class="card-header" style="background-color: #fff; margin-top:10px">
                            <h5 class="card-title">Akses Cepat Transaksi</h5>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6 mb-2">
                                    <a href="{{ route('keuangan.pengeluaran.index') }}"
                                       class="btn btn-primary w-100 transaksi-btn">
                                        <i class="fas fa-money-bill-wave me-2"></i>
                                        Pengeluaran Kas
                                    </a>
                                </div>
                                <div class="col-md-6 mb-2">
                                    <button type="button" class="btn btn-success w-100 transaksi-btn btn-create-modal">
                                        <i class="fas fa-plus-circle me-2"></i>
                                        Buat Pengeluaran
                                    </button>
                                </div>
                                <div class="col-md-6 mb-2">
                                    <a href="{{ route('keuangan.laporan') }}"
                                       class="btn btn-info w-100 transaksi-btn">
                                        <i class="fas fa-chart-bar me-2"></i>
                                        Laporan Keuangan
                                    </a>
                                </div>
                                <div class="col-md-6 mb-2">
                                    <a href="{{ route('keuangan') }}"
                                       class="btn btn-warning w-100 transaksi-btn">
                                        <i class="fas fa-database me-2"></i>
                                        Master Data
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Summary Info --}}
                <div class="col-6">
                    <div class="card">
                        <div class="card-header" style="background-color: #fff; margin-top:10px">
                            <h5 class="card-title">Ringkasan Status</h5>
                        </div>
                        <div class="card-body">
                            <div class="list-group">
                                <div class="list-group-item d-flex justify-content-between align-items-center">
                                    <span>
                                        <i class="fas fa-hourglass-half text-warning me-2"></i>
                                        Draft & Pending
                                    </span>
                                    <span class="badge bg-warning rounded-pill">{{ $statistics['draft_pending'] ?? 0 }}</span>
                                </div>
                                <div class="list-group-item d-flex justify-content-between align-items-center">
                                    <span>
                                        <i class="fas fa-check-circle text-success me-2"></i>
                                        Disetujui Bulan Ini
                                    </span>
                                    <span class="badge bg-success rounded-pill">{{ $statistics['approved_month'] ?? 0 }}</span>
                                </div>
                                <div class="list-group-item d-flex justify-content-between align-items-center">
                                    <span>
                                        <i class="fas fa-credit-card text-info me-2"></i>
                                        Dibayar Bulan Ini
                                    </span>
                                    <span class="badge bg-info rounded-pill">{{ $statistics['paid_month'] ?? 0 }}</span>
                                </div>
                                <div class="list-group-item d-flex justify-content-between align-items-center">
                                    <span>
                                        <i class="fas fa-times-circle text-danger me-2"></i>
                                        Ditolak
                                    </span>
                                    <span class="badge bg-danger rounded-pill">{{ $statistics['rejected'] ?? 0 }}</span>
                                </div>
                                <div class="list-group-item d-flex justify-content-between align-items-center">
                                    <span>
                                        <i class="fas fa-calculator text-primary me-2"></i>
                                        Rata-rata Per Transaksi
                                    </span>
                                    <span class="badge bg-primary rounded-pill">
                                        Rp {{ number_format($statistics['average_value'] ?? 0, 0, ',', '.') }}
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Recent Transactions --}}
            <div class="row mt-3">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header" style="background-color: #fff; margin-top:10px">
                            <div class="row">
                                <div class="col-8">
                                    <h5 class="card-title">Transaksi Terbaru</h5>
                                </div>
                                <div class="col-4">
                                    <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                                        <button type="button" class="btn btn-sm btn-success btn-create-modal me-2">
                                            <i class="fas fa-plus me-1"></i>Tambah
                                        </button>
                                        <a href="{{ route('keuangan.pengeluaran.index') }}" class="btn btn-sm btn-outline-primary">
                                            Lihat Semua
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            @if(count($recentTransactions) > 0)
                                <div class="table-responsive">
                                    <table class="table table-hover">
                                        <thead>
                                        <tr>
                                            <th>Nomor Bukti</th>
                                            <th>Tanggal</th>
                                            <th>Penerima</th>
                                            <th>Jumlah</th>
                                            <th>Status</th>
                                            <th>Aksi</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @foreach($recentTransactions as $transaction)
                                            <tr>
                                                <td>
                                                    <span class="badge bg-primary">{{ $transaction->nomor_bukti }}</span>
                                                </td>
                                                <td>{{ $transaction->tanggal ? $transaction->tanggal->format('d/m/Y') : '-' }}</td>
                                                <td>{{ Str::limit($transaction->sudah_terima_dari, 30) }}</td>
                                                <td>
                                                    <strong>Rp {{ number_format($transaction->uang_sebanyak_angka, 0, ',', '.') }}</strong>
                                                </td>
                                                <td>
                                                    @php
                                                        $badgeClass = match($transaction->status) {
                                                            'draft' => 'secondary',
                                                            'pending' => 'warning',
                                                            'approved' => 'success',
                                                            'rejected' => 'danger',
                                                            'paid' => 'info',
                                                            default => 'secondary'
                                                        };
                                                        $statusLabel = match($transaction->status) {
                                                            'draft' => 'Draft',
                                                            'pending' => 'Pending',
                                                            'approved' => 'Disetujui',
                                                            'rejected' => 'Ditolak',
                                                            'paid' => 'Dibayar',
                                                            default => ucfirst($transaction->status)
                                                        };
                                                    @endphp
                                                    <span class="badge bg-{{ $badgeClass }}">{{ $statusLabel }}</span>
                                                </td>
                                                <td>
                                                    <div class="btn-group" role="group">
                                                        <a href="{{ route('keuangan.pengeluaran.show', $transaction->id) }}"
                                                           class="btn btn-info btn-sm" title="Detail">
                                                            <i class="fas fa-eye"></i>
                                                        </a>
                                                        @if($transaction->canBeEdited())
                                                            <button type="button"
                                                                    class="btn btn-warning btn-sm btn-edit-modal"
                                                                    data-id="{{ $transaction->id }}"
                                                                    title="Edit">
                                                                <i class="fas fa-edit"></i>
                                                            </button>
                                                        @endif
                                                        <a href="{{ route('keuangan.pengeluaran.print', $transaction->id) }}"
                                                           class="btn btn-secondary btn-sm" target="_blank" title="Print">
                                                            <i class="fas fa-print"></i>
                                                        </a>
                                                    </div>
                                                </td>
                                            </tr>
                                        @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            @else
                                <div class="text-center py-4">
                                    <i class="fas fa-receipt fa-3x text-muted mb-3"></i>
                                    <p class="text-muted">Belum ada transaksi terbaru</p>
                                    <button type="button" class="btn btn-primary btn-create-modal">
                                        <i class="fas fa-plus me-1"></i>
                                        Buat Transaksi Pertama
                                    </button>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Include Modal Form --}}
    @include('keuangan.transaksi.partials.modal-form')
@endsection

@section('js-tambahan')
    @include('keuangan.transaksi.transaksi-dashboard.partials.scripts')
    @include('keuangan.transaksi.partials.modal-scripts')
@endsection
