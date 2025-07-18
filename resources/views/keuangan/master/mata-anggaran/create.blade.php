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
                'placeholder' => 'Contoh: 1 atau 1.1',
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
                'required' => true,
                'options' => [
                    'debet' => 'Debet (Pengeluaran/Biaya)',
                    'kredit' => 'Kredit (Pendapatan/Penerimaan)'
                ],
                'placeholder' => 'Pilih kategori',
                'col_size' => '6'
            ]
        ]
    ];
@endphp
