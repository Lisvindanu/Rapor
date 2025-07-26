{{-- resources/views/whistleblower/user/partials/form-terlapor.blade.php --}}
<div class="form-section mt-3">
    <h6><i class="fas fa-users me-2"></i>Informasi Terlapor</h6>

    <div id="terlapor-container">
        <!-- Terlapor 1 (Default - tanpa tombol hapus) -->
        <div class="terlapor-item" data-index="1">
            <h6>Terlapor 1</h6>

            <div class="row mb-3">
                <div class="col-md-6">
                    <label class="form-label">Nama Terlapor <span class="text-danger">*</span></label>
                    <input type="text" class="form-control @error('terlapor.0.nama_terlapor') is-invalid @enderror"
                        name="terlapor[0][nama_terlapor]" value="{{ old('terlapor.0.nama_terlapor') }}" required>
                    @error('terlapor.0.nama_terlapor')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="col-md-6">
                    <label class="form-label">Status <span class="text-danger">*</span></label>
                    <select class="form-select @error('terlapor.0.status_terlapor') is-invalid @enderror"
                        name="terlapor[0][status_terlapor]" required>
                        <option value="">Pilih Status</option>
                        <option value="mahasiswa"
                            {{ old('terlapor.0.status_terlapor') == 'mahasiswa' ? 'selected' : '' }}>Mahasiswa</option>
                        <option value="pegawai" {{ old('terlapor.0.status_terlapor') == 'pegawai' ? 'selected' : '' }}>
                            Pegawai</option>
                    </select>
                    @error('terlapor.0.status_terlapor')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <div class="row mb-3">
                <div class="col-md-6">
                    <label class="form-label">Nomor Identitas (NIM/NIP)</label>
                    <input type="text" class="form-control @error('terlapor.0.nomor_identitas') is-invalid @enderror"
                        name="terlapor[0][nomor_identitas]" value="{{ old('terlapor.0.nomor_identitas') }}"
                        placeholder="Opsional">
                    @error('terlapor.0.nomor_identitas')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="col-md-6">
                    <label class="form-label">Unit Kerja/Fakultas</label>
                    <input type="text"
                        class="form-control @error('terlapor.0.unit_kerja_fakultas') is-invalid @enderror"
                        name="terlapor[0][unit_kerja_fakultas]" value="{{ old('terlapor.0.unit_kerja_fakultas') }}"
                        placeholder="Opsional">
                    @error('terlapor.0.unit_kerja_fakultas')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <div class="mb-3">
                <label class="form-label">Kontak Terlapor <span class="text-danger">*</span></label>
                <input type="text" class="form-control @error('terlapor.0.kontak_terlapor') is-invalid @enderror"
                    name="terlapor[0][kontak_terlapor]" value="{{ old('terlapor.0.kontak_terlapor') }}"
                    placeholder="Email atau Nomor Telepon" required>
                @error('terlapor.0.kontak_terlapor')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
        </div>
    </div>

    <!-- Tombol Tambah Terlapor -->
    <div class="text-center mt-3">
        <button type="button" class="btn-add-terlapor" id="btn-add-terlapor">
            <i class="fas fa-plus me-2"></i>Tambah Terlapor
        </button>
        <div class="form-text mt-2">
            <i class="fas fa-info-circle me-1"></i>
            Anda dapat menambahkan lebih dari satu terlapor jika diperlukan
        </div>
    </div>
</div>
