{{-- resources/views/keuangan/transaksi/pengeluaran/show.blade.php --}}
@extends('keuangan.transaksi.layouts.transaksi-show')

@php
    $headerConfig = [
        'title' => 'Detail Bukti Pengeluaran Kas',
        'description' => 'Rincian lengkap bukti pengeluaran kas nomor: ' . $pengeluaran->nomor_bukti,
        'breadcrumbs' => [
            ['text' => 'Dashboard', 'url' => route('gate')],
            ['text' => 'Keuangan', 'url' => route('keuangan')],
            ['text' => 'Transaksi', 'url' => route('keuangan.transaksi.dashboard')],
            ['text' => 'Pengeluaran Kas', 'url' => route('keuangan.pengeluaran.index')],
            ['text' => 'Detail #' . $pengeluaran->nomor_bukti, 'active' => true]
        ]
    ];
@endphp

@section('detail-content')
    <div class="row">
        <div class="col-lg-8">
            {{-- Main Detail Card --}}
            <div class="card mb-4">
                <div class="card-header">
                    <h6 class="m-0 font-weight-bold text-primary">
                        <i class="fas fa-file-invoice me-2"></i>Informasi Bukti Pengeluaran
                    </h6>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <table class="table table-borderless">
                                <tr>
                                    <td width="40%"><strong>Nomor Bukti:</strong></td>
                                    <td>
                                        <span class="badge bg-primary">{{ $pengeluaran->nomor_bukti }}</span>
                                    </td>
                                </tr>
                                <tr>
                                    <td><strong>Tanggal:</strong></td>
                                    <td>{{ $pengeluaran->tanggal ? $pengeluaran->tanggal->format('d F Y') : '-' }}</td>
                                </tr>
                                <tr>
                                    <td><strong>Sudah Terima Dari:</strong></td>
                                    <td>{{ $pengeluaran->sudah_terima_dari }}</td>
                                </tr>
                                <tr>
                                    <td><strong>Uang Sebanyak:</strong></td>
                                    <td>
                                        <strong class="text-success">
                                            Rp {{ number_format($pengeluaran->uang_sebanyak_angka, 0, ',', '.') }}
                                        </strong>
                                    </td>
                                </tr>
                                <tr>
                                    <td><strong>Terbilang:</strong></td>
                                    <td><em>{{ $pengeluaran->uang_sebanyak_huruf }}</em></td>
                                </tr>
                            </table>
                        </div>
                        <div class="col-md-6">
                            <table class="table table-borderless">
                                <tr>
                                    <td width="40%"><strong>Mata Anggaran:</strong></td>
                                    <td>
                                        {{ $pengeluaran->mataAnggaran->kode_mata_anggaran ?? '-' }}<br>
                                        <small class="text-muted">{{ $pengeluaran->mataAnggaran->nama_mata_anggaran ?? '-' }}</small>
                                    </td>
                                </tr>
                                <tr>
                                    <td><strong>Program:</strong></td>
                                    <td>{{ $pengeluaran->program->nama_program ?? '-' }}</td>
                                </tr>
                                <tr>
                                    <td><strong>Sumber Dana:</strong></td>
                                    <td>{{ $pengeluaran->sumberDana->nama_sumber_dana ?? '-' }}</td>
                                </tr>
                                <tr>
                                    <td><strong>Tahun Anggaran:</strong></td>
                                    <td>{{ $pengeluaran->tahunAnggaran->tahun ?? '-' }}</td>
                                </tr>
                                <tr>
                                    <td><strong>Status:</strong></td>
                                    <td>
                                        @php
                                            $badgeClass = match($pengeluaran->status) {
                                                'draft' => 'secondary',
                                                'pending' => 'warning',
                                                'approved' => 'success',
                                                'rejected' => 'danger',
                                                'paid' => 'info',
                                                default => 'secondary'
                                            };
                                            $statusLabel = match($pengeluaran->status) {
                                                'draft' => 'Draft',
                                                'pending' => 'Pending',
                                                'approved' => 'Disetujui',
                                                'rejected' => 'Ditolak',
                                                'paid' => 'Dibayar',
                                                default => ucfirst($pengeluaran->status)
                                            };
                                        @endphp
                                        <span class="badge bg-{{ $badgeClass }}">{{ $statusLabel }}</span>
                                    </td>
                                </tr>
                            </table>
                        </div>
                    </div>

                    @if($pengeluaran->untuk_pembayaran)
                        <div class="row mt-3">
                            <div class="col-12">
                                <div class="alert alert-info">
                                    <strong><i class="fas fa-info-circle me-2"></i>Untuk Pembayaran:</strong><br>
                                    {{ $pengeluaran->untuk_pembayaran }}
                                </div>
                            </div>
                        </div>
                    @endif
                </div>
            </div>

            {{-- Approval Info --}}
            @if($pengeluaran->status !== 'draft')
                <div class="card">
                    <div class="card-header">
                        <h6 class="m-0 font-weight-bold text-primary">
                            <i class="fas fa-signature me-2"></i>Informasi Persetujuan
                        </h6>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-3">
                                <div class="text-center">
                                    <h6>Dekan</h6>
                                    @if($pengeluaran->dekan)
                                        <p class="mb-1"><strong>{{ $pengeluaran->dekan->nama }}</strong></p>
                                        <small class="text-muted">{{ $pengeluaran->dekan->jabatan }}</small>
                                    @else
                                        <p class="text-muted">Belum ditentukan</p>
                                    @endif
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="text-center">
                                    <h6>Wakil Dekan II</h6>
                                    @if($pengeluaran->wakilDekanII)
                                        <p class="mb-1"><strong>{{ $pengeluaran->wakilDekanII->nama }}</strong></p>
                                        <small class="text-muted">{{ $pengeluaran->wakilDekanII->jabatan }}</small>
                                    @else
                                        <p class="text-muted">Belum ditentukan</p>
                                    @endif
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="text-center">
                                    <h6>KSB Keuangan</h6>
                                    @if($pengeluaran->ksbKeuangan)
                                        <p class="mb-1"><strong>{{ $pengeluaran->ksbKeuangan->nama }}</strong></p>
                                        <small class="text-muted">{{ $pengeluaran->ksbKeuangan->jabatan }}</small>
                                    @else
                                        <p class="text-muted">Belum ditentukan</p>
                                    @endif
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="text-center">
                                    <h6>Penerima</h6>
                                    @if($pengeluaran->penerima)
                                        <p class="mb-1"><strong>{{ $pengeluaran->penerima->nama }}</strong></p>
                                        <small class="text-muted">{{ $pengeluaran->penerima->jabatan }}</small>
                                    @else
                                        <p class="text-muted">Belum ditentukan</p>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endif
        </div>

        <div class="col-lg-4">
            {{-- Action Card --}}
            <div class="card">
                <div class="card-header">
                    <h6 class="m-0 font-weight-bold text-primary">
                        <i class="fas fa-cogs me-2"></i>Aksi
                    </h6>
                </div>
                <div class="card-body">
                    <div class="d-grid gap-2">
                        @if($pengeluaran->canBeEdited())
                            <a href="{{ route('keuangan.pengeluaran.edit', $pengeluaran->id) }}"
                               class="btn btn-warning">
                                <i class="fas fa-edit me-2"></i>Edit Data
                            </a>
                        @endif

                        <a href="{{ route('keuangan.pengeluaran.print', $pengeluaran->id) }}"
                           class="btn btn-secondary" target="_blank">
                            <i class="fas fa-print me-2"></i>Print Bukti
                        </a>

                        <a href="{{ route('keuangan.pengeluaran.pdf', $pengeluaran->id) }}"
                           class="btn btn-danger">
                            <i class="fas fa-file-pdf me-2"></i>Download PDF
                        </a>

                        <a href="{{ route('keuangan.pengeluaran.index') }}"
                           class="btn btn-outline-primary">
                            <i class="fas fa-arrow-left me-2"></i>Kembali ke Daftar
                        </a>

                        @if($pengeluaran->canBeDeleted())
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
        </div>
    </div>
@endsection
