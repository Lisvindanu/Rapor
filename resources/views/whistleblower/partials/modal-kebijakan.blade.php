{{-- resources/views/whistleblower/partials/modal-kebijakan.blade.php --}}
<div class="modal fade" id="modalKebijakan" tabindex="-1" aria-labelledby="modalKebijakanLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title" id="modalKebijakanLabel">
                    <i class="fas fa-shield-alt me-2"></i>Kebijakan Privasi & Perlindungan Pelapor
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="accordion" id="accordionKebijakan">
                    <!-- Kerahasiaan Identitas -->
                    <div class="accordion-item">
                        <h2 class="accordion-header" id="headingSatu">
                            <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseSatu" aria-expanded="true" aria-controls="collapseSatu">
                                1. Kerahasiaan Identitas
                            </button>
                        </h2>
                        <div id="collapseSatu" class="accordion-collapse collapse show" aria-labelledby="headingSatu" data-bs-parent="#accordionKebijakan">
                            <div class="accordion-body">
                                <ul class="list-unstyled">
                                    <li class="mb-2"><i class="fas fa-check-circle text-success me-2"></i>Identitas pelapor akan dijaga kerahasiaannya sesuai dengan peraturan yang berlaku</li>
                                    <li class="mb-2"><i class="fas fa-check-circle text-success me-2"></i>Hanya pihak yang berwenang yang dapat mengakses informasi identitas pelapor</li>
                                    <li class="mb-2"><i class="fas fa-check-circle text-success me-2"></i>Sistem menggunakan enkripsi untuk melindungi data sensitif</li>
                                    <li class="mb-2"><i class="fas fa-check-circle text-success me-2"></i>Data disimpan dalam server yang aman dengan akses terbatas</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Penggunaan Data -->
                    <div class="accordion-item">
                        <h2 class="accordion-header" id="headingDua">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseDua" aria-expanded="false" aria-controls="collapseDua">
                                2. Penggunaan Data
                            </button>
                        </h2>
                        <div id="collapseDua" class="accordion-collapse collapse" aria-labelledby="headingDua" data-bs-parent="#accordionKebijakan">
                            <div class="accordion-body">
                                <ul class="list-unstyled">
                                    <li class="mb-2"><i class="fas fa-check-circle text-success me-2"></i>Data yang dikumpulkan hanya digunakan untuk proses penanganan pengaduan</li>
                                    <li class="mb-2"><i class="fas fa-check-circle text-success me-2"></i>Informasi tidak akan dibagikan kepada pihak ketiga tanpa persetujuan</li>
                                    <li class="mb-2"><i class="fas fa-check-circle text-success me-2"></i>Data disimpan sesuai dengan kebijakan retensi institusi</li>
                                    <li class="mb-2"><i class="fas fa-check-circle text-success me-2"></i>Akses data dibatasi hanya untuk keperluan investigasi dan tindak lanjut</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Perlindungan Pelapor -->
                    <div class="accordion-item">
                        <h2 class="accordion-header" id="headingTiga">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseTiga" aria-expanded="false" aria-controls="collapseTiga">
                                3. Perlindungan Pelapor
                            </button>
                        </h2>
                        <div id="collapseTiga" class="accordion-collapse collapse" aria-labelledby="headingTiga" data-bs-parent="#accordionKebijakan">
                            <div class="accordion-body">
                                <ul class="list-unstyled">
                                    <li class="mb-2"><i class="fas fa-check-circle text-success me-2"></i>Pelapor dilindungi dari tindakan balasan atau diskriminasi</li>
                                    <li class="mb-2"><i class="fas fa-check-circle text-success me-2"></i>Tersedia mekanisme perlindungan khusus jika diperlukan</li>
                                    <li class="mb-2"><i class="fas fa-check-circle text-success me-2"></i>Sistem pelaporan terpisah untuk keluhan terhadap proses penanganan</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Proses Penanganan -->
                    <div class="accordion-item">
                        <h2 class="accordion-header" id="headingEmpat">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseEmpat" aria-expanded="false" aria-controls="collapseEmpat">
                                4. Proses Penanganan
                            </button>
                        </h2>
                        <div id="collapseEmpat" class="accordion-collapse collapse" aria-labelledby="headingEmpat" data-bs-parent="#accordionKebijakan">
                            <div class="accordion-body">
                                <ul class="list-unstyled">
                                    <li class="mb-2"><i class="fas fa-check-circle text-success me-2"></i>Setiap laporan akan ditindaklanjuti sesuai prosedur yang berlaku</li>
                                    <li class="mb-2"><i class="fas fa-check-circle text-success me-2"></i>Pelapor akan mendapat informasi perkembangan penanganan</li>
                                    <li class="mb-2"><i class="fas fa-check-circle text-success me-2"></i>Proses penanganan dilakukan secara objektif dan adil</li>
                                    <li class="mb-2"><i class="fas fa-check-circle text-success me-2"></i>Timeline penanganan akan diinformasikan kepada pelapor</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Hak Pelapor -->
                    <div class="accordion-item">
                        <h2 class="accordion-header" id="headingLima">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseLima" aria-expanded="false" aria-controls="collapseLima">
                                5. Hak Pelapor
                            </button>
                        </h2>
                        <div id="collapseLima" class="accordion-collapse collapse" aria-labelledby="headingLima" data-bs-parent="#accordionKebijakan">
                            <div class="accordion-body">
                                <ul class="list-unstyled">
                                    <li class="mb-2"><i class="fas fa-check-circle text-success me-2"></i>Hak untuk mendapat informasi tentang status pengaduan</li>
                                    <li class="mb-2"><i class="fas fa-check-circle text-success me-2"></i>Hak untuk membatalkan pengaduan pada kondisi tertentu</li>
                                    <li class="mb-2"><i class="fas fa-check-circle text-success me-2"></i>Hak untuk mendapat pendampingan selama proses</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Kontak Bantuan -->
                <div class="mt-4">
                    <div class="card border-primary">
                        <div class="card-header bg-light">
                            <h6 class="mb-0">
                                Kontak Bantuan & Informasi
                            </h6>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <p class="mb-2">
                                        <strong>Email:</strong> ppkpt@university.ac.id
                                    </p>
                                    <p class="mb-2">
                                        <strong>Telepon:</strong> (021) 1234-5678
                                    </p>
                                </div>
                                <div class="col-md-6">
                                    <p class="mb-2">
                                        <strong>WhatsApp:</strong> 0812-3456-7890
                                    </p>
                                    <p class="mb-2">
                                        <strong>Layanan:</strong> 24/7
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Disclaimer -->
                <div class="mt-3">
                    <div class="alert alert-info">
                        <small>
                            <i class="fas fa-info-circle me-1"></i>
                            <strong>Catatan:</strong> Dengan menggunakan sistem ini, Anda menyetujui bahwa informasi yang diberikan adalah benar dan dapat dipertanggungjawabkan. Laporan palsu dapat dikenakan sanksi sesuai peraturan yang berlaku.
                        </small>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                    <i class="fas fa-times me-1"></i>Tutup
                </button>
                <button type="button" class="btn btn-primary" data-bs-dismiss="modal" onclick="document.getElementById('persetujuan_kebijakan').checked = true;">
                    <i class="fas fa-check me-1"></i>Saya Setuju
                </button>
            </div>
        </div>
    </div>
</div>