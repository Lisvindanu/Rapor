{{-- F:\rapor-dosen\resources\views\keuangan\master\program\show.blade.php --}}
@extends('keuangan.master.layouts.master-show')

@php
    $headerConfig = [
        'title' => 'Detail Program',
        'description' => 'Detail lengkap program: ' . $program->nama_program,
        'back_route' => route('keuangan.program.index'),
        'back_text' => 'Kembali ke Daftar',
        'primary_action' => [
            'route' => route('keuangan.program.edit', $program->id),
            'text' => 'Edit Data',
            'icon' => 'fas fa-edit',
            'class' => 'btn-warning'
        ]
    ];

    $detailConfig = [
        'title' => 'Informasi Program',
        'data' => $program,
        'sections' => [
            [
                'title' => 'Informasi Umum',
                'icon' => 'graduation-cap',
                'fields' => [
                    [
                        'label' => 'Nama Program',
                        'field' => 'nama_program',
                        'type' => 'program_badge_large',
                        'col_size' => '6'
                    ],
                    [
                        'label' => 'ID Program',
                        'field' => 'id',
                        'type' => 'text',
                        'col_size' => '6'
                    ],
                    [
                        'label' => 'Dibuat Pada',
                        'field' => 'created_at',
                        'type' => 'datetime',
                        'col_size' => '6'
                    ],
                    [
                        'label' => 'Terakhir Diubah',
                        'field' => 'updated_at',
                        'type' => 'datetime',
                        'col_size' => '6'
                    ]
                ]
            ]
        ]
    ];
@endphp
