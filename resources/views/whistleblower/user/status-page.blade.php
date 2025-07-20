{{-- resources/views/whistleblower/status-page.blade.php --}}
@extends('layouts.main2')

@section('navbar')
    @include('whistleblower.navbar')
@endsection

@section('konten')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <!-- Header -->
            <div class="text-center mb-4">
                <h2>Cek Status Pengaduan</h2>
                <p class="text-muted">Masukkan kode pengaduan untuk melihat status terkini</p>
            </div>

            <!-- Form Cek Status -->
            <div class="card">
                <div class="card-header text-center">
                    <h5 class="mb-0">
                        <i class="fas fa-search"></i> Lacak Pengaduan Anda
                    </h5>
                </div>
                <div class="card-body">
                    @if(session('error'))
                        <div class="alert alert-danger">
                            <i class="fas fa-exclamation-triangle"></i>
                            {{ session('error') }}
                        </div>
                    @endif

                    <form action="{{ route('whistleblower.check-status') }}" method="POST">
                        @csrf
                        
                        <div class="mb-3">
                            <label for="kode_pengaduan" class="form-label">
                                Kode Pengaduan <span class="text-danger">*</span>
                            </label>
                            <input type="text" name="kode_pengaduan" id="kode_pengaduan" 
                                   class="form-control @error('kode_pengaduan') is-invalid @enderror"
                                   value="{{ old('kode_pengaduan') }}" 
                                   placeholder="Contoh: WB202507001" 
                                   style="text-transform: uppercase;" required>
                            @error('kode_pengaduan')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <div class="form-text">
                                <small>
                                    Masukkan kode pengaduan yang Anda terima saat membuat pengaduan.
                                    Format: WB + Tahun + Bulan + Nomor urut
                                </small>
                            </div>
                        </div>

                        <div class="d-grid">
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-search"></i> Cek Status
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Informasi Tambahan -->
            <div class="card mt-4">
                <div class="card-header">
                    <h6 class="mb-0">
                        <i class="fas fa-info-circle"></i> Informasi Penting
                    </h6>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <h6 class="text-primary">Status Pengaduan</h6>
                            <ul class="list-unstyled small">
                                <li><span class="badge bg-warning me-2">Menunggu</span> Sedang direview tim</li>
                                <li><span class="badge bg-info me-2">Proses</span> Sedang diinvestigasi</li>
                                <li><span class="badge bg-success me-2">Selesai</span> Pengaduan telah selesai</li>
                            </ul>
                        </div>
                        <div class="col-md-6">
                            <h6 class="text-primary">Butuh Bantuan?</h6>
                            <p class="small mb-0">
                                Jika lupa kode pengaduan atau butuh bantuan, hubungi:
                                <br><strong>0274-123456</strong>
                                <br><strong>ppkpt@university.ac.id</strong>
                            </p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Tips -->
            <div class="alert alert-info mt-4">
                <h6><i class="fas fa-lightbulb"></i> Tips</h6>
                <ul class="mb-0 small">
                    <li>Simpan kode pengaduan di tempat yang aman</li>
                    <li>Cek status secara berkala untuk mendapat update terbaru</li>
                    <li>Hubungi tim PPKPT jika tidak ada update dalam 3x24 jam</li>
                </ul>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
document.getElementById('kode_pengaduan').addEventListener('input', function(e) {
    e.target.value = e.target.value.toUpperCase();
});
</script>
@endpush
@endsection