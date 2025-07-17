@extends('layouts.main2')

@section('css-tambahan')
    @include('keuangan.partials.styles')
@endsection

@section('navbar')
    @include('keuangan.navbar')
@endsection

@section('konten')
    <div class="container">
        @include('keuangan.partials.header')
        @include('komponen.message-alert')
        @include('keuangan.partials.development-alert')
        @include('keuangan.partials.statistics-cards')
        @include('keuangan.partials.main-content')
    </div>
@endsection

@section('js-tambahan')
    @include('keuangan.partials.scripts')
@endsection
