{{-- F:\rapor-dosen\resources\views\keuangan\master\tahun-anggaran\create.blade.php --}}
@extends('keuangan.master.layouts.master-form')

@php
    $headerConfig = [
        'title' => 'Tambah Tahun Anggaran',
        'description' => 'Menambahkan data tahun anggaran baru',
        'back_route' => route('keuangan.tahun-anggaran.index'),
        'back_text' => 'Kembali ke Daftar'
    ];

    $formConfig = [
        'title' => 'Form Tambah Tahun Anggaran',
        'icon' => 'calendar-plus',
        'action' => route('keuangan.tahun-anggaran.store'),
        'cancel_route' => route('keuangan.tahun-anggaran.index'),
        'submit_text' => 'Simpan',
        'fields' => [
            [
                'name' => 'tahun_anggaran',
                'label' => 'Tahun Anggaran',
                'type' => 'text',
                'required' => true,
                'placeholder' => 'Contoh: 2025 atau 2024/2025',
                'col_size' => '12',
                'help_text' => 'Format tahun anggaran (maksimal 10 karakter)'
            ],
            [
                'name' => 'tgl_awal_anggaran',
                'label' => 'Tanggal Awal Anggaran',
                'type' => 'date',
                'required' => true,
                'col_size' => '6',
                'help_text' => 'Tanggal mulai berlakunya anggaran'
            ],
            [
                'name' => 'tgl_akhir_anggaran',
                'label' => 'Tanggal Akhir Anggaran',
                'type' => 'date',
                'required' => true,
                'col_size' => '6',
                'help_text' => 'Tanggal berakhirnya anggaran'
            ]
        ],
        'info_panel' => [
            'type' => 'info',
            'icon' => 'info-circle',
            'title' => 'Informasi',
            'subtitle' => 'Petunjuk Pengisian:',
            'items' => [
                [
                    'icon' => 'check',
                    'color' => 'success',
                    'text' => '<strong>Tahun Anggaran:</strong> Format bebas, contoh: 2025, 2024/2025'
                ],
                [
                    'icon' => 'check',
                    'color' => 'success',
                    'text' => '<strong>Periode:</strong> Tanggal akhir harus setelah tanggal awal'
                ],
                [
                    'icon' => 'exclamation-triangle',
                    'color' => 'warning',
                    'text' => '<strong>Validasi:</strong> Periode tidak boleh overlap dengan yang sudah ada'
                ]
            ]
        ]
    ];

    // Development alert config
    $alertConfig = [
        'type' => 'info',
        'module' => 'Form Tambah Tahun Anggaran',
        'status' => 'Ready',
        'version' => 'v1.0.0',
        'features' => ['Validasi Input', 'Validasi Overlap', 'Date Picker'],
        'database' => true,
        'note' => 'Form tambah tahun anggaran dengan validasi lengkap'
    ];
@endphp
