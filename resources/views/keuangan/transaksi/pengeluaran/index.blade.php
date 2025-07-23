{{-- resources/views/keuangan/transaksi/pengeluaran/index.blade.php --}}
@extends('keuangan.transaksi.layouts.transaksi-index')

@php
    $headerConfig = [
        'title' => 'Pencatatan Pengeluaran Kas',
        'description' => 'Kelola bukti pengeluaran kas dan transaksi keuangan',
        'icon' => 'fas fa-money-bill-wave',
        'breadcrumbs' => [
            ['text' => 'Dashboard', 'url' => route('dashboard')],
            ['text' => 'Keuangan', 'url' => route('keuangan.dashboard')],
            ['text' => 'Transaksi', 'url' => '#'],
            ['text' => 'Pengeluaran Kas', 'active' => true]
        ],
        'primary_action' => [
            'route' => route('keuangan.pengeluaran.create'),
            'text' => 'Tambah Pengeluaran',
            'icon' => 'fas fa-plus',
            'class' => 'btn-warning'
        ]
    ];

    // Calculate statistics from data
    $statistics = [
        'total_transaksi' => $pengeluarans->total(),
        'total_pending' => $pengeluarans->where('status', 'pending')->count(),
        'total_approved' => $pengeluarans->where('status', 'approved')->count(),
        'total_nilai' => $pengeluarans->sum('uang_sebanyak_angka')
    ];

    $tableConfig = [
        'title' => 'Data Bukti Pengeluaran Kas',
        'data' => $pengeluarans,
        'create_route' => route('keuangan.pengeluaran.create'),
        'create_button_text' => 'Tambah Pengeluaran',
        'empty_message' => 'Belum ada data pengeluaran kas. Klik tombol "Tambah Pengeluaran" untuk membuat bukti pengeluaran pertama.',
        'delete_name_field' => 'nomor_bukti',
        'columns' => [
            [
                'label' => 'No',
                'type' => 'number',
                'width' => '5%'
            ],
            [
                'label' => 'Nomor Bukti',
                'type' => 'badge',
                'field' => 'nomor_bukti',
                'badge_class' => 'primary',
                'width' => '12%'
            ],
            [
                'label' => 'Tanggal',
                'type' => 'date',
                'field' => 'tanggal',
                'format' => 'd/m/Y',
                'width' => '10%'
            ],
            [
                'label' => 'Penerima',
                'type' => 'text',
                'field' => 'sudah_terima_dari',
                'width' => '20%',
                'truncate' => 40
            ],
            [
                'label' => 'Mata Anggaran',
                'type' => 'relation_text',
                'field' => 'mataAnggaran.kode_mata_anggaran',
                'width' => '15%'
            ],
            [
                'label' => 'Jumlah',
                'type' => 'currency',
                'field' => 'uang_sebanyak_angka',
                'width' => '12%'
            ],
            [
                'label' => 'Status',
                'type' => 'status_badge',
                'field' => 'status',
                'width' => '10%'
            ]
        ],
        'actions' => [
            'show' => route('keuangan.pengeluaran.show', ':id'),
            'edit' => route('keuangan.pengeluaran.edit', ':id'),
            'delete' => route('keuangan.pengeluaran.destroy', ':id'),
            'print' => route('keuangan.pengeluaran.print', ':id')
        ],
        'custom_actions' => [
            [
                'route' => route('keuangan.pengeluaran.pdf', ':id'),
                'text' => 'PDF',
                'icon' => 'fas fa-file-pdf',
                'class' => 'btn-danger btn-sm',
                'title' => 'Download PDF'
            ]
        ]
    ];

    $filterConfig = [
        'title' => 'Filter & Pencarian Pengeluaran',
        'action_route' => route('keuangan.pengeluaran.index'),
        'search_placeholder' => 'Cari nomor bukti, penerima, atau keterangan...',
        'filters' => [
            [
                'name' => 'status',
                'label' => 'Status',
                'type' => 'select',
                'options' => $filterOptions['statusOptions'] ?? [],
                'value' => request('status')
            ],
            [
                'name' => 'mata_anggaran_id',
                'label' => 'Mata Anggaran',
                'type' => 'select',
                'options' => $filterOptions['mataAnggarans']->pluck('nama_mata_anggaran', 'id')->toArray() ?? [],
                'value' => request('mata_anggaran_id')
            ],
            [
                'name' => 'start_date',
                'label' => 'Dari Tanggal',
                'type' => 'date',
                'value' => request('start_date')
            ],
            [
                'name' => 'end_date',
                'label' => 'Sampai Tanggal',
                'type' => 'date',
                'value' => request('end_date')
            ]
        ]
    ];

    $alertConfig = [
        'type' => 'info',
        'module' => 'Pencatatan Pengeluaran Kas',
        'status' => 'Ready',
        'version' => 'v1.0.0',
        'features' => [
            'CRUD Bukti Pengeluaran',
            'Auto Generate Nomor Bukti',
            'Status Workflow',
            'Print & PDF Export',
            'Master Data Integration',
            'PostgreSQL Optimized'
        ],
        'database' => true,
        'note' => 'Sesuai dengan template bukti pengeluaran kas fakultas'
    ];
@endphp
