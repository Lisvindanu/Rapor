{{-- resources/views/keuangan/transaksi/partials/data-table.blade.php --}}
@php
    $defaultTableConfig = [
        'title' => 'Data Transaksi',
        'data' => collect(),
        'create_route' => '#',
        'create_button_text' => 'Tambah Data',
        'create_button_class' => '', // NEW: for modal trigger
        'empty_message' => 'Belum ada data.',
        'delete_name_field' => 'id',
        'columns' => [],
        'actions' => [],
        'custom_actions' => []
    ];

    $tableConfig = array_merge($defaultTableConfig, $tableConfig ?? []);
@endphp

<div class="card transaksi-card">
    <div class="card-header bg-white py-3">
        <div class="row align-items-center">
            <div class="col">
                <h6 class="m-0 font-weight-bold text-primary">
                    <i class="fas fa-table me-2"></i>{{ $tableConfig['title'] }}
                </h6>
            </div>
            <div class="col-auto">
                @if($tableConfig['create_button_class'])
                    <button type="button" class="btn btn-primary btn-sm {{ $tableConfig['create_button_class'] }}">
                        <i class="fas fa-plus me-1"></i>{{ $tableConfig['create_button_text'] }}
                    </button>
                @else
                    <a href="{{ $tableConfig['create_route'] }}" class="btn btn-primary btn-sm">
                        <i class="fas fa-plus me-1"></i>{{ $tableConfig['create_button_text'] }}
                    </a>
                @endif
            </div>
        </div>
    </div>

    <div class="card-body p-0">
        @if($tableConfig['data']->count() > 0)
            <div class="table-responsive">
                <table class="table table-hover mb-0">
                    <thead>
                    <tr>
                        @foreach($tableConfig['columns'] as $column)
                            <th style="width: {{ $column['width'] ?? 'auto' }}"
                                class="{{ isset($column['type']) && $column['type'] === 'currency' ? 'text-end' : '' }}">
                                {{ $column['label'] }}
                            </th>
                        @endforeach
                        <th style="width: 15%" class="text-center">Aksi</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($tableConfig['data'] as $index => $item)
                        <tr>
                            @foreach($tableConfig['columns'] as $column)
                                <td>
                                    @if($column['type'] === 'number')
                                        {{ $tableConfig['data']->perPage() * ($tableConfig['data']->currentPage() - 1) + $index + 1 }}

                                    @elseif($column['type'] === 'badge')
                                        <span class="badge badge-{{ $column['badge_class'] ?? 'primary' }}">
                                                {{ data_get($item, $column['field']) }}
                                            </span>

                                    @elseif($column['type'] === 'date')
                                        {{ data_get($item, $column['field']) ?
                                           \Carbon\Carbon::parse(data_get($item, $column['field']))->format($column['format'] ?? 'd/m/Y') : '-' }}

                                    @elseif($column['type'] === 'currency')
                                        <span class="text-end d-block font-weight-bold">
                                            Rp {{ number_format(data_get($item, $column['field'], 0), 0, ',', '.') }}
                                        </span>

                                    @elseif($column['type'] === 'status_badge')
                                        @php
                                            $status = data_get($item, $column['field']);
                                            $badgeClass = match($status) {
                                                'draft' => 'secondary',
                                                'pending' => 'warning',
                                                'approved' => 'success',
                                                'rejected' => 'danger',
                                                'paid' => 'info',
                                                default => 'secondary'
                                            };
                                            $statusLabel = match($status) {
                                                'draft' => 'Draft',
                                                'pending' => 'Pending',
                                                'approved' => 'Disetujui',
                                                'rejected' => 'Ditolak',
                                                'paid' => 'Dibayar',
                                                default => ucfirst($status)
                                            };
                                        @endphp
                                        <span class="badge badge-{{ $badgeClass }}">{{ $statusLabel }}</span>

                                    @elseif($column['type'] === 'relation_text')
                                        {{ data_get($item, $column['field']) ?? '-' }}

                                    @else
                                        @php
                                            $value = data_get($item, $column['field']);
                                            if (isset($column['truncate']) && strlen($value) > $column['truncate']) {
                                                $value = substr($value, 0, $column['truncate']) . '...';
                                            }
                                        @endphp
                                        <span title="{{ data_get($item, $column['field']) }}">{{ $value }}</span>
                                    @endif
                                </td>
                            @endforeach

                            {{-- Actions Column --}}
                            <td class="text-center">
                                <div class="d-flex justify-content-center gap-1">
                                    @if(isset($tableConfig['actions']['show']))
                                        <a href="{{ str_replace(':id', $item->id, $tableConfig['actions']['show']) }}"
                                           class="btn btn-info btn-sm"
                                           title="Lihat Detail">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                    @endif

                                    @if(isset($tableConfig['actions']['edit']) && $item->canBeEdited())
                                        @if(isset($tableConfig['actions']['edit_modal']) && $tableConfig['actions']['edit_modal'])
                                            <button type="button"
                                                    class="btn btn-warning btn-sm btn-edit-modal"
                                                    data-id="{{ $item->id }}"
                                                    title="Edit">
                                                <i class="fas fa-edit"></i>
                                            </button>
                                        @else
                                            <a href="{{ str_replace(':id', $item->id, $tableConfig['actions']['edit']) }}"
                                               class="btn btn-warning btn-sm"
                                               title="Edit">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                        @endif
                                    @endif

                                    @if(isset($tableConfig['actions']['print']))
                                        <a href="{{ str_replace(':id', $item->id, $tableConfig['actions']['print']) }}"
                                           class="btn btn-secondary btn-sm"
                                           title="Print"
                                           target="_blank">
                                            <i class="fas fa-print"></i>
                                        </a>
                                    @endif

                                    @if(isset($tableConfig['custom_actions']))
                                        @foreach($tableConfig['custom_actions'] as $action)
                                            <a href="{{ str_replace(':id', $item->id, $action['route']) }}"
                                               class="{{ $action['class'] ?? 'btn btn-primary btn-sm' }}"
                                               title="{{ $action['title'] ?? $action['text'] }}"
                                               @if(isset($action['target'])) target="{{ $action['target'] }}" @endif>
                                                @if(isset($action['icon']))
                                                    <i class="{{ $action['icon'] }}"></i>
                                                @else
                                                    {{ $action['text'] }}
                                                @endif
                                            </a>
                                        @endforeach
                                    @endif

                                    @if(isset($tableConfig['actions']['delete']) && $item->canBeDeleted())
                                        <button type="button"
                                                class="btn btn-danger btn-sm delete-btn"
                                                data-url="{{ str_replace(':id', $item->id, $tableConfig['actions']['delete']) }}"
                                                data-name="{{ data_get($item, $tableConfig['delete_name_field']) }}"
                                                title="Hapus">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>

            {{-- Pagination --}}
            @if(method_exists($tableConfig['data'], 'links'))
                <div class="card-footer bg-white border-top-0">
                    <div class="row align-items-center">
                        <div class="col">
                            <small class="text-muted">
                                Menampilkan {{ $tableConfig['data']->firstItem() ?? 0 }} -
                                {{ $tableConfig['data']->lastItem() ?? 0 }} dari
                                {{ $tableConfig['data']->total() }} data
                            </small>
                        </div>
                        <div class="col-auto">
                            {{ $tableConfig['data']->links() }}
                        </div>
                    </div>
                </div>
            @endif
        @else
            {{-- Empty State --}}
            <div class="empty-state">
                <i class="fas fa-inbox"></i>
                <h5 class="mt-3">Belum Ada Data</h5>
                <p class="text-muted">{{ $tableConfig['empty_message'] }}</p>
                @if($tableConfig['create_button_class'])
                    <button type="button" class="btn btn-primary {{ $tableConfig['create_button_class'] }}">
                        <i class="fas fa-plus me-1"></i>{{ $tableConfig['create_button_text'] }}
                    </button>
                @else
                    <a href="{{ $tableConfig['create_route'] }}" class="btn btn-primary">
                        <i class="fas fa-plus me-1"></i>{{ $tableConfig['create_button_text'] }}
                    </a>
                @endif
            </div>
        @endif
    </div>
</div>
