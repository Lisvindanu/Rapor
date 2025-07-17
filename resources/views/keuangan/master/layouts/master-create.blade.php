{{-- F:\rapor-dosen\resources\views\keuangan\master\layouts\master-create.blade.php --}}
@extends('layouts.main2')

@section('css-tambahan')
    @include('keuangan.master.partials.styles')
    @include('keuangan.master.partials.form-styles')
@endsection

@section('navbar')
    @include('keuangan.navbar')
@endsection

@section('konten')
    <div class="container">
        @include('keuangan.master.partials.header')
        @include('komponen.message-alert')
        @include('keuangan.master.partials.create-form')
    </div>
@endsection

@section('js-tambahan')
    @include('keuangan.master.partials.scripts')
    @include('keuangan.master.partials.form-scripts')
@endsection
