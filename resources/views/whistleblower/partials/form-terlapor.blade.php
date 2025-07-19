{{-- resources/views/whistleblower/partials/form-terlapor.blade.php --}}
<div class="mb-4">
    <h6 class="fw-bold mb-3">
        <i class="fas fa-users me-2"></i>Informasi Terlapor
    </h6>
    
    <div id="terlapor-container">
        @php
            $old_terlapor = old('terlapor', [[]]);
        @endphp
        
        @foreach($old_terlapor as $index => $terlapor_data)
        <div class="terlapor-item bg-light p-3 rounded mb-3" data-index="{{ $index }}">
            @if($index > 0)
            <div class="d-flex justify-content-end mb-2">
                <button type="button" class="btn btn-outline-danger btn-sm" onclick="removeTerlapor(this)">
                    <i class="fas fa-times me-1"></i>Hapus Terlapor
                </button>
            </div>
            @endif
            
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label for="terlapor_kontak_{{ $index }}" class="form-label fw-bold">
                        Nomor telepon dan alamat surel (e-mail) pihak lain yang dapat dikonfirmasi <span class="text-danger">*</span>
                    </label>
                    <input type="text" class="form-control" name="terlapor[{{ $index }}][kontak_terlapor]" 
                           id="terlapor_kontak_{{ $index }}" value="{{ $terlapor_data['kontak_terlapor'] ?? '' }}" 
                           placeholder="Email atau nomor telepon terlapor" required>
                    <small class="form-text text-muted">Email/No HP terlapor yang dapat dihubungi</small>
                    @error("terlapor.{$index}.kontak_terlapor")
                        <div class="invalid-feedback d-block">{{ $message }}</div>
                    @enderror
                </div>
                
                <div class="col-md-6 mb-3">
                    <label for="terlapor_status_{{ $index }}" class="form-label fw-bold">
                        Status Terlapor <span class="text-danger">*</span>
                    </label>
                    <select class="form-select" name="terlapor[{{ $index }}][status_terlapor]" id="terlapor_status_{{ $index }}" required>
                        <option value="">Pilih Status</option>
                        <option value="pegawai" {{ ($terlapor_data['status_terlapor'] ?? '') == 'pegawai' ? 'selected' : '' }}>Pegawai</option>
                        <option value="mahasiswa" {{ ($terlapor_data['status_terlapor'] ?? '') == 'mahasiswa' ? 'selected' : '' }}>Mahasiswa</option>
                    </select>
                    @error("terlapor.{$index}.status_terlapor")
                        <div class="invalid-feedback d-block">{{ $message }}</div>
                    @enderror
                </div>
            </div>
            
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label for="terlapor_nama_{{ $index }}" class="form-label">Nama Terlapor (Opsional)</label>
                    <input type="text" class="form-control" name="terlapor[{{ $index }}][nama_terlapor]" 
                           id="terlapor_nama_{{ $index }}" value="{{ $terlapor_data['nama_terlapor'] ?? '' }}" 
                           placeholder="Nama lengkap terlapor">
                    @error("terlapor.{$index}.nama_terlapor")
                        <div class="invalid-feedback d-block">{{ $message }}</div>
                    @enderror
                </div>
                
                <div class="col-md-6 mb-3">
                    <label for="terlapor_nomor_{{ $index }}" class="form-label">NIM/NIP (Opsional)</label>
                    <input type="text" class="form-control" name="terlapor[{{ $index }}][nomor_identitas]" 
                           id="terlapor_nomor_{{ $index }}" placeholder="NIM/NIP terlapor" 
                           value="{{ $terlapor_data['nomor_identitas'] ?? '' }}">
                    @error("terlapor.{$index}.nomor_identitas")
                        <div class="invalid-feedback d-block">{{ $message }}</div>
                    @enderror
                </div>
            </div>
            
            <div class="mb-3">
                <label for="terlapor_unit_{{ $index }}" class="form-label">Unit Kerja/Fakultas (Opsional)</label>
                <input type="text" class="form-control" name="terlapor[{{ $index }}][unit_kerja_fakultas]" 
                        id="terlapor_unit_{{ $index }}" placeholder="Contoh: Fakultas Teknik, Bagian Keuangan" 
                        value="{{ $terlapor_data['unit_kerja_fakultas'] ?? '' }}">
                @error("terlapor.{$index}.unit_kerja_fakultas")
                    <div class="invalid-feedback d-block">{{ $message }}</div>
                @enderror
            </div>
        </div>
        @endforeach
    </div>
    
    <div class="text-center">
        <button type="button" class="btn btn-outline-primary" id="add-terlapor">
            <i class="fas fa-plus me-1"></i>Tambah Terlapor Lain
        </button>
    </div>
</div>