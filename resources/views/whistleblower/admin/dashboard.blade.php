{{-- resources/views/whistleblower/admin/dashboard.blade.php --}}
@extends('layouts.main2')

@section('navbar')
    @include('whistleblower.admin.navbar')
@endsection

@section('konten')
<div class="container">
    <div class="row">
        <div class="col-12">
            <!-- Header -->
            <div class="d-flex justify-content-between align-items-center mb-4">
                <div>
                    <h2>Dashboard Admin PPKPT</h2>
                    <p class="text-muted">
                        {{ session('selected_role') }} - Sistem Pencegahan dan Penanganan Kekerasan Seksual
                    </p>
                    @if(session('selected_role') === 'Admin PPKPT Prodi')
                        <small class="badge bg-info">
                            <i class="fas fa-building"></i> 
                            Unit Kerja: {{ auth()->user()->unit_kerja ?? 'Belum diset' }}
                        </small>
                    @endif
                </div>
                <div>
                    <a href="{{ route('whistleblower.admin.pengaduan.index') }}" class="btn btn-primary">
                        <i class="fas fa-list"></i> Kelola Pengaduan
                    </a>
                </div>
            </div>

            <!-- Statistics Cards -->
            <div class="row mb-4">
                <div class="col-md-2">
                    <div class="card bg-primary text-white">
                        <div class="card-body text-center">
                            <h3>{{ $stats['total_pengaduan'] }}</h3>
                            <p class="mb-0">Total Pengaduan</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-2">
                    <div class="card bg-warning text-white">
                        <div class="card-body text-center">
                            <h3>{{ $stats['pending'] }}</h3>
                            <p class="mb-0">Menunggu Review</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-2">
                    <div class="card bg-info text-white">
                        <div class="card-body text-center">
                            <h3>{{ $stats['proses'] }}</h3>
                            <p class="mb-0">Dalam Proses</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-2">
                    <div class="card bg-success text-white">
                        <div class="card-body text-center">
                            <h3>{{ $stats['selesai'] }}</h3>
                            <p class="mb-0">Selesai</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-2">
                    <div class="card bg-dark text-white">
                        <div class="card-body text-center">
                            <h3>{{ $stats['hari_ini'] }}</h3>
                            <p class="mb-0">Hari Ini</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-2">
                    <div class="card bg-secondary text-white">
                        <div class="card-body text-center">
                            <h3>{{ $stats['minggu_ini'] }}</h3>
                            <p class="mb-0">Minggu Ini</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Quick Actions untuk Admin -->
            <div class="row mb-4">
                <div class="col-md-3">
                    <div class="card border-danger">
                        <div class="card-body text-center">
                            <i class="fas fa-exclamation-triangle fa-3x text-danger mb-3"></i>
                            <h5>Pengaduan Prioritas</h5>
                            <p class="text-muted">{{ $stats['pending'] }} pending > 3 hari</p>
                            <a href="{{ route('whistleblower.admin.pengaduan.index') }}?filter=prioritas" class="btn btn-danger">Review</a>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card border-warning">
                        <div class="card-body text-center">
                            <i class="fas fa-clock fa-3x text-warning mb-3"></i>
                            <h5>Menunggu Review</h5>
                            <p class="text-muted">{{ $stats['pending'] }} pengaduan baru</p>
                            <a href="{{ route('whistleblower.admin.pengaduan.index') }}?status=pending" class="btn btn-warning">Lihat</a>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card border-info">
                        <div class="card-body text-center">
                            <i class="fas fa-chart-line fa-3x text-info mb-3"></i>
                            <h5>Laporan</h5>
                            <p class="text-muted">Generate laporan statistik</p>
                            <a href="#" class="btn btn-info" data-bs-toggle="modal" data-bs-target="#modalLaporan">Generate</a>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card border-success">
                        <div class="card-body text-center">
                            <i class="fas fa-cog fa-3x text-success mb-3"></i>
                            <h5>Kelola Pengaduan</h5>
                            <p class="text-muted">Akses semua pengaduan</p>
                            <a href="{{ route('whistleblower.admin.pengaduan.index') }}" class="btn btn-success">Kelola</a>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Info Scope Admin -->
            <div class="alert alert-info mb-4">
                <h6><i class="fas fa-info-circle"></i> Scope Pengelolaan Anda</h6>
                @if(session('selected_role') === 'Admin PPKPT Fakultas')
                    <p class="mb-0">
                        <strong>Admin Fakultas:</strong> Anda dapat mengelola SEMUA pengaduan dari seluruh prodi di fakultas ini.
                        Anda memiliki akses penuh untuk mereview, memproses, dan menyelesaikan pengaduan.
                    </p>
                @elseif(session('selected_role') === 'Admin PPKPT Prodi')
                    <p class="mb-0">
                        <strong>Admin Prodi:</strong> Anda mengelola pengaduan dari unit kerja/prodi {{ auth()->user()->unit_kerja ?? 'Anda' }} saja.
                        Koordinasikan dengan Admin Fakultas untuk kasus yang memerlukan escalation.
                    </p>
                @endif
            </div>

            <div class="row">
                <!-- Pengaduan Prioritas -->
                <div class="col-md-6">
                    <div class="card">
                        <div class="card-header bg-danger text-white">
                            <h5 class="mb-0">
                                <i class="fas fa-exclamation-triangle"></i> Pengaduan Prioritas
                            </h5>
                        </div>
                        <div class="card-body">
                            @if($pengaduan_prioritas->count() > 0)
                                <div class="table-responsive">
                                    <table class="table table-sm">
                                        <thead>
                                            <tr>
                                                <th>Kode</th>
                                                <th>Kategori</th>
                                                <th>Tanggal</th>
                                                <th>Aksi</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($pengaduan_prioritas as $pengaduan)
                                            <tr>
                                                <td>
                                                    <strong>{{ $pengaduan->kode_pengaduan }}</strong>
                                                </td>
                                                <td>
                                                    <span class="badge bg-secondary text-white">
                                                        {{ $pengaduan->kategori->nama ?? 'Lainnya' }}
                                                    </span>
                                                </td>
                                                <td>
                                                    {{ $pengaduan->created_at->format('d/m/Y') }}
                                                    <br>
                                                    <small class="text-danger">
                                                        {{ $pengaduan->created_at->diffForHumans() }}
                                                    </small>
                                                </td>
                                                <td>
                                                    <a href="{{ route('whistleblower.admin.pengaduan.show', $pengaduan->id) }}" 
                                                       class="btn btn-sm btn-danger">
                                                        <i class="fas fa-eye"></i>
                                                    </a>
                                                </td>
                                            </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            @else
                                <div class="text-center py-3">
                                    <i class="fas fa-check-circle fa-2x text-success mb-2"></i>
                                    <p class="text-muted mb-0">Tidak ada pengaduan prioritas</p>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>

                <!-- Pengaduan Terbaru -->
                <div class="col-md-6">
                    <div class="card">
                        <div class="card-header">
                            <h5 class="mb-0">Pengaduan Terbaru</h5>
                        </div>
                        <div class="card-body">
                            @if($pengaduan_terbaru->count() > 0)
                                <div class="table-responsive">
                                    <table class="table table-sm">
                                        <thead>
                                            <tr>
                                                <th>Kode</th>
                                                <th>Status</th>
                                                <th>Tanggal</th>
                                                <th>Aksi</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($pengaduan_terbaru->take(5) as $pengaduan)
                                            <tr>
                                                <td>
                                                    <strong>{{ $pengaduan->kode_pengaduan }}</strong>
                                                </td>
                                                <td>
                                                    @if($pengaduan->status_pengaduan == 'pending')
                                                        <span class="badge bg-warning">Menunggu</span>
                                                    @elseif($pengaduan->status_pengaduan == 'proses')
                                                        <span class="badge bg-info">Proses</span>
                                                    @else
                                                        <span class="badge bg-success">Selesai</span>
                                                    @endif
                                                </td>
                                                <td>{{ $pengaduan->created_at->format('d/m/Y H:i') }}</td>
                                                <td>
                                                    <a href="{{ route('whistleblower.admin.pengaduan.show', $pengaduan->id) }}" 
                                                       class="btn btn-sm btn-outline-primary">
                                                        <i class="fas fa-eye"></i>
                                                    </a>
                                                </td>
                                            </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                                <div class="text-center mt-3">
                                    <a href="{{ route('whistleblower.admin.pengaduan.index') }}" class="btn btn-outline-primary">
                                        Lihat Semua <i class="fas fa-arrow-right"></i>
                                    </a>
                                </div>
                            @else
                                <div class="text-center py-3">
                                    <i class="fas fa-inbox fa-2x text-muted mb-2"></i>
                                    <p class="text-muted mb-0">Belum ada pengaduan</p>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal Laporan -->
<div class="modal fade" id="modalLaporan" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Generate Laporan</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <form>
                    <div class="mb-3">
                        <label class="form-label">Periode</label>
                        <select class="form-select">
                            <option>Bulan Ini</option>
                            <option>3 Bulan Terakhir</option>
                            <option>6 Bulan Terakhir</option>
                            <option>1 Tahun Terakhir</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Format</label>
                        <select class="form-select">
                            <option>PDF</option>
                            <option>Excel</option>
                        </select>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                <button type="button" class="btn btn-primary">Generate Laporan</button>
            </div>
        </div>
    </div>
</div>
@endsection