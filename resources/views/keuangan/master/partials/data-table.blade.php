{{-- F:\rapor-dosen\resources\views\keuangan\master\partials\data-table.blade.php --}}
@if(isset($tableConfig))
    <div class="row justify-content-md-center">
        <div class="container">
            <div class="card">
                <div class="card-header" style="background-color: #fff; margin-top:10px">
                    <div class="row">
                        <div class="col-8">
                            <h5 class="card-title">{{ $tableConfig['title'] ?? 'Data Master' }}</h5>
                        </div>
                        <div class="col-4">
                            <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                                @if(isset($tableConfig['create_route']))
                                    <a href="{{ $tableConfig['create_route'] }}" class="btn btn-primary">
                                        <i class="fas fa-plus"></i> Tambah Data
                                    </a>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    @if(isset($tableConfig['data']) && $tableConfig['data']->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-hover" id="masterDataTable">
                                <thead class="table-light">
                                <tr>
                                    @foreach($tableConfig['columns'] as $column)
                                        <th style="width: {{ $column['width'] ?? 'auto' }}">{{ $column['label'] }}</th>
                                    @endforeach
                                    <th style="width: 150px;">Aksi</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($tableConfig['data'] as $index => $item)
                                    <tr>
                                        {{-- Dynamic columns based on config --}}
                                        @foreach($tableConfig['columns'] as $column)
                                            <td>
                                                @if($column['type'] === 'number')
                                                    {{ $tableConfig['data']->firstItem() + $index }}
                                                @elseif($column['type'] === 'badge')
                                                    <span class="badge bg-{{ $column['badge_class'] ?? 'primary' }}">
                                                        {{ data_get($item, $column['field']) }}
                                                    </span>
                                                @elseif($column['type'] === 'kategori_badge')
                                                    @php
                                                        $kategori = data_get($item, $column['field']);
                                                        $badgeClass = $kategori === 'debet' ? 'danger' : 'success';
                                                        $icon = $kategori === 'debet' ? 'minus-circle' : 'plus-circle';
                                                    @endphp
                                                    <span class="badge bg-{{ $badgeClass }}">
                                                        <i class="fas fa-{{ $icon }} me-1"></i>
                                                        {{ ucfirst($kategori) }}
                                                    </span>
                                                @elseif($column['type'] === 'status')
                                                    @if(data_get($item, $column['field']))
                                                        <span class="badge bg-success">Aktif</span>
                                                    @else
                                                        <span class="badge bg-danger">Tidak Aktif</span>
                                                    @endif
                                                @elseif($column['type'] === 'currency')
                                                    Rp {{ number_format(data_get($item, $column['field'], 0), 0, ',', '.') }}
                                                @elseif($column['type'] === 'text_with_description')
                                                    <div class="fw-bold">{{ data_get($item, $column['field']) }}</div>
                                                    @if(isset($column['description_field']) && data_get($item, $column['description_field']))
                                                        <small class="text-muted">{{ Str::limit(data_get($item, $column['description_field']), 60) }}</small>
                                                    @endif
                                                @elseif($column['type'] === 'text_with_hierarchy')
                                                    @php
                                                        $level = data_get($item, 'hierarchy_level', 0);
                                                        $indent = str_repeat('&nbsp;&nbsp;&nbsp;', $level);
                                                    @endphp
                                                    <div class="fw-bold">
                                                        {!! $indent !!}
                                                        @if($level > 0)
                                                            <i class="fas fa-level-up-alt text-muted me-1" style="transform: rotate(90deg);"></i>
                                                        @endif
                                                        {{ data_get($item, $column['field']) }}
                                                    </div>
                                                @elseif($column['type'] === 'children_count')
                                                    @if(data_get($item, 'children_count', 0) > 0)
                                                        <span class="badge bg-info small">
                                                            {{ data_get($item, 'children_count') }} sub item
                                                        </span>
                                                    @else
                                                        <span class="text-muted">-</span>
                                                    @endif
                                                @elseif($column['type'] === 'parent_name')
                                                    @if(data_get($item, $column['relationship']))
                                                        <span class="badge bg-secondary">
                                                            {{ data_get($item, $column['relationship'] . '.' . $column['field']) }}
                                                        </span>
                                                    @else
                                                        <span class="text-muted">Level Utama</span>
                                                    @endif
                                                @else
                                                    {{ data_get($item, $column['field']) }}
                                                @endif
                                            </td>
                                        @endforeach

                                        {{-- Actions Column --}}
                                        <td>
                                            <div class="btn-group" role="group">
                                                @if(isset($tableConfig['actions']['children']) && data_get($item, 'children_count', 0) > 0)
                                                    <a href="{{ str_replace(':id', $item->id, $tableConfig['actions']['children']) }}"
                                                       class="btn btn-sm btn-outline-success" title="Lihat Sub">
                                                        <i class="fas fa-sitemap"></i>
                                                    </a>
                                                @endif
                                                @if(isset($tableConfig['actions']['show']))
                                                    <a href="{{ str_replace(':id', $item->id, $tableConfig['actions']['show']) }}"
                                                       class="btn btn-sm btn-outline-info" title="Lihat Detail">
                                                        <i class="fas fa-eye"></i>
                                                    </a>
                                                @endif
                                                @if(isset($tableConfig['actions']['edit']))
                                                    <a href="{{ str_replace(':id', $item->id, $tableConfig['actions']['edit']) }}"
                                                       class="btn btn-sm btn-outline-warning" title="Edit">
                                                        <i class="fas fa-edit"></i>
                                                    </a>
                                                @endif
                                                @if(isset($tableConfig['actions']['delete']))
                                                    <form action="{{ str_replace(':id', $item->id, $tableConfig['actions']['delete']) }}"
                                                          method="POST" class="d-inline"
                                                          data-item-name="{{ data_get($item, $tableConfig['delete_name_field'] ?? 'nama', 'data ini') }}"
                                                          onsubmit="return confirm('Yakin ingin menghapus data ini?')">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-sm btn-outline-danger" title="Hapus">
                                                            <i class="fas fa-trash"></i>
                                                        </button>
                                                    </form>
                                                @endif
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>

                        {{-- Custom Pagination --}}
                        @if(method_exists($tableConfig['data'], 'links'))
                            @include('keuangan.master.partials.custom-pagination', [
                                'paginationData' => $tableConfig['data'],
                                'showPerPageSelector' => true
                            ])
                        @endif
                    @else
                        <div class="empty-state">
                            <i class="fas fa-database fa-3x text-muted"></i>
                            <h5 class="text-muted">Belum ada data</h5>
                            <p class="text-muted">{{ $tableConfig['empty_message'] ?? 'Belum ada data yang tersedia.' }}</p>
                            @if(isset($tableConfig['create_route']))
                                <a href="{{ $tableConfig['create_route'] }}" class="btn btn-primary">
                                    <i class="fas fa-plus me-1"></i> Tambah Data Pertama
                                </a>
                            @endif
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endif
