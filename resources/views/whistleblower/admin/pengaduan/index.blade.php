{{-- resources/views/whistleblower/admin/pengaduan/index.blade.php --}}
@extends('layouts.main2')

@section('navbar')
    @include('whistleblower.admin.navbar')
@endsection

@section('konten')
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <!-- Header -->
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <div>
                        <h2>Kelola Pengaduan</h2>
                        <p class="text-muted">
                            {{ session('selected_role') }} -
                            @if (session('selected_role') === 'Admin PPKPT Fakultas')
                                Mengelola semua pengaduan di fakultas
                            @else
                                Mengelola pengaduan di {{ auth()->user()->unit_kerja ?? 'unit kerja Anda' }}
                            @endif
                        </p>
                    </div>
                    <div>
                        <button class="btn btn-success me-2" data-bs-toggle="modal" data-bs-target="#modalExport">
                            <i class="fas fa-download"></i> Export
                        </button>
                        <a href="{{ route('whistleblower.admin.dashboard') }}" class="btn btn-secondary">
                            <i class="fas fa-arrow-left"></i> Dashboard
                        </a>
                    </div>
                </div>

                <!-- Quick Stats -->
                <div class="row mb-4">
                    <div class="col-md-2">
                        <div class="card text-center {{ request('status') == '' ? 'border-primary' : '' }}">
                            <div class="card-body py-2">
                                <h5 class="mb-1">{{ $statusCounts['total'] }}</h5>
                                <small>Total</small>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="card text-center {{ request('status') == 'pending' ? 'border-warning' : '' }}">
                            <div class="card-body py-2">
                                <h5 class="mb-1 text-warning">{{ $statusCounts['pending'] }}</h5>
                                <small>Pending</small>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="card text-center {{ request('status') == 'proses' ? 'border-info' : '' }}">
                            <div class="card-body py-2">
                                <h5 class="mb-1 text-info">{{ $statusCounts['proses'] }}</h5>
                                <small>Proses</small>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="card text-center {{ request('status') == 'selesai' ? 'border-success' : '' }}">
                            <div class="card-body py-2">
                                <h5 class="mb-1 text-success">{{ $statusCounts['selesai'] }}</h5>
                                <small>Selesai</small>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="card text-center {{ request('status') == 'ditolak' ? 'border-danger' : '' }}">
                            <div class="card-body py-2">
                                <h5 class="mb-1 text-danger">{{ $statusCounts['ditolak'] }}</h5>
                                <small>Ditolak</small>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="card text-center {{ request('filter') == 'prioritas' ? 'border-danger' : '' }}">
                            <div class="card-body py-2">
                                <h5 class="mb-1 text-danger">{{ $statusCounts['prioritas'] }}</h5>
                                <small>Prioritas</small>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Filter & Search -->
                <div class="card mb-4">
                    <div class="card-body">
                        <form method="GET" action="{{ route('whistleblower.admin.pengaduan.index') }}">
                            <div class="row align-items-end">
                                <div class="col-md-2">
                                    <label class="form-label">Status</label>
                                    <select name="status" class="form-select form-select-sm">
                                        <option value="">Semua Status</option>
                                        <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>
                                            Pending</option>
                                        <option value="proses" {{ request('status') == 'proses' ? 'selected' : '' }}>Proses
                                        </option>
                                        <option value="selesai" {{ request('status') == 'selesai' ? 'selected' : '' }}>
                                            Selesai</option>
                                        <option value="ditolak" {{ request('status') == 'ditolak' ? 'selected' : '' }}>
                                            Ditolak</option>
                                    </select>
                                </div>
                                <div class="col-md-2">
                                    <label class="form-label">Kategori</label>
                                    <select name="kategori" class="form-select form-select-sm">
                                        <option value="">Semua Kategori</option>
                                        @foreach ($kategori as $kat)
                                            <option value="{{ $kat->id }}"
                                                {{ request('kategori') == $kat->id ? 'selected' : '' }}>
                                                {{ $kat->nama }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-2">
                                    <label class="form-label">Filter Khusus</label>
                                    <select name="filter" class="form-select form-select-sm">
                                        <option value="">Tidak ada</option>
                                        <option value="prioritas" {{ request('filter') == 'prioritas' ? 'selected' : '' }}>
                                            Prioritas (> 3 hari)</option>
                                    </select>
                                </div>
                                <div class="col-md-3">
                                    <label class="form-label">Cari</label>
                                    <input type="text" name="search" class="form-control form-control-sm"
                                        placeholder="Kode, judul, atau nama pelapor..." value="{{ request('search') }}">
                                </div>
                                <div class="col-md-2">
                                    <label class="form-label">Urutkan</label>
                                    <select name="sort" class="form-select form-select-sm">
                                        <option value="created_at"
                                            {{ request('sort', 'created_at') == 'created_at' ? 'selected' : '' }}>Tanggal
                                        </option>
                                        <option value="priority" {{ request('sort') == 'priority' ? 'selected' : '' }}>
                                            Prioritas</option>
                                        <option value="status_pengaduan"
                                            {{ request('sort') == 'status_pengaduan' ? 'selected' : '' }}>Status</option>
                                    </select>
                                </div>
                                <div class="col-md-1">
                                    <button type="submit" class="btn btn-primary btn-sm w-100">
                                        <i class="fas fa-search"></i>
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>

                <!-- Bulk Actions -->
                @if ($pengaduan->count() > 0)
                    <div class="card mb-3">
                        <div class="card-body py-2">
                            <form id="bulkActionForm" method="POST"
                                action="{{ route('whistleblower.admin.pengaduan.bulk-action') }}">
                                @csrf
                                <div class="row align-items-center">
                                    <div class="col-md-2">
                                        <input type="checkbox" id="selectAll" class="form-check-input me-2">
                                        <label for="selectAll" class="form-check-label">Pilih Semua</label>
                                    </div>
                                    <div class="col-md-3">
                                        <select name="action" class="form-select form-select-sm" required>
                                            <option value="">Pilih Aksi</option>
                                            <option value="change_status">Ubah Status</option>
                                            <option value="assign_to">Tugaskan Ke</option>
                                        </select>
                                    </div>
                                    <div class="col-md-2">
                                        <select name="status" class="form-select form-select-sm">
                                            <option value="">Pilih Status</option>
                                            <option value="pending">Pending</option>
                                            <option value="proses">Proses</option>
                                            <option value="selesai">Selesai</option>
                                            <option value="ditolak">Ditolak</option>
                                        </select>
                                    </div>
                                    <div class="col-md-3">
                                        <select name="assigned_to" class="form-select form-select-sm">
                                            <option value="">Pilih Admin</option>
                                            <!-- Daftar admin akan diisi sesuai scope -->
                                        </select>
                                    </div>
                                    <div class="col-md-2">
                                        <button type="submit" class="btn btn-success btn-sm">
                                            <i class="fas fa-check"></i> Jalankan
                                        </button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                @endif

                <!-- Daftar Pengaduan -->
                <div class="card">
                    <div class="card-header">
                        <h5 class="mb-0">
                            <i class="fas fa-list"></i> Daftar Pengaduan
                            <span class="badge bg-secondary ms-2">{{ $pengaduan->total() }} total</span>
                        </h5>
                    </div>
                    <div class="card-body p-0">
                        @if ($pengaduan->count() > 0)
                            <div class="table-responsive">
                                <table class="table table-hover mb-0">
                                    <thead class="table-light">
                                        <tr>
                                            <th width="50">
                                                <input type="checkbox" id="selectAllTable" class="form-check-input">
                                            </th>
                                            <th>Kode</th>
                                            <th>Pelapor</th>
                                            <th>Kategori</th>
                                            <th>Judul</th>
                                            <th>Status</th>
                                            <th>Tanggal</th>
                                            <th>Handler</th>
                                            <th width="150">Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($pengaduan as $item)
                                            <tr class="{{ $item->is_prioritas ? 'table-warning' : '' }}">
                                                <td>
                                                    <input type="checkbox" name="pengaduan_ids[]"
                                                        value="{{ $item->id }}"
                                                        class="form-check-input pengaduan-checkbox">
                                                </td>
                                                <td>
                                                    <strong class="text-primary">{{ $item->kode_pengaduan }}</strong>
                                                    @if ($item->is_anonim)
                                                        <br><span class="badge bg-info">Anonim</span>
                                                    @endif
                                                    @if ($item->is_prioritas)
                                                        <br><span class="badge bg-danger">Prioritas</span>
                                                    @endif
                                                </td>
                                                <td>
                                                    @if ($item->is_anonim)
                                                        <em class="text-muted">Anonim</em>
                                                    @else
                                                        {{ $item->user->name ?? 'N/A' }}
                                                        <br><small
                                                            class="text-muted">{{ $item->user->email ?? '' }}</small>
                                                    @endif
                                                </td>
                                                <td>
                                                    <span class="badge bg-secondary">
                                                        {{ $item->kategori->nama ?? 'Lainnya' }}
                                                    </span>
                                                </td>
                                                <td>
                                                    <div class="fw-bold">{{ Str::limit($item->judul_pengaduan, 30) }}
                                                    </div>
                                                    <small
                                                        class="text-muted">{{ Str::limit($item->deskripsi_pengaduan, 50) }}</small>
                                                </td>
                                                <td>
                                                    <span class="badge bg-{{ $item->status_badge }}">
                                                        {{ $item->status_text }}
                                                    </span>
                                                </td>
                                                <td>
                                                    <div>{{ $item->created_at->format('d/m/Y') }}</div>
                                                    <small
                                                        class="text-muted">{{ $item->created_at->diffForHumans() }}</small>
                                                </td>
                                                <td>
                                                    @if ($item->handler)
                                                        <small>{{ $item->handler->name }}</small>
                                                    @else
                                                        <span class="text-muted">Belum ditugaskan</span>
                                                    @endif
                                                </td>
                                                <td>
                                                    <div class="btn-group btn-group-sm">
                                                        <a href="{{ route('whistleblower.admin.pengaduan.show', $item->id) }}"
                                                            class="btn btn-outline-primary">
                                                            <i class="fas fa-eye"></i>
                                                        </a>
                                                        @if ($item->status_pengaduan != 'selesai')
                                                            <button class="btn btn-outline-success"
                                                                onclick="updateStatus('{{ $item->id }}', '{{ $item->kode_pengaduan }}')">
                                                                <i class="fas fa-edit"></i>
                                                            </button>
                                                        @endif
                                                    </div>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>

                            <!-- Pagination -->
                            <div class="d-flex justify-content-center mt-3">
                                {{ $pengaduan->appends(request()->query())->links() }}
                            </div>
                        @else
                            <div class="text-center py-5">
                                <i class="fas fa-inbox fa-4x text-muted mb-3"></i>
                                <h4 class="text-muted">Tidak Ada Pengaduan</h4>
                                <p class="text-muted">
                                    @if (request()->hasAny(['status', 'kategori', 'search', 'filter']))
                                        Tidak ada pengaduan yang sesuai dengan filter yang dipilih.
                                    @else
                                        Belum ada pengaduan yang masuk.
                                    @endif
                                </p>
                                @if (request()->hasAny(['status', 'kategori', 'search', 'filter']))
                                    <a href="{{ route('whistleblower.admin.pengaduan.index') }}"
                                        class="btn btn-secondary">
                                        <i class="fas fa-redo"></i> Reset Filter
                                    </a>
                                @endif
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Update Status -->
    <div class="modal fade" id="modalUpdateStatus" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <form id="updateStatusForm" method="POST">
                    @csrf
                    <div class="modal-header">
                        <h5 class="modal-title">Update Status Pengaduan</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label class="form-label">Kode Pengaduan</label>
                            <input type="text" id="modalKodePengaduan" class="form-control" readonly>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Status Baru <span class="text-danger">*</span></label>
                            <select name="status_pengaduan" class="form-select" required>
                                <option value="">Pilih Status</option>
                                <option value="pending">Pending</option>
                                <option value="proses">Dalam Proses</option>
                                <option value="selesai">Selesai</option>
                                <option value="ditolak">Ditolak</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Tanggapan/Keterangan</label>
                            <textarea name="admin_response" class="form-control" rows="4"
                                placeholder="Berikan tanggapan atau keterangan..."></textarea>
                            <div class="form-text">
                                <small>Wajib diisi jika status diubah ke "Selesai" atau "Ditolak"</small>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save"></i> Update Status
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Modal Export -->
    <div class="modal fade" id="modalExport" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <form action="{{ route('whistleblower.admin.pengaduan.export') }}" method="GET">
                    <div class="modal-header">
                        <h5 class="modal-title">Export Data Pengaduan</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-6">
                                <label class="form-label">Tanggal Mulai</label>
                                <input type="date" name="date_from" class="form-control">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Tanggal Selesai</label>
                                <input type="date" name="date_to" class="form-control">
                            </div>
                        </div>
                        <div class="mb-3 mt-3">
                            <label class="form-label">Status</label>
                            <select name="status" class="form-select">
                                <option value="">Semua Status</option>
                                <option value="pending">Pending</option>
                                <option value="proses">Proses</option>
                                <option value="selesai">Selesai</option>
                                <option value="ditolak">Ditolak</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Format</label>
                            <select name="format" class="form-select">
                                <option value="excel">Excel (.xlsx)</option>
                                <option value="pdf">PDF</option>
                            </select>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-success">
                            <i class="fas fa-download"></i> Export
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    @push('scripts')
        <script>
            function updateStatus(id, kode) {
                document.getElementById('modalKodePengaduan').value = kode;
                document.getElementById('updateStatusForm').action = `/whistleblower/admin/pengaduan/${id}/update-status`;

                const modal = new bootstrap.Modal(document.getElementById('modalUpdateStatus'));
                modal.show();
            }

            // Select all functionality
            document.getElementById('selectAll').addEventListener('change', function() {
                const checkboxes = document.querySelectorAll('.pengaduan-checkbox');
                checkboxes.forEach(checkbox => {
                    checkbox.checked = this.checked;
                });
            });

            document.getElementById('selectAllTable').addEventListener('change', function() {
                const checkboxes = document.querySelectorAll('.pengaduan-checkbox');
                checkboxes.forEach(checkbox => {
                    checkbox.checked = this.checked;
                });
            });
        </script>
    @endpush
@endsection
