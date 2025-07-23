{{-- resources/views/keuangan/transaksi/partials/development-alert.blade.php --}}
@php
    $defaultAlertConfig = [
        'type' => 'info',
        'module' => 'Transaksi Keuangan',
        'status' => 'Development',
        'version' => 'v1.0.0',
        'features' => [],
        'database' => false,
        'note' => ''
    ];

    $alertConfig = array_merge($defaultAlertConfig, $alertConfig ?? []);
@endphp

<div class="alert alert-{{ $alertConfig['type'] }} alert-dismissible fade show" role="alert">
    <div class="d-flex align-items-center">
        <i class="fas fa-info-circle me-2"></i>
        <div class="flex-grow-1">
            <strong>{{ $alertConfig['module'] }}:</strong>
            {{ $alertConfig['note'] ?: 'Modul dalam pengembangan untuk mengelola data transaksi keuangan.' }}
            <small class="d-block mt-1">
                Versi: {{ $alertConfig['version'] }} | Status: {{ $alertConfig['status'] }}
                @if($alertConfig['database'])
                    | Database: Ready
                @endif
            </small>
        </div>
    </div>
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
</div>
