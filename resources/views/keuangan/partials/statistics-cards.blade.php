{{-- Statistics Cards (BTQ Pattern) --}}
<div class="" style="margin-top: 15px">
    <div class="row justify-content-md-center">
        <div class="col-3">
            <div class="card bg-success text-white mb-3 stats-card" data-stat="pemasukan">
                <div class="card-body">
                    <h3 class="card-title">Rp {{ number_format($totalPemasukan ?? 15750000, 0, ',', '.') }}</h3>
                    <p class="card-text">Total Pemasukan</p>
                </div>
            </div>
        </div>
        <div class="col-3">
            <div class="card bg-danger text-white mb-3 stats-card" data-stat="pengeluaran">
                <div class="card-body">
                    <h3 class="card-title">Rp {{ number_format($totalPengeluaran ?? 12300000, 0, ',', '.') }}</h3>
                    <p class="card-text">Total Pengeluaran</p>
                </div>
            </div>
        </div>
        <div class="col-3">
            <div class="card bg-primary text-white mb-3 stats-card" data-stat="saldo">
                <div class="card-body">
                    <h3 class="card-title">Rp {{ number_format($saldo ?? 3450000, 0, ',', '.') }}</h3>
                    <p class="card-text">Saldo</p>
                </div>
            </div>
        </div>
        <div class="col-3">
            <div class="card bg-info text-white mb-3 stats-card" data-stat="transaksi">
                <div class="card-body">
                    <h3 class="card-title">{{ $totalTransaksi ?? 47 }}</h3>
                    <p class="card-text">Total Transaksi</p>
                </div>
            </div>
        </div>
    </div>
</div>
