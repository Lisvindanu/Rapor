@extends('layouts.main2')

@section('css-tambahan')
    @include('keuangan.laporan.partials.style')
@endsection

@section('navbar')
    @include('keuangan.navbar')
@endsection

@section('konten')
    <div class="container">
        @include('keuangan.laporan.partials.header')
        @include('komponen.message-alert')
        @include('keuangan.laporan.partials.development-alert')
        @include('keuangan.laporan.partials.filter-form')
        @include('keuangan.laporan.partials.preview-section')
        @include('keuangan.laporan.partials.quick-actions')
    </div>
@endsection

@section('js-tambahan')
    @include('keuangan.laporan.partials.scripts')
@endsection
