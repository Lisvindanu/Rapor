{{-- F:\rapor-dosen\resources\views\keuangan\master\mata-anggaran\show.blade.php --}}
@extends('keuangan.master.layouts.master-show')

@php
    $headerConfig = [
        'title' => 'Detail Mata Anggaran',
        'description' => 'Detail lengkap mata anggaran: ' . $mataAnggaran->nama_mata_anggaran,
        'back_route' => route('keuangan.mata-anggaran.index'),
        'back_text' => 'Kembali ke Daftar',
        'primary_action' => [
            'route' => route('keuangan.mata-anggaran.edit', $mataAnggaran->id),
            'text' => 'Edit Data',
            'icon' => 'fas fa-edit',
            'class' => 'btn-warning'
        ]
    ];

    $detailConfig = [
        'title' => 'Informasi Mata Anggaran',
        'data' => $mataAnggaran,
        'sections' => [
            [
                'title' => 'Informasi Umum',
                'fields' => [
                    [
                        'label' => 'Kode Mata Anggaran',
                        'field' => 'kode_mata_anggaran',
                        'type' => 'badge',
                        'badge_class' => 'primary'
                    ],
                    [
                        'label' => 'Nama Mata Anggaran',
                        'field' => 'nama_mata_anggaran',
                        'type' => 'text'
                    ],
                    [
                        'label' => 'Nama (English)',
                        'field' => 'nama_mata_anggaran_en',
                        'type' => 'text'
                    ],
                    [
                        'label' => 'Parent Mata Anggaran',
                        'field' => 'parentMataAnggaran.nama_mata_anggaran',
                        'type' => 'text',
                        'empty_text' => 'Level Utama'
                    ]
                ]
            ],
            [
                'title' => 'Kategori & Anggaran',
                'fields' => [
                    [
                        'label' => 'Kategori',
                        'field' => 'kategori',
                        'type' => 'badge',
                        'badge_class' => 'info'
                    ],
                    [
                        'label' => 'Tahun Anggaran',
                        'field' => 'tahun_anggaran',
                        'type' => 'badge',
                        'badge_class' => 'info'
                    ],
                    [
                        'label' => 'Alokasi Anggaran',
                        'field' => 'alokasi_anggaran',
                        'type' => 'currency'
                    ],
                    [
                        'label' => 'Sisa Anggaran',
                        'field' => 'sisa_anggaran',
                        'type' => 'currency'
                    ]
                ]
            ],
            [
                'title' => 'Status & Waktu',
                'fields' => [
                    [
                        'label' => 'Status',
                        'field' => 'status_aktif',
                        'type' => 'status'
                    ],
                    [
                        'label' => 'Dibuat Pada',
                        'field' => 'created_at',
                        'type' => 'datetime'
                    ],
                    [
                        'label' => 'Terakhir Diubah',
                        'field' => 'updated_at',
                        'type' => 'datetime'
                    ]
                ]
            ]
        ]
    ];

    if (!empty($mataAnggaran->deskripsi)) {
        $detailConfig['sections'][] = [
            'title' => 'Deskripsi',
            'fields' => [
                [
                    'label' => 'Deskripsi',
                    'field' => 'deskripsi',
                    'type' => 'longtext'
                ]
            ]
        ];
    }

    $actionConfig = [
        'buttons' => [
            [
                'route' => route('keuangan.mata-anggaran.edit', $mataAnggaran->id),
                'text' => 'Edit',
                'icon' => 'fas fa-edit',
                'class' => 'btn-warning'
            ]
        ]
    ];

    if ($mataAnggaran->hasChildren()) {
        $actionConfig['buttons'][] = [
            'route' => route('keuangan.sub-mata-anggaran.index', $mataAnggaran->id),
            'text' => 'Lihat Sub Mata Anggaran',
            'icon' => 'fas fa-sitemap',
            'class' => 'btn-info'
        ];
    }

    $actionConfig['buttons'][] = [
        'type' => 'delete',
        'route' => route('keuangan.mata-anggaran.destroy', $mataAnggaran->id),
        'text' => 'Hapus',
        'icon' => 'fas fa-trash',
        'class' => 'btn-danger',
        'confirm_message' => 'Yakin ingin menghapus mata anggaran "' . $mataAnggaran->nama_mata_anggaran . '"?'
    ];
@endphp
