{{-- resources/views/whistleblower/admin/navbar.blade.php --}}
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
                                    <a class="nav-link {{ request()->routeIs('whistleblower.admin.dashboard') ? 'active' : '' }}" 
                                       href="{{ route('whistleblower.admin.dashboard') }}">
                                        Dashboard Admin
                                    </a>
                                </li>
                                
                                <!-- Manajemen Pengaduan -->
                                <li class="nav-item dropdown">
                                    <a class="nav-link dropdown-toggle {{ request()->routeIs('whistleblower.admin.pengaduan.*') ? 'active' : '' }}" 
                                       href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                        Kelola Pengaduan
                                    </a>
                                    <ul class="dropdown-menu">
                                        <li>
                                            <a class="dropdown-item {{ request()->routeIs('whistleblower.admin.pengaduan.index') && !request()->has('status') ? 'active' : '' }}" 
                                               href="{{ route('whistleblower.admin.pengaduan.index') }}">
                                                <i class="fas fa-list"></i> Semua Pengaduan
                                            </a>
                                        </li>
                                        <li>
                                            <a class="dropdown-item {{ request('status') == 'pending' ? 'active' : '' }}" 
                                               href="{{ route('whistleblower.admin.pengaduan.index') }}?status=pending">
                                                <i class="fas fa-clock text-warning"></i> Menunggu Review
                                            </a>
                                        </li>
                                        <li>
                                            <a class="dropdown-item {{ request('status') == 'proses' ? 'active' : '' }}" 
                                               href="{{ route('whistleblower.admin.pengaduan.index') }}?status=proses">
                                                <i class="fas fa-spinner text-info"></i> Dalam Proses
                                            </a>
                                        </li>
                                        <li>
                                            <a class="dropdown-item {{ request('filter') == 'prioritas' ? 'active' : '' }}" 
                                               href="{{ route('whistleblower.admin.pengaduan.index') }}?filter=prioritas">
                                                <i class="fas fa-exclamation-triangle text-danger"></i> Pengaduan Prioritas
                                            </a>
                                        </li>
                                        <li><hr class="dropdown-divider"></li>
                                        <li>
                                            <a class="dropdown-item {{ request('status') == 'selesai' ? 'active' : '' }}" 
                                               href="{{ route('whistleblower.admin.pengaduan.index') }}?status=selesai">
                                                <i class="fas fa-check text-success"></i> Pengaduan Selesai
                                            </a>
                                        </li>
                                        <li>
                                            <a class="dropdown-item {{ request('status') == 'ditolak' ? 'active' : '' }}" 
                                               href="{{ route('whistleblower.admin.pengaduan.index') }}?status=ditolak">
                                                <i class="fas fa-times text-danger"></i> Pengaduan Ditolak
                                            </a>
                                        </li>
                                    </ul>
                                </li>
                                
                                <!-- Laporan & Analisis -->
                                <li class="nav-item dropdown">
                                    <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                        Laporan & Analisis
                                    </a>
                                    <ul class="dropdown-menu">
                                        <li>
                                            <a class="dropdown-item" href="#" data-bs-toggle="modal" data-bs-target="#modalLaporan">
                                                <i class="fas fa-file-alt"></i> Generate Laporan
                                            </a>
                                        </li>
                                        <li>
                                            <a class="dropdown-item" href="#">
                                                <i class="fas fa-chart-bar"></i> Statistik Pengaduan
                                            </a>
                                        </li>
                                        <li>
                                            <a class="dropdown-item" href="#">
                                                <i class="fas fa-chart-line"></i> Trend Analysis
                                            </a>
                                        </li>
                                        <li><hr class="dropdown-divider"></li>
                                        <li>
                                            <a class="dropdown-item" href="{{ route('whistleblower.admin.pengaduan.export') }}">
                                                <i class="fas fa-download"></i> Export Data
                                            </a>
                                        </li>
                                    </ul>
                                </li>

                                <!-- Pengaturan -->
                                <li class="nav-item dropdown">
                                    <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                        Pengaturan
                                    </a>
                                    <ul class="dropdown-menu">
                                        <li>
                                            <a class="dropdown-item" href="#">
                                                <i class="fas fa-tags"></i> Kategori Pengaduan
                                            </a>
                                        </li>
                                        <li>
                                            <a class="dropdown-item" href="#">
                                                <i class="fas fa-file-alt"></i> Template Response
                                            </a>
                                        </li>
                                        <li>
                                            <a class="dropdown-item" href="#">
                                                <i class="fas fa-users"></i> Manajemen Tim
                                            </a>
                                        </li>
                                        <li><hr class="dropdown-divider"></li>
                                        <li>
                                            <a class="dropdown-item" href="#">
                                                <i class="fas fa-bell"></i> Notifikasi
                                            </a>
                                        </li>
                                    </ul>
                                </li>

                                <!-- Bantuan -->
                                <li class="nav-item">
                                    <a class="nav-link" href="#" data-bs-toggle="modal" data-bs-target="#modalBantuanAdmin">
                                        Bantuan
                                    </a>
                                </li>
                            </ul>
                            
                            <!-- Admin Info di kanan -->
                            <ul class="navbar-nav ms-auto">
                                <li class="nav-item dropdown">
                                    <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                        <i class="fas fa-user-shield text-primary"></i>
                                        {{ auth()->user()->name }}
                                        <small class="d-block text-muted">{{ session('selected_role') }}</small>
                                    </a>
                                    <ul class="dropdown-menu">
                                        <li>
                                            <a class="dropdown-item" href="{{ route('profile.edit') }}">
                                                <i class="fas fa-user"></i> Profile
                                            </a>
                                        </li>
                                        <li>
                                            <a class="dropdown-item" href="#">
                                                <i class="fas fa-cog"></i> Pengaturan
                                            </a>
                                        </li>
                                        <li><hr class="dropdown-divider"></li>
                                        <li>
                                            <a class="dropdown-item" href="{{ route('gate') }}">
                                                <i class="fas fa-exchange-alt"></i> Ganti Role
                                            </a>
                                        </li>
                                        <li>
                                            <a class="dropdown-item" href="/login/exit"
                                               onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                                <i class="fas fa-sign-out-alt"></i> Logout
                                            </a>
                                            <form id="logout-form" action="/login/exit" method="POST" class="d-none">
                                                @csrf
                                            </form>
                                        </li>
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

{{-- Modal Bantuan Admin --}}
<div class="modal fade" id="modalBantuanAdmin" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title">Bantuan Admin PPKPT</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <h6>Tugas dan Tanggung Jawab Admin:</h6>
                <ul>
                    <li><strong>Review Pengaduan:</strong> Periksa kelengkapan dan validitas pengaduan yang masuk</li>
                    <li><strong>Investigasi Awal:</strong> Lakukan verifikasi dan pengumpulan data tambahan</li>
                    <li><strong>Update Status:</strong> Mengubah status pengaduan sesuai progress penanganan</li>
                    <li><strong>Memberikan Respon:</strong> Memberikan tanggapan dan komunikasi kepada pelapor</li>
                    <li><strong>Koordinasi Tim:</strong> Berkoordinasi dengan tim PPKPT dan pihak terkait</li>
                    <li><strong>Dokumentasi:</strong> Membuat laporan berkala dan dokumentasi kasus</li>
                </ul>

                <h6 class="mt-4">Workflow Penanganan Pengaduan:</h6>
                <div class="row">
                    <div class="col-md-6">
                        <ol>
                            <li><strong>Review:</strong> Periksa kelengkapan dan validitas pengaduan</li>
                            <li><strong>Investigasi:</strong> Lakukan verifikasi dan pengumpulan data</li>
                            <li><strong>Tindak Lanjut:</strong> Tentukan langkah penanganan yang tepat</li>
                            <li><strong>Monitoring:</strong> Pantau progress penanganan</li>
                            <li><strong>Closure:</strong> Finalisasi dan dokumentasi hasil</li>
                        </ol>
                    </div>
                    <div class="col-md-6">
                        <h6>Status Pengaduan:</h6>
                        <ul class="list-unstyled">
                            <li><span class="badge bg-warning me-2">Pending</span> Menunggu review admin</li>
                            <li><span class="badge bg-info me-2">Proses</span> Sedang diinvestigasi</li>
                            <li><span class="badge bg-success me-2">Selesai</span> Kasus telah diselesaikan</li>
                            <li><span class="badge bg-danger me-2">Ditolak</span> Pengaduan tidak valid</li>
                        </ul>
                    </div>
                </div>

                <h6 class="mt-4">Scope Pengelolaan:</h6>
                @if(session('selected_role') === 'Admin PPKPT Fakultas')
                <div class="alert alert-info">
                    <strong>Admin Fakultas:</strong> Anda dapat mengelola SEMUA pengaduan dari seluruh prodi di fakultas ini. 
                    Anda memiliki akses penuh untuk mereview, memproses, dan menyelesaikan pengaduan.
                </div>
                @elseif(session('selected_role') === 'Admin PPKPT Prodi')
                <div class="alert alert-warning">
                    <strong>Admin Prodi:</strong> Anda mengelola pengaduan dari unit kerja/prodi {{ auth()->user()->unit_kerja ?? 'Anda' }} saja. 
                    Koordinasikan dengan Admin Fakultas untuk kasus yang memerlukan escalation.
                </div>
                @endif

                <h6 class="mt-4">Tips dan Best Practices:</h6>
                <ul>
                    <li>Selalu prioritaskan pengaduan yang sudah pending lebih dari 3 hari</li>
                    <li>Berikan respon yang empatik dan profesional kepada pelapor</li>
                    <li>Dokumentasikan setiap langkah penanganan dengan detail</li>
                    <li>Jaga kerahasiaan identitas pelapor sesuai protokol</li>
                    <li>Koordinasikan dengan pihak terkait jika diperlukan</li>
                </ul>

                <div class="alert alert-warning mt-3">
                    <h6><i class="fas fa-exclamation-triangle"></i> Penting!</h6>
                    <p class="mb-0">
                        <strong>Kerahasiaan:</strong> Selalu jaga kerahasiaan identitas pelapor dan data pengaduan sesuai dengan protokol PPKPT.
                        <br><strong>Objektivitas:</strong> Tangani setiap pengaduan secara objektif dan tidak memihak.
                        <br><strong>Dokumentasi:</strong> Semua komunikasi dan tindakan harus didokumentasikan dengan baik.
                    </p>
                </div>

                <h6 class="mt-4">Kontak Darurat:</h6>
                <div class="row">
                    <div class="col-md-6">
                        <p class="mb-1"><strong>Koordinator PPKPT:</strong></p>
                        <p><i class="fas fa-phone text-success"></i> 0274-654321</p>
                    </div>
                    <div class="col-md-6">
                        <p class="mb-1"><strong>Email Tim:</strong></p>
                        <p><i class="fas fa-envelope text-primary"></i> admin-ppkpt@university.ac.id</p>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                <a href="#" class="btn btn-primary">
                    <i class="fas fa-download"></i> Download Manual Admin
                </a>
            </div>
        </div>
    </div>
</div>

{{-- Modal Laporan --}}
<div class="modal fade" id="modalLaporan" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Generate Laporan</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <form action="{{ route('whistleblower.admin.pengaduan.export') }}" method="GET">
                    <div class="mb-3">
                        <label class="form-label">Periode Laporan</label>
                        <select name="period" class="form-select">
                            <option value="this_month">Bulan Ini</option>
                            <option value="last_month">Bulan Lalu</option>
                            <option value="this_quarter">Kuartal Ini</option>
                            <option value="this_year">Tahun Ini</option>
                            <option value="custom">Custom</option>
                        </select>
                    </div>
                    
                    <div id="customDateRange" style="display: none;">
                        <div class="row">
                            <div class="col-md-6">
                                <label class="form-label">Tanggal Mulai</label>
                                <input type="date" name="date_from" class="form-control">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Tanggal Selesai</label>
                                <input type="date" name="date_to" class="form-control">
                            </div>
                        </div>
                    </div>
                    
                    <div class="mb-3 mt-3">
                        <label class="form-label">Status</label>
                        <select name="status" class="form-select">
                            <option value="">Semua Status</option>
                            <option value="pending">Pending</option>
                            <option value="proses">Proses</option>
                            <option value="selesai">Selesai</option>
                            <option value="ditolak">Ditolak</option>
                        </select>
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label">Kategori</label>
                        <select name="kategori" class="form-select">
                            <option value="">Semua Kategori</option>
                            <option value="kekerasan_seksual">Kekerasan Seksual</option>
                            <option value="pelecehan_seksual">Pelecehan Seksual</option>
                            <option value="diskriminasi">Diskriminasi</option>
                            <option value="bullying">Bullying/Perundungan</option>
                            <option value="penyalahgunaan_wewenang">Penyalahgunaan Wewenang</option>
                        </select>
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label">Format Output</label>
                        <select name="format" class="form-select">
                            <option value="excel">Excel (.xlsx)</option>
                            <option value="pdf">PDF</option>
                            <option value="csv">CSV</option>
                        </select>
                    </div>
                    
                    <div class="form-check">
                        <input type="checkbox" name="include_details" class="form-check-input" id="includeDetails">
                        <label class="form-check-label" for="includeDetails">
                            Include Detail Pengaduan
                        </label>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                <button type="submit" class="btn btn-primary" onclick="document.querySelector('#modalLaporan form').submit();">
                    <i class="fas fa-download"></i> Generate Laporan
                </button>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Show/hide custom date range
    const periodSelect = document.querySelector('select[name="period"]');
    const customDateRange = document.getElementById('customDateRange');
    
    if (periodSelect) {
        periodSelect.addEventListener('change', function() {
            if (this.value === 'custom') {
                customDateRange.style.display = 'block';
            } else {
                customDateRange.style.display = 'none';
            }
        });
    }
});
</script>