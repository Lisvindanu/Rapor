{{-- F:\rapor-dosen\resources\views\keuangan\master\partials\filter-form.blade.php --}}
@if(isset($filterConfig))
    <div class="filter-konten">
        <div class="row justify-content-md-center">
            <div class="container">
                <form method="GET" action="{{ $filterConfig['action_route'] }}" id="masterFilterForm">
                    <div class="card">
                        <div class="card-header" style="background-color: #fff; margin-top:10px">
                            <h5 class="card-title">Filter & Pencarian</h5>
                        </div>
                        <div class="card-body">
                            {{-- Improved Layout with Better Alignment --}}
                            <div class="row align-items-end">
                                {{-- Search Field --}}
                                <div class="col-md-{{ isset($filterConfig['filters']) && count($filterConfig['filters']) > 0 ? '6' : '9' }}">
                                    <div class="form-group mb-3">
                                        <label for="search" class="form-label">Pencarian</label>
                                        <div class="input-group">
                                            <span class="input-group-text"><i class="fas fa-search"></i></span>
                                            <input type="text" class="form-control" id="search" name="search"
                                                   value="{{ request('search') }}"
                                                   placeholder="{{ $filterConfig['search_placeholder'] ?? 'Cari data...' }}">
                                        </div>
                                    </div>
                                </div>

                                {{-- Dynamic Filter Fields --}}
                                @if(isset($filterConfig['filters']))
                                    @foreach($filterConfig['filters'] as $filter)
                                        <div class="col-md-3">
                                            <div class="form-group mb-3">
                                                <label for="{{ $filter['name'] }}" class="form-label">{{ $filter['label'] }}</label>
                                                @if($filter['type'] === 'select')
                                                    <select class="form-control" id="{{ $filter['name'] }}" name="{{ $filter['name'] }}">
                                                        <option value="">{{ $filter['placeholder'] ?? 'Semua' }}</option>
                                                        @foreach($filter['options'] as $value => $label)
                                                            <option value="{{ $value }}" {{ request($filter['name']) == $value ? 'selected' : '' }}>
                                                                {{ $label }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                @elseif($filter['type'] === 'text')
                                                    <input type="text" class="form-control" id="{{ $filter['name'] }}" name="{{ $filter['name'] }}"
                                                           value="{{ request($filter['name']) }}"
                                                           placeholder="{{ $filter['placeholder'] ?? '' }}">
                                                @endif
                                            </div>
                                        </div>
                                    @endforeach
                                @endif

                                {{-- Action Buttons --}}
                                <div class="col-md-3">
                                    <div class="form-group mb-3">
                                        <div class="btn-group-master d-flex gap-2">
                                            <button type="submit" class="btn btn-primary flex-fill">
                                                <i class="fas fa-search"></i> Cari
                                            </button>
                                            <a href="{{ $filterConfig['action_route'] }}" class="btn btn-secondary flex-fill">
                                                <i class="fas fa-undo"></i> Reset
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endif

{{-- Additional CSS for better alignment --}}
<style>
    .filter-konten .form-group {
        height: 100%;
    }

    .filter-konten .form-label {
        font-weight: 600;
        color: #495057;
        margin-bottom: 0.5rem;
        white-space: nowrap;
    }

    .filter-konten .form-control,
    .filter-konten .input-group {
        height: 38px; /* Consistent height */
    }

    .filter-konten .btn {
        height: 38px; /* Match input height */
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .filter-konten .btn-group-master {
        height: 38px; /* Match other elements */
    }

    .filter-konten .input-group-text {
        background-color: #f8f9fa;
        border-color: #ced4da;
        color: #6c757d;
        height: 38px;
        display: flex;
        align-items: center;
    }

    /* Ensure all form elements have same baseline */
    .filter-konten .row.align-items-end .col-md-3,
    .filter-konten .row.align-items-end .col-md-6,
    .filter-konten .row.align-items-end .col-md-9 {
        display: flex;
        flex-direction: column;
    }

    .filter-konten .form-group {
        display: flex;
        flex-direction: column;
        justify-content: flex-end;
        height: 100%;
    }

    /* Responsive adjustments */
    @media (max-width: 768px) {
        .filter-konten .row {
            flex-direction: column;
        }

        .filter-konten .col-md-3,
        .filter-konten .col-md-6,
        .filter-konten .col-md-9 {
            width: 100%;
            margin-bottom: 15px;
        }

        .filter-konten .btn-group-master {
            flex-direction: column;
            gap: 10px !important;
        }

        .filter-konten .btn-group-master .btn {
            width: 100%;
        }
    }

    @media (max-width: 576px) {
        .filter-konten .form-control,
        .filter-konten .btn {
            font-size: 0.9rem;
            height: 36px;
        }

        .filter-konten .input-group-text {
            height: 36px;
        }
    }
</style>
