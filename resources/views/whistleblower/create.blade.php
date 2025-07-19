{{-- resources/views/whistleblower/create.blade.php --}}
@extends('layouts.main2')

@section('navbar')
    @include('whistleblower.navbar')
@endsection

@push('styles')
<link href="{{ asset('css/whistleblower.css') }}" rel="stylesheet">
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