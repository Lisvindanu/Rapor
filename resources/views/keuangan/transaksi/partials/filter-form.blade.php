{{-- resources/views/keuangan/transaksi/partials/filter-form.blade.php --}}
@php
    $defaultFilterConfig = [
        'title' => 'Filter & Pencarian',
        'action_route' => request()->url(),
        'search_placeholder' => 'Cari data...',
        'filters' => []
    ];

    $filterConfig = array_merge($defaultFilterConfig, $filterConfig ?? []);
@endphp

<div class="card filter-card">
    <div class="card-body">
        <form method="GET" action="{{ $filterConfig['action_route'] }}" class="mb-0">
            <div class="row align-items-end">
                {{-- Search Input --}}
                <div class="col-lg-4 col-md-6 mb-3">
                    <label for="search" class="form-label text-white">
                        <i class="fas fa-search me-1"></i>Pencarian
                    </label>
                    <input type="text"
                           class="form-control"
                           id="search"
                           name="search"
                           value="{{ request('search') }}"
                           placeholder="{{ $filterConfig['search_placeholder'] }}">
                </div>

                {{-- Dynamic Filters --}}
                @foreach($filterConfig['filters'] as $filter)
                    <div class="col-lg-2 col-md-4 col-sm-6 mb-3">
                        <label for="{{ $filter['name'] }}" class="form-label text-white">
                            {{ $filter['label'] }}
                        </label>

                        @if($filter['type'] === 'select')
                            <select class="form-control" id="{{ $filter['name'] }}" name="{{ $filter['name'] }}">
                                <option value="">Semua</option>
                                @foreach($filter['options'] as $value => $label)
                                    <option value="{{ $value }}"
                                        {{ $filter['value'] == $value ? 'selected' : '' }}>
                                        {{ $label }}
                                    </option>
                                @endforeach
                            </select>

                        @elseif($filter['type'] === 'date')
                            <input type="date"
                                   class="form-control"
                                   id="{{ $filter['name'] }}"
                                   name="{{ $filter['name'] }}"
                                   value="{{ $filter['value'] }}">

                        @else
                            <input type="text"
                                   class="form-control"
                                   id="{{ $filter['name'] }}"
                                   name="{{ $filter['name'] }}"
                                   value="{{ $filter['value'] }}"
                                   placeholder="{{ $filter['placeholder'] ?? '' }}">
                        @endif
                    </div>
                @endforeach

                {{-- Action Buttons --}}
                <div class="col-lg-2 col-md-6 mb-3">
                    <div class="d-flex gap-2">
                        <button type="submit" class="btn btn-light btn-sm flex-fill">
                            <i class="fas fa-filter me-1"></i>Filter
                        </button>

                        <a href="{{ $filterConfig['action_route'] }}" class="btn btn-outline-light btn-sm">
                            <i class="fas fa-undo me-1"></i>Reset
                        </a>
                    </div>
                </div>
            </div>

            {{-- Active Filters Display --}}
            @if(request()->hasAny(['search'] + collect($filterConfig['filters'])->pluck('name')->toArray()))
                <div class="row mt-2">
                    <div class="col-12">
                        <div class="d-flex flex-wrap gap-2 align-items-center">
                            <small class="text-white-75 me-2">Filter aktif:</small>

                            @if(request('search'))
                                <span class="badge badge-light">
                                    Pencarian: "{{ request('search') }}"
                                    <a href="{{ request()->fullUrlWithQuery(['search' => null]) }}"
                                       class="text-dark ms-1">
                                        <i class="fas fa-times"></i>
                                    </a>
                                </span>
                            @endif

                            @foreach($filterConfig['filters'] as $filter)
                                @if(request($filter['name']))
                                    <span class="badge badge-light">
                                        {{ $filter['label'] }}:
                                        @if($filter['type'] === 'select' && isset($filter['options'][request($filter['name'])]))
                                            "{{ $filter['options'][request($filter['name'])] }}"
                                        @else
                                            "{{ request($filter['name']) }}"
                                        @endif
                                        <a href="{{ request()->fullUrlWithQuery([$filter['name'] => null]) }}"
                                           class="text-dark ms-1">
                                            <i class="fas fa-times"></i>
                                        </a>
                                    </span>
                                @endif
                            @endforeach
                        </div>
                    </div>
                </div>
            @endif
        </form>
    </div>
</div>
