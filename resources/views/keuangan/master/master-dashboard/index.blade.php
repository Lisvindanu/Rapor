{{-- F:\rapor-dosen\resources\views\keuangan\master-dashboard\index.blade.php --}}
@extends('layouts.main2')

@section('css-tambahan')
    @include('keuangan.master.master-dashboard.partials.styles')
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
                        <h3>Dashboard Master Data</h3>
                        <p>Overview dan Statistik Data Master Sistem Keuangan</p>
                    </span>
                </div>
            </div>
        </div>

        @include('komponen.message-alert')

        {{-- Development Alert --}}
        <div class="alert alert-info alert-dismissible fade show" role="alert">
            <div class="d-flex align-items-center">
                <i class="fas fa-info-circle me-2"></i>
                <div class="flex-grow-1">
                    <strong>Dashboard Master Data:</strong>
                    Overview dan statistik untuk semua master data keuangan dalam satu tempat.
                    <small class="d-block mt-1">
                        Versi: v1.1.0 | Pattern: Clean Architecture | Status: Production Ready
                    </small>
                </div>
            </div>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>

        {{-- Statistics Cards --}}
        <div class="statistics-section" style="margin-top: 15px">
            <div class="row justify-content-md-center">
                <div class="col-md-2 col-sm-6 col-6">
                    <div class="card bg-primary text-white mb-3 stats-card" data-master="mata-anggaran">
                        <div class="card-body text-center">
                            <h3 class="card-title mb-1">{{ $statistics['total_mata_anggaran'] ?? 0 }}</h3>
                            <p class="card-text mb-0">Mata Anggaran</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-2 col-sm-6 col-6">
                    <div class="card bg-info text-white mb-3 stats-card" data-master="program">
                        <div class="card-body text-center">
                            <h3 class="card-title mb-1">{{ $statistics['total_program'] ?? 0 }}</h3>
                            <p class="card-text mb-0">Program</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-2 col-sm-6 col-6">
                    <div class="card bg-warning text-white mb-3 stats-card" data-master="sumber-dana">
                        <div class="card-body text-center">
                            <h3 class="card-title mb-1">{{ $statistics['total_sumber_dana'] ?? 0 }}</h3>
                            <p class="card-text mb-0">Sumber Dana</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-2 col-sm-6 col-6">
                    <div class="card bg-success text-white mb-3 stats-card" data-master="tahun-anggaran">
                        <div class="card-body text-center">
                            <h3 class="card-title mb-1">{{ $statistics['total_tahun_anggaran'] ?? 0 }}</h3>
                            <p class="card-text mb-0">Tahun Anggaran</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-2 col-sm-6 col-6">
                    <div class="card bg-danger text-white mb-3 stats-card" data-master="tanda-tangan">
                        <div class="card-body text-center">
                            <h3 class="card-title mb-1">{{ $statistics['total_tanda_tangan'] ?? 0 }}</h3>
                            <p class="card-text mb-0">Tanda Tangan</p>
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
                            <h5 class="card-title">Akses Cepat Master Data</h5>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6 mb-2">
                                    <a href="{{ route('keuangan.mata-anggaran.index') }}"
                                       class="btn btn-primary w-100 master-btn">
                                        <i class="fas fa-list-alt me-2"></i>
                                        Mata Anggaran
                                    </a>
                                </div>
                                <div class="col-md-6 mb-2">
                                    <a href="{{ route('keuangan.program.index') }}"
                                       class="btn btn-info w-100 master-btn">
                                        <i class="fas fa-project-diagram me-2"></i>
                                        Program
                                    </a>
                                </div>
                                <div class="col-md-6 mb-2">
                                    <a href="{{ route('keuangan.sumber-dana.index') }}"
                                       class="btn btn-warning w-100 master-btn">
                                        <i class="fas fa-donate me-2"></i>
                                        Sumber Dana
                                    </a>
                                </div>
                                <div class="col-md-6 mb-2">
                                    <a href="{{ route('keuangan.tahun-anggaran.index') }}"
                                       class="btn btn-success w-100 master-btn">
                                        <i class="fas fa-calendar-alt me-2"></i>
                                        Tahun Anggaran
                                    </a>
                                </div>
                                <div class="col-md-12 mb-2">
                                    <a href="{{ route('keuangan.tanda-tangan.index') }}"
                                       class="btn btn-danger w-100 master-btn">
                                        <i class="fas fa-signature me-2"></i>
                                        Tanda Tangan
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
                            <h5 class="card-title">Ringkasan Data</h5>
                        </div>
                        <div class="card-body">
                            <div class="list-group">
                                <div class="list-group-item d-flex justify-content-between align-items-center">
                                    <span>
                                        <i class="fas fa-list-alt text-primary me-2"></i>
                                        Mata Anggaran Aktif
                                    </span>
                                    <span class="badge bg-primary rounded-pill">{{ $statistics['mata_anggaran_aktif'] }}</span>
                                </div>
                                <div class="list-group-item d-flex justify-content-between align-items-center">
                                    <span>
                                        <i class="fas fa-project-diagram text-info me-2"></i>
                                        Program Berjalan
                                    </span>
                                    <span class="badge bg-info rounded-pill">{{ $statistics['program_aktif'] }}</span>
                                </div>
                                <div class="list-group-item d-flex justify-content-between align-items-center">
                                    <span>
                                        <i class="fas fa-donate text-warning me-2"></i>
                                        Sumber Dana Aktif
                                    </span>
                                    <span class="badge bg-warning rounded-pill">{{ $statistics['sumber_dana_aktif'] }}</span>
                                </div>
                                <div class="list-group-item d-flex justify-content-between align-items-center">
                                    <span>
                                        <i class="fas fa-calendar-check text-success me-2"></i>
                                        Tahun Anggaran Aktif
                                    </span>
                                    <span class="badge bg-success rounded-pill">{{ $statistics['tahun_anggaran_aktif'] }}</span>
                                </div>
                                <div class="list-group-item d-flex justify-content-between align-items-center">
                                    <span>
                                        <i class="fas fa-signature text-danger me-2"></i>
                                        TTD Tersedia
                                    </span>
                                    <span class="badge bg-danger rounded-pill">{{ $statistics['tanda_tangan_aktif'] }}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Activity Summary --}}
            <div class="row mt-3">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header" style="background-color: #fff; margin-top:10px">
                            <div class="row">
                                <div class="col-8">
                                    <h5 class="card-title">Aktivitas Terbaru</h5>
                                </div>
                                <div class="col-4">
                                    <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                                        <small class="text-muted">Update: {{ $statistics['last_updated'] }}</small>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            @if(count($recentActivity) > 0)
                                <div class="list-group">
                                    @foreach($recentActivity as $activity)
                                        <div class="list-group-item d-flex justify-content-between align-items-start">
                                            <div class="ms-2 me-auto">
                                                <div class="fw-bold">
                                                    <i class="fas fa-{{ $activity['icon'] }} text-{{ $activity['color'] }} me-2"></i>
                                                    {{ $activity['action'] }}
                                                </div>
                                                <small class="text-muted">{{ $activity['item_name'] }} - {{ $activity['time_ago'] }}</small>
                                            </div>
                                            <span class="badge bg-{{ $activity['color'] }} rounded-pill">{{ $activity['badge'] }}</span>
                                        </div>
                                    @endforeach
                                </div>
                            @else
                                <div class="text-center py-4">
                                    <i class="fas fa-inbox fa-3x text-muted mb-3"></i>
                                    <p class="text-muted">Belum ada aktivitas terbaru</p>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('js-tambahan')
    @include('keuangan.master.master-dashboard.partials.scripts')
@endsection
