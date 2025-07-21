{{-- resources/views/whistleblower/admin/dashboard.blade.php --}}
@extends('layouts.main2')

@section('navbar')
    @include('whistleblower.admin.navbar')
@endsection

@push('styles')
<style>
/* Border fixes untuk dropdown */
.form-select {
    border: 1px solid #ced4da !important;
}

.form-control {
    border: 1px solid #ced4da !important;
}

.form-select:focus {
    border-color: #86b7fe !important;
    box-shadow: 0 0 0 0.25rem rgba(13, 110, 253, 0.25) !important;
}

.form-control:focus {
    border-color: #86b7fe !important;
    box-shadow: 0 0 0 0.25rem rgba(13, 110, 253, 0.25) !important;
}

.card {
    border: 1px solid #dee2e6;
    box-shadow: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.075);
}

.stats-card {
    transition: transform 0.2s;
}

.stats-card:hover {
    transform: translateY(-5px);
}
</style>
@endpush

@section('konten')
<div class="container">
    <div class="row">
        <div class="col-12">
            <!-- Header -->
            <div class="d-flex justify-content-between align-items-center mb-4">
                <div>
                    <h2>Dashboard Admin PPKPT</h2>
                    <p class="text-muted">
                        <i class="fas fa-user-shield"></i> 
                        {{ session('selected_role') }} - Sistem Pencegahan dan Penanganan Kekerasan Seksual
                    </p>
                    <div class="d-flex gap-3">
                        <small class="text-info">
                            <i class="fas fa-envelope"></i> 
                            Email: {{ auth()->user()->email }}
                        </small>
                        @if(session('selected_role') === 'Admin PPKPT Prodi')
                            <small class="badge bg-info">
                                <i class="fas fa-building"></i> 
                                Unit Kerja: {{ auth()->user()->unit_kerja ?? 'Belum diset' }}
                            </small>
                        @endif
                    </div>
                </div>
                <div>
                    <a href="{{ route('whistleblower.create') }}" class="btn btn-outline-primary me-2">
                        <i class="fas fa-plus"></i> Buat Laporan
                    </a>
                    <div class="btn-group">
                        <button type="button" class="btn btn-primary dropdown-toggle" data-bs-toggle="dropdown">
                            <i class="fas fa-cog"></i> Kelola
                        </button>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="{{ route('whistleblower.admin.pengaduan.index') }}">
                                <i class="fas fa-list"></i> Semua Pengaduan
                            </a></li>
                            <li><a class="dropdown-item" href="{{ route('whistleblower.admin.pengaduan.pending') }}">
                                <i class="fas fa-clock"></i> Pengaduan Pending
                            </a></li>
                            <li><a class="dropdown-item" href="{{ route('whistleblower.admin.kategori.index') }}">
                                <i class="fas fa-tags"></i> Kelola Kategori
                            </a></li>
                            <li><hr class="dropdown-divider"></li>
                            <li><a class="dropdown-item" href="{{ route('whistleblower.admin.laporan') }}">
                                <i class="fas fa-chart-bar"></i> Laporan & Statistik
                            </a></li>
                        </ul>
                    </div>
                </div>
            </div>

            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <i class="fas fa-check-circle"></i>
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            @if(session('error'))
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <i class="fas fa-exclamation-triangle"></i>
                    {{ session('error') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            <!-- Statistics Cards -->
            <div class="row mb-4">
                <div class="col-md-2 mb-3">
                    <div class="card bg-primary text-white stats-card">
                        <div class="card-body text-center">
                            <i class="fas fa-file-alt fa-2x mb-2"></i>
                            <h3>{{ $stats['total_pengaduan'] }}</h3>
                            <p class="mb-0">Total Pengaduan</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-2 mb-3">
                    <div class="card bg-warning text-white stats-card">
                        <div class="card-body text-center">
                            <i class="fas fa-clock fa-2x mb-2"></i>
                            <h3>{{ $stats['pending'] }}</h3>
                            <p class="mb-0">Menunggu Review</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-2 mb-3">
                    <div class="card bg-info text-white stats-card">
                        <div class="card-body text-center">
                            <i class="fas fa-spinner fa-2x mb-2"></i>
                            <h3>{{ $stats['proses'] }}</h3>
                            <p class="mb-0">Dalam Proses</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-2 mb-3">
                    <div class="card bg-success text-white stats-card">
                        <div class="card-body text-center">
                            <i class="fas fa-check fa-2x mb-2"></i>
                            <h3>{{ $stats['selesai'] }}</h3>
                            <p class="mb-0">Selesai</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-2 mb-3">
                    <div class="card bg-danger text-white stats-card">
                        <div class="card-body text-center">
                            <i class="fas fa-times fa-2x mb-2"></i>
                            <h3>{{ $stats['ditolak'] ?? 0 }}</h3>
                            <p class="mb-0">Ditolak</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-2 mb-3">
                    <div class="card bg-secondary text-white stats-card">
                        <div class="card-body text-center">
                            <i class="fas fa-exclamation fa-2x mb-2"></i>
                            <h3>{{ $stats['butuh_bukti'] ?? 0 }}</h3>
                            <p class="mb-0">Butuh Bukti</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Quick Actions for Admin -->
            <div class="row mb-4">
                <div class="col-md-3 mb-3">
                    <div class="card border-warning">
                        <div class="card-body text-center">
                            <i class="fas fa-clock fa-3x text-warning mb-3"></i>
                            <h5>Pengaduan Pending</h5>
                            <p class="text-muted">Review pengaduan yang menunggu</p>
                            <a href="{{ route('whistleblower.admin.pengaduan.pending') }}" class="btn btn-warning">
                                Review ({{ $stats['pending'] }})
                            </a>
                        </div>
                    </div>
                </div>
                <div class="col-md-3 mb-3">
                    <div class="card border-info">
                        <div class="card-body text-center">
                            <i class="fas fa-list fa-3x text-info mb-3"></i>
                            <h5>Kelola Pengaduan</h5>
                            <p class="text-muted">Lihat dan kelola semua pengaduan</p>
                            <a href="{{ route('whistleblower.admin.pengaduan.index') }}" class="btn btn-info">Kelola</a>
                        </div>
                    </div>
                </div>
                <div class="col-md-3 mb-3">
                    <div class="card border-success">
                        <div class="card-body text-center">
                            <i class="fas fa-chart-bar fa-3x text-success mb-3"></i>
                            <h5>Laporan & Statistik</h5>
                            <p class="text-muted">Lihat laporan dan analisis data</p>
                            <a href="{{ route('whistleblower.admin.laporan') }}" class="btn btn-success">Lihat Laporan</a>
                        </div>
                    </div>
                </div>
                <div class="col-md-3 mb-3">
                    <div class="card border-primary">
                        <div class="card-body text-center">
                            <i class="fas fa-tags fa-3x text-primary mb-3"></i>
                            <h5>Kelola Kategori</h5>
                            <p class="text-muted">Atur kategori pengaduan</p>
                            <a href="{{ route('whistleblower.admin.kategori.index') }}" class="btn btn-primary">Kelola</a>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Recent Reports -->
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header d-flex justify-content-between align-items-center">
                            <h5 class="mb-0">
                                <i class="fas fa-history"></i> Pengaduan Terbaru
                            </h5>
                            <a href="{{ route('whistleblower.admin.pengaduan.index') }}" class="btn btn-sm btn-outline-primary">
                                Lihat Semua
                            </a>
                        </div>
                        <div class="card-body">
                            @if($pengaduan->count() > 0)
                                <div class="table-responsive">
                                    <table class="table table-hover">
                                        <thead class="table-light">
                                            <tr>
                                                <th>Kode Pengaduan</th>
                                                <th>Pelapor</th>
                                                <th>Kategori</th>
                                                <th>Status</th>
                                                <th>Terlapor</th>
                                                <th>Tanggal</th>
                                                <th>Aksi</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($pengaduan as $item)
                                                <tr>
                                                    <td>
                                                        @if($item->anonymous)
                                                            <span class="text-muted">Anonim</span>
                                                        @else
                                                            {{ $item->nama_pelapor ?? 'N/A' }}
                                                            <br><small class="text-muted">{{ $item->email_pelapor }}</small>
                                                        @endif
                                                    </td>
                                                    <td>
                                                        <span class="badge bg-light text-dark">
                                                            {{ $item->nama_kategori ?? 'Tidak ada kategori' }}
                                                        </span>
                                                    </td>
                                                    <td>
                                                        @php
                                                            $statusClass = match($item->status_pengaduan) {
                                                                'pending' => 'bg-warning',
                                                                'proses' => 'bg-info',
                                                                'selesai' => 'bg-success',
                                                                'ditolak' => 'bg-danger',
                                                                'butuh_bukti' => 'bg-secondary',
                                                                'dibatalkan' => 'bg-dark',
                                                                default => 'bg-light text-dark'
                                                            };
                                                            
                                                            $statusText = match($item->status_pengaduan) {
                                                                'pending' => 'Menunggu',
                                                                'proses' => 'Diproses',
                                                                'selesai' => 'Selesai',
                                                                'ditolak' => 'Ditolak',
                                                                'butuh_bukti' => 'Butuh Bukti',
                                                                'dibatalkan' => 'Dibatalkan',
                                                                default => 'Unknown'
                                                            };
                                                        @endphp
                                                        
                                                        <span class="badge {{ $statusClass }}">
                                                            {{ $statusText }}
                                                        </span>
                                                    </td>
                                                    <td>
                                                        {{ $item->nama_terlapor ?? 'Tidak disebutkan' }}
                                                    </td>
                                                    <td>
                                                        <small>
                                                            {{ \Carbon\Carbon::parse($item->created_at)->format('d/m/Y H:i') }}
                                                        </small>
                                                    </td>
                                                    <td>
                                                        <div class="btn-group btn-group-sm">
                                                            <a href="{{ route('whistleblower.show', $item->id) }}" 
                                                               class="btn btn-outline-primary btn-sm">
                                                                <i class="fas fa-eye"></i> Detail
                                                            </a>
                                                            
                                                            @if($item->status_pengaduan === 'pending')
                                                                <div class="btn-group btn-group-sm">
                                                                    <button type="button" class="btn btn-outline-success btn-sm dropdown-toggle" 
                                                                            data-bs-toggle="dropdown">
                                                                        <i class="fas fa-check"></i> Proses
                                                                    </button>
                                                                    <ul class="dropdown-menu">
                                                                        <li><a class="dropdown-item" href="#" 
                                                                               onclick="updateStatus('{{ $item->id }}', 'proses')">
                                                                            <i class="fas fa-play text-info"></i> Proses
                                                                        </a></li>
                                                                        <li><a class="dropdown-item" href="#" 
                                                                               onclick="updateStatus('{{ $item->id }}', 'butuh_bukti')">
                                                                            <i class="fas fa-exclamation text-warning"></i> Butuh Bukti
                                                                        </a></li>
                                                                        <li><a class="dropdown-item" href="#" 
                                                                               onclick="updateStatus('{{ $item->id }}', 'ditolak')">
                                                                            <i class="fas fa-times text-danger"></i> Tolak
                                                                        </a></li>
                                                                    </ul>
                                                                </div>
                                                            @endif
                                                        </div>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                                
                                <!-- Pagination -->
                                <div class="d-flex justify-content-center">
                                    {{ $pengaduan->links() }}
                                </div>
                            @else
                                <div class="text-center py-4">
                                    <i class="fas fa-inbox fa-3x text-muted mb-3"></i>
                                    <h5 class="text-muted">Belum Ada Pengaduan</h5>
                                    <p class="text-muted">Belum ada pengaduan yang masuk ke sistem.</p>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal Update Status -->
<div class="modal fade" id="modalUpdateStatus" tabindex="-1" aria-labelledby="modalUpdateStatusLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalUpdateStatusLabel">
                    <i class="fas fa-edit"></i> Update Status Pengaduan
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="formUpdateStatus" method="POST">
                @csrf
                @method('PATCH')
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="status_pengaduan" class="form-label">Status Pengaduan</label>
                        <select class="form-select" id="status_pengaduan" name="status_pengaduan" required>
                            <option value="">Pilih Status</option>
                            <option value="pending">Menunggu</option>
                            <option value="proses">Dalam Proses</option>
                            <option value="selesai">Selesai</option>
                            <option value="ditolak">Ditolak</option>
                            <option value="butuh_bukti">Butuh Bukti Tambahan</option>
                        </select>
                    </div>
                    
                    <div class="mb-3">
                        <label for="keterangan_admin" class="form-label">Keterangan (Opsional)</label>
                        <textarea class="form-control" id="keterangan_admin" name="keterangan_admin" 
                                  rows="3" placeholder="Berikan keterangan terkait update status..."></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save"></i> Update Status
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
function updateStatus(id, status = null) {
    const modal = new bootstrap.Modal(document.getElementById('modalUpdateStatus'));
    const form = document.getElementById('formUpdateStatus');
    const statusSelect = document.getElementById('status_pengaduan');
    
    // Set form action
    form.action = `/whistleblower/${id}/update-status`;
    
    // Pre-select status if provided
    if (status) {
        statusSelect.value = status;
    } else {
        statusSelect.value = '';
    }
    
    // Clear previous keterangan
    document.getElementById('keterangan_admin').value = '';
    
    modal.show();
}

// Auto-dismiss alerts
document.addEventListener('DOMContentLoaded', function() {
    setTimeout(function() {
        const alerts = document.querySelectorAll('.alert-dismissible');
        alerts.forEach(function(alert) {
            const bsAlert = new bootstrap.Alert(alert);
            bsAlert.close();
        });
    }, 5000);
});
</script>
@endpush
                                                        <strong>{{ $item->kode_pengaduan ?? 'N/A' }}</strong>
                                                        @if($item->anonymous)
                                                            <span class="badge bg-secondary ms-1">Anonim</span>
                                                        @endif
                                                    </td>
                                                    <td>