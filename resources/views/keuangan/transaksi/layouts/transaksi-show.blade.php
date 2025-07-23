{{-- resources/views/keuangan/transaksi/layouts/transaksi-show.blade.php --}}
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
        @include('keuangan.transaksi.partials.detail-content')
        @include('keuangan.transaksi.partials.action-buttons')
    </div>
@endsection

@section('js-tambahan')
    @include('keuangan.transaksi.partials.scripts')
    @include('keuangan.transaksi.partials.print-scripts')
@endsection
