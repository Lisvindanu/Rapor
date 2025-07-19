{{-- resources/views/whistleblower/admin/show.blade.php --}}
@extends('layouts.admin')

@section('title', 'Detail Pengaduan')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <!-- Header -->
            <div class="d-flex justify-content-between align-items-center mb-4">
                <div>
                    <h2>Detail Pengaduan</h2>
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item">
                                <a href="{{ route('whistleblower.admin.dashboard') }}">Dashboard</a>
                            </li>
                            <li class="breadcrumb-item">
                                <a href="{{ route('whistleblower.admin.index') }}">Pengaduan</a>
                            </li>
                            <li class="breadcrumb-item active">{{ $pengaduan->kode_pengaduan }}</li>
                        </ol>
                    </nav>
                </div>
                <div>
                    <a href="{{ route('whistleblower.admin.index') }}" class="btn btn-outline-secondary">
                        <i class="fas fa-arrow-left"></i> Kembali
                    </a>
                </div>
            </div>

            <div class="row">
                <!-- Detail Pengaduan -->
                <div class="col-lg-8">
                    <div class="card mb-4">
                        <div class="card-header d-flex justify-content-between align-items-center">
                            <h5 class="mb-0">
                                <i class="fas fa-file-alt"></i> Informasi Pengaduan
                            </h5>
                            <span class="badge bg-{{ $pengaduan->status_badge }}">
                                {{ $pengaduan->status_label }}
                            </span>
                        </div>
                        <div class="card-body">
                            <div class="row mb-3">
                                <div class="col-sm-3"><strong>Kode Pengaduan:</strong></div>
                                <div class="col-sm-9">{{ $pengaduan->kode_pengaduan }}</div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-sm-3"><strong>Judul:</strong></div>
                                <div class="col-sm-9">{{ $pengaduan->judul_pengaduan }}</div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-sm-3"><strong>Kategori:</strong></div>
                                <div class="col-sm-9">
                                    <span class="badge bg-info">{{ $pengaduan->kategori->nama }}</span>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-sm-3"><strong>Status Pelapor:</strong></div>
                                <div class="col-sm-9">
                                    <span class="badge bg-{{ $pengaduan->status_pelapor === 'korban' ? 'danger' : 'warning' }}">
                                        {{ ucfirst($pengaduan->status_pelapor) }}
                                    </span>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-sm-3"><strong>Tanggal Pengaduan:</strong></div>
                                <div class="col-sm-9">{{ $pengaduan->tanggal_pengaduan->format('d/m/Y H:i:s') }}</div>
                            </div>
                            @if($pengaduan->tanggal_kejadian)
                            <div class="row mb-3">
                                <div class="col-sm-3"><strong>Tanggal Kejadian:</strong></div>
                                <div class="col-sm-9">{{ $pengaduan->tanggal_kejadian->format('d/m/Y') }}</div>
                            </div>
                            @endif
                            @if($pengaduan->lokasi_kejadian)
                            <div class="row mb-3">
                                <div class="col-sm-3"><strong>Lokasi Kejadian:</strong></div>
                                <div class="col-sm-9">{{ $pengaduan->lokasi_kejadian }}</div>
                            </div>
                            @endif
                            <div class="row mb-3">
                                <div class="col-sm-3"><strong>Memiliki Disabilitas:</strong></div>
                                <div class="col-sm-9">
                                    <span class="badge bg-{{ $pengaduan->memiliki_disabilitas ? 'warning' : 'secondary' }}">
                                        {{ $pengaduan->memiliki_disabilitas ? 'Ya' : 'Tidak' }}
                                    </span>
                                    @if($pengaduan->memiliki_disabilitas && $pengaduan->jenis_disabilitas)
                                        <br><small class="text-muted">{{ $pengaduan->jenis_disabilitas }}</small>
                                    @endif
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-sm-3"><strong>Anonim:</strong></div>
                                <div class="col-sm-9">
                                    <span class="badge bg-{{ $pengaduan->is_anonim ? 'dark' : 'light text-dark' }}">
                                        {{ $pengaduan->is_anonim ? 'Ya' : 'Tidak' }}
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Informasi Terlapor -->
                    <div class="card mb-4">
                        <div class="card-header">
                            <h5 class="mb-0">
                                <i class="fas fa-users"></i> Informasi Terlapor
                            </h5>
                        </div>
                        <div class="card-body">
                            @foreach($pengaduan->terlapor as $index => $terlapor)
                            <div class="border rounded p-3 mb-3 {{ $loop->last ? '' : 'border-bottom' }}">
                                <h6 class="fw-bold mb-3">Terlapor #{{ $index + 1 }}</h6>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="mb-2">
                                            <strong>Nama:</strong> {{ $terlapor->nama_terlapor }}
                                        </div>
                                        <div class="mb-2">
                                            <strong>Status:</strong> 
                                            <span class="badge bg-{{ $terlapor->status_terlapor === 'mahasiswa' ? 'primary' : 'success' }}">
                                                {{ $terlapor->status_label }}
                                            </span>
                                        </div>
                                        @if($terlapor->nomor_identitas)
                                        <div class="mb-2">
                                            <strong>{{ $terlapor->status_terlapor === 'mahasiswa' ? 'NIM' : 'NIP' }}:</strong> 
                                            {{ $terlapor->nomor_identitas }}
                                        </div>
                                        @endif
                                    </div>
                                    <div class="col-md-6">
                                        @if($terlapor->unit_kerja_fakultas)
                                        <div class="mb-2">
                                            <strong>{{ $terlapor->status_terlapor === 'mahasiswa' ? 'Fakultas/Prodi' : 'Unit Kerja' }}:</strong> 
                                            {{ $terlapor->unit_kerja_fakultas }}
                                        </div>
                                        @endif
                                        <div class="mb-2">
                                            <strong>Kontak:</strong> {{ $terlapor->kontak_terlapor }}
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>

                    <!-- Detail Peristiwa -->
                    <div class="card mb-4">
                        <div class="card-header">
                            <h5 class="mb-0">
                                <i class="fas fa-file-text"></i> Detail Peristiwa
                            </h5>
                        </div>
                        <div class="card-body">
                            <div class="mb-3">
                                <h6>Cerita Singkat Peristiwa:</h6>
                                <div class="bg-light p-3 rounded">
                                    {!! nl2br(e($pengaduan->cerita_singkat_peristiwa)) !!}
                                </div>
                            </div>
                            
                            @if($pengaduan->alasan_pengaduan)
                            <div class="mb-3">
                                <h6>Alasan Pengaduan:</h6>
                                <ul class="list-unstyled">
                                    @foreach($pengaduan->alasan_pengaduan_labels as $alasan)
                                    <li class="mb-1">
                                        <i class="fas fa-check-circle text-success"></i> {{ $alasan }}
                                    </li>
                                    @endforeach
                                </ul>
                            </div>
                            @endif
                        </div>
                    </div>

                    <!-- Bukti/Evidence -->
                    @if($pengaduan->evidence_path || $pengaduan->evidence_gdrive_link)
                    <div class="card mb-4">
                        <div class="card-header">
                            <h5 class="mb-0">
                                <i class="fas fa-paperclip"></i> Bukti Lampiran
                            </h5>
                        </div>
                        <div class="card-body">
                            @if($pengaduan->evidence_type === 'file' && $pengaduan->evidence_path)
                                <div class="d-flex align-items-center">
                                    <i class="fas fa-file fa-2x text-primary me-3"></i>
                                    <div>
                                        <strong>File Lampiran:</strong><br>
                                        <a href="{{ Storage::url($pengaduan->evidence_path) }}" 
                                           target="_blank" class="btn btn-sm btn-outline-primary">
                                            <i class="fas fa-download"></i> Download File
                                        </a>
                                    </div>
                                </div>
                            @elseif($pengaduan->evidence_type === 'gdrive' && $pengaduan->evidence_gdrive_link)
                                <div class="d-flex align-items-center">
                                    <i class="fab fa-google-drive fa-2x text-success me-3"></i>
                                    <div>
                                        <strong>Link Google Drive:</strong><br>
                                        <a href="{{ $pengaduan->evidence_gdrive_link }}" 
                                           target="_blank" class="btn btn-sm btn-outline-success">
                                            <i class="fas fa-external-link-alt"></i> Buka Link
                                        </a>
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>
                    @endif

                    <!-- Pelapor Info (jika tidak anonim) -->
                    @if(!$pengaduan->is_anonim)
                    <div class="card mb-4">
                        <div class="card-header">
                            <h5 class="mb-0">
                                <i class="fas fa-user"></i> Informasi Pelapor
                            </h5>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-sm-3"><strong>Nama:</strong></div>
                                <div class="col-sm-9">{{ $pengaduan->user->name }}</div>
                            </div>
                            <div class="row">
                                <div class="col-sm-3"><strong>Email:</strong></div>
                                <div class="col-sm-9">{{ $pengaduan->user->email }}</div>
                            </div>
                        </div>
                    </div>
                    @endif
                </div>

                <!-- Sidebar Aksi -->
                <div class="col-lg-4">
                    <!-- Update Status -->
                    <div class="card mb-4">
                        <div class="card-header">
                            <h5 class="mb-0">
                                <i class="fas fa-cogs"></i> Kelola Pengaduan
                            </h5>
                        </div>
                        <div class="card-body">
                            <form action="{{ route('whistleblower.admin.update-status', $pengaduan->id) }}" method="POST">
                                @csrf
                                @method('PUT')
                                
                                <div class="mb-3">
                                    <label for="status_pengaduan" class="form-label">Status Pengaduan</label>
                                    <select name="status_pengaduan" id="status_pengaduan" class="form-select" required>
                                        <option value="pending" {{ $pengaduan->status_pengaduan === 'pending' ? 'selected' : '' }}>
                                            Menunggu
                                        </option>
                                        <option value="proses" {{ $pengaduan->status_pengaduan === 'proses' ? 'selected' : '' }}>
                                            Sedang Diproses
                                        </option>
                                        <option value="butuh_bukti" {{ $pengaduan->status_pengaduan === 'butuh_bukti' ? 'selected' : '' }}>
                                            Butuh Bukti Tambahan
                                        </option>
                                        <option value="selesai" {{ $pengaduan->status_pengaduan === 'selesai' ? 'selected' : '' }}>
                                            Selesai
                                        </option>
                                        <option value="ditolak" {{ $pengaduan->status_pengaduan === 'ditolak' ? 'selected' : '' }}>
                                            Ditolak
                                        </option>
                                    </select>
                                </div>

                                <div class="mb-3">
                                    <label for="admin_response" class="form-label">Respon/Catatan Admin</label>
                                    <textarea name="admin_response" id="admin_response" class="form-control" rows="4" 
                                              placeholder="Berikan catatan atau respon untuk pelapor...">{{ $pengaduan->admin_response }}</textarea>
                                </div>

                                <button type="submit" class="btn btn-primary w-100">
                                    <i class="fas fa-save"></i> Update Status
                                </button>
                            </form>
                        </div>
                    </div>

                    <!-- Informasi Penanganan -->
                    <div class="card mb-4">
                        <div class="card-header">
                            <h5 class="mb-0">
                                <i class="fas fa-info-circle"></i> Info Penanganan
                            </h5>
                        </div>
                        <div class="card-body">
                            @if($pengaduan->handled_by)
                            <div class="mb-2">
                                <strong>Ditangani oleh:</strong><br>
                                {{ $pengaduan->handler->name ?? 'Admin' }}
                            </div>
                            @endif
                            
                            <div class="mb-2">
                                <strong>Dibuat:</strong><br>
                                {{ $pengaduan->created_at->format('d/m/Y H:i:s') }}
                            </div>
                            
                            <div class="mb-2">
                                <strong>Terakhir update:</strong><br>
                                {{ $pengaduan->updated_at->format('d/m/Y H:i:s') }}
                            </div>
                            
                            @if($pengaduan->closed_at)
                            <div class="mb-2">
                                <strong>Ditutup:</strong><br>
                                {{ $pengaduan->closed_at->format('d/m/Y H:i:s') }}
                            </div>
                            @endif
                        </div>
                    </div>

                    <!-- Quick Actions -->
                    <div class="card">
                        <div class="card-header">
                            <h5 class="mb-0">
                                <i class="fas fa-bolt"></i> Aksi Cepat
                            </h5>
                        </div>
                        <div class="card-body">
                            <div class="d-grid gap-2">
                                @if($pengaduan->status_pengaduan === 'pending')
                                <button type="button" class="btn btn-info btn-sm" onclick="updateStatus('proses')">
                                    <i class="fas fa-play"></i> Mulai Proses
                                </button>
                                @endif
                                
                                @if($pengaduan->needsEvidence())
                                <button type="button" class="btn btn-warning btn-sm" onclick="updateStatus('butuh_bukti')">
                                    <i class="fas fa-exclamation-triangle"></i> Minta Bukti
                                </button>
                                @endif
                                
                                @if(in_array($pengaduan->status_pengaduan, ['proses', 'butuh_bukti']))
                                <button type="button" class="btn btn-success btn-sm" onclick="updateStatus('selesai')">
                                    <i class="fas fa-check"></i> Selesaikan
                                </button>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
function updateStatus(status) {
    document.getElementById('status_pengaduan').value = status;
    
    // Auto-fill response based on status
    const responseField = document.getElementById('admin_response');
    const currentResponse = responseField.value;
    
    let autoResponse = '';
    switch(status) {
        case 'proses':
            autoResponse = 'Pengaduan Anda sedang dalam proses investigasi. Tim PPKPT akan menindaklanjuti sesuai prosedur yang berlaku.';
            break;
        case 'butuh_bukti':
            autoResponse = 'Untuk melanjutkan proses investigasi, kami memerlukan bukti atau lampiran tambahan. Silakan hubungi tim PPKPT.';
            break;
        case 'selesai':
            autoResponse = 'Pengaduan telah selesai ditangani. Terima kasih atas laporan yang diberikan.';
            break;
    }
    
    if (!currentResponse && autoResponse) {
        responseField.value = autoResponse;
    }
}
</script>
@endsection