{{-- resources/views/whistleblower/partials/form-upload-bukti.blade.php --}}
<div class="mb-4">
    <h6 class="border-bottom pb-2 mb-3">Upload Bukti Pendukung</h6>
    
    <div class="border rounded p-3">
        <p class="mb-3"><strong>Pilih jenis bukti yang akan diupload:</strong> <span class="text-danger">*</span></p>
        
        <!-- Evidence Type Selection -->
        <div class="row mb-3">
            <div class="col-md-6">
                <div class="form-check evidence-option p-3 border rounded">
                    <input class="form-check-input" type="radio" name="evidence_type" 
                           id="evidence_file" value="file" 
                           {{ old('evidence_type') == 'file' ? 'checked' : '' }}>
                    <label class="form-check-label w-100" for="evidence_file">
                        <i class="fas fa-upload text-primary"></i>
                        <strong>Upload File</strong>
                        <small class="d-block text-muted">Upload file dari komputer Anda</small>
                    </label>
                </div>
            </div>
            
            <div class="col-md-6">
                <div class="form-check evidence-option p-3 border rounded">
                    <input class="form-check-input" type="radio" name="evidence_type" 
                           id="evidence_gdrive" value="gdrive" 
                           {{ old('evidence_type') == 'gdrive' ? 'checked' : '' }}>
                    <label class="form-check-label w-100" for="evidence_gdrive">
                        <i class="fab fa-google-drive text-success"></i>
                        <strong>Google Drive</strong>
                        <small class="d-block text-muted">Berikan link Google Drive</small>
                    </label>
                </div>
            </div>
        </div>
        
        @error('evidence_type')
            <div class="text-danger mb-3">
                <small>{{ $message }}</small>
            </div>
        @enderror
        
        <!-- File Upload Section -->
        <div id="fileUploadDiv">
            <div class="mb-3">
                <label for="file_bukti" class="form-label">Upload File Bukti <span class="text-danger">*</span></label>
                <input type="file" class="form-control @error('file_bukti') is-invalid @enderror" 
                       id="file_bukti" name="file_bukti" 
                       accept=".pdf,.doc,.docx,.jpg,.jpeg,.png">
                <div class="form-text">
                    Format yang didukung: PDF, DOC, DOCX, JPG, PNG. Maksimal 10MB.
                </div>
                @error('file_bukti')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            
            <!-- File Preview -->
            <div id="filePreview"></div>
        </div>
        
        <!-- Google Drive Section -->
        <div id="gdriveDiv">
            <div class="mb-3">
                <label for="evidence_gdrive_link" class="form-label">Link Google Drive <span class="text-danger">*</span></label>
                <input type="url" class="form-control @error('evidence_gdrive_link') is-invalid @enderror" 
                       id="evidence_gdrive_link" name="evidence_gdrive_link" 
                       value="{{ old('evidence_gdrive_link') }}"
                       placeholder="Masukkan URL Google Drive (contoh: https://drive.google.com/file/d/...)">
                <div class="form-text">
                    <strong>Pastikan link Google Drive dapat diakses publik:</strong><br>
                    1. Upload file ke Google Drive<br>
                    2. Klik kanan file → "Bagikan" atau "Share"<br>
                    3. Ubah akses menjadi "Siapa saja yang memiliki link dapat melihat"<br>
                    4. Copy link dan paste di form ini
                </div>
                @error('evidence_gdrive_link')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            
            <div class="alert alert-warning">
                <i class="fas fa-exclamation-triangle"></i>
                <strong>Penting:</strong> 
                Pastikan file di Google Drive Anda dapat diakses oleh tim PPKPT. 
                Link harus dalam format yang benar dan file harus dapat dilihat oleh publik.
            </div>
        </div>
    </div>
</div>