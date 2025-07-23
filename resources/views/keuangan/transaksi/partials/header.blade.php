{{-- resources/views/keuangan/transaksi/partials/header.blade.php --}}
@php
    $defaultHeaderConfig = [
        'title' => 'Transaksi Keuangan',
        'description' => 'Kelola transaksi keuangan fakultas',
        'icon' => 'fas fa-exchange-alt',
        'breadcrumbs' => [],
        'back_route' => null,
        'back_text' => 'Kembali',
        'primary_action' => null
    ];

    $headerConfig = array_merge($defaultHeaderConfig, $headerConfig ?? []);
@endphp

<div class="transaksi-header">
    <div class="row align-items-center">
        <div class="col-lg-8">
            {{-- Breadcrumbs --}}
            @if(!empty($headerConfig['breadcrumbs']))
                <nav aria-label="breadcrumb" class="mb-2">
                    <ol class="breadcrumb bg-transparent p-0 mb-0">
                        @foreach($headerConfig['breadcrumbs'] as $breadcrumb)
                            @if(isset($breadcrumb['active']) && $breadcrumb['active'])
                                <li class="breadcrumb-item active text-white-50" aria-current="page">
                                    {{ $breadcrumb['text'] }}
                                </li>
                            @else
                                <li class="breadcrumb-item">
                                    <a href="{{ $breadcrumb['url'] }}" class="text-white">
                                        {{ $breadcrumb['text'] }}
                                    </a>
                                </li>
                            @endif
                        @endforeach
                    </ol>
                </nav>
            @endif

            {{-- Title and Description --}}
            <div class="d-flex align-items-center">
                @if(isset($headerConfig['icon']))
                    <i class="{{ $headerConfig['icon'] }} fa-2x me-3"></i>
                @endif
                <div>
                    <h1 class="h2 mb-1 font-weight-bold">{{ $headerConfig['title'] }}</h1>
                    @if(isset($headerConfig['description']))
                        <p class="mb-0 text-white-75">{{ $headerConfig['description'] }}</p>
                    @endif
                </div>
            </div>
        </div>

        <div class="col-lg-4 text-lg-end text-start mt-3 mt-lg-0">
            {{-- Back Button --}}
            @if($headerConfig['back_route'])
                <a href="{{ $headerConfig['back_route'] }}"
                   class="btn btn-outline-light me-2">
                    <i class="fas fa-arrow-left me-1"></i>
                    {{ $headerConfig['back_text'] }}
                </a>
            @endif

            {{-- Primary Action --}}
            @if($headerConfig['primary_action'])
                <a href="{{ $headerConfig['primary_action']['route'] }}"
                   class="btn {{ $headerConfig['primary_action']['class'] ?? 'btn-warning' }}">
                    @if(isset($headerConfig['primary_action']['icon']))
                        <i class="{{ $headerConfig['primary_action']['icon'] }} me-1"></i>
                    @endif
                    {{ $headerConfig['primary_action']['text'] }}
                </a>
            @endif
        </div>
    </div>
</div>
