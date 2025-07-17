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
                            {{-- Horizontal Layout - All in one row --}}
                            <div class="row">
                                {{-- Search Field --}}
                                <div class="col-md-{{ isset($filterConfig['filters']) && count($filterConfig['filters']) > 0 ? '6' : '9' }}">
                                    <div class="form-group">
                                        <label for="search">Pencarian</label>
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
                                            <div class="form-group">
                                                <label for="{{ $filter['name'] }}">{{ $filter['label'] }}</label>
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
                                <div class="col-md-3 d-flex align-items-end">
                                    <div class="btn-group-master">
                                        <button type="submit" class="btn btn-primary">
                                            <i class="fas fa-search"></i> Cari
                                        </button>
                                        <a href="{{ $filterConfig['action_route'] }}" class="btn btn-secondary">
                                            <i class="fas fa-undo"></i> Reset
                                        </a>
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
