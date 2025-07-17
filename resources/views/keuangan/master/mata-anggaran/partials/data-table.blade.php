{{-- F:\rapor-dosen\resources\views\keuangan\master\partials\data-table.blade.php --}}
@if(isset($tableConfig))
    <div class="card shadow-sm">
        <div class="card-header bg-light">
            <div class="d-flex justify-content-between align-items-center">
                <h5 class="card-title mb-0">
                    <i class="fas fa-table me-2"></i>{{ $tableConfig['title'] }}
                </h5>
                <span class="badge bg-info">Total: {{ $tableConfig['data']->total() }} data</span>
            </div>
        </div>
        <div class="card-body p-0">
            @if($tableConfig['data']->count() > 0)
                <div class="table-responsive">
                    <table class="table table-hover table-striped mb-0">
                        <thead class="table-dark">
                        <tr>
                            @foreach($tableConfig['columns'] as $column)
                                <th width="{{ $column['width'] ?? 'auto' }}"
                                    class="{{ isset($column['align']) ? 'text-'.$column['align'] : '' }}">
                                    {{ $column['label'] }}
                                </th>
                            @endforeach
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($tableConfig['data'] as $index => $item)
                            <tr>
                                {{-- No --}}
                                <td class="text-center">{{ $tableConfig['data']->firstItem() + $index }}</td>

                                {{-- Kode --}}
                                <td>
                                    <span class="badge bg-primary">{{ $item->kode_mata_anggaran }}</span>
                                </td>

                                {{-- Nama --}}
                                <td>
                                    <div class="fw-bold">{{ $item->nama_mata_anggaran }}</div>
                                    @if($item->deskripsi)
                                        <small class="text-muted">{{ Str::limit($item->deskripsi, 60) }}</small>
                                    @endif
                                    @if($item->children_count > 0)
                                        <div class="mt-1">
                                            <span class="badge bg-info small">
                                                {{ $item->children_count }} sub mata anggaran
                                            </span>
                                        </div>
                                    @endif
                                </td>

                                {{-- Parent --}}
                                <td>
                                    @if($item->parentMataAnggaran)
                                        <span class="badge bg-secondary">
                                            {{ $item->parentMataAnggaran->kode_mata_anggaran }}
                                        </span>
                                    @else
                                        <span class="text-muted">-</span>
                                    @endif
                                </td>

                                {{-- Level --}}
                                <td class="text-center">
                                    @if($item->level_mata_anggaran == 0)
                                        <span class="badge bg-success">Parent</span>
                                    @else
                                        <span class="badge bg-warning">Level {{ $item->level_mata_anggaran }}</span>
                                    @endif
                                </td>

                                {{-- Tahun --}}
                                <td class="text-center">
                                    <span class="badge bg-info">{{ $item->tahun_anggaran }}</span>
                                </td>

                                {{-- Actions --}}
                                <td class="text-center">
                                    <div class="btn-group" role="group">
                                        @if($item->children_count > 0)
                                            <a href="{{ route('keuangan.sub-mata-anggaran.index', $item->id) }}"
                                               class="btn btn-sm btn-outline-success" title="Lihat Sub">
                                                <i class="fas fa-sitemap"></i>
                                            </a>
                                        @endif
                                        <a href="{{ route('keuangan.mata-anggaran.show', $item->id) }}"
                                           class="btn btn-sm btn-outline-info" title="Lihat Detail">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        <a href="{{ route('keuangan.mata-anggaran.edit', $item->id) }}"
                                           class="btn btn-sm btn-outline-warning" title="Edit">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <form action="{{ route('keuangan.mata-anggaran.destroy', $item->id) }}"
                                              method="POST" class="d-inline"
                                              data-item-name="{{ $item->nama_mata_anggaran }}"
                                              onsubmit="return confirm('Yakin ingin menghapus mata anggaran ini?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-outline-danger" title="Hapus">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <div class="empty-state">
                    <i class="fas fa-list-alt fa-3x text-muted"></i>
                    <h5 class="text-muted">Belum ada data mata anggaran</h5>
                    <p class="text-muted">Klik tombol "Tambah Mata Anggaran" untuk menambahkan data pertama.</p>
                    <a href="{{ route('keuangan.mata-anggaran.create') }}" class="btn btn-primary">
                        <i class="fas fa-plus me-1"></i> Tambah Mata Anggaran
                    </a>
                </div>
            @endif
        </div>

        {{-- Pagination --}}
        @if($tableConfig['data']->hasPages())
            <div class="card-footer">
                <div class="d-flex justify-content-between align-items-center">
                    <div class="text-muted small">
                        Menampilkan {{ $tableConfig['data']->firstItem() }} sampai {{ $tableConfig['data']->lastItem() }}
                        dari {{ $tableConfig['data']->total() }} data
                    </div>
                    {{ $tableConfig['data']->links() }}
                </div>
            </div>
        @endif
    </div>
@endif
