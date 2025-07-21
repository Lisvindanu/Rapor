{{-- resources/views/whistleblower/create.blade.php --}}
@extends('layouts.main2')

@section('navbar')
    @include('whistleblower.user.navbar')
@endsection

@push('styles')
<style>
/* Border fixes untuk dropdown dan form controls */
.form-select {
    border: 1px solid #ced4da !important;
}

.form-control {
    border: 1px solid #ced4da !important;
}

.form-check-input {
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

.form-check-input:focus {
    border-color: #86b7fe !important;
    box-shadow: 0 0 0 0.25rem rgba(13, 110, 253, 0.25) !important;
}

/* Minimal CSS untuk styling yang diperlukan */
.terlapor-item {
    transition: all 0.3s ease;
    border: 1px solid #dee2e6 !important;
}

.terlapor-item:hover {
    box-shadow: 0 2px 5px rgba(0,0,0,0.1);
}

.evidence-option {
    transition: all 0.2s ease;
    border: 1px solid #dee2e6 !important;
}

.evidence-option:hover {
    background-color: #f8f9fa;
}

#fileUploadDiv, #gdriveDiv {
    display: none;
}

#disabilityTypeDiv {
    display: none;
}

.is-invalid {
    border-color: #dc3545 !important;
}

.alasan-pengaduan-section.border-danger {
    border-color: #dc3545 !important;
}

.card {
    border: 1px solid #dee2e6 !important;
}

@media (max-width: 768px) {
    .terlapor-item {
        margin-bottom: 1rem;
    }
    
    .btn-group-vertical .btn {
        margin-bottom: 0.5rem;
    }
}
</style>
@endpush

@section('konten')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <!-- Header -->
            @include('whistleblower.partials.form-header')

            @if(session('error'))
                <div class="alert alert-danger mb-4">
                    <i class="fas fa-exclamation-triangle"></i>
                    {{ session('error') }}
                </div>
            @endif

            <!-- Form Pengaduan -->
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">
                        <i class="fas fa-edit"></i> Form Pengaduan
                    </h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('whistleblower.store') }}" method="POST" enctype="multipart/form-data" id="pengaduanForm">
                        @csrf

                        <!-- Status Pelapor -->
                        @include('whistleblower.partials.form-status-pelapor')

                        <!-- Informasi Terlapor -->
                        @include('whistleblower.partials.form-terlapor')

                        <!-- Detail Peristiwa -->
                        @include('whistleblower.partials.form-detail-peristiwa')

                        <!-- Alasan Pengaduan -->
                        @include('whistleblower.partials.form-alasan-pengaduan')

                        <!-- Upload Bukti -->
                        @include('whistleblower.partials.form-upload-bukti')

                        <!-- Opsi Anonim -->
                        @include('whistleblower.partials.form-anonim')

                        <!-- Persetujuan -->
                        @include('whistleblower.partials.form-persetujuan')

                        <!-- Tombol Submit -->
                        <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                            <a href="{{ route('whistleblower.dashboard') }}" class="btn btn-secondary me-md-2">
                                <i class="fas fa-arrow-left"></i> Batal
                            </a>
                            <button type="submit" class="btn btn-danger">
                                <i class="fas fa-paper-plane"></i> Kirim Pengaduan
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal Kebijakan -->
@include('whistleblower.partials.modal-kebijakan')
@endsection

@push('scripts')
<script src="{{ asset('js/whistleblower/form.js') }}"></script>
@endpush