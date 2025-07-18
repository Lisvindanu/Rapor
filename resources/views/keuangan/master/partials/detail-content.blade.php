{{-- F:\rapor-dosen\resources\views\keuangan\master\partials\detail-content.blade.php --}}
@if(isset($detailConfig))
    <div class="row justify-content-md-center">
        <div class="container">
            <div class="card">
                <div class="card-header" style="background-color: #fff; margin-top:10px">
                    <h5 class="card-title">{{ $detailConfig['title'] ?? 'Detail Data' }}</h5>
                </div>
                <div class="card-body">
                    @foreach($detailConfig['sections'] as $section)
                        <div class="section-detail mb-4">
                            @if(isset($section['title']))
                                <h6 class="section-title mb-3">
                                    <i class="fas fa-{{ $section['icon'] ?? 'info-circle' }} me-2"></i>
                                    {{ $section['title'] }}
                                </h6>
                            @endif

                            <div class="row">
                                @foreach($section['fields'] as $field)
                                    <div class="col-md-{{ $field['col_size'] ?? '6' }}">
                                        <div class="detail-item mb-3">
                                            <label class="detail-label">{{ $field['label'] }}</label>
                                            <div class="detail-value">
                                                @php
                                                    $value = data_get($detailConfig['data'], $field['field']);
                                                @endphp

                                                @if($field['type'] === 'badge')
                                                    @if($value)
                                                        <span class="badge bg-{{ $field['badge_class'] ?? 'primary' }}">
                                                            {{ $value }}
                                                        </span>
                                                    @else
                                                        <span class="text-muted">{{ $field['empty_text'] ?? '-' }}</span>
                                                    @endif

                                                @elseif($field['type'] === 'status')
                                                    @if($value)
                                                        <span class="badge bg-success">
                                                            <i class="fas fa-check-circle me-1"></i>Aktif
                                                        </span>
                                                    @else
                                                        <span class="badge bg-danger">
                                                            <i class="fas fa-times-circle me-1"></i>Tidak Aktif
                                                        </span>
                                                    @endif

                                                @elseif($field['type'] === 'currency')
                                                    @if($value && $value > 0)
                                                        <span class="text-success fw-bold">
                                                            Rp {{ number_format($value, 0, ',', '.') }}
                                                        </span>
                                                    @else
                                                        <span class="text-muted">Rp 0</span>
                                                    @endif

                                                @elseif($field['type'] === 'datetime')
                                                    @if($value)
                                                        <span class="text-muted">
                                                            {{ \Carbon\Carbon::parse($value)->format('d/m/Y H:i') }}
                                                        </span>
                                                    @else
                                                        <span class="text-muted">-</span>
                                                    @endif

                                                @elseif($field['type'] === 'longtext')
                                                    @if($value)
                                                        <div class="longtext-content p-3 bg-light rounded">
                                                            {!! nl2br(e($value)) !!}
                                                        </div>
                                                    @else
                                                        <span class="text-muted">{{ $field['empty_text'] ?? 'Tidak ada deskripsi' }}</span>
                                                    @endif

                                                @else
                                                    @if($value)
                                                        {{ $value }}
                                                    @else
                                                        <span class="text-muted">{{ $field['empty_text'] ?? '-' }}</span>
                                                    @endif
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                        @if(!$loop->last)
                            <hr class="section-divider">
                        @endif
                    @endforeach
                </div>
            </div>
        </div>
    </div>
@endif

<style>
    .section-detail {
        margin-bottom: 2rem;
    }

    .section-title {
        color: #495057;
        font-weight: 600;
        border-bottom: 2px solid #e9ecef;
        padding-bottom: 0.5rem;
        margin-bottom: 1rem;
    }

    .detail-item {
        margin-bottom: 1rem;
    }

    .detail-label {
        font-weight: 600;
        color: #6c757d;
        font-size: 0.875rem;
        margin-bottom: 0.25rem;
        display: block;
    }

    .detail-value {
        font-size: 0.95rem;
        color: #495057;
    }

    .longtext-content {
        font-size: 0.9rem;
        line-height: 1.6;
        border: 1px solid #dee2e6;
    }

    .section-divider {
        border-color: #dee2e6;
        margin: 2rem 0;
    }

    @media (max-width: 768px) {
        .detail-item {
            margin-bottom: 0.75rem;
        }

        .section-title {
            font-size: 1rem;
        }

        .detail-label {
            font-size: 0.8rem;
        }

        .detail-value {
            font-size: 0.85rem;
        }
    }
</style>
