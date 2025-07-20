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
                                        Dashboard
                                    </a>
                                </li>

                                {{-- Master Data --}}
                                <li class="nav-item dropdown">
                                    <a class="nav-link dropdown-toggle {{ Request::routeIs('keuangan.mata-anggaran*') ? 'active' : '' }}" href="#" id="navbarMaster" role="button"
                                       data-bs-toggle="dropdown" aria-expanded="false">
                                        Master Data
                                    </a>
                                    <ul class="dropdown-menu" aria-labelledby="navbarMaster">
                                        <li><a class="dropdown-item disabled" href="#" tabindex="-1" aria-disabled="true">Kategori Transaksi <small class="text-muted">(dev)</small></a></li>
                                        <li><a class="dropdown-item {{ Request::routeIs('keuangan.mata-anggaran*') ? 'active' : '' }}" href="{{ route('keuangan.mata-anggaran.index') }}">
                                                Mata Anggaran <span class="badge bg-success ms-1">Ready</span>
                                            </a></li>
                                        <li><a class="dropdown-item disabled" href="#" tabindex="-1" aria-disabled="true">Unit Kerja <small class="text-muted">(dev)</small></a></li>
                                        <li><hr class="dropdown-divider"></li>
                                        <li><a class="dropdown-item disabled" href="#" tabindex="-1" aria-disabled="true">Periode Akademik <small class="text-muted">(dev)</small></a></li>
                                        <li><a class="dropdown-item disabled" href="#" tabindex="-1" aria-disabled="true">Template Laporan <small class="text-muted">(dev)</small></a></li>
                                    </ul>
                                </li>

                                {{-- Laporan --}}
                                <li class="nav-item dropdown">
                                    <a class="nav-link dropdown-toggle {{ Request::routeIs('keuangan.laporan*') ? 'active' : '' }}"
                                       href="#" id="navbarLaporan" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                        Laporan
                                    </a>
                                    <ul class="dropdown-menu" aria-labelledby="navbarLaporan">
                                        <li>
                                            <h6 class="dropdown-header">Laporan Utama</h6>
                                        </li>
                                        <li><a class="dropdown-item" href="{{ route('keuangan.laporan') }}">
                                                Jurnal Pengeluaran
                                            </a></li>
                                        <li><a class="dropdown-item" href="{{ route('keuangan.laporan') }}">
                                                Jurnal Per Mata Anggaran
                                            </a></li>
                                        <li><a class="dropdown-item" href="{{ route('keuangan.laporan') }}">
                                                Buku Besar
                                            </a></li>
                                        <li><a class="dropdown-item" href="{{ route('keuangan.laporan') }}">
                                                Bukti Pengeluaran Kas
                                            </a></li>

                                        <li><hr class="dropdown-divider"></li>
                                        <li>
                                            <h6 class="dropdown-header">Laporan Khusus</h6>
                                        </li>
                                        <li><a class="dropdown-item" href="{{ route('keuangan.laporan') }}">
                                                Pembayaran Tugas Akhir
                                            </a></li>
                                        <li><a class="dropdown-item" href="{{ route('keuangan.laporan') }}">
                                                Honor Koreksi
                                            </a></li>
                                        <li><a class="dropdown-item" href="{{ route('keuangan.laporan') }}">
                                                Honor & Vakasi
                                            </a></li>
                                        <li><a class="dropdown-item" href="{{ route('keuangan.laporan') }}">
                                                Pengeluaran Fakultas
                                            </a></li>
                                    </ul>
                                </li>

                                {{-- Transaksi --}}
                                <li class="nav-item dropdown">
                                    <a class="nav-link dropdown-toggle disabled" href="#" id="navbarTransaksi" role="button"
                                       data-bs-toggle="dropdown" aria-expanded="false" tabindex="-1" aria-disabled="true">
                                        Transaksi
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
                            </ul>
                        </div>
                    </div>
                </nav>
            </div>
        </div>
    </div>
</div>
