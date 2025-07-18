{{-- resources/views/whistleblower/index.blade.php --}}
@extends('layouts.main2')

@section('navbar')
    @include('whistleblower.navbar')
@endsection

@section('konten')
<div class="container">
    <div class="row">
        <div class="col-12">
            <!-- Header -->
            <div class="d-flex justify-content-between align-items-center mb-4">
                <div>
                    <h2>Riwayat Pengaduan</h2>
                    <p class="text-muted">Daftar semua pengaduan yang pernah Anda buat</p>
                </div>
                <div>
                    <a href="{{ route('whistleblower.create') }}" class="btn btn-danger">
                        <i class="fas fa-plus"></i> Buat Pengaduan Baru
                    </a>
                </div>
            </div>

            <!-- Filter & Search -->
            <div class="card mb-4">
                <div class="card-body">
                    <form method="GET" action="{{ route('whistleblower.index') }}">
                        <div class="row">
                            <div class="col-md-3">
                                <label class="form-label">Status</label>
                                <select name="status" class="form-select">
                                    <option value="">Semua Status</option>
                                    <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Menunggu</option>
                                    <option value="proses" {{ request('status') == 'proses' ? 'selected' : '' }}>Proses</option>
                                    <option value="selesai" {{ request('status') == 'selesai' ? 'selected' : '' }}>Selesai</option>
                                </select>
                            </div>
                            <div class="col-md-3">
                                <label class="form-label">Kategori</label>
                                <select name="kategori" class="form-select">
                                    <option value="">Semua Kategori</option>
                                    @foreach(App\Models\KategoriPengaduan::all() as $kat)
                                    <option value="{{ $kat->id }}" {{ request('kategori') == $kat->id ? 'selected' : '' }}>
                                        {{ $kat->nama }}
                                    </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-4">
                                <label class="form-label">Cari</label>
                                <input type="text" name="search" class="form-control" 
                                       placeholder="Cari berdasarkan kode atau judul..." 
                                       value="{{ request('search') }}">
                            </div>
                            <div class="col-md-2">
                                <label class="form-label">&nbsp;</label>
                                <div class="d-grid">
                                    <button type="submit" class="btn btn-primary">
                                        <i class="fas fa-search"></i> Filter
                                    </button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Daftar Pengaduan -->
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">
                        <i class="fas fa-list"></i> Daftar Pengaduan
                        <span class="badge bg-secondary ms-2">{{ $pengaduan->total() }} total</span>
                    </h5>
                </div>
                <div class="card-body">
                    @if($pengaduan->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead class="table-light">
                                    <tr>
                                        <th>Kode Pengaduan</th>
                                        <th>Judul</th>
                                        <th>Kategori</th>
                                        <th>Status</th>
                                        <th>Tanggal</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($pengaduan as $item)
                                    <tr>
                                        <td>
                                            <strong class="text-primary">{{ $item->kode_pengaduan }}</strong>
                                            @if($item->is_anonim)
                                                <span class="badge bg-info ms-1">Anonim</span>
                                            @endif
                                        </td>
                                        <td>
                                            <div class="fw-bold">{{ Str::limit($item->judul_pengaduan, 50) }}</div>
                                            <small class="text-muted">{{ Str::limit($item->deskripsi_pengaduan, 80) }}</small>
                                        </td>
                                        <td>
                                            <span class="badge bg-secondary">
                                                {{ $item->kategori->nama ?? 'Lainnya' }}
                                            </span>
                                        </td>
                                        <td>
                                            @if($item->status_pengaduan == 'pending')
                                                <span class="badge bg-warning text-dark">
                                                    <i class="fas fa-clock"></i> Menunggu
                                                </span>
                                            @elseif($item->status_pengaduan == 'proses')
                                                <span class="badge bg-info">
                                                    <i class="fas fa-spinner"></i> Proses
                                                </span>
                                            @elseif($item->status_pengaduan == 'selesai')
                                                <span class="badge bg-success">
                                                    <i class="fas fa-check"></i> Selesai
                                                </span>
                                            @else
                                                <span class="badge bg-danger">
                                                    <i class="fas fa-times"></i> Ditolak
                                                </span>
                                            @endif
                                        </td>
                                        <td>
                                            <div>{{ $item->tanggal_pengaduan->format('d/m/Y') }}</div>
                                            <small class="text-muted">{{ $item->tanggal_pengaduan->format('H:i') }}</small>
                                        </td>
                                        <td>
                                            <div class="btn-group btn-group-sm">
                                                <a href="{{ route('whistleblower.show', $item->id) }}" 
                                                   class="btn btn-outline-primary">
                                                    <i class="fas fa-eye"></i> Detail
                                                </a>
                                                @if($item->status_pengaduan == 'pending')
                                                <button class="btn btn-outline-secondary dropdown-toggle" 
                                                        data-bs-toggle="dropdown">
                                                    <i class="fas fa-cog"></i>
                                                </button>
                                                <ul class="dropdown-menu">
                                                    <li>
                                                        <a class="dropdown-item" href="#" 
                                                           onclick="batalkanPengaduan('{{ $item->id }}')">
                                                            <i class="fas fa-times text-danger"></i> Batalkan
                                                        </a>
                                                    </li>
                                                </ul>
                                                @endif
                                            </div>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                        <!-- Pagination -->
                        <div class="d-flex justify-content-center mt-4">
                            {{ $pengaduan->appends(request()->query())->links() }}
                        </div>
                    @else
                        <div class="text-center py-5">
                            <i class="fas fa-inbox fa-4x text-muted mb-3"></i>
                            <h4 class="text-muted">Belum Ada Pengaduan</h4>
                            <p class="text-muted mb-4">
                                @if(request()->hasAny(['status', 'kategori', 'search']))
                                    Tidak ada pengaduan yang sesuai dengan filter yang Anda pilih.
                                @else
                                    Anda belum pernah membuat pengaduan. Mulai buat pengaduan pertama Anda.
                                @endif
                            </p>
                            @if(request()->hasAny(['status', 'kategori', 'search']))
                                <a href="{{ route('whistleblower.index') }}" class="btn btn-secondary me-2">
                                    <i class="fas fa-redo"></i> Reset Filter
                                </a>
                            @endif
                            <a href="{{ route('whistleblower.create') }}" class="btn btn-primary">
                                <i class="fas fa-plus"></i> Buat Pengaduan Pertama
                            </a>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal Konfirmasi Batalkan -->
<div class="modal fade" id="modalBatalkan" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Konfirmasi Batalkan Pengaduan</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <p>Apakah Anda yakin ingin membatalkan pengaduan ini?</p>
                <div class="alert alert-warning">
                    <i class="fas fa-exclamation-triangle"></i>
                    <strong>Perhatian:</strong> Pengaduan yang dibatalkan tidak dapat dikembalikan.
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                <form id="formBatalkan" method="POST" style="display: inline;">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger">
                        <i class="fas fa-trash"></i> Ya, Batalkan
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
function batalkanPengaduan(id) {
    const form = document.getElementById('formBatalkan');
    form.action = `/whistleblower/${id}`;
    
    const modal = new bootstrap.Modal(document.getElementById('modalBatalkan'));
    modal.show();
}
</script>
@endpush
@endsection