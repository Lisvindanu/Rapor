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
                                    <th style="width: 5%">No</th>
                                    <th style="width: 5%"></th> {{-- Expand/Collapse column --}}
                                    <th style="width: 10%">Kode</th>
                                    <th style="width: 35%">Nama Mata Anggaran</th>
                                    <th style="width: 15%">Parent</th>
                                    <th style="width: 10%">Sub Item</th>
                                    <th style="width: 15%">Kategori</th>
                                    <th style="width: 150px;">Aksi</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($tableConfig['data'] as $index => $item)
                                    <tr class="parent-row" data-parent-id="{{ $item->id }}">
                                        <td>{{ $tableConfig['data']->firstItem() + $index }}</td>
                                        <td>
                                            @if($item->children_count > 0)
                                                <button class="btn btn-sm btn-link expand-btn p-0"
                                                        data-parent-id="{{ $item->id }}"
                                                        title="Tampilkan sub item">
                                                    <i class="fas fa-plus-square text-primary"></i>
                                                </button>
                                            @endif
                                        </td>
                                        <td>
                                            <span class="badge bg-primary">{{ $item->kode_mata_anggaran }}</span>
                                        </td>
                                        <td>
                                            <div class="fw-bold">{{ $item->nama_mata_anggaran }}</div>
                                        </td>
                                        <td>
                                            <span class="text-muted">Level Utama</span>
                                        </td>
                                        <td>
                                            @if($item->children_count > 0)
                                                <span class="badge bg-info small">{{ $item->children_count }} sub item</span>
                                            @else
                                                <span class="text-muted">-</span>
                                            @endif
                                        </td>
                                        <td>
                                            @php
                                                $badgeClass = $item->kategori === 'debet' ? 'danger' : 'success';
                                                $icon = $item->kategori === 'debet' ? 'minus-circle' : 'plus-circle';
                                            @endphp
                                            <span class="badge bg-{{ $badgeClass }}">
                                                <i class="fas fa-{{ $icon }} me-1"></i>
                                                {{ ucfirst($item->kategori) }}
                                            </span>
                                        </td>
                                        <td>
                                            <div class="btn-group" role="group">
                                                <a href="{{ str_replace(':id', $item->id, $tableConfig['actions']['show']) }}"
                                                   class="btn btn-sm btn-outline-info" title="Lihat Detail">
                                                    <i class="fas fa-eye"></i>
                                                </a>
                                                <a href="{{ str_replace(':id', $item->id, $tableConfig['actions']['edit']) }}"
                                                   class="btn btn-sm btn-outline-warning" title="Edit">
                                                    <i class="fas fa-edit"></i>
                                                </a>
                                                <form action="{{ str_replace(':id', $item->id, $tableConfig['actions']['delete']) }}"
                                                      method="POST" class="d-inline"
                                                      onsubmit="return confirm('Yakin ingin menghapus mata anggaran {{ $item->nama_mata_anggaran }}?')">
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

<style>
    /* ==========================================================================
       1. Konfigurasi Tombol Expand/Collapse
       ========================================================================== */
    .expand-btn {
        background: none !important;
        border: none !important;
        padding: 0 !important;
        font-size: 16px;
        cursor: pointer;
        transition: transform 0.3s ease;
    }

    .expand-btn:hover {
        transform: scale(1.1);
    }

    .expand-btn .fas {
        transition: all 0.3s ease;
    }


    /* ==========================================================================
       2. Style untuk Baris Data (Row)
       ========================================================================== */
    .child-row {
        background-color: #f8f9fc !important;
        border-left: 4px solid #4e73df !important;
    }

    .loading-row,
    .info-row {
        background-color: #f8f9fa !important;
        text-align: center;
        font-style: italic;
        color: #6c757d;
    }

    .child-row td {
        padding: 0.75rem 0.5rem !important;
        font-size: 0.9rem;
        border-top: 1px solid #e3e6f0;
    }


    /* ==========================================================================
       3. Efek Hover
       ========================================================================== */
    .table-hover .parent-row:hover {
        background-color: rgba(0, 123, 255, 0.05) !important;
    }

    .table-hover .child-row:hover {
        background-color: rgba(78, 115, 223, 0.1) !important;
    }


    /* ==========================================================================
       4. Style Konten di dalam Baris Anak (Child Row)
       ========================================================================== */
    /* Style untuk KODE di baris anak, teks diubah jadi putih */
    .child-row .child-kode {
        font-family: 'Courier New', monospace;
        font-weight: bold;
        color: #ffffff !important;
        font-size: 0.85rem;
    }

    .child-row .child-nama {
        color: #2c3e50 !important;
        font-weight: 500;
        padding-left: 1.5rem;
        position: relative;
    }

    .child-row .child-nama::before {
        content: "└── ";
        color: #6c757d;
        font-weight: bold;
        position: absolute;
        left: 0;
    }

    /* Style untuk PARENT di baris anak, teks diubah jadi putih */
    .child-row .child-parent {
        color: #ffffff !important;
        font-size: 0.8rem;
    }


    /* ==========================================================================
       5. Desain Responsif
       ========================================================================== */
    @media (max-width: 768px) {
        .child-row td {
            padding: 0.5rem 0.25rem !important;
            font-size: 0.8rem;
        }

        .child-row .child-nama {
            padding-left: 1rem;
        }
    }
</style>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        console.log('🎯 Data Table with Expand/Collapse loaded');

        const expandButtons = document.querySelectorAll('.expand-btn');

        expandButtons.forEach(button => {
            button.addEventListener('click', function(e) {
                e.preventDefault();
                e.stopPropagation();

                const parentId = this.dataset.parentId;
                const parentRow = this.closest('tr');
                const icon = this.querySelector('i');

                if (icon.classList.contains('fa-plus-square')) {
                    expandChildren(parentId, parentRow, icon);
                } else {
                    collapseChildren(parentId, parentRow, icon);
                }
            });
        });

        function expandChildren(parentId, parentRow, icon) {
            // Show loading
            const loadingRow = document.createElement('tr');
            loadingRow.className = 'loading-row';
            loadingRow.innerHTML = `
            <td colspan="8" class="text-center py-3">
                <i class="fas fa-spinner fa-spin me-2"></i>Memuat sub item...
            </td>
        `;
            parentRow.insertAdjacentElement('afterend', loadingRow);

            // Change icon
            icon.classList.remove('fa-plus-square');
            icon.classList.add('fa-minus-square');

            // Fetch children
            fetch(`/keuangan/mata-anggaran/${parentId}/children`)
                .then(response => {
                    if (!response.ok) {
                        throw new Error(`HTTP ${response.status}`);
                    }
                    return response.json();
                })
                .then(data => {
                    loadingRow.remove();

                    if (data.success && data.data.length > 0) {
                        data.data.forEach((child) => {
                            const childRow = createChildRow(child, parentId);
                            parentRow.insertAdjacentElement('afterend', childRow);
                        });
                    } else {
                        showNoChildrenRow(parentRow, parentId);
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    loadingRow.remove();
                    showErrorRow(parentRow, parentId);
                });
        }

        function collapseChildren(parentId, parentRow, icon) {
            const childRows = document.querySelectorAll(`tr[data-parent-id="${parentId}"]`);
            childRows.forEach(row => {
                if (row !== parentRow) {
                    row.remove();
                }
            });

            icon.classList.remove('fa-minus-square');
            icon.classList.add('fa-plus-square');
        }

        function createChildRow(child, parentId) {
            const row = document.createElement('tr');
            row.className = 'child-row';
            row.dataset.parentId = parentId;

            const kategoriClass = child.kategori === 'debet' ? 'danger' : 'success';
            const kategoriIcon = child.kategori === 'debet' ? 'minus-circle' : 'plus-circle';
            const parentKode = child.kode_mata_anggaran.split('.')[0];

            row.innerHTML = `
            <td></td>
            <td></td>
            <td>
                <span class="badge bg-secondary child-kode">${child.kode_mata_anggaran}</span>
            </td>
            <td>
                <div class="child-nama">${child.nama_mata_anggaran}</div>
            </td>
            <td>
                <span class="badge bg-secondary small child-parent">${parentKode}</span>
            </td>
            <td>
                <span class="text-muted">-</span>
            </td>
            <td>
                <span class="badge bg-${kategoriClass}">
                    <i class="fas fa-${kategoriIcon} me-1"></i>
                    ${child.kategori.charAt(0).toUpperCase() + child.kategori.slice(1)}
                </span>
            </td>
            <td>
                <div class="btn-group" role="group">
                    <a href="/keuangan/mata-anggaran/${child.id}" class="btn btn-sm btn-outline-info" title="Detail">
                        <i class="fas fa-eye"></i>
                    </a>
                    <a href="/keuangan/mata-anggaran/${child.id}/edit" class="btn btn-sm btn-outline-warning" title="Edit">
                        <i class="fas fa-edit"></i>
                    </a>
                </div>
            </td>
        `;

            return row;
        }

        function showNoChildrenRow(parentRow, parentId) {
            const noChildRow = document.createElement('tr');
            noChildRow.className = 'child-row';
            noChildRow.dataset.parentId = parentId;
            noChildRow.innerHTML = `
            <td colspan="8" class="text-center py-3 text-muted">
                <i class="fas fa-info-circle me-2"></i>Tidak ada sub item
            </td>
        `;
            parentRow.insertAdjacentElement('afterend', noChildRow);
        }

        function showErrorRow(parentRow, parentId) {
            const errorRow = document.createElement('tr');
            errorRow.className = 'child-row';
            errorRow.dataset.parentId = parentId;
            errorRow.innerHTML = `
            <td colspan="8" class="text-center py-3 text-danger">
                <i class="fas fa-exclamation-triangle me-2"></i>Gagal memuat sub item
            </td>
        `;
            parentRow.insertAdjacentElement('afterend', errorRow);
        }
    });
</script>
