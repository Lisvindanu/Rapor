{{-- resources/views/keuangan/transaksi/partials/modal-form.blade.php --}}
<!-- Modal Create/Edit Pengeluaran -->
<div class="modal fade" id="modalPengeluaran" tabindex="-1" aria-labelledby="modalPengeluaranLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalPengeluaranLabel">
                    <i class="fas fa-money-bill-wave me-2"></i>
                    <span id="modalTitle">Tambah Pengeluaran Kas</span>
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="formPengeluaran" method="POST">
                @csrf
                <div class="modal-body">
                    <div id="modalAlert" class="alert d-none"></div>

                    {{-- Row 1: Tanggal dan Nomor Bukti --}}
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="tanggal" class="form-label required">Tanggal</label>
                            <input type="date" class="form-control" id="tanggal" name="tanggal" required>
                            <div class="invalid-feedback"></div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="nomor_bukti" class="form-label">Nomor Bukti</label>
                            <input type="text" class="form-control" id="nomor_bukti" name="nomor_bukti"
                                   placeholder="Auto generate jika kosong" readonly>
                            <small class="text-muted">Nomor bukti akan dibuat otomatis jika dikosongkan</small>
                        </div>
                    </div>

                    {{-- Row 2: Penerima --}}
                    <div class="row">
                        <div class="col-12 mb-3">
                            <label for="sudah_terima_dari" class="form-label required">Sudah Terima Dari</label>
                            <input type="text" class="form-control" id="sudah_terima_dari" name="sudah_terima_dari"
                                   placeholder="Nama penerima" required>
                            <div class="invalid-feedback"></div>
                        </div>
                    </div>

                    {{-- Row 3: Jumlah Uang --}}
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="uang_sebanyak_angka" class="form-label required">Jumlah (Rp)</label>
                            <input type="number" class="form-control" id="uang_sebanyak_angka" name="uang_sebanyak_angka"
                                   placeholder="0" required min="0" step="1">
                            <div class="invalid-feedback"></div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="uang_sebanyak" class="form-label required">Terbilang</label>
                            <input type="text" class="form-control" id="uang_sebanyak" name="uang_sebanyak"
                                   placeholder="Otomatis dari jumlah angka" required>
                            <div class="invalid-feedback"></div>
                        </div>
                    </div>

                    {{-- Row 4: Mata Anggaran dan Program --}}
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="mata_anggaran_id" class="form-label required">Mata Anggaran</label>
                            <select class="form-control" id="mata_anggaran_id" name="mata_anggaran_id" required>
                                <option value="">Pilih Mata Anggaran</option>
                            </select>
                            <div class="invalid-feedback"></div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="program_id" class="form-label required">Program</label>
                            <select class="form-control" id="program_id" name="program_id" required>
                                <option value="">Pilih Program</option>
                            </select>
                            <div class="invalid-feedback"></div>
                        </div>
                    </div>

                    {{-- Row 5: Sumber Dana --}}
                    <div class="row">
                        <div class="col-12 mb-3">
                            <label for="sumber_dana_id" class="form-label required">Sumber Dana</label>
                            <select class="form-control" id="sumber_dana_id" name="sumber_dana_id" required>
                                <option value="">Pilih Sumber Dana</option>
                            </select>
                            <div class="invalid-feedback"></div>
                        </div>
                    </div>

                    {{-- Row 6: Untuk Pembayaran --}}
                    <div class="row">
                        <div class="col-12 mb-3">
                            <label for="untuk_pembayaran" class="form-label required">Untuk Pembayaran</label>
                            <textarea class="form-control" id="untuk_pembayaran" name="untuk_pembayaran"
                                      rows="3" placeholder="Keterangan pembayaran" required></textarea>
                            <div class="invalid-feedback"></div>
                        </div>
                    </div>

                    {{-- Row 7: Tanda Tangan --}}
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="dekan_id" class="form-label required">Dekan</label>
                            <select class="form-control" id="dekan_id" name="dekan_id" required>
                                <option value="">Pilih Dekan</option>
                            </select>
                            <div class="invalid-feedback"></div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="wakil_dekan_ii_id" class="form-label required">Wakil Dekan II</label>
                            <select class="form-control" id="wakil_dekan_ii_id" name="wakil_dekan_ii_id" required>
                                <option value="">Pilih Wakil Dekan II</option>
                            </select>
                            <div class="invalid-feedback"></div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="ksb_keuangan_id" class="form-label required">KSB Keuangan</label>
                            <select class="form-control" id="ksb_keuangan_id" name="ksb_keuangan_id" required>
                                <option value="">Pilih KSB Keuangan</option>
                            </select>
                            <div class="invalid-feedback"></div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="penerima_id" class="form-label required">Penerima</label>
                            <select class="form-control" id="penerima_id" name="penerima_id" required>
                                <option value="">Pilih Penerima</option>
                            </select>
                            <div class="invalid-feedback"></div>
                        </div>
                    </div>

                    {{-- Row 8: Status dan Keterangan --}}
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="status" class="form-label required">Status</label>
                            <select class="form-control" id="status" name="status" required>
                                <option value="">Pilih Status</option>
                            </select>
                            <div class="invalid-feedback"></div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="keterangan" class="form-label">Keterangan</label>
                            <textarea class="form-control" id="keterangan" name="keterangan"
                                      rows="2" placeholder="Keterangan tambahan (opsional)"></textarea>
                        </div>
                    </div>

                    {{-- Hidden Fields --}}
                    <input type="hidden" id="tahun_anggaran_id" name="tahun_anggaran_id">
                    <input type="hidden" id="pengeluaran_id" name="pengeluaran_id">
                    <input type="hidden" id="form_method" name="_method">
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                        <i class="fas fa-times me-1"></i>Batal
                    </button>
                    <button type="submit" class="btn btn-primary" id="btnSubmit">
                        <i class="fas fa-save me-1"></i>Simpan
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<style>
    .required::after {
        content: ' *';
        color: red;
    }

    .modal-lg {
        max-width: 900px;
    }

    .form-control.is-invalid {
        border-color: #dc3545;
    }

    .form-control.is-valid {
        border-color: #28a745;
    }

    .invalid-feedback {
        display: block;
    }
</style>
