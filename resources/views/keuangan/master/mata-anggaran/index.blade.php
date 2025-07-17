{{-- F:\rapor-dosen\resources\views\keuangan\master\mata-anggaran\index.blade.php --}}
@extends('layouts.main2')

{{-- Define all configurations at the top --}}
@php
    $headerConfig = [
        'title' => 'Kelola Mata Anggaran',
        'description' => 'Pengelolaan data master mata anggaran dan sub mata anggaran'
    ];

    // Dynamic year options based on available data
    $yearOptions = collect();
    if (isset($availableYears) && !empty($availableYears)) {
        $yearOptions = collect($availableYears)->mapWithKeys(fn($year) => [$year => $year]);
    } else {
        // Fallback to current year range if no data
        $yearOptions = collect(range(date('Y') + 1, date('Y') - 5))->mapWithKeys(fn($year) => [$year => $year]);
    }

    $filterConfig = [
        'search_placeholder' => 'Cari berdasarkan kode atau nama mata anggaran...',
        'action_route' => route('keuangan.mata-anggaran.index'),
        'filters' => [
            [
                'name' => 'tahun_anggaran',
                'label' => 'Tahun Anggaran',
                'type' => 'select',
                'options' => $yearOptions,
                'placeholder' => isset($availableYears) && !empty($availableYears) ?
                    'Pilih Tahun (' . implode(', ', $availableYears) . ')' : 'Semua'
            ]
        ]
    ];

    // Enhanced empty message
    $emptyMessage = $emptyMessage ?? 'Belum ada data mata anggaran. Klik tombol "Tambah Data" untuk menambahkan mata anggaran pertama.';

    // Add year info to empty message if filtered
    if (request('tahun_anggaran') && isset($availableYears) && !empty($availableYears)) {
        $emptyMessage .= " Data tersedia untuk tahun: " . implode(', ', $availableYears) . ".";
    }

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

        {{-- Enhanced development alert with year info --}}
        @php
            $alertConfig = [
                'type' => 'info',
                'module' => 'Master Data',
                'status' => 'Ready',
                'version' => 'v1.0.0',
                'features' => ['CRUD lengkap', 'Search & Filter', 'Pagination'],
                'database' => true,
                'note' => isset($availableYears) && !empty($availableYears) ?
                    'Data tersedia untuk tahun: ' . implode(', ', $availableYears) :
                    'Belum ada data di database'
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
