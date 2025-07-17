@if(isset($paginationData) && method_exists($paginationData, 'total') && $paginationData->total() > 0)
    <div class="pagination-wrapper mt-4">
        <div class="row align-items-center">
            {{-- Data Info - Always show --}}
            <div class="col-sm-6">
                <span class="text-muted small">
                    Menampilkan {{ $paginationData->firstItem() }} sampai {{ $paginationData->lastItem() }}
                    dari {{ $paginationData->total() }} data
                </span>
            </div>

            {{-- Pagination Controls - Only show if multiple pages --}}
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

                                    if ($current <= 3) $end = min($last, 5);
                                    if ($current >= $last - 2) $start = max(1, $last - 4);
                                @endphp

                                {{-- First page + ellipsis --}}
                                @if($start > 1)
                                    <li class="page-item {{ $current == 1 ? 'active' : '' }}">
                                        @if($current == 1)
                                            <span class="page-link">1</span>
                                        @else
                                            <a class="page-link" href="{{ $paginationData->url(1) }}">1</a>
                                        @endif
                                    </li>
                                    @if($start > 2)<li class="page-item disabled"><span class="page-link">...</span></li>@endif
                                @endif

                                {{-- Page range --}}
                                @for($i = $start; $i <= $end; $i++)
                                    <li class="page-item {{ $current == $i ? 'active' : '' }}">
                                        @if($current == $i)
                                            <span class="page-link">{{ $i }}</span>
                                        @else
                                            <a class="page-link" href="{{ $paginationData->url($i) }}">{{ $i }}</a>
                                        @endif
                                    </li>
                                @endfor

                                {{-- Last page + ellipsis --}}
                                @if($end < $last)
                                    @if($end < $last - 1)<li class="page-item disabled"><span class="page-link">...</span></li>@endif
                                    <li class="page-item {{ $current == $last ? 'active' : '' }}">
                                        @if($current == $last)
                                            <span class="page-link">{{ $last }}</span>
                                        @else
                                            <a class="page-link" href="{{ $paginationData->url($last) }}">{{ $last }}</a>
                                        @endif
                                    </li>
                                @endif

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

        {{-- Per Page Selector - ALWAYS show for better UX --}}
        @if(isset($showPerPageSelector) && $showPerPageSelector)
            <div class="row mt-3">
                <div class="col-sm-6">
                    <form method="GET" class="d-flex align-items-center">
                        @foreach(request()->query() as $key => $value)
                            @if($key !== 'per_page')<input type="hidden" name="{{ $key }}" value="{{ $value }}">@endif
                        @endforeach
                        <label class="form-label me-2 mb-0 small text-muted">Per halaman:</label>
                        <select name="per_page" class="form-select form-select-sm" style="width:auto" onchange="this.form.submit()">
                            @foreach([10, 25, 50, 100] as $size)
                                <option value="{{ $size }}" {{ request('per_page', 15) == $size ? 'selected' : '' }}>{{ $size }}</option>
                            @endforeach
                        </select>
                    </form>
                </div>

                {{-- Quick Jump - Only show if more than 10 pages --}}
                @if($paginationData->lastPage() > 10)
                    <div class="col-sm-6">
                        <form method="GET" class="d-flex align-items-center justify-content-end">
                            @foreach(request()->query() as $key => $value)
                                @if($key !== 'page')<input type="hidden" name="{{ $key }}" value="{{ $value }}">@endif
                            @endforeach
                            <label class="form-label me-2 mb-0 small text-muted">Ke halaman:</label>
                            <input type="number" name="page" class="form-control form-control-sm me-2" style="width:70px"
                                   min="1" max="{{ $paginationData->lastPage() }}" placeholder="{{ $paginationData->currentPage() }}">
                            <button type="submit" class="btn btn-sm btn-outline-primary"><i class="fas fa-arrow-right"></i></button>
                        </form>
                    </div>
                @else
                    {{-- Show info when single page but still allow per page changes --}}
                    @if(!$paginationData->hasPages())
                        <div class="col-sm-6">
                            <div class="d-flex justify-content-end align-items-center">
                                <span class="text-muted small">
                                    <i class="fas fa-info-circle me-1"></i>
                                    Semua data ditampilkan dalam 1 halaman
                                </span>
                            </div>
                        </div>
                    @endif
                @endif
            </div>
        @endif
    </div>

    {{-- Compact CSS --}}
    <style>
        .pagination-wrapper{background:linear-gradient(135deg,#f8f9fa 0%,#e9ecef 100%);padding:1.25rem;border-radius:.5rem;border:1px solid #dee2e6;box-shadow:0 2px 4px rgba(0,0,0,.05)}
        .pagination{gap:.25rem}
        .pagination .page-link{color:#495057;border:1px solid #dee2e6;border-radius:.375rem!important;padding:.5rem .875rem;font-weight:500;transition:all .2s ease-in-out;background-color:#fff;margin:0}
        .pagination .page-link:hover{color:#0d6efd;background-color:#e7f1ff;border-color:#b6d7ff;transform:translateY(-1px);box-shadow:0 2px 4px rgba(13,110,253,.15)}
        .pagination .page-item.active .page-link{background:linear-gradient(135deg,#0d6efd 0%,#0056b3 100%);border-color:#0d6efd;color:#fff;box-shadow:0 2px 4px rgba(13,110,253,.3);transform:translateY(-1px)}
        .pagination .page-item.disabled .page-link{color:#adb5bd;background-color:#f8f9fa;border-color:#dee2e6;cursor:not-allowed}
        .pagination-sm .page-link{padding:.375rem .75rem;font-size:.875rem}
        @media (max-width:576px){.pagination-wrapper{padding:1rem}.pagination-wrapper .row{flex-direction:column;gap:1rem}.d-flex.justify-content-end{justify-content:center!important}.pagination-sm .page-link{padding:.25rem .5rem;font-size:.8rem}.form-label{font-size:.8rem}}
    </style>

    {{-- Compact JavaScript --}}
    <script>
        document.addEventListener('DOMContentLoaded',function(){
            // Loading states for pagination
            document.querySelectorAll('.pagination .page-link').forEach(link=>{
                link.addEventListener('click',function(){
                    if(!this.closest('.page-item').classList.contains('disabled')&&!this.closest('.page-item').classList.contains('active')){
                        this.innerHTML='<i class="fas fa-spinner fa-spin"></i>';this.style.pointerEvents='none'
                    }
                })
            });

            // Per page selector loading
            const perPage=document.querySelector('select[name="per_page"]');
            if(perPage){perPage.addEventListener('change',function(){this.style.opacity='0.6';this.disabled=true})}

            // Quick jump validation
            const jumpInput=document.querySelector('input[name="page"]');
            if(jumpInput){
                jumpInput.addEventListener('input',function(){
                    const max=parseInt(this.max),value=parseInt(this.value);
                    if(value>max)this.value=max;if(value<1)this.value=1
                });
                jumpInput.addEventListener('focus',function(){this.select()})
            }
        });
    </script>
@endif
