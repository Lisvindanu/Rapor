@if(isset($paginationData) && method_exists($paginationData, 'total') && $paginationData->total() > 0)
    <div class="pagination-wrapper mt-4">
        <div class="row align-items-center">
            {{-- Data Info --}}
            <div class="col-sm-6">
                <span class="text-muted small">
                    Menampilkan {{ $paginationData->firstItem() }} sampai {{ $paginationData->lastItem() }}
                    dari {{ $paginationData->total() }} data
                </span>
            </div>

            {{-- Pagination Controls --}}
            <div class="col-sm-6">
                <div class="d-flex justify-content-end">
                    @if($paginationData->hasPages())
                        <nav>
                            <ul class="pagination pagination-sm mb-0">
                                {{-- Previous --}}
                                @if ($paginationData->onFirstPage())
                                    <li class="page-item disabled"><span class="page-link"><i class="fas fa-chevron-left"></i></span></li>
                                @else
                                    <li class="page-item"><a class="page-link" href="{{ $paginationData->previousPageUrl() }}"><i class="fas fa-chevron-left"></i></a></li>
                                @endif

                                {{-- Page Numbers --}}
                                @php
                                    $current = $paginationData->currentPage();
                                    $last = $paginationData->lastPage();
                                    $start = max(1, $current - 2);
                                    $end = min($last, $current + 2);
                                @endphp

                                @for($i = $start; $i <= $end; $i++)
                                    <li class="page-item {{ $current == $i ? 'active' : '' }}">
                                        @if($current == $i)
                                            <span class="page-link">{{ $i }}</span>
                                        @else
                                            <a class="page-link" href="{{ $paginationData->url($i) }}">{{ $i }}</a>
                                        @endif
                                    </li>
                                @endfor

                                {{-- Next --}}
                                @if ($paginationData->hasMorePages())
                                    <li class="page-item"><a class="page-link" href="{{ $paginationData->nextPageUrl() }}"><i class="fas fa-chevron-right"></i></a></li>
                                @else
                                    <li class="page-item disabled"><span class="page-link"><i class="fas fa-chevron-right"></i></span></li>
                                @endif
                            </ul>
                        </nav>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <style>
        .pagination-wrapper {
            background: #f8f9fa;
            padding: 1rem;
            border-radius: 0.5rem;
            border: 1px solid #dee2e6;
        }
        .pagination .page-link {
            color: #495057;
            border: 1px solid #dee2e6;
            border-radius: 0.375rem;
            margin: 0 0.125rem;
            transition: all 0.2s;
        }
        .pagination .page-link:hover {
            background-color: #e7f1ff;
            border-color: #0d6efd;
        }
        .pagination .page-item.active .page-link {
            background-color: #0d6efd;
            border-color: #0d6efd;
        }
        @media (max-width: 576px) {
            .pagination-wrapper { padding: 0.75rem; }
            .pagination .page-link { padding: 0.25rem 0.5rem; font-size: 0.8rem; }
        }
    </style>
@endif
