{{-- resources/views/keuangan/transaksi/partials/action-buttons.blade.php --}}
{{-- Action Card --}}
<div class="card">
    <div class="card-header">
        <h6 class="m-0 font-weight-bold text-primary">
            <i class="fas fa-cogs me-2"></i>Aksi
        </h6>
    </div>
    <div class="card-body">
        <div class="d-grid gap-2">
            @if(isset($pengeluaran) && $pengeluaran->canBeEdited())
                <a href="{{ route('keuangan.pengeluaran.edit', $pengeluaran->id) }}"
                   class="btn btn-warning">
                    <i class="fas fa-edit me-2"></i>Edit Data
                </a>
            @endif

            @if(isset($pengeluaran))
                <a href="{{ route('keuangan.pengeluaran.print', $pengeluaran->id) }}"
                   class="btn btn-secondary" target="_blank">
                    <i class="fas fa-print me-2"></i>Print Bukti
                </a>

                <a href="{{ route('keuangan.pengeluaran.pdf', $pengeluaran->id) }}"
                   class="btn btn-danger">
                    <i class="fas fa-file-pdf me-2"></i>Download PDF
                </a>
            @endif

            <a href="{{ route('keuangan.pengeluaran.index') }}"
               class="btn btn-outline-primary">
                <i class="fas fa-arrow-left me-2"></i>Kembali ke Daftar
            </a>

            @if(isset($pengeluaran) && method_exists($pengeluaran, 'canBeDeleted') && $pengeluaran->canBeDeleted())
                <button type="button"
                        class="btn btn-outline-danger delete-btn"
                        data-url="{{ route('keuangan.pengeluaran.destroy', $pengeluaran->id) }}"
                        data-name="{{ $pengeluaran->nomor_bukti }}">
                    <i class="fas fa-trash me-2"></i>Hapus Data
                </button>
            @endif
        </div>
    </div>
</div>

{{-- Info Card --}}
@if(isset($pengeluaran))
    <div class="card mt-3">
        <div class="card-header">
            <h6 class="m-0 font-weight-bold text-info">
                <i class="fas fa-info-circle me-2"></i>Informasi
            </h6>
        </div>
        <div class="card-body">
            <small class="text-muted">
                <strong>Dibuat:</strong> {{ $pengeluaran->created_at->format('d F Y H:i') }}<br>
                <strong>Diubah:</strong> {{ $pengeluaran->updated_at->format('d F Y H:i') }}
            </small>
        </div>
    </div>
@endif
