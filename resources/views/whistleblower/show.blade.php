{{-- resources/views/whistleblower/show.blade.php --}}
@extends('layouts.main2')

@section('navbar')
    @include('whistleblower.navbar')
@endsection

@section('konten')
<div class="container">
    <div class="row">
        <div class="col-md-8">
            <!-- Header -->
            <div class="d-flex justify-content-between align-items-center mb-4">
                <div>
                    <h2>Detail Pengaduan</h2>
                    <p class="text-muted">{{ $pengaduan->kode_pengaduan }}</p>
                </div>
                <div>
                    <a href="{{ route('whistleblower.index') }}" class="btn btn-secondary">
                        <i class="fas fa-arrow-left"></i> Kembali
                    </a>
                </div>
            </div>

            <!-- Status Card -->
            <div class="card mb-4">
                <div class="card-body">
                    <div class="row align-items-center">
                        <div class="col-md-6">
                            <h5 class="mb-1">Status Pengaduan</h5>
                            @if($pengaduan->status_pengaduan == 'pending')
                                <span class="badge bg-warning fs-6">
                                    <i class="fas fa-clock"></i> Menunggu Review
                                </span>
                            @elseif($pengaduan->status_pengaduan == 'proses')
                                <span class="badge bg-info fs-6">
                                    <i class="fas fa-spinner"></i> Dalam Proses
                                </span>
                            @elseif($pengaduan->status_pengaduan == 'selesai')
                                <span class="badge bg-success fs-6">
                                    <i class="fas fa-check"></i> Selesai
                                </span>
                            @else
                                <span class="badge bg-danger fs-6">
                                    <i class="fas fa-times"></i> Ditolak
                                </span>
                            @endif
                        </div>
                        <div class="col-md-6 text-end">
                            <small class="text-muted">
                                Dibuat: {{ $pengaduan->tanggal_pengaduan->format('d F Y, H:i') }}
                            </small>
                            @if($pengaduan->is_anonim)
                                <br><span class="badge bg-info">Anonim</span>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            <!-- Detail Pengaduan -->
            <div class="card mb-4">
                <div class="card-header">
                    <h5 class="mb-0">
                        <i class="fas fa-file-alt"></i> Informasi Pengaduan
                    </h5>
                </div>
                <div class="card-body">
                    <div class="row mb-3">
                        <div class="col-md-3">
                            <strong>Kategori:</strong>
                        </div>
                        <div class="col-md-9">
                            <span class="badge bg-secondary">{{ $pengaduan->kategori->nama ?? 'Lainnya' }}</span>
                        </div>
                    </div>
                    
                    <div class="row mb-3">
                        <div class="col-md-3">
                            <strong>Judul:</strong>
                        </div>
                        <div class="col-md-9">
                            {{ $pengaduan->judul_pengaduan }}
                        </div>
                    </div>
                    
                    <div class="row mb-3">
                        <div class="col-md-3">
                            <strong>Deskripsi:</strong>
                        </div>
                        <div class="col-md-9">
                            <div class="bg-light p-3 rounded">
                                {!! nl2br(e($pengaduan->deskripsi_pengaduan)) !!}
                            </div>
                        </div>
                    </div>

                    @if($pengaduan->evidence_path)
                    <div class="row">
                        <div class="col-md-3">
                            <strong>Bukti:</strong>
                        </div>
                        <div class="col-md-9">
                            <a href="{{ Storage::url($pengaduan->evidence_path) }}" 
                               class="btn btn-outline-primary btn-sm" target="_blank">
                                <i class="fas fa-download"></i> Lihat Bukti
                            </a>
                        </div>
                    </div>
                    @endif
                </div>
            </div>

            <!-- Response dari Admin -->
            @if($pengaduan->admin_response)
            <div class="card mb-4">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0">
                        <i class="fas fa-reply"></i> Tanggapan Tim PPKPT
                    </h5>
                </div>
                <div class="card-body">
                    <div class="bg-light p-3 rounded">
                        {!! nl2br(e($pengaduan->admin_response)) !!}
                    </div>
                    @if($pengaduan->handled_by)
                    <div class="mt-3">
                        <small class="text-muted">
                            Ditangani oleh: {{ $pengaduan->handler->name ?? 'Tim PPKPT' }}
                        </small>
                    </div>
                    @endif
                </div>
            </div>
            @endif

            <!-- Timeline -->
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">
                        <i class="fas fa-history"></i> Timeline Pengaduan
                    </h5>
                </div>
                <div class="card-body">
                    <div class="timeline">
                        <div class="timeline-item">
                            <div class="timeline-marker bg-primary"></div>
                            <div class="timeline-content">
                                <h6 class="timeline-title">Pengaduan Dibuat</h6>
                                <p class="timeline-text">
                                    Pengaduan dengan kode {{ $pengaduan->kode_pengaduan }} telah berhasil dibuat
                                </p>
                                <small class="text-muted">{{ $pengaduan->created_at->format('d F Y, H:i') }}</small>
                            </div>
                        </div>

                        @if($pengaduan->status_pengaduan != 'pending')
                        <div class="timeline-item">
                            <div class="timeline-marker bg-info"></div>
                            <div class="timeline-content">
                                <h6 class="timeline-title">Pengaduan Diproses</h6>
                                <p class="timeline-text">
                                    Tim PPKPT telah mulai memproses pengaduan Anda
                                </p>
                                <small class="text-muted">{{ $pengaduan->updated_at->format('d F Y, H:i') }}</small>
                            </div>
                        </div>
                        @endif

                        @if($pengaduan->status_pengaduan == 'selesai')
                        <div class="timeline-item">
                            <div class="timeline-marker bg-success"></div>
                            <div class="timeline-content">
                                <h6 class="timeline-title">Pengaduan Selesai</h6>
                                <p class="timeline-text">
                                    Pengaduan telah selesai ditangani oleh tim PPKPT
                                </p>
                                <small class="text-muted">{{ $pengaduan->closed_at?->format('d F Y, H:i') ?? $pengaduan->updated_at->format('d F Y, H:i') }}</small>
                            </div>
                        </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        <!-- Sidebar -->
        <div class="col-md-4">
            <!-- Quick Info -->
            <div class="card mb-4">
                <div class="card-header">
                    <h6 class="mb-0">
                        <i class="fas fa-info-circle"></i> Informasi Cepat
                    </h6>
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <small class="text-muted">Kode Pengaduan</small>
                        <div class="fw-bold">{{ $pengaduan->kode_pengaduan }}</div>
                    </div>
                    <div class="mb-3">
                        <small class="text-muted">Status</small>
                        <div>
                            @if($pengaduan->status_pengaduan == 'pending')
                                <span class="badge bg-warning">Menunggu Review</span>
                            @elseif($pengaduan->status_pengaduan == 'proses')
                                <span class="badge bg-info">Dalam Proses</span>
                            @elseif($pengaduan->status_pengaduan == 'selesai')
                                <span class="badge bg-success">Selesai</span>
                            @else
                                <span class="badge bg-danger">Ditolak</span>
                            @endif
                        </div>
                    </div>
                    <div class="mb-3">
                        <small class="text-muted">Tanggal Dibuat</small>
                        <div>{{ $pengaduan->tanggal_pengaduan->format('d F Y') }}</div>
                    </div>
                    <div class="mb-0">
                        <small class="text-muted">Kategori</small>
                        <div>{{ $pengaduan->kategori->nama ?? 'Lainnya' }}</div>
                    </div>
                </div>
            </div>

            <!-- Actions -->
            @if($pengaduan->status_pengaduan == 'pending')
            <div class="card mb-4">
                <div class="card-header">
                    <h6 class="mb-0">
                        <i class="fas fa-cog"></i> Aksi
                    </h6>
                </div>
                <div class="card-body">
                    <div class="d-grid gap-2">
                        <button class="btn btn-outline-danger btn-sm" 
                                onclick="batalkanPengaduan('{{ $pengaduan->id }}')">
                            <i class="fas fa-times"></i> Batalkan Pengaduan
                        </button>
                    </div>
                    <small class="text-muted">
                        Anda hanya dapat membatalkan pengaduan yang masih dalam status "Menunggu Review"
                    </small>
                </div>
            </div>
            @endif

            <!-- Kontak Darurat -->
            <div class="card mb-4">
                <div class="card-header bg-danger text-white">
                    <h6 class="mb-0">
                        <i class="fas fa-phone"></i> Kontak Darurat
                    </h6>
                </div>
                <div class="card-body">
                    <div class="mb-2">
                        <strong>Hotline PPKPT:</strong><br>
                        <i class="fas fa-phone text-success"></i> 0274-123456
                    </div>
                    <div class="mb-2">
                        <strong>WhatsApp:</strong><br>
                        <i class="fab fa-whatsapp text-success"></i> 08123456789
                    </div>
                    <div class="mb-0">
                        <strong>Email:</strong><br>
                        <i class="fas fa-envelope text-primary"></i> ppkpt@university.ac.id
                    </div>
                </div>
            </div>

            <!-- Bantuan -->
            <div class="card">
                <div class="card-header">
                    <h6 class="mb-0">
                        <i class="fas fa-question-circle"></i> Butuh Bantuan?
                    </h6>
                </div>
                <div class="card-body">
                    <p class="small mb-3">
                        Jika Anda memiliki pertanyaan atau memerlukan bantuan terkait pengaduan ini, 
                        jangan ragu untuk menghubungi tim PPKPT.
                    </p>
                    <div class="d-grid">
                        <button class="btn btn-outline-primary btn-sm" 
                                data-bs-toggle="modal" data-bs-target="#modalKontak">
                            <i class="fas fa-headset"></i> Hubungi Tim PPKPT
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal Konfirmasi Batalkan -->
<div class="modal fade" id="modalBatalkan" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Konfirmasi Batalkan Pengaduan</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <p>Apakah Anda yakin ingin membatalkan pengaduan ini?</p>
                <div class="alert alert-warning">
                    <i class="fas fa-exclamation-triangle"></i>
                    <strong>Perhatian:</strong> Pengaduan yang dibatalkan tidak dapat dikembalikan.
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                <form id="formBatalkan" method="POST" style="display: inline;">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger">
                        <i class="fas fa-trash"></i> Ya, Batalkan
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Modal Kontak -->
<div class="modal fade" id="modalKontak" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title">
                    <i class="fas fa-phone"></i> Kontak Tim PPKPT
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-6">
                        <h6>Hotline</h6>
                        <p>
                            <i class="fas fa-phone text-success"></i> 0274-123456<br>
                            <small class="text-muted">24 jam setiap hari</small>
                        </p>
                        
                        <h6>WhatsApp</h6>
                        <p>
                            <i class="fab fa-whatsapp text-success"></i> 08123456789<br>
                            <small class="text-muted">Chat & Voice Call</small>
                        </p>
                    </div>
                    <div class="col-md-6">
                        <h6>Email</h6>
                        <p>
                            <i class="fas fa-envelope text-primary"></i> ppkpt@university.ac.id<br>
                            <small class="text-muted">Respon dalam 6 jam</small>
                        </p>
                        
                        <h6>Kode Pengaduan</h6>
                        <p>
                            <strong>{{ $pengaduan->kode_pengaduan }}</strong><br>
                            <small class="text-muted">Sebutkan kode ini saat menghubungi</small>
                        </p>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                <a href="tel:0274123456" class="btn btn-primary">
                    <i class="fas fa-phone"></i> Hubungi Sekarang
                </a>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
function batalkanPengaduan(id) {
    const form = document.getElementById('formBatalkan');
    form.action = `/whistleblower/${id}`;
    
    const modal = new bootstrap.Modal(document.getElementById('modalBatalkan'));
    modal.show();
}
</script>
@endpush

<style>
.timeline {
    position: relative;
    padding-left: 2rem;
}

.timeline-item {
    position: relative;
    margin-bottom: 2rem;
}

.timeline-item:before {
    content: '';
    position: absolute;
    left: -2rem;
    top: 0.5rem;
    width: 2px;
    height: calc(100% + 1rem);
    background-color: #dee2e6;
}

.timeline-item:last-child:before {
    display: none;
}

.timeline-marker {
    position: absolute;
    left: -2.5rem;
    top: 0.5rem;
    width: 1rem;
    height: 1rem;
    border-radius: 50%;
    border: 2px solid #fff;
    box-shadow: 0 0 0 2px #dee2e6;
}

.timeline-content {
    background-color: #f8f9fa;
    padding: 1rem;
    border-radius: 0.375rem;
    border-left: 3px solid #0d6efd;
}

.timeline-title {
    margin-bottom: 0.5rem;
    color: #495057;
}

.timeline-text {
    margin-bottom: 0.5rem;
    color: #6c757d;
}
</style>
@endsection