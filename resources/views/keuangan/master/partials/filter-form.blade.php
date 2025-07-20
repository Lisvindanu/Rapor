{{-- F:\rapor-dosen\resources\views\keuangan\master\partials\filter-form.blade.php --}}
@if(isset($filterConfig))
    <div class="row justify-content-md-center mb-4">
        <div class="container">
            <div class="card">
                <div class="card-header" style="background-color: #fff; margin-top:10px">
                    <h5 class="card-title">{{ $filterConfig['title'] ?? 'Filter & Pencarian' }}</h5>
                </div>
                <div class="card-body">
                    <form method="GET" action="{{ $filterConfig['action_route'] }}" id="filterForm">
                        <div class="row align-items-end">

                            {{-- Search Input - Konsisten dengan mata anggaran --}}
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

                            {{-- Dynamic Filters - Menyesuaikan dengan mata anggaran --}}
                            @if(isset($filterConfig['filters']) && count($filterConfig['filters']) > 0)
                                @foreach($filterConfig['filters'] as $filter)
                                    <div class="col-md-{{ $filter['col_size'] ?? '3' }}">
                                        <div class="form-group">
                                            <label for="{{ $filter['name'] }}" class="form-label">{{ $filter['label'] }}</label>

                                            @if($filter['type'] === 'text')
                                                <input type="text"
                                                       class="form-control"
                                                       id="{{ $filter['name'] }}"
                                                       name="{{ $filter['name'] }}"
                                                       value="{{ $filter['value'] ?? request($filter['name']) }}"
                                                       placeholder="{{ $filter['placeholder'] ?? '' }}">

                                            @elseif($filter['type'] === 'select')
                                                <select class="form-control" id="{{ $filter['name'] }}" name="{{ $filter['name'] }}">
                                                    @foreach($filter['options'] ?? [] as $value => $label)
                                                        <option value="{{ $value }}"
                                                            {{ (($filter['value'] ?? request($filter['name'])) == $value) ? 'selected' : '' }}>
                                                            {{ $label }}
                                                        </option>
                                                    @endforeach
                                                </select>

                                            @elseif($filter['type'] === 'date')
                                                <input type="date"
                                                       class="form-control"
                                                       id="{{ $filter['name'] }}"
                                                       name="{{ $filter['name'] }}"
                                                       value="{{ $filter['value'] ?? request($filter['name']) }}">
                                            @endif
                                        </div>
                                    </div>
                                @endforeach
                            @endif

                            {{-- Action Buttons - Konsisten dengan mata anggaran --}}
                            <div class="col-md-3">
                                <div class="form-group">
                                    <button type="submit" class="btn btn-primary me-2">
                                        <i class="fas fa-search"></i> Cari
                                    </button>
                                    @if(request()->hasAny(['search', 'kategori', 'status', 'tahun']))
                                        <a href="{{ $filterConfig['action_route'] }}" class="btn btn-outline-secondary">
                                            <i class="fas fa-times"></i> Reset
                                        </a>
                                    @endif
                                </div>
                            </div>
                        </div>

                        {{-- Active Filters Display --}}
                        @if(request()->hasAny(['search', 'tahun', 'status', 'kategori']) && (request('search') || request('tahun') || request('status') || request('kategori')))
                            <div class="row mt-3">
                                <div class="col-12">
                                    <div class="d-flex align-items-center gap-2 flex-wrap">
                                        <small class="text-muted">Filter aktif:</small>

                                        @if(request('search'))
                                            <span class="badge bg-primary">
                                                Pencarian: "{{ request('search') }}"
                                                <a href="{{ request()->fullUrlWithQuery(['search' => null]) }}" class="text-white ms-1">
                                                    <i class="fas fa-times"></i>
                                                </a>
                                            </span>
                                        @endif

                                        @if(request('tahun'))
                                            <span class="badge bg-info">
                                                Tahun: "{{ request('tahun') }}"
                                                <a href="{{ request()->fullUrlWithQuery(['tahun' => null]) }}" class="text-white ms-1">
                                                    <i class="fas fa-times"></i>
                                                </a>
                                            </span>
                                        @endif

                                        @if(request('status'))
                                            <span class="badge bg-secondary">
                                                Status: "{{ ucfirst(str_replace('_', ' ', request('status'))) }}"
                                                <a href="{{ request()->fullUrlWithQuery(['status' => null]) }}" class="text-white ms-1">
                                                    <i class="fas fa-times"></i>
                                                </a>
                                            </span>
                                        @endif

                                        @if(request('kategori'))
                                            <span class="badge bg-warning">
                                                Kategori: "{{ ucfirst(request('kategori')) }}"
                                                <a href="{{ request()->fullUrlWithQuery(['kategori' => null]) }}" class="text-white ms-1">
                                                    <i class="fas fa-times"></i>
                                                </a>
                                            </span>
                                        @endif

                                        <a href="{{ $filterConfig['reset_route'] ?? $filterConfig['action_route'] }}" class="badge bg-danger text-decoration-none">
                                            <i class="fas fa-times-circle me-1"></i>Hapus Semua
                                        </a>
                                    </div>
                                </div>
                            </div>
                        @endif
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Enter key support for search input
        document.getElementById('search')?.addEventListener('keypress', function(e) {
            if (e.key === 'Enter') {
                document.getElementById('filterForm').submit();
            }
        });

        console.log('✅ Filter form updated - Consistent with mata anggaran layout');
    </script>
@endif
