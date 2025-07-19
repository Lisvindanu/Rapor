{{-- resources/views/whistleblower/partials/form-upload-bukti.blade.php --}}
<!-- Upload Bukti -->
<div class="mb-3">
    <label class="form-label">
        Upload Bukti <span class="text-danger">*</span>
    </label>
    <p class="text-muted mb-3">Lampiran bukti adalah <strong>wajib</strong>. Pilih salah satu metode upload:</p>

    <!-- Toggle Upload Method -->
    <div class="btn-group mb-3" role="group">
        <input type="radio" class="btn-check" name="evidence_type" id="evidence_file_radio" value="file" {{ old('evidence_type', 'file') == 'file' ? 'checked' : '' }}>
        <label class="btn btn-outline-primary" for="evidence_file_radio">
            <i class="fas fa-upload"></i> Upload File
        </label>

        <input type="radio" class="btn-check" name="evidence_type" id="evidence_gdrive_radio" value="gdrive" {{ old('evidence_type') == 'gdrive' ? 'checked' : '' }}>
        <label class="btn btn-outline-success" for="evidence_gdrive_radio">
            <i class="fab fa-google-drive"></i> Link Google Drive
        </label>
    </div>

    <!-- File Upload Section -->
    <div id="file-upload-section" style="display: {{ old('evidence_type', 'file') == 'file' ? 'block' : 'none' }};">
        <input type="file" name="evidence_file" id="evidence_file" 
               class="form-control @error('evidence_file') is-invalid @enderror"
               accept=".jpg,.jpeg,.png,.pdf,.doc,.docx">
        @error('evidence_file')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
        <div class="form-text">
            <small>
                Format yang diizinkan: JPG, PNG, PDF, DOC, DOCX. Maksimal 10MB.
                <br>Semua bukti akan disimpan dengan aman dan hanya dapat diakses oleh tim PPKPT.
            </small>
        </div>
    </div>

    <!-- Google Drive Link Section -->
    <div id="gdrive-link-section" style="display: {{ old('evidence_type') == 'gdrive' ? 'block' : 'none' }};">
        <div class="mb-3">
            <label for="evidence_gdrive_link" class="form-label">
                <i class="fab fa-google-drive text-success"></i> Link Google Drive
            </label>
            <div class="input-group">
                <span class="input-group-text">
                    <i class="fas fa-link"></i>
                </span>
                <input type="url" 
                       name="evidence_gdrive_link" 
                       id="evidence_gdrive_link" 
                       class="form-control @error('evidence_gdrive_link') is-invalid @enderror"
                       value="{{ old('evidence_gdrive_link') }}" 
                       placeholder="https://drive.google.com/file/d/..."
                       autocomplete="url">
                @error('evidence_gdrive_link')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            <div class="form-text">
                <div class="alert alert-warning mt-2">
                    <small>
                        <i class="fas fa-exclamation-triangle"></i>
                        <strong>Penting:</strong> Pastikan link dapat diakses oleh tim PPKPT dengan cara:
                        <br>1. Klik kanan pada file di Google Drive
                        <br>2. Pilih "Get link" atau "Dapatkan link"
                        <br>3. Ubah permission menjadi <strong>"Anyone with the link can view"</strong>
                        <br>4. Copy dan paste link tersebut di form ini
                    </small>
                </div>
            </div>
        </div>
    </div>
</div>  