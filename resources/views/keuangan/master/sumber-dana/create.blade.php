{{-- resources/views/keuangan/master/sumber-dana/create.blade.php --}}
@extends('layouts.main2')

@php
    $headerConfig = [
        'title' => 'Tambah Sumber Dana',
        'description' => 'Tambah data sumber dana baru untuk sistem keuangan',
        'back_route' => route('keuangan.sumber-dana.index'),
        'back_text' => 'Kembali ke Daftar'
    ];

    $formConfig = [
        'title' => 'Form Tambah Sumber Dana',
        'action' => route('keuangan.sumber-dana.store'),
        'method' => 'POST',
        'submit_text' => 'Simpan Sumber Dana',
        'cancel_route' => route('keuangan.sumber-dana.index'),
        'icon' => 'plus',
        'fields' => [
            [
                'name' => 'nama_sumber_dana',
                'type' => 'text',
                'label' => 'Nama Sumber Dana',
                'placeholder' => 'Masukkan nama sumber dana...',
                'required' => true,
                'help_text' => 'Maksimal 200 karakter. Contoh: "Dropping dari Universitas"'
            ]
        ],
        'info_panel' => [
            'type' => 'info',
            'icon' => 'info-circle',
            'title' => 'Informasi Sumber Dana',
            'subtitle' => 'Panduan pengisian:',
            'items' => [
                [
                    'icon' => 'check-circle',
                    'color' => 'success',
                    'text' => 'Nama sumber dana harus unik dan tidak boleh sama'
                ],
                [
                    'icon' => 'edit',
                    'color' => 'info',
                    'text' => 'Gunakan nama yang jelas dan mudah dipahami'
                ],
                [
                    'icon' => 'lightbulb',
                    'color' => 'warning',
                    'text' => 'Contoh: "Dropping dari Fakultas", "Dana Internal"'
                ],
                [
                    'icon' => 'database',
                    'color' => 'info',
                    'text' => 'Data akan tersimpan permanent di database'
                ]
            ]
        ]
    ];
@endphp

@section('css-tambahan')
    @include('keuangan.master.partials.styles')
    @include('keuangan.master.partials.form-styles')
@endsection

@section('navbar')
    @include('keuangan.navbar')
@endsection

@section('konten')
    @include('keuangan.master.partials.form-template')
@endsection

@section('js-tambahan')
    @include('keuangan.master.partials.form-scripts')
@endsection
