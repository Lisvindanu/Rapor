{{-- resources/views/keuangan/master/tanda-tangan/show.blade.php --}}
@extends('layouts.main2')

@section('css-tambahan')
    @include('keuangan.master.partials.styles')
    <style>
        .signature-display {
            border: 1px solid #dee2e6;
            border-radius: 8px;
            padding: 20px;
            background-color: white;
            text-align: center;
            margin: 20px 0;
        }

        .signature-display img {
            max-width: 100%;
            max-height: 200px;
            border: 1px solid #dee2e6;
            border-radius: 4px;
            background-color: #f8f9fa;
        }

        .no-signature {
            color: #6c757d;
            font-style: italic;
            padding: 40px;
        }

        .info-item {
            background-color: white;
            border-radius: 8px;
            padding: 15px;
            margin-bottom: 15px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }

        .info-label {
            font-weight: 600;
            color: #495057;
            font-size: 0.9rem;
            margin-bottom: 5px;
        }

        .info-value {
            font-size: 1.1rem;
            color: #212529;
        }

        .badge-custom {
            font-size: 0.9rem;
            padding: 8px 12px;
        }
    </style>
@endsection

@section('navbar')
    @include('keuangan.navbar')
@endsection

@section('konten')
    <div class="container">
        @include('keuangan.master.partials.header')
        @include('komponen.message-alert')

        <div class="row mb-4">
            <div class="col">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h4 class="mb-1">Detail Penanda Tangan</h4>
                        <p class="text-muted mb-0">Informasi detail penanda tangan: {{ $tandaTangan->nama }}</p>
                    </div>
                    <div>
                        <a href="{{ route('keuangan.tanda-tangan.edit', $tandaTangan->id) }}" class="btn btn-warning me-2">
                            <i class="fas fa-edit me-1"></i>Edit
                        </a>
                        <a href="{{ route('keuangan.tanda-tangan.index') }}" class="btn btn-outline-secondary">
                            <i class="fas fa-arrow-left me-1"></i>Kembali
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-6">
                <div class="card shadow-sm">
                    <div class="card-header bg-white">
                        <h5 class="card-title mb-0">
                            <i class="fas fa-info-circle me-2 text-primary"></i>
                            Informasi Penanda Tangan
                        </h5>
                    </div>
                    <div class="card-body">
                        <div class="info-item">
                            <div class="info-label">Nomor TTD</div>
                            <div class="info-value">
                                <span class="badge bg-primary badge-custom">{{ $tandaTangan->nomor_ttd }}</span>
                            </div>
                        </div>

                        <div class="info-item">
                            <div class="info-label">Nama Lengkap</div>
                            <div class="info-value">{{ $tandaTangan->nama }}</div>
                        </div>

                        <div class="info-item">
                            <div class="info-label">Jabatan</div>
                            <div class="info-value">{{ $tandaTangan->jabatan }}</div>
                        </div>

                        <div class="info-item">
                            <div class="info-label">Tanggal Dibuat</div>
                            <div class="info-value">
                                <i class="fas fa-calendar me-1 text-muted"></i>
                                {{ $tandaTangan->formatted_created_at }}
                            </div>
                        </div>

                        <div class="info-item">
                            <div class="info-label">Status Tanda Tangan</div>
                            <div class="info-value">
                                @if($tandaTangan->has_image)
                                    <span class="badge bg-success badge-custom">
                                        <i class="fas fa-check me-1"></i>Tersedia
                                    </span>
                                @else
                                    <span class="badge bg-warning badge-custom">
                                        <i class="fas fa-exclamation-triangle me-1"></i>Belum Upload
                                    </span>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-6">
                <div class="card shadow-sm">
                    <div class="card-header bg-white">
                        <h5 class="card-title mb-0">
                            <i class="fas fa-signature me-2 text-primary"></i>
                            Gambar Tanda Tangan
                        </h5>
                    </div>
                    <div class="card-body">
                        <div class="signature-display">
                            @if($tandaTangan->has_image)
                                <img src="{{ $tandaTangan->image_preview }}"
                                     alt="Tanda Tangan {{ $tandaTangan->nama }}"
                                     class="img-fluid">
                                <div class="mt-3">
                                    <small class="text-muted">
                                        <i class="fas fa-info-circle me-1"></i>
                                        Tanda tangan digital tersimpan dalam format base64
                                    </small>
                                </div>
                            @else
                                <div class="no-signature">
                                    <i class="fas fa-signature fa-3x mb-3 text-muted"></i>
                                    <p class="mb-0">Belum ada gambar tanda tangan</p>
                                    <small>Klik tombol "Edit" untuk menambahkan tanda tangan</small>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row mt-4">
            <div class="col">
                <div class="card shadow-sm">
                    <div class="card-header bg-white">
                        <h5 class="card-title mb-0">
                            <i class="fas fa-cogs me-2 text-primary"></i>
                            Aksi Tersedia
                        </h5>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-4">
                                <div class="d-grid">
                                    <a href="{{ route('keuangan.tanda-tangan.edit', $tandaTangan->id) }}"
                                       class="btn btn-warning">
                                        <i class="fas fa-edit me-2"></i>Edit Data
                                    </a>
                                </div>
                                <small class="text-muted d-block mt-2 text-center">
                                    Mengubah informasi atau tanda tangan
                                </small>
                            </div>
                            <div class="col-md-4">
                                <div class="d-grid">
                                    <button type="button"
                                            class="btn btn-danger"
                                            onclick="confirmDelete('{{ $tandaTangan->id }}', '{{ $tandaTangan->nama }}')">
                                        <i class="fas fa-trash me-2"></i>Hapus Data
                                    </button>
                                </div>
                                <small class="text-muted d-block mt-2 text-center">
                                    Menghapus penanda tangan secara permanen
                                </small>
                            </div>
                            <div class="col-md-4">
                                <div class="d-grid">
                                    <a href="{{ route('keuangan.tanda-tangan.index') }}"
                                       class="btn btn-outline-secondary">
                                        <i class="fas fa-list me-2"></i>Daftar Semua
                                    </a>
                                </div>
                                <small class="text-muted d-block mt-2 text-center">
                                    Kembali ke daftar penanda tangan
                                </small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="deleteModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">
                        <i class="fas fa-exclamation-triangle text-warning me-2"></i>
                        Konfirmasi Hapus
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <p>Apakah Anda yakin ingin menghapus penanda tangan <strong id="deleteName"></strong>?</p>
                    <div class="alert alert-warning">
                        <i class="fas fa-exclamation-triangle me-2"></i>
                        <strong>Peringatan:</strong> Tindakan ini tidak dapat dibatalkan!
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <form id="deleteForm" method="POST" style="display: inline;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger">
                            <i class="fas fa-trash me-1"></i>Ya, Hapus
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('js-tambahan')
    @include('keuangan.master.partials.scripts')
    <script>
        function confirmDelete(id, name) {
            document.getElementById('deleteName').textContent = name;
            document.getElementById('deleteForm').action =
                "{{ route('keuangan.tanda-tangan.destroy', ':id') }}".replace(':id', id);

            const modal = new bootstrap.Modal(document.getElementById('deleteModal'));
            modal.show();
        }
    </script>
@endsection
