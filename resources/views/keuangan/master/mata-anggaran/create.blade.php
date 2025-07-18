{{-- F:\rapor-dosen\resources\views\keuangan\master\mata-anggaran\create.blade.php --}}
@extends('keuangan.master.layouts.master-create')

@php
    $headerConfig = [
        'title' => 'Tambah Mata Anggaran',
        'description' => 'Menambahkan data mata anggaran baru',
        'back_route' => route('keuangan.mata-anggaran.index'),
        'back_text' => 'Kembali ke Daftar'
    ];

    $formConfig = [
        'title' => 'Form Tambah Mata Anggaran',
        'action' => route('keuangan.mata-anggaran.store'),
        'cancel_route' => route('keuangan.mata-anggaran.index'),
        'fields' => [
            [
                'name' => 'kode_mata_anggaran',
                'label' => 'Kode Mata Anggaran',
                'type' => 'text',
                'required' => true,
                'placeholder' => 'Contoh: MA001',
                'col_size' => '6',
                'help_text' => 'Kode unik untuk mata anggaran (maksimal 20 karakter)'
            ],
            [
                'name' => 'nama_mata_anggaran',
                'label' => 'Nama Mata Anggaran',
                'type' => 'text',
                'required' => true,
                'placeholder' => 'Masukkan nama mata anggaran',
                'col_size' => '6'
            ],
            [
                'name' => 'nama_mata_anggaran_en',
                'label' => 'Nama Mata Anggaran (English)',
                'type' => 'text',
                'required' => false,
                'placeholder' => 'English name (optional)',
                'col_size' => '6'
            ],
            [
                'name' => 'parent_mata_anggaran',
                'label' => 'Parent Mata Anggaran',
                'type' => 'select',
                'required' => false,
                'options' => $parentOptions->pluck('nama_mata_anggaran', 'id')->toArray(),
                'placeholder' => 'Pilih parent (kosongkan jika level utama)',
                'col_size' => '6'
            ],
            [
                'name' => 'kategori',
                'label' => 'Kategori',
                'type' => 'select',
                'required' => false,
                'options' => [
                    'operasional' => 'Operasional',
                    'investasi' => 'Investasi',
                    'pembiayaan' => 'Pembiayaan',
                    'lainnya' => 'Lainnya'
                ],
                'placeholder' => 'Pilih kategori',
                'col_size' => '6'
            ],
            [
                'name' => 'tahun_anggaran',
                'label' => 'Tahun Anggaran',
                'type' => 'select',
                'required' => true,
                'options' => array_combine($tahunOptions, $tahunOptions),
                'placeholder' => 'Pilih tahun anggaran',
                'col_size' => '6'
            ],
            [
                'name' => 'alokasi_anggaran',
                'label' => 'Alokasi Anggaran',
                'type' => 'currency',
                'required' => false,
                'placeholder' => '0',
                'col_size' => '6',
                'help_text' => 'Dalam Rupiah, kosongkan jika belum ditentukan'
            ],
            [
                'name' => 'deskripsi',
                'label' => 'Deskripsi',
                'type' => 'textarea',
                'required' => false,
                'placeholder' => 'Deskripsi detail mata anggaran',
                'rows' => '4',
                'col_size' => '12'
            ],
            [
                'name' => 'status_aktif',
                'label' => 'Status',
                'type' => 'checkbox',
                'required' => false,
                'checkbox_label' => 'Aktif',
                'col_size' => '12'
            ]
        ]
    ];
@endphp
