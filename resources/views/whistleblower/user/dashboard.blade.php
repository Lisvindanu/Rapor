{{-- resources/views/whistleblower/user/dashboard.blade.php --}}
@extends('layouts.main2')

@section('navbar')
    @include('whistleblower.user.navbar')
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
                    <h2>Dashboard Whistleblower</h2>
                    <p class="text-muted">
                        <i class="fas fa-user"></i> 
                        Selamat datang, <strong>{{ auth()->user()->name }}</strong>
                    </p>
                    <small class="text-info">
                        <i class="fas fa-envelope"></i> 
                        Email: {{ auth()->user()->email }}
                    </small>
                </div>
                <div>
                    <a href="{{ route('whistleblower.create') }}" class="btn btn-danger">
                        <i class="fas fa-plus"></i> Buat Laporan
                    </a>
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
                <div class="col-md-3 mb-3">
                    <div class="card bg-primary text-white stats-card">
                        <div class="card-body text-center">
                            <i class="fas fa-file-alt fa-2x mb-2"></i>
                            <h3>{{ $stats['total_pengaduan'] }}</h3>
                            <p class="mb-0">Total Pengaduan</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-3 mb-3">
                    <div class="card bg-warning text-white stats-card">
                        <div class="card-body text-center">
                            <i class="fas fa-clock fa-2x mb-2"></i>
                            <h3>{{ $stats['pending'] }}</h3>
                            <p class="mb-0">Menunggu Review</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-3 mb-3">
                    <div class="card bg-info text-white stats-card">
                        <div class="card-body text-center">
                            <i class="fas fa-spinner fa-2x mb-2"></i>
                            <h3>{{ $stats['proses'] }}</h3>
                            <p class="mb-0">Dalam Proses</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-3 mb-3">
                    <div class="card bg-success text-white stats-card">
                        <div class="card-body text-center">
                            <i class="fas fa-check fa-2x mb-2"></i>
                            <h3>{{ $stats['selesai'] }}</h3>
                            <p class="mb-0">Selesai</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Quick Actions -->
            <div class="row mb-4">
                <div class="col-md-4 mb-3">
                    <div class="card border-danger">
                        <div class="card-body text-center">
                            <i class="fas fa-plus-circle fa-3x text-danger mb-3"></i>
                            <h5>Buat Laporan Baru</h5>
                            <p class="text-muted">Laporkan insiden yang terjadi</p>
                            <a href="{{ route('whistleblower.create') }}" class="btn btn-danger">Lapor Sekarang</a>
                        </div>
                    </div>
                </div>
                <div class="col-md-4 mb-3">
                    <div class="card border-info">
                        <div class="card-body text-center">
                            <i class="fas fa-list fa-3x text-info mb-3"></i>
                            <h5>Riwayat Laporan</h5>
                            <p class="text-muted">Lihat pengaduan yang pernah dibuat</p>
                            <button class="btn btn-info" onclick="scrollToReports()">Lihat Riwayat</button>
                        </div>
                    </div>
                </div>
                <div class="col-md-4 mb-3">
                    <div class="card border-success">
                        <div class="card-body text-center">
                            <i class="fas fa-phone fa-3x text-success mb-3"></i>
                            <h5>Kontak Darurat</h5>
                            <p class="text-muted">Hubungi tim PPKPT</p>
                            <button class="btn btn-success" data-bs-toggle="modal" data-bs-target="#modalKontak">Kontak</button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Recent Reports -->
            <div class="row" id="reports-section">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h5 class="mb-0">
                                <i class="fas fa-history"></i> Riwayat Pengaduan Anda
                            </h5>
                        </div>
                        <div class="card-body">
                            @if($pengaduan->count() > 0)
                                <div class="table-responsive">
                                    <table class="table table-hover">
                                        <thead class="table-light">
                                            <tr>
                                                <th>Kode Pengaduan</th>
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
                                                        <strong>{{ $item->kode_pengaduan ?? 'N/A' }}</strong>
                                                        @if($item->anonymous)
                                                            <span class="badge bg-secondary ms-1">Anonim</span>
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
                                                            
                                                            @if(in_array($item->status_pengaduan, ['pending', 'butuh_bukti']))
                                                                <button type="button" 
                                                                        class="btn btn-outline-danger btn-sm"
                                                                        onclick="cancelPengaduan('{{ $item->id }}', '{{ $item->kode_pengaduan }}')">
                                                                    <i class="fas fa-times"></i> Batal
                                                                </button>
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
                                    <p class="text-muted">Anda belum pernah membuat laporan pengaduan.</p>
                                    <a href="{{ route('whistleblower.create') }}" class="btn btn-danger">
                                        <i class="fas fa-plus"></i> Buat Laporan Pertama
                                    </a>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal Kontak -->
<div class="modal fade" id="modalKontak" tabindex="-1" aria-labelledby="modalKontakLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalKontakLabel">
                    <i class="fas fa-phone"></i> Kontak Darurat PPKPT
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="text-center mb-3">
                    <i class="fas fa-shield-alt fa-3x text-success"></i>
                    <h5 class="mt-2">Tim PPKPT Universitas Jenderal Achmad Yani</h5>
                </div>
                
                <div class="list-group">
                    <div class="list-group-item">
                        <div class="d-flex align-items-center">
                            <i class="fas fa-envelope text-primary me-3"></i>
                            <div>
                                <strong>Email</strong><br>
                                <a href="mailto:ppkpt@unjaya.ac.id">ppkpt@unjaya.ac.id</a>
                            </div>
                        </div>
                    </div>
                    
                    <div class="list-group-item">
                        <div class="d-flex align-items-center">
                            <i class="fas fa-phone text-success me-3"></i>
                            <div>
                                <strong>Telepon</strong><br>
                                <a href="tel:+622287789000">(022) 8778-9000</a>
                            </div>
                        </div>
                    </div>
                    
                    <div class="list-group-item">
                        <div class="d-flex align-items-center">
                            <i class="fab fa-whatsapp text-success me-3"></i>
                            <div>
                                <strong>WhatsApp</strong><br>
                                <a href="https://wa.me/6282877890000" target="_blank">+62 828-7789-0000</a>
                            </div>
                        </div>
                    </div>
                    
                    <div class="list-group-item">
                        <div class="d-flex align-items-center">
                            <i class="fas fa-map-marker-alt text-danger me-3"></i>
                            <div>
                                <strong>Alamat</strong><br>
                                Gedung Rektorat Lt. 2<br>
                                Universitas Jenderal Achmad Yani<br>
                                Cimahi, Jawa Barat
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="alert alert-info mt-3">
                    <i class="fas fa-info-circle"></i>
                    <strong>Jam Operasional:</strong><br>
                    Senin - Jumat: 08:00 - 16:00 WIB<br>
                    Darurat: 24/7 (WhatsApp)
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
function scrollToReports() {
    document.getElementById('reports-section').scrollIntoView({ 
        behavior: 'smooth' 
    });
}

function cancelPengaduan(id, kode) {
    if (confirm(`Apakah Anda yakin ingin membatalkan pengaduan ${kode}?\n\nPengaduan yang dibatalkan tidak dapat dikembalikan.`)) {
        // Create form and submit
        const form = document.createElement('form');
        form.method = 'POST';
        form.action = `/whistleblower/${id}/cancel`;
        
        // Add CSRF token
        const csrfToken = document.createElement('input');
        csrfToken.type = 'hidden';
        csrfToken.name = '_token';
        csrfToken.value = '{{ csrf_token() }}';
        form.appendChild(csrfToken);
        
        // Add method override
        const methodField = document.createElement('input');
        methodField.type = 'hidden';
        methodField.name = '_method';
        methodField.value = 'PATCH';
        form.appendChild(methodField);
        
        document.body.appendChild(form);
        form.submit();
    }
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