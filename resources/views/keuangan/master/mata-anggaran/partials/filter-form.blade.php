{{-- F:\rapor-dosen\resources\views\keuangan\master\partials\filter-form.blade.php --}}
@if(isset($filterConfig))
    <div class="card shadow-sm mb-4">
        <div class="card-body">
            <form method="GET" action="{{ $filterConfig['action_route'] }}" class="row g-3">
                {{-- Search Field --}}
                <div class="col-md-{{ isset($filterConfig['filters']) && count($filterConfig['filters']) > 0 ? '6' : '9' }}">
                    <label for="search" class="form-label">Pencarian</label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="fas fa-search"></i></span>
                        <input type="text" class="form-control" id="search" name="search"
                               value="{{ request('search') }}"
                               placeholder="{{ $filterConfig['search_placeholder'] ?? 'Cari data...' }}">
                    </div>
                </div>

                {{-- Dynamic Filter Fields --}}
                @if(isset($filterConfig['filters']))
                    @foreach($filterConfig['filters'] as $filter)
                        <div class="col-md-3">
                            <label for="{{ $filter['name'] }}" class="form-label">{{ $filter['label'] }}</label>
                            @if($filter['type'] === 'select')
                                <select class="form-select" id="{{ $filter['name'] }}" name="{{ $filter['name'] }}">
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
                    @endforeach
                @endif

                {{-- Action Buttons --}}
                <div class="col-md-3 d-flex align-items-end">
                    <div class="btn-group w-100">
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-search me-1"></i> Cari
                        </button>
                        <a href="{{ $filterConfig['action_route'] }}" class="btn btn-outline-secondary">
                            <i class="fas fa-times me-1"></i> Reset
                        </a>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endif
