{{-- resources/views/keuangan/master/sumber-dana/index.blade.php --}}
@extends('layouts.main2')

@php
    $tableConfig = [
        'title' => 'Data Sumber Dana',
        'data' => $sumberDanas ?? collect(),
        'create_route' => route('keuangan.sumber-dana.create'),
        'empty_message' => 'Belum ada data sumber dana. Klik tombol "Tambah Data" untuk menambahkan sumber dana pertama.',
        'delete_name_field' => 'nama_sumber_dana',
        'columns' => [
            [
                'label' => 'No',
                'type' => 'number',
                'width' => '5%'
            ],
            [
                'label' => 'Nama Sumber Dana',
                'type' => 'text',
                'field' => 'nama_sumber_dana',
                'width' => '60%'
            ],
            [
                'label' => 'Tanggal Dibuat',
                'type' => 'text',
                'field' => 'formatted_created_at',
                'width' => '20%'
            ]
        ],
        'actions' => [
            'show' => route('keuangan.sumber-dana.show', ':id'),
            'edit' => route('keuangan.sumber-dana.edit', ':id'),
            'delete' => route('keuangan.sumber-dana.destroy', ':id')
        ]
    ];

    $alertConfig = [
        'type' => 'info',
        'module' => 'Master Data Sumber Dana',
        'status' => 'Ready',
        'version' => 'v1.0.0',
        'features' => ['CRUD lengkap', 'Search & Filter', 'Validation', 'Clean Architecture'],
        'database' => true,
        'note' => 'Modul sederhana untuk pengelolaan sumber dana keuangan'
    ];

    $filterConfig = [
        'title' => 'Filter & Pencarian Sumber Dana',
        'action_route' => route('keuangan.sumber-dana.index'),
        'search_placeholder' => 'Cari nama sumber dana...'
    ];
@endphp

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
        @include('keuangan.master.partials.data-table-custom')
    </div>
@endsection

@section('js-tambahan')
    @include('keuangan.master.partials.scripts')
    @include('keuangan.master.partials.delete-script')
@endsection
