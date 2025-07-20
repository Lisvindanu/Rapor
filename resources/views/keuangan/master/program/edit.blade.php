{{-- F:\rapor-dosen\resources\views\keuangan\master\program\edit.blade.php --}}
@extends('keuangan.master.layouts.master-form')

@php
    $headerConfig = [
        'title' => 'Edit Program',
        'description' => 'Mengubah data program: ' . $program->nama_program,
        'back_route' => route('keuangan.program.index'),
        'back_text' => 'Kembali ke Daftar'
    ];

    $formConfig = [
        'title' => 'Form Edit Program',
        'icon' => 'graduation-cap',
        'action' => route('keuangan.program.update', $program->id),
        'method' => 'PUT',
        'cancel_route' => route('keuangan.program.index'),
        'submit_text' => 'Update',
        'data' => $program,
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
            'type' => 'warning',
            'icon' => 'exclamation-triangle',
            'title' => 'Peringatan',
            'subtitle' => 'Perhatian:',
            'items' => [
                [
                    'icon' => 'info',
                    'color' => 'info',
                    'text' => 'Perubahan nama program dapat mempengaruhi data transaksi'
                ],
                [
                    'icon' => 'exclamation-triangle',
                    'color' => 'warning',
                    'text' => 'Pastikan nama program tidak duplikat dengan yang sudah ada'
                ],
                [
                    'icon' => 'database',
                    'color' => 'secondary',
                    'text' => 'Program ini mungkin sudah digunakan di modul lain'
                ]
            ]
        ]
    ];

    // Development alert config
    $alertConfig = [
        'type' => 'warning',
        'module' => 'Form Edit Program',
        'status' => 'Ready',
        'version' => 'v1.0.0',
        'features' => ['Validasi Input', 'Unique Constraint', 'Data Protection'],
        'database' => true,
        'note' => 'Form edit program dengan validasi lengkap'
    ];
@endphp
