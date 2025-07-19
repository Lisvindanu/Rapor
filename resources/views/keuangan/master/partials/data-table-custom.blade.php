{{-- resources/views/keuangan/master/partials/data-table-custom.blade.php --}}
<div class="card shadow">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h5 class="card-title mb-0">
            <i class="fas fa-table me-2"></i>{{ $tableConfig['title'] ?? 'Data Table' }}
        </h5>
        @if(isset($tableConfig['create_route']))
            <a href="{{ $tableConfig['create_route'] }}" class="btn btn-primary btn-sm">
                <i class="fas fa-plus me-1"></i>Tambah Data
            </a>
        @endif
    </div>

    <div class="card-body">
        @if(isset($tableConfig['data']) && $tableConfig['data']->isNotEmpty())
            <div class="table-responsive">
                <table class="table table-hover table-striped">
                    <thead class="table-dark">
                    <tr>
                        @if(isset($tableConfig['columns']))
                            @foreach($tableConfig['columns'] as $column)
                                <th style="width: {{ $column['width'] ?? 'auto' }};">
                                    {{ $column['label'] }}
                                </th>
                            @endforeach
                        @endif
                        @if(isset($tableConfig['actions']))
                            <th style="width: 15%;" class="text-center">Aksi</th>
                        @endif
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($tableConfig['data'] as $index => $item)
                        <tr>
                            @foreach($tableConfig['columns'] as $column)
                                <td>
                                    @if($column['type'] == 'number')
                                        {{ $index + 1 }}

                                    @elseif($column['type'] == 'badge')
                                        <span class="badge bg-{{ $column['badge_class'] ?? 'primary' }}">
                                                {{ data_get($item, $column['field']) }}
                                            </span>

                                    @elseif($column['type'] == 'program_badge')
                                        <span class="badge bg-{{ data_get($item, 'badge_class') }} me-2">
                                                <i class="fas fa-{{ data_get($item, 'icon') }} me-1"></i>
                                                {{ data_get($item, $column['field']) }}
                                            </span>

                                    @elseif($column['type'] == 'program_badge_large')
                                        <div class="d-flex align-items-center">
                                                <span class="badge bg-{{ data_get($item, 'badge_class') }} fs-6 me-2">
                                                    <i class="fas fa-{{ data_get($item, 'icon') }} me-2"></i>
                                                    {{ data_get($item, $column['field']) }}
                                                </span>
                                        </div>

                                    @elseif($column['type'] == 'periode_lengkap')
                                        <div>
                                            <strong>{{ data_get($item, $column['field']) }}</strong>
                                        </div>

                                    @elseif($column['type'] == 'durasi_hari')
                                        <span class="badge bg-info">
                                                {{ data_get($item, $column['field']) }} hari
                                            </span>

                                    @elseif($column['type'] == 'status_badge')
                                        <span class="badge bg-{{ data_get($item, 'status_class') }}">
                                                {{ data_get($item, $column['field']) }}
                                            </span>

                                    @elseif($column['type'] == 'date')
                                        @php
                                            $dateValue = data_get($item, $column['field']);
                                        @endphp
                                        @if($dateValue)
                                            @if($dateValue instanceof \Carbon\Carbon)
                                                {{ $dateValue->format('d M Y') }}
                                            @elseif(is_string($dateValue) && !preg_match('/^\d{2}\/\d{2}\/\d{4}/', $dateValue))
                                                {{ \Carbon\Carbon::parse($dateValue)->format('d M Y') }}
                                            @else
                                                {{ $dateValue }}
                                            @endif
                                        @else
                                            -
                                        @endif

                                    @elseif($column['type'] == 'datetime')
                                        @php
                                            $datetimeValue = data_get($item, $column['field']);
                                        @endphp
                                        @if($datetimeValue)
                                            @if($datetimeValue instanceof \Carbon\Carbon)
                                                {{ $datetimeValue->format('d M Y H:i') }}
                                            @elseif(is_string($datetimeValue) && !preg_match('/^\d{2}\/\d{2}\/\d{4}/', $datetimeValue))
                                                {{ \Carbon\Carbon::parse($datetimeValue)->format('d M Y H:i') }}
                                            @else
                                                {{ $datetimeValue }}
                                            @endif
                                        @else
                                            -
                                        @endif

                                    @elseif($column['type'] == 'text')
                                        {{ data_get($item, $column['field']) ?? '-' }}

                                    @else
                                        {{ data_get($item, $column['field']) ?? '-' }}
                                    @endif
                                </td>
                            @endforeach

                            @if(isset($tableConfig['actions']))
                                <td>
                                    <div class="btn-group btn-group-sm" role="group">
                                        @if(isset($tableConfig['actions']['show']))
                                            <a href="{{ str_replace(':id', $item->id, $tableConfig['actions']['show']) }}"
                                               class="btn btn-outline-info btn-sm" title="Lihat Detail">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                        @endif
                                        @if(isset($tableConfig['actions']['edit']))
                                            <a href="{{ str_replace(':id', $item->id, $tableConfig['actions']['edit']) }}"
                                               class="btn btn-outline-warning btn-sm" title="Edit">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                        @endif
                                        @if(isset($tableConfig['actions']['delete']))
                                            <button type="button"
                                                    class="btn btn-outline-danger btn-sm delete-btn"
                                                    data-url="{{ str_replace(':id', $item->id, $tableConfig['actions']['delete']) }}"
                                                    data-name="{{ data_get($item, $tableConfig['delete_name_field'] ?? 'name') }}"
                                                    title="Hapus">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        @endif
                                    </div>
                                </td>
                            @endif
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>

            {{-- Pagination jika diperlukan --}}
            @if(method_exists($tableConfig['data'], 'links'))
                <div class="d-flex justify-content-center mt-3">
                    {{ $tableConfig['data']->links() }}
                </div>
            @endif

        @else
            {{-- Empty State --}}
            <div class="text-center py-5">
                <div class="mb-3">
                    <i class="fas fa-inbox text-muted" style="font-size: 4rem;"></i>
                </div>
                <h5 class="text-muted mb-3">Data Tidak Ditemukan</h5>
                <p class="text-muted mb-4">
                    {{ $tableConfig['empty_message'] ?? 'Belum ada data yang tersedia.' }}
                </p>
                @if(isset($tableConfig['create_route']))
                    <a href="{{ $tableConfig['create_route'] }}" class="btn btn-primary">
                        <i class="fas fa-plus me-1"></i>Tambah Data Pertama
                    </a>
                @endif
            </div>
        @endif
    </div>
</div>
