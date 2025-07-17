{{-- F:\rapor-dosen\resources\views\keuangan\master\partials\development-alert.blade.php --}}
@php
    $alertConfig = $alertConfig ?? [
        'type' => 'info',
        'module' => 'Master Data',
        'status' => 'Ready',
        'version' => 'v1.0.0',
        'features' => ['CRUD lengkap', 'Search & Filter', 'Pagination']
    ];
@endphp

<div class="alert alert-{{ $alertConfig['type'] }} alert-dismissible fade show" role="alert">
    <div class="d-flex align-items-center">
        <i class="fas fa-{{ $alertConfig['type'] === 'info' ? 'info-circle' : ($alertConfig['type'] === 'warning' ? 'exclamation-triangle' : 'check-circle') }} me-2"></i>
        <div class="flex-grow-1">
            <strong>Status Pengembangan:</strong>
            Modul {{ $alertConfig['module'] }} sudah dapat digunakan dengan {{ implode(', ', $alertConfig['features']) }}.
            <small class="d-block mt-1">
                Versi: {{ $alertConfig['version'] }} |
                Pattern: Clean Architecture |
                Status: {{ $alertConfig['status'] }}
                @if(isset($alertConfig['database']) && $alertConfig['database'])
                    | Database: Connected
                @endif
            </small>
            @if(isset($alertConfig['note']))
                <small class="d-block mt-1 text-muted">
                    <i class="fas fa-lightbulb me-1"></i>{{ $alertConfig['note'] }}
                </small>
            @endif
        </div>
    </div>
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
</div>
