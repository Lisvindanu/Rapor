{{-- F:\rapor-dosen\resources\views\keuangan\master\sub-mata-anggaran\create.blade.php --}}
@extends('keuangan.master.layouts.master-create')

@php
    $headerConfig = [
        'title' => 'Tambah Sub Mata Anggaran',
        'description' => 'Menambahkan sub mata anggaran untuk: ' . $parent->nama_mata_anggaran . ' (' . $parent->kode_mata_anggaran . ')',
        'back_route' => route('keuangan.sub-mata-anggaran.index', $parent->id),
        'back_text' => 'Kembali ke Daftar Sub'
    ];

    $formConfig = [
        'title' => 'Form Tambah Sub Mata Anggaran',
        'action' => route('keuangan.sub-mata-anggaran.store', $parent->id),
        'cancel_route' => route('keuangan.sub-mata-anggaran.index', $parent->id),
        'fields' => [
            [
                'name' => 'kode_mata_anggaran',
                'label' => 'Kode Sub Mata Anggaran',
                'type' => 'text',
                'required' => true,
                'placeholder' => 'Contoh: ' . $parent->kode_mata_anggaran . '.01',
                'col_size' => '6',
                'help_text' => 'Kode unik untuk sub mata anggaran (maksimal 20 karakter)'
            ],
            [
                'name' => 'nama_mata_anggaran',
                'label' => 'Nama Sub Mata Anggaran',
                'type' => 'text',
                'required' => true,
                'placeholder' => 'Masukkan nama sub mata anggaran',
                'col_size' => '6'
            ],
            [
                'name' => 'nama_mata_anggaran_en',
                'label' => 'Nama Sub Mata Anggaran (English)',
                'type' => 'text',
                'required' => false,
                'placeholder' => 'English name (optional)',
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
                'placeholder' => 'Deskripsi detail sub mata anggaran',
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

{{-- Parent Info Section --}}
@section('konten')
    <div class="container">
        @include('keuangan.master.partials.header')
        @include('komponen.message-alert')

        {{-- Parent Mata Anggaran Info --}}
        <div class="row justify-content-md-center">
            <div class="container">
                <div class="alert alert-info" role="alert">
                    <div class="d-flex align-items-center">
                        <i class="fas fa-info-circle me-2"></i>
                        <div>
                            <strong>Parent Mata Anggaran:</strong>
                            <span class="badge bg-primary me-2">{{ $parent->kode_mata_anggaran }}</span>
                            {{ $parent->nama_mata_anggaran }}
                            <br>
                            <small class="text-muted">
                                Tahun Anggaran: {{ $parent->tahun_anggaran }} |
                                Kategori: {{ $parent->kategori ?? 'Belum ditentukan' }}
                                @if($parent->alokasi_anggaran > 0)
                                    | Alokasi: Rp {{ number_format($parent->alokasi_anggaran, 0, ',', '.') }}
                                @endif
                            </small>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        @include('keuangan.master.partials.create-form')
    </div>
@endsection
