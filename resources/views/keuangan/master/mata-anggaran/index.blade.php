{{-- F:\rapor-dosen\resources\views\keuangan\master\mata-anggaran\index.blade.php (REVISED) --}}
@extends('layouts.main2')

{{-- Define all configurations at the top --}}
@php
    $headerConfig = [
        'icon' => 'fas fa-list-alt',
        'title' => 'Kelola Mata Anggaran',
        'description' => 'Pengelolaan data master mata anggaran dan sub mata anggaran',
        'back_route' => route('keuangan'), // FIXED: Changed from keuangan.index to keuangan
        'back_text' => 'Kembali',
        'primary_action' => [
            'route' => route('keuangan.mata-anggaran.create'),
            'text' => 'Tambah Mata Anggaran',
            'icon' => 'fas fa-plus',
            'class' => 'btn-primary'
        ]
    ];

    $filterConfig = [
        'search_placeholder' => 'Cari berdasarkan kode atau nama mata anggaran...',
        'action_route' => route('keuangan.mata-anggaran.index'),
        'filters' => [
            [
                'name' => 'tahun_anggaran',
                'label' => 'Tahun Anggaran',
                'type' => 'select',
                'options' => collect(range(date('Y') + 1, date('Y') - 5))->mapWithKeys(fn($year) => [$year => $year]),
            ]
        ]
    ];

    $tableConfig = [
        'title' => 'Data Mata Anggaran',
        'data' => $mataAnggarans ?? [],
        'columns' => [
            ['label' => 'No', 'width' => '5%', 'align' => 'center'],
            ['label' => 'Kode', 'width' => '15%'],
            ['label' => 'Nama Mata Anggaran', 'width' => '35%'],
            ['label' => 'Parent', 'width' => '15%'],
            ['label' => 'Level', 'width' => '10%', 'align' => 'center'],
            ['label' => 'Tahun', 'width' => '10%', 'align' => 'center'],
            ['label' => 'Aksi', 'width' => '10%', 'align' => 'center'],
        ]
    ];
@endphp

@section('css-tambahan')
    {{-- Include generic master styles --}}
    @include('keuangan.master.partials.styles')
@endsection

@section('navbar')
    @include('keuangan.navbar')
@endsection

@section('konten')
    <div class="container py-4">
        {{-- Include SPECIFIC partials for Mata Anggaran --}}
        @include('keuangan.master.partials.header')
        @include('komponen.message-alert')
        @include('keuangan.master.mata-anggaran.partials.filter-form')
        @include('keuangan.master.mata-anggaran.partials.data-table')
    </div>
@endsection

@section('js-tambahan')
    {{-- Include generic master scripts --}}
    @include('keuangan.master.partials.scripts')
@endsection
