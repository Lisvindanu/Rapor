{{-- resources/views/keuangan/master/sumber-dana/edit.blade.php --}}
@extends('app')

@php
    $headerConfig = [
        'title' => 'Edit Sumber Dana',
        'description' => 'Edit data sumber dana untuk sistem keuangan',
        'back_route' => route('keuangan.sumber-dana.index'),
        'back_text' => 'Kembali ke Daftar'
    ];

    $formConfig = [
        'title' => 'Form Edit Sumber Dana',
        'action' => route('keuangan.sumber-dana.update', $sumberDana->id),
        'method' => 'PUT',
        'submit_text' => 'Perbarui Sumber Dana',
        'cancel_route' => route('keuangan.sumber-dana.index'),
        'icon' => 'edit',
        'data' => $sumberDana,
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
            'type' => 'warning',
            'icon' => 'edit',
            'title' => 'Informasi Edit',
            'subtitle' => 'Data yang akan diubah:',
            'items' => [
                ['icon' => 'calendar', 'color' => 'info', 'text' => 'Dibuat: ' . $sumberDana->formatted_created_at],
                ['icon' => 'clock', 'color' => 'info', 'text' => 'Terakhir diubah: ' . $sumberDana->updated_at->format('d/m/Y H:i')],
                ['icon' => 'exclamation-triangle', 'color' => 'warning', 'text' => 'Pastikan nama sumber dana tidak duplikat'],
                ['icon' => 'info-circle', 'color' => 'info', 'text' => 'Perubahan akan memengaruhi data transaksi terkait']
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
