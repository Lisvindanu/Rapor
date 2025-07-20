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
                'icon' => 'info-circle',
                'fields' => [
                    [
                        'label' => 'Kode Mata Anggaran',
                        'field' => 'kode_mata_anggaran',
                        'type' => 'badge',
                        'badge_class' => 'primary',
                        'col_size' => '6'
                    ],
                    [
                        'label' => 'Nama Mata Anggaran',
                        'field' => 'nama_mata_anggaran',
                        'type' => 'text',
                        'col_size' => '6'
                    ],
                    [
                        'label' => 'Kategori',
                        'field' => 'kategori',
                        'type' => 'kategori_badge',
                        'col_size' => '6'
                    ],
                    [
                        'label' => 'Level Hierarki',
                        'field' => 'hierarchy_level',
                        'type' => 'badge',
                        'badge_class' => 'info',
                        'col_size' => '6'
                    ]
                ]
            ],
            [
                'title' => 'Hierarki & Struktur',
                'icon' => 'sitemap',
                'fields' => [
                    [
                        'label' => 'Parent Mata Anggaran',
                        'field' => 'parentMataAnggaran.nama_mata_anggaran',
                        'type' => 'text',
                        'empty_text' => 'Level Utama (Tidak ada parent)',
                        'col_size' => '6'
                    ],
                    [
                        'label' => 'Jumlah Sub Item',
                        'field' => 'children_count',
                        'type' => 'badge',
                        'badge_class' => 'success',
                        'col_size' => '6'
                    ],
                    [
                        'label' => 'Path Lengkap',
                        'field' => 'full_path',
                        'type' => 'text',
                        'col_size' => '12'
                    ]
                ]
            ],
            [
                'title' => 'Informasi Sistem',
                'icon' => 'clock',
                'fields' => [
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

    $actionConfig = [
        'buttons' => [
            [
                'route' => route('keuangan.mata-anggaran.edit', $mataAnggaran->id),
                'text' => 'Edit Data',
                'icon' => 'fas fa-edit',
                'class' => 'btn-warning'
            ]
        ]
    ];

    // Add create child button if this is a parent
    if ($mataAnggaran->is_parent || $mataAnggaran->children_count == 0) {
        $actionConfig['buttons'][] = [
            'route' => route('keuangan.mata-anggaran.create') . '?parent=' . $mataAnggaran->id,
            'text' => 'Tambah Sub Item',
            'icon' => 'fas fa-plus',
            'class' => 'btn-success'
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
