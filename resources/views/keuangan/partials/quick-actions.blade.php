<div class="card">
    <div class="card-header" style="background-color: #fff; margin-top:10px">
        <div class="row">
            <div class="col-12">
                <h5 class="card-title">Aksi Cepat</h5>
            </div>
        </div>
    </div>
    <div class="card-body">
        <div class="row">
            <div class="col-md-6 mb-2">
                <button class="btn btn-primary w-100 quick-action-btn"
                        onclick="handleQuickAction('Input Transaksi')"
                        data-action="input-transaksi">
                    <i class="fas fa-plus"></i> Input Transaksi
                </button>
            </div>
            <div class="col-md-6 mb-2">
                <button class="btn btn-info w-100 quick-action-btn"
                        onclick="handleQuickAction('Review Transaksi')"
                        data-action="review-transaksi">
                    <i class="fas fa-list"></i> Review Transaksi
                </button>
            </div>
            <div class="col-md-6 mb-2">
                <a href="{{ route('keuangan.laporan') }}"
                   class="btn btn-success w-100 quick-action-btn"
                   data-action="laporan">
                    <i class="fas fa-file-alt"></i> Laporan
                </a>
            </div>
            <div class="col-md-6 mb-2">
                <button class="btn btn-warning w-100 quick-action-btn"
                        onclick="handleQuickAction('Master Data')"
                        data-action="master-data">
                    <i class="fas fa-cog"></i> Master Data
                </button>
            </div>
        </div>
    </div>
</div>
