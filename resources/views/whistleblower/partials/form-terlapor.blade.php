{{-- resources/views/whistleblower/partials/form-terlapor.blade.php --}}
<div class="mb-4">
    <div id="terlaporContainer">
        <!-- Terlapor Item  -->
        <div class="terlapor-item border rounded p-3 mb-3 bg-light">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h6 class="mb-0">Terlapor</h6>
                <button type="button" class="btn btn-sm btn-outline-danger remove-terlapor">
                    <i class="fas fa-trash"></i> Hapus
                </button>
            </div>
            
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label class="form-label">Nama Terlapor <span class="text-danger">*</span></label>
                    <input type="text" name="terlapor[0][nama_terlapor]" 
                           class="form-control @error('terlapor.0.nama_terlapor') is-invalid @enderror" 
                           value="{{ old('terlapor.0.nama_terlapor') }}" required>
                    @error('terlapor.0.nama_terlapor')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                
                <div class="col-md-6 mb-3">
                    <label class="form-label">Status <span class="text-danger">*</span></label>
                    <select name="terlapor[0][status_terlapor]" 
                            class="form-select @error('terlapor.0.status_terlapor') is-invalid @enderror" required>
                        <option value="">Pilih Status</option>
                        <option value="mahasiswa" {{ old('terlapor.0.status_terlapor') == 'mahasiswa' ? 'selected' : '' }}>Mahasiswa</option>
                        <option value="pegawai" {{ old('terlapor.0.status_terlapor') == 'pegawai' ? 'selected' : '' }}>Pegawai</option>
                    </select>
                    @error('terlapor.0.status_terlapor')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                
                <div class="col-md-6 mb-3">
                    <label class="form-label">Nomor Identitas (NIM/NIP)</label>
                    <input type="text" name="terlapor[0][nomor_identitas]" 
                           class="form-control @error('terlapor.0.nomor_identitas') is-invalid @enderror" 
                           value="{{ old('terlapor.0.nomor_identitas') }}"
                           placeholder="Masukkan NIM atau NIP">
                    @error('terlapor.0.nomor_identitas')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                
                <div class="col-md-6 mb-3">
                    <label class="form-label">Unit Kerja/Fakultas</label>
                    <input type="text" name="terlapor[0][unit_kerja_fakultas]" 
                           class="form-control @error('terlapor.0.unit_kerja_fakultas') is-invalid @enderror" 
                           value="{{ old('terlapor.0.unit_kerja_fakultas') }}"
                           placeholder="Contoh: Fakultas Teknik">
                    @error('terlapor.0.unit_kerja_fakultas')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                
                <div class="col-12 mb-3">
                    <label class="form-label">Nomor telepon dan alamat surel (e-mail) pihak lain yang dapat dikonfirmasi <span class="text-danger">*</span></label>
                    <input type="text" name="terlapor[0][kontak_terlapor]" 
                           class="form-control @error('terlapor.0.kontak_terlapor') is-invalid @enderror" 
                           value="{{ old('terlapor.0.kontak_terlapor') }}"
                           placeholder="Email atau nomor telepon" required>
                    @error('terlapor.0.kontak_terlapor')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>
        </div>
    </div>
</div>