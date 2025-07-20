{{-- F:\rapor-dosen\resources\views\keuangan\master\tahun-anggaran\edit.blade.php --}}
@extends('keuangan.master.layouts.master-form')

@php
    $headerConfig = [
        'title' => 'Edit Tahun Anggaran',
        'description' => 'Mengubah data tahun anggaran: ' . $tahunAnggaran->tahun_anggaran,
        'back_route' => route('keuangan.tahun-anggaran.index'),
        'back_text' => 'Kembali ke Daftar'
    ];

    $formConfig = [
        'title' => 'Form Edit Tahun Anggaran',
        'icon' => 'calendar-edit',
        'action' => route('keuangan.tahun-anggaran.update', $tahunAnggaran->id),
        'method' => 'PUT',
        'cancel_route' => route('keuangan.tahun-anggaran.index'),
        'submit_text' => 'Update',
        'data' => $tahunAnggaran,
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
            'type' => 'warning',
            'icon' => 'exclamation-triangle',
            'title' => 'Peringatan',
            'subtitle' => 'Perhatian:',
            'items' => [
                [
                    'icon' => 'info',
                    'color' => 'info',
                    'text' => 'Perubahan periode dapat mempengaruhi data transaksi'
                ],
                [
                    'icon' => 'exclamation-triangle',
                    'color' => 'warning',
                    'text' => 'Pastikan periode tidak overlap dengan tahun anggaran lain'
                ],
                ...$tahunAnggaran->is_aktif ? [[
                    'icon' => 'ban',
                    'color' => 'danger',
                    'text' => '<strong class="text-danger">Tahun anggaran sedang aktif!</strong> Hati-hati mengubah periode.'
                ]] : []
            ]
        ]
    ];

    // Development alert config
    $alertConfig = [
        'type' => 'warning',
        'module' => 'Form Edit Tahun Anggaran',
        'status' => 'Ready',
        'version' => 'v1.0.0',
        'features' => ['Validasi Input', 'Validasi Overlap', 'Date Picker'],
        'database' => true,
        'note' => 'Form edit tahun anggaran dengan validasi lengkap'
    ];
@endphp
