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

    $alertClass = match($alertConfig['type']) {
        'success' => 'alert-success',
        'warning' => 'alert-warning',
        'danger' => 'alert-danger',
        'info' => 'alert-info',
        default => 'alert-info'
    };

    $statusClass = match($alertConfig['status']) {
        'Ready' => 'success',
        'Development' => 'warning',
        'Testing' => 'info',
        'Maintenance' => 'danger',
        default => 'secondary'
    };
@endphp

<div class="alert {{ $alertClass }} development-alert" role="alert">
    <div class="row align-items-center">
        <div class="col-lg-8">
            <div class="d-flex align-items-center">
                <div class="me-3">
                    @if($alertConfig['type'] === 'success')
                        <i class="fas fa-check-circle fa-2x text-white"></i>
                    @elseif($alertConfig['type'] === 'warning')
                        <i class="fas fa-exclamation-triangle fa-2x text-white"></i>
                    @elseif($alertConfig['type'] === 'danger')
                        <i class="fas fa-times-circle fa-2x text-white"></i>
                    @else
                        <i class="fas fa-info-circle fa-2x text-white"></i>
                    @endif
                </div>
                <div>
                    <h6 class="alert-heading mb-1 text-white">
                        <strong>{{ $alertConfig['module'] }}</strong>
                        <span class="badge badge-{{ $statusClass }} ms-2">{{ $alertConfig['status'] }}</span>
                        <small class="badge badge-light ms-1">{{ $alertConfig['version'] }}</small>
                    </h6>

                    @if(!empty($alertConfig['features']))
                        <div class="mb-2">
                            <small class="text-white-75">Features:</small>
                            @foreach($alertConfig['features'] as $feature)
                                <span class="badge badge-light me-1">{{ $feature }}</span>
                            @endforeach
                        </div>
                    @endif

                    @if($alertConfig['note'])
                        <p class="mb-0 text-white-75">
                            <i class="fas fa-sticky-note me-1"></i>{{ $alertConfig['note'] }}
                        </p>
                    @endif
                </div>
            </div>
        </div>

        <div class="col-lg-4 text-lg-end text-start mt-3 mt-lg-0">
            <div class="d-flex align-items-center justify-content-lg-end justify-content-start">
                @if($alertConfig['database'])
                    <div class="me-3">
                        <i class="fas fa-database text-white me-1"></i>
                        <small class="text-white-75">Database Ready</small>
                    </div>
                @endif

                <div>
                    <i class="fas fa-code text-white me-1"></i>
                    <small class="text-white-75">Clean Architecture</small>
                </div>
            </div>
        </div>
    </div>
</div>
