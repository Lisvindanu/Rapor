<div class="menu-navbar">
    <div class="container">
        <div class="row justify-content-md-center">
            <div class="container">
                <nav class="navbar navbar-expand-lg navbar-light bg-light">
                    <div class="container-fluid">
                        <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                                data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent"
                                aria-expanded="false" aria-label="Toggle navigation">
                            <span class="navbar-toggler-icon"></span>
                        </button>

                        <div class="collapse navbar-collapse" id="navbarSupportedContent">
                            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                                {{-- Dashboard --}}
                                <li class="nav-item">
                                    <a class="nav-link {{ Request::routeIs('keuangan') ? 'active' : '' }}" href="{{ route('keuangan') }}">
                                        <i class="fas fa-tachometer-alt"></i> Dashboard
                                    </a>
                                </li>

                                {{-- Transaksi --}}
                                <li class="nav-item dropdown">
                                    <a class="nav-link dropdown-toggle disabled" href="#" id="navbarTransaksi" role="button"
                                       data-bs-toggle="dropdown" aria-expanded="false" tabindex="-1" aria-disabled="true">
                                        <i class="fas fa-exchange-alt"></i> Transaksi
                                        <small class="text-muted">(dev)</small>
                                    </a>
                                    <ul class="dropdown-menu" aria-labelledby="navbarTransaksi">
                                        <li><a class="dropdown-item disabled" href="#" tabindex="-1" aria-disabled="true">Input Transaksi</a></li>
                                        <li><a class="dropdown-item disabled" href="#" tabindex="-1" aria-disabled="true">Review Transaksi</a></li>
                                        <li><a class="dropdown-item disabled" href="#" tabindex="-1" aria-disabled="true">Approval</a></li>
                                        <li><hr class="dropdown-divider"></li>
                                        <li><a class="dropdown-item disabled" href="#" tabindex="-1" aria-disabled="true">Riwayat Transaksi</a></li>
                                    </ul>
                                </li>

                                {{-- Laporan --}}
                                <li class="nav-item dropdown">
                                    <a class="nav-link dropdown-toggle {{ Request::routeIs('keuangan.laporan*') ? 'active' : '' }}"
                                       href="#" id="navbarLaporan" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                        <i class="fas fa-chart-line"></i> Laporan
                                    </a>
                                    <ul class="dropdown-menu" aria-labelledby="navbarLaporan">
                                        <li>
                                            <h6 class="dropdown-header">Laporan Utama</h6>
                                        </li>
                                        <li><a class="dropdown-item" href="{{ route('keuangan.laporan') }}">
                                                <i class="fas fa-book"></i> Jurnal Pengeluaran
                                            </a></li>
                                        <li><a class="dropdown-item" href="{{ route('keuangan.laporan') }}">
                                                <i class="fas fa-list-alt"></i> Jurnal Per Mata Anggaran
                                            </a></li>
                                        <li><a class="dropdown-item" href="{{ route('keuangan.laporan') }}">
                                                <i class="fas fa-book-open"></i> Buku Besar
                                            </a></li>
                                        <li><a class="dropdown-item" href="{{ route('keuangan.laporan') }}">
                                                <i class="fas fa-receipt"></i> Bukti Pengeluaran Kas
                                            </a></li>

                                        <li><hr class="dropdown-divider"></li>
                                        <li>
                                            <h6 class="dropdown-header">Laporan Khusus</h6>
                                        </li>
                                        <li><a class="dropdown-item" href="{{ route('keuangan.laporan') }}">
                                                <i class="fas fa-graduation-cap"></i> Pembayaran Tugas Akhir
                                            </a></li>
                                        <li><a class="dropdown-item" href="{{ route('keuangan.laporan') }}">
                                                <i class="fas fa-edit"></i> Honor Koreksi
                                            </a></li>
                                        <li><a class="dropdown-item" href="{{ route('keuangan.laporan') }}">
                                                <i class="fas fa-money-bill"></i> Honor & Vakasi
                                            </a></li>
                                        <li><a class="dropdown-item" href="{{ route('keuangan.laporan') }}">
                                                <i class="fas fa-university"></i> Pengeluaran Fakultas
                                            </a></li>
                                    </ul>
                                </li>

                                {{-- Master Data --}}
                                <li class="nav-item dropdown">
                                    <a class="nav-link dropdown-toggle disabled" href="#" id="navbarMaster" role="button"
                                       data-bs-toggle="dropdown" aria-expanded="false" tabindex="-1" aria-disabled="true">
                                        <i class="fas fa-cogs"></i> Master Data
                                        <small class="text-muted">(dev)</small>
                                    </a>
                                    <ul class="dropdown-menu" aria-labelledby="navbarMaster">
                                        <li><a class="dropdown-item disabled" href="#" tabindex="-1" aria-disabled="true">Kategori Transaksi</a></li>
                                        <li><a class="dropdown-item disabled" href="#" tabindex="-1" aria-disabled="true">Mata Anggaran</a></li>
                                        <li><a class="dropdown-item disabled" href="#" tabindex="-1" aria-disabled="true">Unit Kerja</a></li>
                                        <li><hr class="dropdown-divider"></li>
                                        <li><a class="dropdown-item disabled" href="#" tabindex="-1" aria-disabled="true">Periode Akademik</a></li>
                                        <li><a class="dropdown-item disabled" href="#" tabindex="-1" aria-disabled="true">Template Laporan</a></li>
                                    </ul>
                                </li>
                            </ul>

                            {{-- Right side navigation --}}
                            <ul class="navbar-nav">
                                {{-- Development Status --}}
                                <li class="nav-item">
                                    <span class="navbar-text">
                                        <span class="badge bg-warning">
                                            <i class="fas fa-code"></i> In Development
                                        </span>
                                    </span>
                                </li>

                                {{-- Back to Main Menu --}}
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('gate') }}">
                                        <i class="fas fa-home"></i> Menu Utama
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </nav>
            </div>
        </div>
    </div>
</div>
