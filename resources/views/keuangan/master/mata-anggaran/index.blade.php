{{-- F:\rapor-dosen\resources\views\keuangan\master\mata-anggaran\index.blade.php --}}

@php
    // Header Configuration
    $headerConfig = [
        'icon' => 'fas fa-list-alt',
        'title' => 'Kelola Mata Anggaran',
        'description' => 'Pengelolaan data master mata anggaran dan sub mata anggaran',
        'back_route' => route('keuangan'),
        'back_text' => 'Kembali',
        'primary_action' => [
            'route' => route('keuangan.mata-anggaran.create'),
            'text' => 'Tambah Mata Anggaran',
            'icon' => 'fas fa-plus',
            'class' => 'btn-primary'
        ]
    ];

    // Alert Configuration
    $alertConfig = [
        'type' => 'info',
        'module' => 'Mata Anggaran',
        'status' => 'Ready',
        'version' => 'v1.0.0',
        'features' => ['CRUD lengkap', 'Search & Filter', 'Hierarchy Support'],
        'database' => true,
        'note' => 'Mendukung struktur parent-child untuk kategorisasi mata anggaran'
    ];

    // Filter Configuration
    $filterConfig = [
        'search_placeholder' => 'Cari berdasarkan kode atau nama mata anggaran...',
        'action_route' => route('keuangan.mata-anggaran.index'),
        'filters' => [
            [
                'name' => 'tahun_anggaran',
                'label' => 'Tahun Anggaran',
                'type' => 'select',
                'options' => collect(range(date('Y') + 2, date('Y') - 5))->mapWithKeys(fn($year) => [$year => $year]),
                'placeholder' => 'Semua Tahun'
            ]
        ]
    ];

    // Table Configuration
    $tableConfig = [
        'title' => 'Data Mata Anggaran',
        'data' => $mataAnggarans,
        'columns' => [
            ['key' => 'no', 'label' => 'No', 'width' => '5%', 'align' => 'center'],
            ['key' => 'kode', 'label' => 'Kode', 'width' => '15%'],
            ['key' => 'nama', 'label' => 'Nama Mata Anggaran', 'width' => '35%'],
            ['key' => 'parent', 'label' => 'Parent', 'width' => '15%'],
            ['key' => 'level', 'label' => 'Level', 'width' => '10%', 'align' => 'center'],
            ['key' => 'tahun', 'label' => 'Tahun', 'width' => '10%', 'align' => 'center'],
            ['key' => 'actions', 'label' => 'Aksi', 'width' => '10%', 'align' => 'center']
        ]
    ];
@endphp

{{-- Use Master Layout --}}
@include('keuangan.master.layouts.master-index')
