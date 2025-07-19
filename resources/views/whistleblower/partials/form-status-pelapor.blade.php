{{-- resources/views/whistleblower/partials/form-status-pelapor.blade.php --}}
<!-- Status Pelapor -->
<div class="mb-3">
    <label for="status_pelapor" class="form-label">
        Status Pelapor <span class="text-danger">*</span>
    </label>
    <select name="status_pelapor" id="status_pelapor" 
            class="form-select @error('status_pelapor') is-invalid @enderror" required>
        <option value="">Pilih Status Pelapor</option>
        <option value="saksi" {{ old('status_pelapor') == 'saksi' ? 'selected' : '' }}>Saksi</option>
        <option value="korban" {{ old('status_pelapor') == 'korban' ? 'selected' : '' }}>Korban</option>
    </select>
    @error('status_pelapor')
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
    <div class="form-text">
        <small>Pilih apakah Anda sebagai saksi atau korban dalam peristiwa ini</small>
    </div>
</div>

<!-- Informasi Disabilitas -->
<div class="row">
    <div class="col-md-6">
        <div class="mb-3">
            <label for="memiliki_disabilitas" class="form-label">
                Memiliki Disabilitas <span class="text-danger">*</span>
            </label>
            <select name="memiliki_disabilitas" id="memiliki_disabilitas" 
                    class="form-select @error('memiliki_disabilitas') is-invalid @enderror" required>
                <option value="">Pilih</option>
                <option value="0" {{ old('memiliki_disabilitas') == '0' ? 'selected' : '' }}>Tidak</option>
                <option value="1" {{ old('memiliki_disabilitas') == '1' ? 'selected' : '' }}>Ya</option>
            </select>
            @error('memiliki_disabilitas')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
    </div>
    <div class="col-md-6" id="jenis_disabilitas_wrapper" style="display: {{ old('memiliki_disabilitas') == '1' ? 'block' : 'none' }};">
        <div class="mb-3">
            <label for="jenis_disabilitas" class="form-label">Jenis Disabilitas</label>
            <input type="text" name="jenis_disabilitas" id="jenis_disabilitas" 
                   class="form-control @error('jenis_disabilitas') is-invalid @enderror"
                   value="{{ old('jenis_disabilitas') }}" 
                   placeholder="Sebutkan jenis disabilitas">
            @error('jenis_disabilitas')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
    </div>
</div>