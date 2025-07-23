{{-- resources/views/keuangan/transaksi/layouts/transaksi-index.blade.php --}}
@extends('layouts.main2')

@section('css-tambahan')
    @include('keuangan.transaksi.partials.styles')
@endsection

@section('navbar')
    @include('keuangan.navbar')
@endsection

@section('konten')
    <div class="container">
        @include('keuangan.transaksi.partials.header')
        @include('komponen.message-alert')
        @include('keuangan.transaksi.partials.development-alert')
        @include('keuangan.transaksi.partials.statistics-cards')
        @include('keuangan.transaksi.partials.filter-form')
        @include('keuangan.transaksi.partials.data-table')
    </div>
@endsection

@section('js-tambahan')
    @include('keuangan.transaksi.partials.scripts')
    @include('keuangan.transaksi.partials.delete-script')
@endsection
