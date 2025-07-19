{{-- resources/views/whistleblower/partials/form-terlapor.blade.php --}}
<!-- Informasi Terlapor -->
<div class="card bg-light mb-4">
    <div class="card-header">
        <h6 class="mb-0"><i class="fas fa-user-slash"></i> Informasi Terlapor</h6>
    </div>
    <div class="card-body">
        <div id="terlapor-container">
            <div class="terlapor-item border rounded p-3 mb-3" data-index="0">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h6 class="mb-0 text-primary">TerlaporS</h6>
                    <button type="button" class="btn btn-sm btn-outline-danger remove-terlapor" style="display: none;">
                        <i class="fas fa-trash"></i>
                    </button>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="form-label">Nama Terlapor <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('terlapor.0.nama') is-invalid @enderror" 
                                   name="terlapor[0][nama]" value="{{ old('terlapor.0.nama') }}" 
                                   placeholder="Nama lengkap terlapor" required>
                            @error('terlapor.0.nama')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="form-label">Status Terlapor <span class="text-danger">*</span></label>
                            <select class="form-select @error('terlapor.0.status') is-invalid @enderror" 
                                    name="terlapor[0][status]" required>
                                <option value="">Pilih Status</option>
                                <option value="mahasiswa" {{ old('terlapor.0.status') == 'mahasiswa' ? 'selected' : '' }}>Mahasiswa</option>
                                <option value="pegawai" {{ old('terlapor.0.status') == 'pegawai' ? 'selected' : '' }}>Pegawai</option>
                            </select>
                            @error('terlapor.0.status')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="form-label">Nomor Identitas (NIM/NIP)</label>
                            <input type="text" class="form-control @error('terlapor.0.nomor_identitas') is-invalid @enderror" 
                                   name="terlapor[0][nomor_identitas]" value="{{ old('terlapor.0.nomor_identitas') }}" 
                                   placeholder="Opsional">
                            @error('terlapor.0.nomor_identitas')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="form-label">Fakultas/Unit Kerja</label>
                            <input type="text" class="form-control @error('terlapor.0.unit_kerja') is-invalid @enderror" 
                                   name="terlapor[0][unit_kerja]" value="{{ old('terlapor.0.unit_kerja') }}" 
                                   placeholder="Opsional">
                            @error('terlapor.0.unit_kerja')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

                <div class="mb-3">
                    <label class="form-label">Nomor telepon dan alamat surel (*e-mail*) pihak lain yang dapat dikonfirmasi <span class="text-danger">*</span></label>
                    <input type="text" class="form-control @error('terlapor.0.kontak') is-invalid @enderror" 
                           name="terlapor[0][kontak]" value="{{ old('terlapor.0.kontak') }}" 
                           placeholder="No Telp/alamat email terlapor yang dapat dihubungi" required>
                    @error('terlapor.0.kontak')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>
        </div>

        <button type="button" class="btn btn-outline-primary btn-sm" id="add-terlapor">
            <i class="fas fa-plus"></i> Tambah Terlapor
        </button>
    </div>
</div>