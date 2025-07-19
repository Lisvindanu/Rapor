{{-- resources/views/keuangan/master/sumber-dana/create.blade.php --}}
@extends('app')

@php
    $headerConfig = [
        'title' => 'Tambah Sumber Dana',
        'description' => 'Tambah data sumber dana untuk sistem keuangan',
        'back_route' => route('keuangan.sumber-dana.index'),
        'back_text' => 'Kembali ke Daftar'
    ];

    $formConfig = [
        'title' => 'Form Tambah Sumber Dana',
        'action' => route('keuangan.sumber-dana.store'),
        'submit_text' => 'Simpan Sumber Dana',
        'cancel_route' => route('keuangan.sumber-dana.index'),
        'icon' => 'plus-circle',
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
            'title' => 'Informasi',
            'subtitle' => 'Petunjuk pengisian:',
            'items' => [
                ['icon' => 'check', 'color' => 'success', 'text' => 'Nama sumber dana wajib diisi'],
                ['icon' => 'check', 'color' => 'success', 'text' => 'Maksimal 200 karakter'],
                ['icon' => 'check', 'color' => 'success', 'text' => 'Nama tidak boleh duplikat'],
                ['icon' => 'lightbulb', 'color' => 'warning', 'text' => 'Gunakan nama yang jelas dan mudah dipahami']
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
