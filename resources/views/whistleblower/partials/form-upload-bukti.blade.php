{{-- resources/views/whistleblower/partials/form-upload-bukti.blade.php --}}
<div class="mb-4">
    <label class="form-label fw-bold">
        <i class="fas fa-paperclip me-2"></i>Upload Bukti <span class="text-danger">*</span>
    </label>
    <p class="text-muted small mb-3">Lampirkan bukti pendukung yang relevan dengan pengaduan Anda</p>
    
    <div class="card">
        <div class="card-body">
            <!-- Evidence Type Toggle -->
            <div class="row mb-3">
                <div class="col-md-6">
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="evidence_type" id="evidence_file" value="file" 
                               {{ old('evidence_type', 'file') == 'file' ? 'checked' : '' }}>
                        <label class="form-check-label fw-bold" for="evidence_file">
                            <i class="fas fa-file-upload me-1"></i>Upload File
                        </label>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="evidence_type" id="evidence_gdrive" value="gdrive"
                               {{ old('evidence_type') == 'gdrive' ? 'checked' : '' }}>
                        <label class="form-check-label fw-bold" for="evidence_gdrive">
                            <i class="fab fa-google-drive me-1"></i>Link Google Drive
                        </label>
                    </div>
                </div>
            </div>

            <!-- File Upload Section -->
            <div id="file-upload-section" style="display: {{ old('evidence_type', 'file') == 'file' ? 'block' : 'none' }};">
                <div class="upload-area border border-2 border-dashed rounded p-4 text-center" id="file-drop-area">
                    <i class="fas fa-cloud-upload-alt fa-3x text-muted mb-3"></i>
                    <h6 class="text-muted">Drag & Drop file di sini</h6>
                    <p class="text-muted mb-3">atau</p>
                    <input type="file" class="form-control" id="file_bukti" name="file_bukti" 
                           accept=".pdf,.doc,.docx,.jpg,.jpeg,.png" style="display: none;">
                    <button type="button" class="btn btn-outline-primary" onclick="document.getElementById('file_bukti').click()">
                        <i class="fas fa-folder-open me-1"></i>Pilih File
                    </button>
                    <small class="form-text text-muted d-block mt-2">
                        Format: PDF, DOC, DOCX, JPG, PNG (Maksimal 10MB)
                    </small>
                </div>
                
                <div id="file-preview" class="mt-3" style="display: none;">
                    <div class="alert alert-success">
                        <i class="fas fa-file me-2"></i>
                        <span id="file-name"></span>
                        <button type="button" class="btn btn-sm btn-outline-danger float-end" onclick="clearFile()">
                            <i class="fas fa-times"></i>
                        </button>
                    </div>
                </div>
                
                @error('file_bukti')
                    <div class="invalid-feedback d-block">{{ $message }}</div>
                @enderror
            </div>

            <!-- Google Drive URL Section -->
            <div id="gdrive-upload-section" style="display: {{ old('evidence_type') == 'gdrive' ? 'block' : 'none' }};">
                <div class="row">
                    <div class="col-md-12 mb-3">
                        <label for="gdrive_link" class="form-label fw-bold">
                            <i class="fab fa-google-drive me-1 text-primary"></i>Link Google Drive <span class="text-danger">*</span>
                        </label>
                        <input type="url" class="form-control" id="gdrive_link" name="evidence_gdrive_link" 
                               placeholder="https://drive.google.com/file/d/..." 
                               value="{{ old('evidence_gdrive_link') }}">
                        @error('evidence_gdrive_link')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                
                <div class="alert alert-warning">
                    <h6 class="alert-heading">
                        <i class="fas fa-exclamation-triangle me-1"></i>Penting!
                    </h6>
                    <p class="mb-2">Pastikan file sudah di-share dengan akses <strong>"Anyone with the link can view"</strong></p>
                    
                    <details>
                        <summary class="fw-bold">Cara mendapatkan link Google Drive:</summary>
                        <ol class="mt-2 mb-0">
                            <li>Upload file bukti ke Google Drive Anda</li>
                            <li>Klik kanan pada file → pilih "Get link" atau "Dapatkan link"</li>
                            <li>Ubah pengaturan akses menjadi "Anyone with the link" → "Can view"</li>
                            <li>Copy link yang muncul dan paste di form ini</li>
                        </ol>
                    </details>
                </div>
            </div>
            
            @error('evidence_type')
                <div class="invalid-feedback d-block">{{ $message }}</div>
            @enderror
        </div>
    </div>
</div>