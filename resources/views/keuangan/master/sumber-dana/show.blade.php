{{-- resources/views/keuangan/master/sumber-dana/show.blade.php --}}
@extends('app')

@php
    $headerConfig = [
        'title' => 'Detail Sumber Dana',
        'description' => 'Informasi detail sumber dana: ' . $sumberDana->nama_sumber_dana,
        'back_route' => route('keuangan.sumber-dana.index'),
        'back_text' => 'Kembali ke Daftar'
    ];

    $detailConfig = [
        'title' => 'Detail Sumber Dana',
        'data' => $sumberDana,
        'sections' => [
            [
                'title' => 'Informasi Umum',
                'icon' => 'info-circle',
                'fields' => [
                    [
                        'label' => 'ID',
                        'field' => 'id',
                        'type' => 'text',
                        'col_size' => '12'
                    ],
                    [
                        'label' => 'Nama Sumber Dana',
                        'field' => 'nama_sumber_dana',
                        'type' => 'badge',
                        'badge_class' => 'primary',
                        'col_size' => '12'
                    ]
                ]
            ],
            [
                'title' => 'Informasi Waktu',
                'icon' => 'clock',
                'fields' => [
                    [
                        'label' => 'Tanggal Dibuat',
                        'field' => 'created_at',
                        'type' => 'datetime',
                        'col_size' => '6'
                    ],
                    [
                        'label' => 'Terakhir Diperbarui',
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
                'text' => 'Edit',
                'route' => route('keuangan.sumber-dana.edit', $sumberDana->id),
                'class' => 'btn-warning',
                'icon' => 'fas fa-edit'
            ],
            [
                'text' => 'Hapus',
                'route' => route('keuangan.sumber-dana.destroy', $sumberDana->id),
                'class' => 'btn-danger delete-btn',
                'icon' => 'fas fa-trash',
                'type' => 'delete',
                'confirm_message' => 'Apakah Anda yakin ingin menghapus sumber dana "' . $sumberDana->nama_sumber_dana . '"?'
            ]
        ]
    ];
@endphp

@section('css-tambahan')
    @include('keuangan.master.partials.styles')
    @include('keuangan.master.partials.detail-styles')
@endsection

@section('navbar')
    @include('keuangan.navbar')
@endsection

@section('konten')
    <div class="container">
        @include('keuangan.master.partials.header')
        @include('komponen.message-alert')
        @include('keuangan.master.partials.detail-content')
        @include('keuangan.master.partials.action-buttons')
    </div>
@endsection

@section('js-tambahan')
    @include('keuangan.master.partials.scripts')
    @include('keuangan.master.partials.delete-script')
@endsection
