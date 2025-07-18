{{-- F:\rapor-dosen\resources\views\keuangan\master\partials\filter-form.blade.php --}}
@if(isset($filterConfig))
    <div class="row justify-content-md-center">
        <div class="container">
            <div class="card">
                <div class="card-header" style="background-color: #fff; margin-top:10px">
                    <h5 class="card-title">Filter & Pencarian</h5>
                </div>
                <div class="card-body">
                    <form method="GET" action="{{ $filterConfig['action_route'] }}" id="filterForm">
                        <div class="row align-items-end">
                            {{-- Search Input --}}
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="search" class="form-label">Pencarian</label>
                                    <input type="text"
                                           class="form-control"
                                           id="search"
                                           name="search"
                                           value="{{ request('search') }}"
                                           placeholder="{{ $filterConfig['search_placeholder'] ?? 'Cari...' }}"
                                           autocomplete="off">
                                </div>
                            </div>

                            {{-- Dynamic Filters --}}
                            @if(isset($filterConfig['filters']) && count($filterConfig['filters']) > 0)
                                @foreach($filterConfig['filters'] as $filter)
                                    <div class="col-md-{{ $filter['col_size'] ?? '3' }}">
                                        <div class="form-group">
                                            <label for="{{ $filter['name'] }}" class="form-label">{{ $filter['label'] }}</label>
                                            @if($filter['type'] === 'select')
                                                <select class="form-control"
                                                        id="{{ $filter['name'] }}"
                                                        name="{{ $filter['name'] }}"
                                                        onchange="this.form.submit()">
                                                    <option value="">{{ $filter['placeholder'] ?? 'Semua' }}</option>
                                                    @foreach($filter['options'] as $value => $label)
                                                        <option value="{{ $value }}"
                                                            {{ request($filter['name']) == $value ? 'selected' : '' }}>
                                                            {{ $label }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            @endif
                                        </div>
                                    </div>
                                @endforeach
                            @endif

                            {{-- Action Buttons --}}
                            <div class="col-md-3">
                                <div class="form-group">
                                    <button type="submit" class="btn btn-primary me-2">
                                        <i class="fas fa-search"></i> Cari
                                    </button>
                                    @if(request()->hasAny(['search', 'kategori', 'status']))
                                        <a href="{{ $filterConfig['action_route'] }}" class="btn btn-outline-secondary">
                                            <i class="fas fa-times"></i> Reset
                                        </a>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endif
