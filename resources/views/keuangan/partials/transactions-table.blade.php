<div class="card">
    <div class="card-header" style="background-color: #fff; margin-top:10px">
        <div class="row">
            <div class="col-8">
                <h5 class="card-title">Preview Transaksi Terbaru</h5>
            </div>
            <div class="col-4">
                <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                    <button class="btn btn-primary" onclick="handleViewAllTransactions()">
                        Lihat Semua
                    </button>
                </div>
            </div>
        </div>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-hover" id="transactionsTable">
                <thead class="table-light">
                <tr>
                    <th>Tanggal</th>
                    <th>No. Transaksi</th>
                    <th>Kategori</th>
                    <th>Penerima</th>
                    <th>Jumlah</th>
                    <th>Status</th>
                    <th>Aksi</th>
                </tr>
                </thead>
                <tbody>
                @if(isset($recentTransactions) && count($recentTransactions) > 0)
                    @foreach($recentTransactions as $transaction)
                        <tr class="transaction-row" data-transaction-id="{{ $transaction['no_transaksi'] ?? '' }}">
                            <td>{{ $transaction['tanggal'] ?? '' }}</td>
                            <td>{{ $transaction['no_transaksi'] ?? '' }}</td>
                            <td>
                                    <span class="badge bg-{{ $transaction['kategori_class'] ?? 'secondary' }}">
                                        {{ $transaction['kategori'] ?? '' }}
                                    </span>
                            </td>
                            <td>{{ $transaction['penerima'] ?? '' }}</td>
                            <td class="text-{{ $transaction['jumlah_class'] ?? 'dark' }}">
                                {{ $transaction['jumlah_prefix'] ?? '' }}Rp {{ number_format($transaction['jumlah'] ?? 0, 0, ',', '.') }}
                            </td>
                            <td>
                                    <span class="badge bg-{{ $transaction['status_class'] ?? 'secondary' }}">
                                        {{ $transaction['status'] ?? '' }}
                                    </span>
                            </td>
                            <td>
                                <button class="btn btn-sm btn-{{ $transaction['action_class'] ?? 'outline-primary' }}"
                                        onclick="handleTransactionAction('{{ $transaction['action_type'] ?? 'view' }}', '{{ $transaction['no_transaksi'] ?? '' }}')"
                                        data-action="{{ $transaction['action_type'] ?? 'view' }}">
                                    <i class="fas fa-{{ $transaction['action_icon'] ?? 'eye' }}"></i>
                                </button>
                            </td>
                        </tr>
                    @endforeach
                @else
                    {{-- Default mock data when no data from controller --}}
                    @include('keuangan.partials.default-transactions')
                @endif
                </tbody>
            </table>
        </div>
        <small class="text-muted">
            Showing {{ isset($recentTransactions) ? count($recentTransactions) : 3 }} of {{ $totalTransaksi ?? 47 }} entries
            @if(!isset($recentTransactions) || count($recentTransactions) == 0)
                (mock data)
            @endif
        </small>
    </div>
</div>
