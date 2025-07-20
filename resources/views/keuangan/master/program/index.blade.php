{{-- F:\rapor-dosen\resources\views\keuangan\master\program\index.blade.php --}}
@extends('keuangan.master.layouts.master-index-custom')

@php
    $emptyMessage = count($programs) == 0 ?
        'Belum ada data program. Klik tombol "Tambah Data" untuk menambahkan program pertama.' :
        'Belum ada data program. Klik tombol "Tambah Data" untuk menambahkan program pertama.';

    $tableConfig = [
        'title' => 'Data Program',
        'data' => $programs ?? collect(),
        'create_route' => route('keuangan.program.create'),
        'empty_message' => $emptyMessage,
        'delete_name_field' => 'nama_program',
        'columns' => [
            [
                'label' => 'No',
                'type' => 'number',
                'width' => '10%'
            ],
            [
                'label' => 'Nama Program',
                'type' => 'program_badge',
                'field' => 'nama_program',
                'width' => '60%'
            ],
            [
                'label' => 'Dibuat',
                'type' => 'datetime',
                'field' => 'created_at',
                'width' => '20%'
            ],
            [
                'label' => 'Diperbarui',
                'type' => 'datetime',
                'field' => 'updated_at',
                'width' => '20%'
            ]
        ],
        'actions' => [
            'show' => route('keuangan.program.show', ':id'),
            'edit' => route('keuangan.program.edit', ':id'),
            'delete' => route('keuangan.program.destroy', ':id')
        ]
    ];

    // Filter config - Sederhana untuk program
    $filterConfig = [
        'search_placeholder' => 'Cari nama program...',
        'action_route' => route('keuangan.program.index'),
        'filters' => []
    ];

    // Development alert config
    $alertConfig = [
        'type' => 'info',
        'module' => 'Master Data Program',
        'status' => 'Ready',
        'version' => 'v1.0.0',
        'features' => ['CRUD lengkap', 'Search Program', 'Smart Badge Colors'],
        'database' => true,
        'note' => 'Sistem pengelolaan program dengan auto badge colors'
    ];
@endphp
