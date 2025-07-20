{{-- resources/views/whistleblower/partials/form-status-pelapor.blade.php --}}
<div class="mb-4">
    <h6 class="border-bottom pb-2 mb-3">Informasi Pelapor</h6>
    
    <div class="row">
        <div class="col-md-6 mb-3">
            <label for="nama_pelapor" class="form-label">Nama Pelapor <span class="text-danger">*</span></label>
            <input type="text" class="form-control @error('nama_pelapor') is-invalid @enderror" 
                   id="nama_pelapor" name="nama_pelapor" 
                   value="{{ old('nama_pelapor', $user->name ?? '') }}" required>
            @error('nama_pelapor')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="col-md-6 mb-3">
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

        <div class="col-md-6 mb-3">
            <label for="memiliki_disabilitas" class="form-label">Memiliki Disabilitas</label>
            <select class="form-select @error('memiliki_disabilitas') is-invalid @enderror" 
                    id="memiliki_disabilitas" name="memiliki_disabilitas">
                <option value="0" {{ old('memiliki_disabilitas') == '0' ? 'selected' : '' }}>Tidak</option>
                <option value="1" {{ old('memiliki_disabilitas') == '1' ? 'selected' : '' }}>Ya</option>
            </select>
            @error('memiliki_disabilitas')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="col-md-6 mb-3" id="disabilityTypeDiv" style="display: none;">
            <label for="jenis_disabilitas" class="form-label">Jenis Disabilitas</label>
            <input type="text" class="form-control @error('jenis_disabilitas') is-invalid @enderror" 
                   id="jenis_disabilitas" name="jenis_disabilitas" 
                   value="{{ old('jenis_disabilitas') }}"
                   placeholder="Sebutkan jenis disabilitas">
            @error('jenis_disabilitas')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
    </div>
</div>