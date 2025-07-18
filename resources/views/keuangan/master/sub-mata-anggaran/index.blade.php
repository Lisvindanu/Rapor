{{-- F:\rapor-dosen\resources\views\keuangan\master\sub-mata-anggaran\index.blade.php --}}
@extends('layouts.main2')

@php
    $headerConfig = [
        'title' => 'Sub Mata Anggaran',
        'description' => 'Sub mata anggaran dari: ' . $parent->nama_mata_anggaran . ' (' . $parent->kode_mata_anggaran . ')',
        'back_route' => route('keuangan.mata-anggaran.index'),
        'back_text' => 'Kembali ke Mata Anggaran',
        'primary_action' => [
            'route' => route('keuangan.sub-mata-anggaran.create', $parent->id),
            'text' => 'Tambah Sub Mata Anggaran',
            'icon' => 'fas fa-plus',
            'class' => 'btn-primary'
        ]
    ];

    $filterConfig = [
        'search_placeholder' => 'Cari berdasarkan kode atau nama sub mata anggaran...',
        'action_route' => route('keuangan.sub-mata-anggaran.index', $parent->id),
        'filters' => []
    ];

    $emptyMessage = 'Belum ada sub mata anggaran untuk mata anggaran ini. Klik tombol "Tambah Sub Mata Anggaran" untuk menambahkan yang pertama.';
    if (request('search')) {
        $emptyMessage = "Tidak ditemukan sub mata anggaran yang sesuai dengan pencarian '" . request('search') . "'.";
    }

    $tableConfig = [
        'title' => 'Data Sub Mata Anggaran',
        'data' => $subMataAnggarans ?? collect(),
        'create_route' => route('keuangan.sub-mata-anggaran.create', $parent->id),
        'empty_message' => $emptyMessage,
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
                'badge_class' => 'secondary',
                'width' => '15%'
            ],
            [
                'label' => 'Nama Sub Mata Anggaran',
                'type' => 'text_with_description',
                'field' => 'nama_mata_anggaran',
                'description_field' => 'deskripsi',
                'width' => '35%'
            ],
            [
                'label' => 'Kategori',
                'type' => 'badge',
                'field' => 'kategori',
                'badge_class' => 'info',
                'width' => '15%'
            ],
            [
                'label' => 'Alokasi Anggaran',
                'type' => 'currency',
                'field' => 'alokasi_anggaran',
                'width' => '15%'
            ],
            [
                'label' => 'Status',
                'type' => 'status',
                'field' => 'status_aktif',
                'width' => '10%'
            ]
        ],
        'actions' => [
            'edit' => route('keuangan.sub-mata-anggaran.edit', [$parent->id, ':id']),
            'delete' => route('keuangan.sub-mata-anggaran.destroy', [$parent->id, ':id'])
        ]
    ];

    $alertConfig = [
        'type' => 'info',
        'module' => 'Sub Mata Anggaran',
        'status' => 'Ready',
        'version' => 'v1.0.0',
        'features' => ['CRUD lengkap', 'Search & Filter', 'Pagination'],
        'database' => true,
        'note' => 'Parent: ' . $parent->kode_mata_anggaran . ' - ' . $parent->nama_mata_anggaran
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
