{{-- F:\rapor-dosen\resources\views\keuangan\master\partials\data-table-custom.blade.php --}}
{{-- Custom data table dengan support untuk field tahun anggaran dan program --}}

@if(isset($tableConfig) && count($tableConfig['data']) > 0)
    <div class="card shadow-sm border-0">
        <div class="card-header bg-white border-bottom-0">
            <div class="row align-items-center">
                <div class="col">
                    <h5 class="card-title mb-0">
                        <i class="fas fa-table me-2 text-primary"></i>
                        {{ $tableConfig['title'] ?? 'Data Table' }}
                    </h5>
                </div>
                @if(isset($tableConfig['create_route']))
                    <div class="col-auto">
                        <a href="{{ $tableConfig['create_route'] }}" class="btn btn-primary btn-sm">
                            <i class="fas fa-plus me-1"></i>Tambah Data
                        </a>
                    </div>
                @endif
            </div>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover mb-0">
                    <thead class="table-light">
                    <tr>
                        @foreach($tableConfig['columns'] as $column)
                            <th style="width: {{ $column['width'] ?? 'auto' }}">
                                {{ $column['label'] }}
                            </th>
                        @endforeach
                        @if(isset($tableConfig['actions']))
                            <th width="15%">Aksi</th>
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
                                        {{ data_get($item, $column['field']) ? \Carbon\Carbon::parse(data_get($item, $column['field']))->format('d M Y') : '-' }}

                                    @elseif($column['type'] == 'datetime')
                                        {{ data_get($item, $column['field']) ? \Carbon\Carbon::parse(data_get($item, $column['field']))->format('d M Y H:i') : '-' }}

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
        </div>
    </div>
@else
    <div class="card shadow-sm border-0">
        <div class="card-header bg-white border-bottom-0">
            <div class="row align-items-center">
                <div class="col">
                    <h5 class="card-title mb-0">
                        <i class="fas fa-table me-2 text-primary"></i>
                        {{ $tableConfig['title'] ?? 'Data Table' }}
                    </h5>
                </div>
                @if(isset($tableConfig['create_route']))
                    <div class="col-auto">
                        <a href="{{ $tableConfig['create_route'] }}" class="btn btn-primary btn-sm">
                            <i class="fas fa-plus me-1"></i>Tambah Data
                        </a>
                    </div>
                @endif
            </div>
        </div>
        <div class="card-body text-center py-5">
            <div class="mb-3">
                @php
                    $emptyIcon = 'calendar-times'; // default for tahun anggaran
                    if(str_contains(request()->path(), 'program')) {
                        $emptyIcon = 'graduation-cap';
                    } elseif(str_contains(request()->path(), 'mata-anggaran')) {
                        $emptyIcon = 'list-alt';
                    }
                @endphp
                <i class="fas fa-{{ $emptyIcon }} fa-3x text-muted"></i>
            </div>
            <h5 class="text-muted">Belum Ada Data</h5>
            <p class="text-muted mb-3">
                {{ $tableConfig['empty_message'] ?? 'Belum ada data untuk ditampilkan.' }}
            </p>
            @if(isset($tableConfig['create_route']))
                <a href="{{ $tableConfig['create_route'] }}" class="btn btn-primary">
                    <i class="fas fa-plus me-1"></i>Tambah Data Pertama
                </a>
            @endif
        </div>
    </div>
@endif
