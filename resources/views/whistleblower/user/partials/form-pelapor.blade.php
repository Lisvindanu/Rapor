{{-- resources/views/whistleblower/user/partials/form-pelapor.blade.php --}}
<div class="form-section">
    <h6><i class="fas fa-user me-2"></i>Informasi Pelapor</h6>
    
    <div class="row mb-3">
        <div class="col-md-6">
            <label for="nama_pelapor" class="form-label">Nama Lengkap <span class="text-danger">*</span></label>
            <input type="text" class="form-control @error('nama_pelapor') is-invalid @enderror" 
                   id="nama_pelapor" name="nama_pelapor" 
                   value="{{ old('nama_pelapor', auth()->user()->name) }}" required>
            @error('nama_pelapor')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
        <div class="col-md-6">
            <label for="email_pelapor" class="form-label">Email <span class="text-danger">*</span></label>
            <input type="email" class="form-control" 
                   id="email_pelapor" name="email_pelapor" 
                   value="{{ auth()->user()->email }}" readonly>
            <small class="text-muted">Email dari akun yang sedang login</small>
        </div>
    </div>

    <div class="row mb-3">
        <div class="col-md-6">
            <label for="status_pelapor" class="form-label">Status Pelapor <span class="text-danger">*</span></label>
            <select class="form-select @error('status_pelapor') is-invalid @enderror" 
                    id="status_pelapor" name="status_pelapor" required>
                <option value="">Pilih Status</option>
                <option value="saksi" {{ old('status_pelapor') == 'saksi' ? 'selected' : '' }}>Saksi</option>
                <option value="korban" {{ old('status_pelapor') == 'korban' ? 'selected' : '' }}>Korban</option>
            </select>
            @error('status_pelapor')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
        <div class="col-md-6">
            <div class="form-check mt-4">
                <input type="checkbox" class="form-check-input" 
                       id="memiliki_disabilitas" name="memiliki_disabilitas" 
                       value="1" {{ old('memiliki_disabilitas') ? 'checked' : '' }}>
                <label class="form-check-label" for="memiliki_disabilitas">
                    Memiliki Disabilitas
                </label>
            </div>
        </div>
    </div>

    <!-- Jenis Disabilitas (Hidden by default) -->
    <div id="jenis_disabilitas_div" style="display: none;">
        <div class="mb-3">
            <label for="jenis_disabilitas" class="form-label">Jenis Disabilitas</label>
            <select class="form-select @error('jenis_disabilitas') is-invalid @enderror" 
                    id="jenis_disabilitas" name="jenis_disabilitas">
                <option value="">Pilih Jenis Disabilitas</option>
                <option value="fisik" {{ old('jenis_disabilitas') == 'fisik' ? 'selected' : '' }}>Disabilitas Fisik</option>
                <option value="sensorik" {{ old('jenis_disabilitas') == 'sensorik' ? 'selected' : '' }}>Disabilitas Sensorik</option>
                <option value="intelektual" {{ old('jenis_disabilitas') == 'intelektual' ? 'selected' : '' }}>Disabilitas Intelektual</option>
                <option value="mental" {{ old('jenis_disabilitas') == 'mental' ? 'selected' : '' }}>Disabilitas Mental</option>
            </select>
            @error('jenis_disabilitas')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
    </div>
</div>