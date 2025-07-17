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
                                    <a class="nav-link active" href="{{ route('keuangan') }}">
                                        <i class="fas fa-tachometer-alt"></i> Dashboard
                                    </a>
                                </li>

                                {{-- Placeholder menu items --}}
                                <li class="nav-item">
                                    <a class="nav-link disabled" href="#" tabindex="-1" aria-disabled="true">
                                        <i class="fas fa-exchange-alt"></i> Transaksi
                                        <small class="text-muted">(dev)</small>
                                    </a>
                                </li>

                                <li class="nav-item">
                                    <a class="nav-link disabled" href="#" tabindex="-1" aria-disabled="true">
                                        <i class="fas fa-chart-line"></i> Laporan
                                        <small class="text-muted">(dev)</small>
                                    </a>
                                </li>

                                <li class="nav-item">
                                    <a class="nav-link disabled" href="#" tabindex="-1" aria-disabled="true">
                                        <i class="fas fa-cogs"></i> Master Data
                                        <small class="text-muted">(dev)</small>
                                    </a>
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
