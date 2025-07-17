{{-- F:\rapor-dosen\resources\views\keuangan\master\layouts\master-index.blade.php --}}
@extends('layouts.main2')

@section('css-tambahan')
    @include('keuangan.master.partials.styles')
@endsection

@section('navbar')
    @include('keuangan.navbar')
@endsection

@section('konten')
    <div class="container">
        @include('keuangan.master.partials.header')
        @include('komponen.message-alert')
        @include('keuangan.master.partials.development-alert')
        @include('keuangan.master.partials.filter-form')
        @include('keuangan.master.partials.data-table')
    </div>
@endsection

@section('js-tambahan')
    @include('keuangan.master.partials.scripts')
@endsection
