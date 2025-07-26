{{-- resources/views/whistleblower/user/create.blade.php --}}
@extends('layouts.main2')

@section('navbar')
    @include('whistleblower.user.navbar')
@endsection

@push('styles')
    <link href="{{ asset('css/whistleblower-form.css') }}" rel="stylesheet">
@endpush

@section('konten')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10 col-lg-8">
            <div class="whistleblower-form">
                <!-- Header -->
                @include('whistleblower.user.partials.form-header')

                <!-- Alert Informasi -->
                @include('whistleblower.user.partials.form-alert')

                <!-- Form -->
                <form action="{{ route('whistleblower.store') }}" method="POST" enctype="multipart/form-data" id="whistleblowerForm">
                    @csrf
                    
                    <!-- Opsi Anonim -->
                    @include('whistleblower.user.partials.form-anonim')
                    
                    <!-- Informasi Pelapor -->
                    @include('whistleblower.user.partials.form-pelapor')

                    <!-- Informasi Terlapor -->
                    @include('whistleblower.user.partials.form-terlapor')

                    <!-- Detail Peristiwa -->
                    @include('whistleblower.user.partials.form-peristiwa')

                    <!-- Upload Bukti -->
                    @include('whistleblower.user.partials.form-upload')

                    <!-- Persetujuan -->
                    @include('whistleblower.user.partials.form-persetujuan')

                    <!-- Submit Buttons -->
                    @include('whistleblower.user.partials.form-buttons')
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Modal Kebijakan Privasi -->
@include('whistleblower.user.partials.modal-kebijakan')
@endsection

@push('scripts')
    <script src="{{ asset('js/whistleblower/form.js') }}"></script>
@endpush