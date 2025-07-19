{{-- F:\rapor-dosen\resources\views\keuangan\master\tahun-anggaran\index.blade.php --}}
@extends('keuangan.master.layouts.master-index-custom')

@php
    $emptyMessage = count($tahunAnggarans) == 0 ?
        'Belum ada data tahun anggaran. Klik tombol "Tambah Data" untuk menambahkan tahun anggaran pertama.' :
        'Belum ada data tahun anggaran. Klik tombol "Tambah Data" untuk menambahkan tahun anggaran pertama.';

    $tableConfig = [
        'title' => 'Data Tahun Anggaran',
        'data' => $tahunAnggarans ?? collect(),
        'create_route' => route('keuangan.tahun-anggaran.create'),
        'empty_message' => $emptyMessage,
        'delete_name_field' => 'tahun_anggaran',
        'columns' => [
            [
                'label' => 'No',
                'type' => 'number',
                'width' => '5%'
            ],
            [
                'label' => 'Tahun Anggaran',
                'type' => 'badge',
                'field' => 'tahun_anggaran',
                'badge_class' => 'primary',
                'width' => '20%'
            ],
            [
                'label' => 'Periode',
                'type' => 'periode_lengkap',
                'field' => 'periode_lengkap',
                'width' => '30%'
            ],
            [
                'label' => 'Durasi',
                'type' => 'durasi_hari',
                'field' => 'durasi_hari',
                'width' => '15%'
            ],
            [
                'label' => 'Status',
                'type' => 'status_badge',
                'field' => 'status',
                'width' => '15%'
            ],
            [
                'label' => 'Dibuat',
                'type' => 'datetime',
                'field' => 'created_at',
                'width' => '15%'
            ]
        ],
        'actions' => [
            'show' => route('keuangan.tahun-anggaran.show', ':id'),
            'edit' => route('keuangan.tahun-anggaran.edit', ':id'),
            'delete' => route('keuangan.tahun-anggaran.destroy', ':id')
        ]
    ];

    // Filter config - KONSISTEN dengan mata anggaran layout
    $filterConfig = [
        'search_placeholder' => 'Cari tahun anggaran...',
        'action_route' => route('keuangan.tahun-anggaran.index'),
        'filters' => [
            [
                'name' => 'status',
                'label' => 'Status',
                'type' => 'select',
                'options' => [
                    '' => 'Semua Status',
                    'aktif' => 'Aktif',
                    'belum_dimulai' => 'Belum Dimulai',
                    'selesai' => 'Selesai'
                ],
                'value' => request('status')
            ]
        ]
    ];

    // Development alert config
    $alertConfig = [
        'type' => 'info',
        'module' => 'Master Data Tahun Anggaran',
        'status' => 'Ready',
        'version' => 'v1.0.0',
        'features' => ['CRUD lengkap', 'Validasi Overlap', 'Filter Status', 'Search & Filter'],
        'database' => true,
        'note' => 'Sistem pencatatan tahun anggaran dengan validasi periode overlap'
    ];
@endphp
