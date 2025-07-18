{{-- resources/views/whistleblower/navbar.blade.php --}}
<div class="menu-navbar">
    <div class="container">
        <div class="row justify-content-md-center">
            <div class="container">
                <nav class="navbar navbar-expand-sm navbar-light bg-light">
                    <div class="">
                        <div class="collapse navbar-collapse" id="navbarSupportedContent">
                            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                                <!-- Dashboard -->
                                <li class="nav-item">
                                    <a class="nav-link {{ request()->routeIs('whistleblower.user.dashboard', 'whistleblower.dashboard') ? 'active' : '' }}"
                                        href="{{ route('whistleblower.user.dashboard') }}">
                                        Dashboard
                                    </a>
                                </li>

                                <!-- Pengaduan -->
                                <li class="nav-item dropdown">
                                    <a class="nav-link dropdown-toggle {{ request()->routeIs('whistleblower.*') && !request()->routeIs('whistleblower.admin.*') ? 'active' : '' }}"
                                        href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                        Pengaduan
                                    </a>
                                    <ul class="dropdown-menu">
                                        <li>
                                            <a class="dropdown-item {{ request()->routeIs('whistleblower.create') ? 'active' : '' }}"
                                                href="{{ route('whistleblower.create') }}">
                                                Buat Pengaduan
                                            </a>
                                        </li>
                                        <li>
                                            <a class="dropdown-item {{ request()->routeIs('whistleblower.index') ? 'active' : '' }}"
                                                href="{{ route('whistleblower.index') }}">
                                                Riwayat Pengaduan
                                            </a>
                                        </li>
                                        <li>
                                            <hr class="dropdown-divider">
                                        </li>
                                        <li>
                                            <a class="dropdown-item" href="{{ route('whistleblower.status-page') }}">
                                                Cek Status (Anonim)
                                            </a>
                                        </li>
                                    </ul>
                                </li>

                                <!-- Informasi -->
                                <li class="nav-item dropdown">
                                    <a class="nav-link dropdown-toggle" href="#" role="button"
                                        data-bs-toggle="dropdown" aria-expanded="false">
                                        Informasi
                                    </a>
                                    <ul class="dropdown-menu">
                                        <li>
                                            <a class="dropdown-item" href="#" data-bs-toggle="modal"
                                                data-bs-target="#modalPanduan">
                                                Panduan Pelaporan
                                            </a>
                                        </li>
                                        <li>
                                            <a class="dropdown-item" href="#" data-bs-toggle="modal"
                                                data-bs-target="#modalKategori">
                                                Kategori Pengaduan
                                            </a>
                                        </li>
                                        <li>
                                            <a class="dropdown-item" href="#" data-bs-toggle="modal"
                                                data-bs-target="#modalPrivasi">
                                                Kebijakan Privasi
                                            </a>
                                        </li>
                                        <li>
                                            <hr class="dropdown-divider">
                                        </li>
                                        <li>
                                            <a class="dropdown-item" href="#" data-bs-toggle="modal"
                                                data-bs-target="#modalKontak">
                                                Kontak Darurat
                                            </a>
                                        </li>
                                    </ul>
                                </li>

                                <!-- Bantuan -->
                                <li class="nav-item">
                                    <a class="nav-link" href="#" data-bs-toggle="modal"
                                        data-bs-target="#modalBantuan">
                                        Bantuan
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

{{-- Modal Panduan --}}
<div class="modal fade" id="modalPanduan" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Panduan Pelaporan</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <h6>Langkah-langkah Pelaporan:</h6>
                <ol>
                    <li>Klik menu "Buat Pengaduan"</li>
                    <li>Pilih kategori pengaduan yang sesuai</li>
                    <li>Isi detail pengaduan dengan jelas dan lengkap</li>
                    <li>Lampirkan bukti jika ada</li>
                    <li>Pilih apakah ingin melaporkan secara anonim atau tidak</li>
                    <li>Submit pengaduan</li>
                    <li>Catat kode pengaduan untuk tracking</li>
                </ol>

                <div class="alert alert-info mt-3">
                    <strong>Tips:</strong> Berikan informasi yang lengkap dan akurat untuk membantu proses investigasi.
                </div>
            </div>
        </div>
    </div>
</div>

{{-- Modal Kategori --}}
<div class="modal fade" id="modalKategori" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Kategori Pengaduan</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <ul class="list-group list-group-flush">
                    <li class="list-group-item">
                        <strong>Kekerasan Seksual</strong>
                        <p class="text-muted mb-0">Tindakan pelecehan atau kekerasan yang bersifat seksual</p>
                    </li>
                    <li class="list-group-item">
                        <strong>Pelecehan Seksual</strong>
                        <p class="text-muted mb-0">Ucapan, gesture, atau perilaku yang tidak pantas</p>
                    </li>
                    <li class="list-group-item">
                        <strong>Diskriminasi</strong>
                        <p class="text-muted mb-0">Perlakuan tidak adil berdasarkan gender, ras, agama, dll</p>
                    </li>
                    <li class="list-group-item">
                        <strong>Bullying/Perundungan</strong>
                        <p class="text-muted mb-0">Tindakan intimidasi atau perundungan</p>
                    </li>
                    <li class="list-group-item">
                        <strong>Penyalahgunaan Wewenang</strong>
                        <p class="text-muted mb-0">Penggunaan posisi untuk tindakan yang tidak semestinya</p>
                    </li>
                    <li class="list-group-item">
                        <strong>Cyber Bullying</strong>
                        <p class="text-muted mb-0">Tindakan intimidasi, pelecehan, atau perundungan yang dilakukan
                            melalui media digital atau online</p>
                    </li>
                    <li class="list-group-item">
                        <strong>Lainnya</strong>
                        <p class="text-muted mb-0">Kategori lain yang berkaitan dengan PPKPT</p>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</div>

{{-- Modal Privasi --}}
<div class="modal fade" id="modalPrivasi" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Kebijakan Privasi</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <h6>Perlindungan Data Pribadi:</h6>
                <ul>
                    <li>Identitas pelapor akan dijaga kerahasiaannya</li>
                    <li>Data pengaduan hanya dapat diakses oleh tim PPKPT yang berwenang</li>
                    <li>Informasi tidak akan disebarluaskan tanpa persetujuan</li>
                    <li>Sistem menggunakan enkripsi untuk keamanan data</li>
                </ul>

                <h6 class="mt-3">Hak Pelapor:</h6>
                <ul>
                    <li>Hak untuk mendapat perlindungan dari tindakan balasan</li>
                    <li>Hak untuk mendapat informasi tentang progress pengaduan</li>
                    <li>Hak untuk mendapat pendampingan jika diperlukan</li>
                    <li>Hak untuk mengajukan banding jika tidak puas dengan penanganan</li>
                </ul>
            </div>
        </div>
    </div>
</div>

{{-- Modal Kontak --}}
<div class="modal fade" id="modalKontak" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-success text-white">
                <h5 class="modal-title">
                    <i class="fas fa-phone"></i> Kontak Darurat PPKPT
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-6">
                        <h6>Hotline Telepon</h6>
                        <p>
                            <i class="fas fa-phone text-success"></i> 0274-123456<br>
                            <small class="text-muted">24 jam setiap hari</small>
                        </p>

                        <h6>WhatsApp</h6>
                        <p>
                            <i class="fab fa-whatsapp text-success"></i> 08123456789<br>
                            <small class="text-muted">Chat & Voice Call</small>
                        </p>
                    </div>
                    <div class="col-md-6">
                        <h6>Email</h6>
                        <p>
                            <i class="fas fa-envelope text-primary"></i> ppkpt@university.ac.id<br>
                            <small class="text-muted">Respon dalam 6 jam</small>
                        </p>

                        <h6>Live Chat</h6>
                        <p>
                            <span class="badge bg-success">Online</span><br>
                            <small class="text-muted">Tersedia di website</small>
                        </p>
                    </div>
                </div>

                <div class="alert alert-danger mt-3">
                    <h6><i class="fas fa-exclamation-triangle"></i> Kondisi Darurat</h6>
                    <p class="mb-0">Jika dalam kondisi darurat yang mengancam keselamatan, segera hubungi:</p>
                    <ul class="mb-0 mt-2">
                        <li>Polisi: <strong>110</strong></li>
                        <li>Ambulans: <strong>118</strong></li>
                        <li>Pemadam Kebakaran: <strong>113</strong></li>
                    </ul>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                <a href="tel:0274123456" class="btn btn-success">
                    <i class="fas fa-phone"></i> Hubungi Sekarang
                </a>
            </div>
        </div>
    </div>
</div>

{{-- Modal Bantuan --}}
<div class="modal fade" id="modalBantuan" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Bantuan & FAQ</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <div class="accordion" id="accordionBantuan">
                    <div class="accordion-item">
                        <h2 class="accordion-header">
                            <button class="accordion-button" type="button" data-bs-toggle="collapse"
                                data-bs-target="#collapseOne">
                                Bagaimana cara membuat pengaduan?
                            </button>
                        </h2>
                        <div id="collapseOne" class="accordion-collapse collapse show"
                            data-bs-parent="#accordionBantuan">
                            <div class="accordion-body">
                                Klik menu "Pengaduan" > "Buat Pengaduan", lalu ikuti langkah-langkah yang tersedia.
                            </div>
                        </div>
                    </div>
                    <div class="accordion-item">
                        <h2 class="accordion-header">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                data-bs-target="#collapseTwo">
                                Apakah pengaduan saya akan dirahasiakan?
                            </button>
                        </h2>
                        <div id="collapseTwo" class="accordion-collapse collapse" data-bs-parent="#accordionBantuan">
                            <div class="accordion-body">
                                Ya, identitas Anda akan dijaga kerahasiaannya sesuai dengan protokol PPKPT.
                            </div>
                        </div>
                    </div>
                    <div class="accordion-item">
                        <h2 class="accordion-header">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                data-bs-target="#collapseThree">
                                Berapa lama proses penanganan pengaduan?
                            </button>
                        </h2>
                        <div id="collapseThree" class="accordion-collapse collapse"
                            data-bs-parent="#accordionBantuan">
                            <div class="accordion-body">
                                Tim PPKPT akan merespons dalam maksimal 3x24 jam. Proses investigasi bervariasi
                                tergantung kompleksitas kasus.
                            </div>
                        </div>
                    </div>
                    <div class="accordion-item">
                        <h2 class="accordion-header">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                data-bs-target="#collapseFour">
                                Bagaimana jika saya lupa kode pengaduan?
                            </button>
                        </h2>
                        <div id="collapseFour" class="accordion-collapse collapse"
                            data-bs-parent="#accordionBantuan">
                            <div class="accordion-body">
                                Hubungi tim PPKPT melalui hotline 0274-123456 atau email ppkpt@university.ac.id dengan
                                menyertakan informasi identitas dan perkiraan tanggal pengaduan.
                            </div>
                        </div>
                    </div>
                    <div class="accordion-item">
                        <h2 class="accordion-header">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                data-bs-target="#collapseFive">
                                Apakah saya bisa mengubah pengaduan yang sudah dikirim?
                            </button>
                        </h2>
                        <div id="collapseFive" class="accordion-collapse collapse"
                            data-bs-parent="#accordionBantuan">
                            <div class="accordion-body">
                                Pengaduan yang sudah dikirim tidak dapat diubah. Namun, Anda dapat menghubungi tim PPKPT
                                untuk memberikan informasi tambahan terkait pengaduan Anda.
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                <a href="#" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalKontak">
                    <i class="fas fa-phone"></i> Hubungi Tim
                </a>
            </div>
        </div>
    </div>
</div>
