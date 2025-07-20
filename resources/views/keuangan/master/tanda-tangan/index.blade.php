{{-- resources/views/keuangan/master/tanda-tangan/index.blade.php --}}
@extends('layouts.main2')

@php
    $tableConfig = [
        'title' => 'Data Penanda Tangan',
        'data' => $tandaTangans ?? collect(),
        'create_route' => route('keuangan.tanda-tangan.create'),
        'empty_message' => 'Belum ada data penanda tangan. Klik tombol "Tambah Data" untuk menambahkan penanda tangan pertama.',
        'delete_name_field' => 'nama',
        'columns' => [
            [
                'label' => 'No',
                'type' => 'number',
                'width' => '5%'
            ],
            [
                'label' => 'Nomor TTD',
                'type' => 'badge',
                'field' => 'nomor_ttd',
                'badge_class' => 'primary',
                'width' => '15%'
            ],
            [
                'label' => 'Nama',
                'type' => 'text',
                'field' => 'nama',
                'width' => '25%'
            ],
            [
                'label' => 'Jabatan',
                'type' => 'text',
                'field' => 'jabatan',
                'width' => '25%'
            ],
            [
                'label' => 'Tanda Tangan',
                'type' => 'preview_ttd',
                'field' => 'gambar_ttd',
                'width' => '15%'
            ],
            [
                'label' => 'Tanggal Dibuat',
                'type' => 'text',
                'field' => 'formatted_created_at',
                'width' => '10%'
            ]
        ],
        'actions' => [
            'show' => route('keuangan.tanda-tangan.show', ':id'),
            'edit' => route('keuangan.tanda-tangan.edit', ':id'),
            'delete' => route('keuangan.tanda-tangan.destroy', ':id')
        ]
    ];

    $alertConfig = [
        'type' => 'info',
        'module' => 'Master Data Penanda Tangan',
        'status' => 'Ready',
        'version' => 'v1.0.0',
        'features' => ['CRUD lengkap', 'Upload Gambar TTD', 'Search & Filter', 'Validation', 'Clean Architecture'],
        'database' => true,
        'note' => 'Modul untuk pengelolaan data penanda tangan dokumen keuangan'
    ];

    $filterConfig = [
        'title' => 'Filter & Pencarian Penanda Tangan',
        'action_route' => route('keuangan.tanda-tangan.index'),
        'search_placeholder' => 'Cari nomor TTD, nama, atau jabatan...'
    ];
@endphp

@section('css-tambahan')
    @include('keuangan.master.partials.styles')
    <style>
        .signature-preview {
            max-width: 80px;
            max-height: 40px;
            border: 1px solid #dee2e6;
            border-radius: 4px;
            padding: 2px;
            background: white;
        }
        .no-signature {
            color: #6c757d;
            font-style: italic;
            font-size: 0.875em;
        }
    </style>
@endsection

@section('navbar')
    @include('keuangan.navbar')
@endsection

@section('konten')
    <div class="container">
        @include('keuangan.master.partials.header')
        @include('komponen.message-alert')
        @include('keuangan.master.partials.development-alert')
        @include('keuangan.master.partials.filter-form')
        @include('keuangan.master.partials.data-table-custom')
    </div>
@endsection

@section('js-tambahan')
    @include('keuangan.master.partials.scripts')
    @include('keuangan.master.partials.delete-script')
@endsection
