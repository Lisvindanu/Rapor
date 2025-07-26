{{-- resources/views/whistleblower/user/partials/form-upload.blade.php --}}
<div class="form-section">
    <h6><i class="fas fa-paperclip"></i> Upload Bukti Pendukung</h6>

    <!-- File Upload Section -->
    <div class="upload-section mt-3">
        <div class="upload-method file-upload">
            <h6><i class="fas fa-upload"></i> Upload File <span class="text-danger">*</span></h6>

            <div class="file-upload-area" id="file-upload-area">
                <h6>Klik atau seret file ke sini</h6>
                <p>Format: PDF, DOC, DOCX, JPG, PNG (Max: 10MB)</p>
                <input type="file" class="form-control @error('file_bukti') is-invalid @enderror" id="file_bukti"
                    name="file_bukti" accept=".pdf,.doc,.docx,.jpg,.jpeg,.png" required>
            </div>
            @error('file_bukti')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
    </div>

    <!-- Google Drive Section -->
    <div class="upload-section mt-4">
        <div class="upload-method gdrive-upload">
            <h6><i class="fab fa-google-drive"></i> Google Drive <span class="text-muted">(Opsional)</span></h6>
            <p>Berikan link Google Drive sebagai bukti tambahan</p>

            <div class="gdrive-section">
                <label for="evidence_gdrive_link" class="form-label">Link Google Drive</label>
                <input type="url" class="form-control @error('evidence_gdrive_link') is-invalid @enderror"
                    id="evidence_gdrive_link" name="evidence_gdrive_link" value="{{ old('evidence_gdrive_link') }}"
                    placeholder="https://drive.google.com/file/d/...">
                @error('evidence_gdrive_link')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
                <div class="form-text">
                    <i class="fas fa-info-circle me-1"></i>
                    Pastikan file Google Drive dapat diakses oleh siapa saja dengan link
                </div>
            </div>
        </div>
    </div>
</div>
