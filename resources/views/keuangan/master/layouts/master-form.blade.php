{{-- F:\rapor-dosen\resources\views\keuangan\master\layouts\master-form.blade.php --}}
@extends('layouts.main2')

@section('css-tambahan')
    @include('keuangan.master.partials.styles')
@endsection

@section('navbar')
    @include('keuangan.navbar')
@endsection

@section('konten')
    @include('keuangan.master.partials.form-template')
@endsection

@section('js-tambahan')
    @include('keuangan.master.partials.scripts')
    @stack('scripts')
@endsection
