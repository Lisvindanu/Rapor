{{-- F:\rapor-dosen\resources\views\keuangan\master\mata-anggaran\index.blade.php --}}
@extends('layouts.main2')

{{-- Define all configurations at the top --}}
@php
    $headerConfig = [
        'title' => 'Kelola Mata Anggaran',
        'description' => 'Pengelolaan data master mata anggaran dan sub mata anggaran'
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
        'data' => $mataAnggarans ?? collect(),
        'create_route' => route('keuangan.mata-anggaran.create'),
        'empty_message' => 'Belum ada data mata anggaran. Klik tombol "Tambah Data" untuk menambahkan mata anggaran pertama.',
        'delete_name_field' => 'nama_mata_anggaran',
        'columns' => [
            [
                'label' => 'No',
                'type' => 'number',
                'width' => '5%'
            ],
            [
                'label' => 'Kode',
                'type' => 'badge',
                'field' => 'kode_mata_anggaran',
                'badge_class' => 'primary',
                'width' => '15%'
            ],
            [
                'label' => 'Nama Mata Anggaran',
                'type' => 'text_with_description',
                'field' => 'nama_mata_anggaran',
                'description_field' => 'deskripsi',
                'width' => '35%'
            ],
            [
                'label' => 'Parent',
                'type' => 'parent_name',
                'field' => 'kode_mata_anggaran',
                'relationship' => 'parentMataAnggaran',
                'width' => '15%'
            ],
            [
                'label' => 'Sub Item',
                'type' => 'children_count',
                'width' => '10%'
            ],
            [
                'label' => 'Tahun',
                'type' => 'badge',
                'field' => 'tahun_anggaran',
                'badge_class' => 'info',
                'width' => '10%'
            ],
            [
                'label' => 'Status',
                'type' => 'status',
                'field' => 'status_aktif',
                'width' => '10%'
            ]
        ],
        'actions' => [
            'children' => route('keuangan.sub-mata-anggaran.index', ':id'),
            'show' => route('keuangan.mata-anggaran.show', ':id'),
            'edit' => route('keuangan.mata-anggaran.edit', ':id'),
            'delete' => route('keuangan.mata-anggaran.destroy', ':id')
        ]
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
        @include('keuangan.master.partials.data-table')
    </div>
@endsection

@section('js-tambahan')
    @include('keuangan.master.partials.scripts')
@endsection
