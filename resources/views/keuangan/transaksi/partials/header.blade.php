{{-- resources/views/keuangan/transaksi/partials/header.blade.php --}}
@php
    $defaultHeaderConfig = [
        'title' => 'Transaksi Keuangan',
        'description' => 'Kelola transaksi keuangan fakultas',
        'breadcrumbs' => []
    ];

    $headerConfig = array_merge($defaultHeaderConfig, $headerConfig ?? []);
@endphp

<div class="row justify-content-md-center">
    <div class="container">
        <div class="judul-modul">
            <span>
                <h3>{{ $headerConfig['title'] }}</h3>
                <p>{{ $headerConfig['description'] }}</p>
            </span>
        </div>
    </div>
</div>
