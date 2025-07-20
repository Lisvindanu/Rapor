{{-- F:\rapor-dosen\resources\views\keuangan\master\mata-anggaran\index.blade.php --}}
@extends('layouts.main2')

{{-- Define all configurations at the top --}}
@php
    $headerConfig = [
        'title' => 'Kelola Mata Anggaran',
        'description' => 'Pengelolaan data master mata anggaran dengan hierarki parent-child'
    ];

    $filterConfig = [
        'search_placeholder' => 'Cari berdasarkan kode atau nama mata anggaran...',
        'action_route' => route('keuangan.mata-anggaran.index'),
        'filters' => [
            [
                'name' => 'kategori',
                'label' => 'Kategori',
                'type' => 'select',
                'options' => [
                    'debet' => 'Debet (Pengeluaran)',
                    'kredit' => 'Kredit (Pendapatan)'
                ],
                'placeholder' => 'Semua Kategori'
            ]
        ]
    ];

    // Enhanced empty message
    $emptyMessage = $emptyMessage ?? 'Belum ada data mata anggaran. Klik tombol "Tambah Data" untuk menambahkan mata anggaran pertama.';

    $tableConfig = [
        'title' => 'Data Mata Anggaran',
        'data' => $mataAnggarans ?? collect(),
        'create_route' => route('keuangan.mata-anggaran.create'),
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
                'badge_class' => 'primary',
                'width' => '15%'
            ],
            [
                'label' => 'Nama Mata Anggaran',
                'type' => 'text_with_hierarchy',
                'field' => 'nama_mata_anggaran',
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
                'label' => 'Kategori',
                'type' => 'kategori_badge',
                'field' => 'kategori',
                'width' => '15%'
            ]
        ],
        'actions' => [
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

        {{-- Enhanced development alert --}}
        @php
            $alertConfig = [
                'type' => 'info',
                'module' => 'Master Data Mata Anggaran',
                'status' => 'Ready',
                'version' => 'v2.0.0',
                'features' => ['CRUD lengkap', 'Hierarki Parent-Child', 'Kategori Debet/Kredit', 'Search & Filter'],
                'database' => true,
                'note' => 'Struktur disederhanakan dengan fokus pada kategori debet/kredit'
            ];
        @endphp
        @include('keuangan.master.partials.development-alert')

        @include('keuangan.master.partials.filter-form')
        @include('keuangan.master.partials.data-table')
    </div>
@endsection

@section('js-tambahan')
    @include('keuangan.master.partials.scripts')
@endsection
