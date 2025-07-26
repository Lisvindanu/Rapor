// resources/js/whistleblower/form.js
// JavaScript untuk form whistleblower - Clean & Complete Version

class WhistleblowerForm {
    constructor() {
        this.terlamorIndex = 1;
        this.init();
    }

    init() {
        this.setupDisabilityToggle();
        this.setupTerlamorHandling();
        this.setupFileUpload();
        this.setupFormValidation();
        this.setupResetForm();
    }

    // Toggle untuk jenis disabilitas
    setupDisabilityToggle() {
        const memilikiDisabilitas = document.getElementById('memiliki_disabilitas');
        const jenisDisabilitasDiv = document.getElementById('jenis_disabilitas_div');
        
        if (memilikiDisabilitas && jenisDisabilitasDiv) {
            memilikiDisabilitas.addEventListener('change', function() {
                if (this.checked) {
                    jenisDisabilitasDiv.style.display = 'block';
                    document.getElementById('jenis_disabilitas').required = true;
                } else {
                    jenisDisabilitasDiv.style.display = 'none';
                    document.getElementById('jenis_disabilitas').required = false;
                    document.getElementById('jenis_disabilitas').value = '';
                }
            });
            
            // Check on page load
            if (memilikiDisabilitas.checked) {
                jenisDisabilitasDiv.style.display = 'block';
                document.getElementById('jenis_disabilitas').required = true;
            }
        }
    }

    // Setup handling untuk tambah/hapus terlapor
    setupTerlamorHandling() {
        const btnAddTerlapor = document.getElementById('btn-add-terlapor');
        
        if (btnAddTerlapor) {
            btnAddTerlapor.addEventListener('click', () => {
                this.addTerlapor();
            });
        }

        // Setup remove function globally
        window.removeTerlapor = (button) => {
            this.removeTerlapor(button);
        };
    }

    // Tambah terlapor baru
    addTerlapor() {
        this.terlamorIndex++;
        const container = document.getElementById('terlapor-container');
        
        const newTerlapor = document.createElement('div');
        newTerlapor.className = 'terlapor-item';
        newTerlapor.setAttribute('data-index', this.terlamorIndex);
        
        newTerlapor.innerHTML = `
            <button type="button" class="btn-remove-terlapor" onclick="removeTerlapor(this)">
                <i class="fas fa-times"></i>
            </button>
            <h6>Terlapor ${this.terlamorIndex}</h6>
            
            <div class="row mb-3">
                <div class="col-md-6">
                    <label class="form-label">Nama Terlapor <span class="text-danger">*</span></label>
                    <input type="text" class="form-control" 
                           name="terlapor[${this.terlamorIndex-1}][nama_terlapor]" required>
                </div>
                <div class="col-md-6">
                    <label class="form-label">Status <span class="text-danger">*</span></label>
                    <select class="form-select" name="terlapor[${this.terlamorIndex-1}][status_terlapor]" required>
                        <option value="">Pilih Status</option>
                        <option value="mahasiswa">Mahasiswa</option>
                        <option value="pegawai">Pegawai</option>
                    </select>
                </div>
            </div>

            <div class="row mb-3">
                <div class="col-md-6">
                    <label class="form-label">Nomor Identitas (NIM/NIP)</label>
                    <input type="text" class="form-control" 
                           name="terlapor[${this.terlamorIndex-1}][nomor_identitas]" 
                           placeholder="Opsional">
                </div>
                <div class="col-md-6">
                    <label class="form-label">Unit Kerja/Fakultas</label>
                    <input type="text" class="form-control" 
                           name="terlapor[${this.terlamorIndex-1}][unit_kerja_fakultas]" 
                           placeholder="Opsional">
                </div>
            </div>

            <div class="mb-3">
                <label class="form-label">Kontak Terlapor <span class="text-danger">*</span></label>
                <input type="text" class="form-control" 
                       name="terlapor[${this.terlamorIndex-1}][kontak_terlapor]" 
                       placeholder="Email atau Nomor Telepon" required>
            </div>
        `;
        
        container.appendChild(newTerlapor);
        
        // Add smooth animation
        newTerlapor.style.opacity = '0';
        newTerlapor.style.transform = 'translateY(-20px)';
        
        // Trigger animation
        requestAnimationFrame(() => {
            newTerlapor.style.transition = 'all 0.4s cubic-bezier(0.4, 0, 0.2, 1)';
            newTerlapor.style.opacity = '1';
            newTerlapor.style.transform = 'translateY(0)';
        });

        console.log(`Terlapor ${this.terlamorIndex} berhasil ditambahkan`);
    }

    // Hapus terlapor
    removeTerlapor(button) {
        const terlamorItem = button.closest('.terlapor-item');
        const container = document.getElementById('terlapor-container');
        
        // Don't allow removing if it's the only terlapor
        if (container.children.length <= 1) {
            alert('Minimal harus ada satu terlapor');
            return;
        }
        
        // Add smooth remove animation
        terlamorItem.style.transition = 'all 0.4s cubic-bezier(0.4, 0, 0.2, 1)';
        terlamorItem.style.opacity = '0';
        terlamorItem.style.transform = 'translateX(100%)';
        
        // Remove element after animation
        setTimeout(() => {
            terlamorItem.remove();
            this.updateTerlamorNumbering();
            console.log('Terlapor berhasil dihapus');
        }, 400);
    }

    // Update numbering setelah hapus terlapor
    updateTerlamorNumbering() {
        const terlamorItems = document.querySelectorAll('.terlapor-item');
        
        terlamorItems.forEach((item, index) => {
            const h6 = item.querySelector('h6');
            h6.textContent = `Terlapor ${index + 1}`;
            
            // Update name attributes
            const inputs = item.querySelectorAll('input, select');
            inputs.forEach(input => {
                const name = input.getAttribute('name');
                if (name) {
                    const newName = name.replace(/\[\d+\]/, `[${index}]`);
                    input.setAttribute('name', newName);
                }
            });
        });
        
        // Reset index counter
        this.terlamorIndex = terlamorItems.length;
    }

    // Setup file upload functionality
    setupFileUpload() {
        const fileInput = document.getElementById('file_bukti');
        const fileUploadArea = document.getElementById('file-upload-area');
        
        if (fileInput && fileUploadArea) {
            // Click to browse
            fileUploadArea.addEventListener('click', (e) => {
                // Prevent triggering if clicking on existing file display
                if (!fileUploadArea.classList.contains('file-selected')) {
                    fileInput.click();
                }
            });
            
            // Drag and drop handlers
            fileUploadArea.addEventListener('dragover', (e) => {
                e.preventDefault();
                fileUploadArea.classList.add('dragover');
            });
            
            fileUploadArea.addEventListener('dragleave', (e) => {
                e.preventDefault();
                fileUploadArea.classList.remove('dragover');
            });
            
            fileUploadArea.addEventListener('drop', (e) => {
                e.preventDefault();
                fileUploadArea.classList.remove('dragover');
                
                const files = e.dataTransfer.files;
                if (files.length > 0) {
                    const file = files[0];
                    if (this.validateFileType(file) && this.validateFileSize(file)) {
                        fileInput.files = files;
                        this.updateFileDisplay(file);
                    }
                }
            });
            
            // File change handler
            fileInput.addEventListener('change', (e) => {
                if (e.target.files.length > 0) {
                    const file = e.target.files[0];
                    if (this.validateFileType(file) && this.validateFileSize(file)) {
                        this.updateFileDisplay(file);
                    } else {
                        e.target.value = '';
                    }
                }
            });
        }
    }

    // Validasi tipe file
    validateFileType(file) {
        const allowedTypes = ['application/pdf', 'application/msword', 
                             'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
                             'image/jpeg', 'image/png', 'image/jpg'];
        
        if (!allowedTypes.includes(file.type)) {
            alert('Tipe file tidak didukung. Harap upload file: PDF, DOC, DOCX, JPG, atau PNG');
            return false;
        }
        return true;
    }

    // Validasi ukuran file
    validateFileSize(file) {
        const maxSize = 10 * 1024 * 1024; // 10MB
        
        if (file.size > maxSize) {
            alert('Ukuran file terlalu besar. Maksimal 10MB');
            return false;
        }
        return true;
    }

    // Update tampilan file yang dipilih
    updateFileDisplay(file) {
        const fileUploadArea = document.getElementById('file-upload-area');
        const fileSize = (file.size / 1024 / 1024).toFixed(2);
        
        fileUploadArea.classList.add('file-selected');
        fileUploadArea.innerHTML = `
            <i class="fas fa-file-alt"></i>
            <h6>${file.name}</h6>
            <p class="text-muted">${fileSize} MB</p>
            <small class="text-success">
                <i class="fas fa-check-circle me-1"></i>
                File berhasil dipilih
            </small>
            <button type="button" class="btn btn-sm btn-outline-danger mt-2" onclick="removeSelectedFile()">
                <i class="fas fa-times me-1"></i>Hapus File
            </button>
        `;
        
        console.log(`File dipilih: ${file.name} (${fileSize} MB)`);
    }

    // Setup form validation
    setupFormValidation() {
        const form = document.getElementById('whistleblowerForm');
        const submitBtn = document.getElementById('btnSubmit');
        
        if (form) {
            form.addEventListener('submit', (e) => {
                if (!this.validateForm()) {
                    e.preventDefault();
                    return false;
                }
                
                // Show loading state
                this.showLoadingState(submitBtn);
            });
        }

        // Google Drive URL validation
        const evidenceGdriveLink = document.getElementById('evidence_gdrive_link');
        if (evidenceGdriveLink) {
            evidenceGdriveLink.addEventListener('input', function() {
                const url = this.value.trim();
                
                if (url && !url.includes('drive.google.com')) {
                    this.setCustomValidity('Harus berupa link Google Drive yang valid');
                    this.classList.add('is-invalid');
                    this.classList.remove('is-valid');
                } else {
                    this.setCustomValidity('');
                    this.classList.remove('is-invalid');
                    if (url) {
                        this.classList.add('is-valid');
                    } else {
                        this.classList.remove('is-valid');
                    }
                }
            });
        }
    }

    // Validasi form sebelum submit
    validateForm() {
        const fileInput = document.getElementById('file_bukti');
        
        // Check required file upload
        if (!fileInput.files.length) {
            alert('Harap upload file bukti terlebih dahulu');
            fileInput.focus();
            return false;
        }
        
        // Check terlapor data
        const terlamorItems = document.querySelectorAll('.terlapor-item');
        if (terlamorItems.length === 0) {
            alert('Minimal harus ada satu data terlapor');
            return false;
        }
        
        console.log('Form validation passed');
        return true;
    }

    // Show loading state pada button
    showLoadingState(button) {
        button.classList.add('btn-loading');
        button.disabled = true;
        button.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i>Mengirim Laporan...';
        
        console.log('Form sedang disubmit...');
    }

    // Setup reset form functionality
    setupResetForm() {
        const resetBtn = document.getElementById('btnReset');
        
        if (resetBtn) {
            resetBtn.addEventListener('click', (e) => {
                if (!confirm('Apakah Anda yakin ingin mereset form? Semua data yang telah diisi akan hilang.')) {
                    e.preventDefault();
                    return;
                }
                
                // Reset dengan delay untuk animasi
                setTimeout(() => {
                    this.resetAllSections();
                    console.log('Form berhasil direset');
                }, 100);
            });
        }
    }

    // Reset semua section form
    resetAllSections() {
        // Reset file upload area
        this.resetFileUploadArea();
        
        // Reset terlapor ke satu saja
        this.resetTerlapor();
        
        // Hide jenis disabilitas
        const jenisDisabilitasDiv = document.getElementById('jenis_disabilitas_div');
        if (jenisDisabilitasDiv) {
            jenisDisabilitasDiv.style.display = 'none';
            const jenisDisabilitas = document.getElementById('jenis_disabilitas');
            if (jenisDisabilitas) {
                jenisDisabilitas.required = false;
                jenisDisabilitas.value = '';
            }
        }
        
        // Reset Google Drive link validation
        const evidenceGdriveLink = document.getElementById('evidence_gdrive_link');
        if (evidenceGdriveLink) {
            evidenceGdriveLink.classList.remove('is-valid', 'is-invalid');
        }
    }

    // Reset file upload area
    resetFileUploadArea() {
        const fileUploadArea = document.getElementById('file-upload-area');
        if (fileUploadArea) {
            fileUploadArea.classList.remove('file-selected', 'dragover');
            fileUploadArea.innerHTML = `
                <i class="fas fa-cloud-upload-alt"></i>
                <h6>Drag & Drop file atau klik untuk browse</h6>
                <p class="text-muted">Format: PDF, DOC, DOCX, JPG, PNG (Max: 10MB)</p>
                <input type="file" class="form-control" 
                       id="file_bukti" name="file_bukti" 
                       accept=".pdf,.doc,.docx,.jpg,.jpeg,.png" required>
            `;
            
            // Re-setup file upload functionality
            this.setupFileUpload();
        }
    }

    // Reset terlapor ke default (hanya satu)
    resetTerlapor() {
        const container = document.getElementById('terlapor-container');
        if (container) {
            // Hapus semua terlapor kecuali yang pertama
            const terlamorItems = container.querySelectorAll('.terlapor-item');
            for (let i = 1; i < terlamorItems.length; i++) {
                terlamorItems[i].remove();
            }
            
            // Reset index counter
            this.terlamorIndex = 1;
        }
    }
}

// Global function untuk hapus file
window.removeSelectedFile = function() {
    const fileInput = document.getElementById('file_bukti');
    const fileUploadArea = document.getElementById('file-upload-area');
    
    if (fileInput) fileInput.value = '';
    
    if (fileUploadArea) {
        fileUploadArea.classList.remove('file-selected');
        fileUploadArea.innerHTML = `
            <i class="fas fa-cloud-upload-alt"></i>
            <h6>Drag & Drop file atau klik untuk browse</h6>
            <p class="text-muted">Format: PDF, DOC, DOCX, JPG, PNG (Max: 10MB)</p>
            <input type="file" class="form-control" 
                   id="file_bukti" name="file_bukti" 
                   accept=".pdf,.doc,.docx,.jpg,.jpeg,.png" required>
        `;
        
        // Re-setup file upload
        const formInstance = window.whistleblowerFormInstance;
        if (formInstance) {
            formInstance.setupFileUpload();
        }
    }
    
    console.log('File dihapus');
};

// Initialize when DOM is loaded
document.addEventListener('DOMContentLoaded', function() {
    window.whistleblowerFormInstance = new WhistleblowerForm();
    console.log('Whistleblower Form initialized successfully');
});