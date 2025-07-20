{{-- F:\rapor-dosen\resources\views\keuangan\master\program\create.blade.php --}}
@extends('keuangan.master.layouts.master-form')

@php
    $headerConfig = [
        'title' => 'Tambah Program',
        'description' => 'Menambahkan data program baru',
        'back_route' => route('keuangan.program.index'),
        'back_text' => 'Kembali ke Daftar'
    ];

    $formConfig = [
        'title' => 'Form Tambah Program',
        'icon' => 'graduation-cap',
        'action' => route('keuangan.program.store'),
        'cancel_route' => route('keuangan.program.index'),
        'submit_text' => 'Simpan',
        'fields' => [
            [
                'name' => 'nama_program',
                'label' => 'Nama Program',
                'type' => 'text',
                'required' => true,
                'placeholder' => 'Contoh: Reguler Pagi, Reguler Sore, Kerja Sama',
                'col_size' => '12',
                'help_text' => 'Nama program pendidikan (maksimal 100 karakter)'
            ]
        ],
        'info_panel' => [
            'type' => 'info',
            'icon' => 'info-circle',
            'title' => 'Informasi',
            'subtitle' => 'Program yang Tersedia:',
            'items' => [
                [
                    'icon' => 'sun',
                    'color' => 'success',
                    'text' => '<strong>Reguler Pagi:</strong> Program kuliah regular waktu pagi'
                ],
                [
                    'icon' => 'moon',
                    'color' => 'warning',
                    'text' => '<strong>Reguler Sore:</strong> Program kuliah regular waktu sore'
                ],
                [
                    'icon' => 'handshake',
                    'color' => 'info',
                    'text' => '<strong>Kerja Sama:</strong> Program kerjasama dengan institusi lain'
                ],
                [
                    'icon' => 'check',
                    'color' => 'success',
                    'text' => 'Nama program harus unik dan tidak boleh duplikat'
                ]
            ]
        ]
    ];

    // Development alert config
    $alertConfig = [
        'type' => 'info',
        'module' => 'Form Tambah Program',
        'status' => 'Ready',
        'version' => 'v1.0.0',
        'features' => ['Validasi Input', 'Unique Constraint', 'Smart Badge'],
        'database' => true,
        'note' => 'Form tambah program dengan validasi lengkap'
    ];
@endphp
