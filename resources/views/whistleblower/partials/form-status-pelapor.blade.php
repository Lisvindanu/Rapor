{{-- resources/views/whistleblower/partials/form-status-pelapor.blade.php --}}
<div class="mb-4">
    <div class="row">
        <div class="col-md-6 mb-3">
            <label for="status_pelapor" class="form-label fw-bold">
                Status Pelapor Saksi/Korban <span class="text-danger">*</span>
            </label>
            <select class="form-select" id="status_pelapor" name="status_pelapor" required>
                <option value="">Pilih Status</option>
                <option value="saksi" {{ old('status_pelapor') == 'saksi' ? 'selected' : '' }}>Saksi</option>
                <option value="korban" {{ old('status_pelapor') == 'korban' ? 'selected' : '' }}>Korban</option>
            </select>
            @error('status_pelapor')
                <div class="invalid-feedback d-block">{{ $message }}</div>
            @enderror
        </div>
        
        <div class="col-md-6 mb-3">
            <label for="memiliki_disabilitas" class="form-label fw-bold">
                Memiliki disabilitas <span class="text-danger">*</span>
            </label>
            <select class="form-select" id="memiliki_disabilitas" name="memiliki_disabilitas" required>
                <option value="">Pilih</option>
                <option value="0" {{ old('memiliki_disabilitas') === '0' ? 'selected' : '' }}>Tidak</option>
                <option value="1" {{ old('memiliki_disabilitas') === '1' ? 'selected' : '' }}>Ya</option>
            </select>
            @error('memiliki_disabilitas')
                <div class="invalid-feedback d-block">{{ $message }}</div>
            @enderror
        </div>
    </div>
    
    <div id="jenis_disabilitas_container" style="display: {{ old('memiliki_disabilitas') === '1' ? 'block' : 'none' }};">
        <div class="mb-3">
            <label for="jenis_disabilitas" class="form-label">Bila memiliki disabilitas, sebutkan</label>
            <input type="text" class="form-control" id="jenis_disabilitas" name="jenis_disabilitas" 
                   value="{{ old('jenis_disabilitas') }}" placeholder="Sebutkan jenis disabilitas Anda">
            @error('jenis_disabilitas')
                <div class="invalid-feedback d-block">{{ $message }}</div>
            @enderror
        </div>
    </div>
</div>