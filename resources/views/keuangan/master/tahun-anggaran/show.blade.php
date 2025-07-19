{{-- F:\rapor-dosen\resources\views\keuangan\master\tahun-anggaran\show.blade.php --}}
@extends('keuangan.master.layouts.master-show')

@php
    $headerConfig = [
        'title' => 'Detail Tahun Anggaran',
        'description' => 'Detail lengkap tahun anggaran: ' . $tahunAnggaran->tahun_anggaran,
        'back_route' => route('keuangan.tahun-anggaran.index'),
        'back_text' => 'Kembali ke Daftar',
        'primary_action' => [
            'route' => route('keuangan.tahun-anggaran.edit', $tahunAnggaran->id),
            'text' => 'Edit Data',
            'icon' => 'fas fa-edit',
            'class' => 'btn-warning'
        ]
    ];

    $detailConfig = [
        'title' => 'Informasi Tahun Anggaran',
        'data' => $tahunAnggaran,
        'sections' => [
            [
                'title' => 'Informasi Umum',
                'icon' => 'calendar-alt',
                'fields' => [
                    [
                        'label' => 'Tahun Anggaran',
                        'field' => 'tahun_anggaran',
                        'type' => 'badge',
                        'badge_class' => 'primary',
                        'col_size' => '6'
                    ],
                    [
                        'label' => 'Status',
                        'field' => 'status',
                        'type' => 'status_badge',
                        'col_size' => '6'
                    ],
                    [
                        'label' => 'Tanggal Awal Anggaran',
                        'field' => 'tgl_awal_anggaran',
                        'type' => 'date',
                        'col_size' => '6'
                    ],
                    [
                        'label' => 'Tanggal Akhir Anggaran',
                        'field' => 'tgl_akhir_anggaran',
                        'type' => 'date',
                        'col_size' => '6'
                    ]
                ]
            ],
            [
                'title' => 'Statistik Periode',
                'icon' => 'chart-bar',
                'fields' => [
                    [
                        'label' => 'Periode Lengkap',
                        'field' => 'periode_lengkap',
                        'type' => 'text',
                        'col_size' => '6'
                    ],
                    [
                        'label' => 'Durasi (Hari)',
                        'field' => 'durasi_hari',
                        'type' => 'badge',
                        'badge_class' => 'info',
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
