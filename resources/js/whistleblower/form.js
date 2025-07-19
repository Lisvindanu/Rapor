// resources/js/whistleblower/form.js - Complete JavaScript for Whistleblower Form

document.addEventListener('DOMContentLoaded', function() {
    console.log('🚀 Initializing Whistleblower Form...');
    initializeWhistleblowerForm();
});

function initializeWhistleblowerForm() {
    try {
        setupAnonymousToggle();
        setupDisabilityToggle();
        setupEvidenceToggle();
        setupFileUpload();
        setupTerlapor();
        setupFormValidation();
        setupGoogleDriveValidation();
        setupFormSubmission();
        
        console.log('✅ All whistleblower form components initialized successfully');
    } catch (error) {
        console.error('❌ Error initializing form:', error);
    }
}

// =================== ANONYMOUS TOGGLE ===================
function setupAnonymousToggle() {
    const anonymousCheckbox = document.getElementById('submit_anonim');
    const namaDisplay = document.getElementById('nama_display');
    const namaHidden = document.getElementById('nama_pelapor');
    
    if (anonymousCheckbox && namaDisplay && namaHidden) {
        // Get user name from meta tag or fallback
        const userNameMeta = document.querySelector('meta[name="user-name"]');
        const userName = userNameMeta ? userNameMeta.content : 
                        document.querySelector('.user-info strong')?.nextSibling?.textContent?.trim() || 
                        'User';
        
        anonymousCheckbox.addEventListener('change', function() {
            if (this.checked) {
                namaDisplay.value = 'Anonim';
                namaHidden.value = 'Anonim';
                namaDisplay.style.backgroundColor = '#fff3cd';
                namaDisplay.style.fontWeight = 'bold';
            } else {
                namaDisplay.value = userName;
                namaHidden.value = userName;
                namaDisplay.style.backgroundColor = '#e9ecef';
                namaDisplay.style.fontWeight = 'normal';
            }
        });
        
        // Initialize on page load
        if (anonymousCheckbox.checked) {
            namaDisplay.value = 'Anonim';
            namaHidden.value = 'Anonim';
            namaDisplay.style.backgroundColor = '#fff3cd';
            namaDisplay.style.fontWeight = 'bold';
        } else {
            namaDisplay.value = userName;
            namaHidden.value = userName;
        }
        
        console.log('✅ Anonymous toggle initialized');
    } else {
        console.warn('⚠️ Anonymous toggle elements not found');
    }
}

// =================== DISABILITY TOGGLE ===================
function setupDisabilityToggle() {
    const disabilitySelect = document.getElementById('memiliki_disabilitas');
    const disabilityContainer = document.getElementById('jenis_disabilitas_container');
    const disabilityInput = document.getElementById('jenis_disabilitas');
    
    if (disabilitySelect && disabilityContainer) {
        disabilitySelect.addEventListener('change', function() {
            if (this.value === '1') {
                disabilityContainer.style.display = 'block';
                disabilityContainer.style.animation = 'slideIn 0.3s ease';
                if (disabilityInput) {
                    disabilityInput.required = true;
                    disabilityInput.focus();
                }
            } else {
                disabilityContainer.style.display = 'none';
                if (disabilityInput) {
                    disabilityInput.value = '';
                    disabilityInput.required = false;
                    disabilityInput.classList.remove('is-invalid', 'is-valid');
                }
            }
        });
        
        console.log('✅ Disability toggle initialized');
    } else {
        console.warn('⚠️ Disability toggle elements not found');
    }
}

// =================== EVIDENCE TYPE TOGGLE ===================
function setupEvidenceToggle() {
    console.log('🔄 Setting up evidence toggle...');
    
    const fileRadio = document.getElementById('evidence_file');
    const gdriveRadio = document.getElementById('evidence_gdrive');
    const fileSection = document.getElementById('file-upload-section');
    const gdriveSection = document.getElementById('gdrive-upload-section');

    console.log('📋 Evidence elements check:', {
        fileRadio: !!fileRadio,
        gdriveRadio: !!gdriveRadio,
        fileSection: !!fileSection,
        gdriveSection: !!gdriveSection
    });

    if (fileRadio && gdriveRadio && fileSection && gdriveSection) {
        
        function toggleEvidenceSection() {
            console.log('🔄 Evidence toggle triggered');
            console.log('📁 File checked:', fileRadio.checked);
            console.log('🔗 GDrive checked:', gdriveRadio.checked);
            
            if (fileRadio.checked) {
                console.log('👉 Showing file upload section');
                fileSection.style.display = 'block';
                gdriveSection.style.display = 'none';
                
                // Clear gdrive input and requirements
                const gdriveInput = document.getElementById('gdrive_link');
                if (gdriveInput) {
                    gdriveInput.value = '';
                    gdriveInput.classList.remove('is-invalid', 'is-valid');
                    gdriveInput.required = false;
                }
                
                // Make file input required
                const fileInput = document.getElementById('file_bukti');
                if (fileInput) {
                    fileInput.required = true;
                }
                
            } else if (gdriveRadio.checked) {
                console.log('👉 Showing Google Drive section');
                fileSection.style.display = 'none';
                gdriveSection.style.display = 'block';
                
                // Clear file input and requirements
                const fileInput = document.getElementById('file_bukti');
                if (fileInput) {
                    fileInput.value = '';
                    fileInput.required = false;
                    clearFile();
                }
                
                // Make gdrive input required
                const gdriveInput = document.getElementById('gdrive_link');
                if (gdriveInput) {
                    gdriveInput.required = true;
                    // Auto focus on Google Drive input
                    setTimeout(() => gdriveInput.focus(), 100);
                }
            }
            
            console.log('✅ Evidence toggle completed');
        }

        // Add multiple event listeners for maximum compatibility
        fileRadio.addEventListener('change', toggleEvidenceSection);
        gdriveRadio.addEventListener('change', toggleEvidenceSection);
        fileRadio.addEventListener('click', toggleEvidenceSection);
        gdriveRadio.addEventListener('click', toggleEvidenceSection);
        
        // Initialize toggle state multiple times to ensure it works
        setTimeout(toggleEvidenceSection, 50);
        setTimeout(toggleEvidenceSection, 200);
        setTimeout(toggleEvidenceSection, 500);
        
        // Global function for manual testing
        window.forceEvidenceToggle = function() {
            console.log('🔧 Force evidence toggle called');
            toggleEvidenceSection();
        };
        
        console.log('✅ Evidence toggle setup completed');
    } else {
        console.error('❌ Evidence toggle elements missing');
        
        // Debug missing elements
        if (!fileRadio) console.error('❌ File radio not found: #evidence_file');
        if (!gdriveRadio) console.error('❌ GDrive radio not found: #evidence_gdrive');
        if (!fileSection) console.error('❌ File section not found: #file-upload-section');
        if (!gdriveSection) console.error('❌ GDrive section not found: #gdrive-upload-section');
    }
}

// =================== FILE UPLOAD ===================
function setupFileUpload() {
    const dropArea = document.getElementById('file-drop-area');
    const fileInput = document.getElementById('file_bukti');
    const filePreview = document.getElementById('file-preview');
    const fileName = document.getElementById('file-name');

    if (!dropArea || !fileInput) {
        console.warn('⚠️ File upload elements not found');
        return;
    }

    // Drag and drop events
    dropArea.addEventListener('dragover', function(e) {
        e.preventDefault();
        e.stopPropagation();
        this.classList.add('dragover');
    });

    dropArea.addEventListener('dragleave', function(e) {
        e.preventDefault();
        e.stopPropagation();
        this.classList.remove('dragover');
    });

    dropArea.addEventListener('drop', function(e) {
        e.preventDefault();
        e.stopPropagation();
        this.classList.remove('dragover');
        
        const files = e.dataTransfer.files;
        if (files.length > 0) {
            handleFileSelect(files[0]);
        }
    });

    // File input change
    fileInput.addEventListener('change', function() {
        if (this.files.length > 0) {
            handleFileSelect(this.files[0]);
        }
    });

    function handleFileSelect(file) {
        console.log('📁 File selected:', file.name, file.size, file.type);
        
        // Validate file size
        const maxSize = 10 * 1024 * 1024; // 10MB
        if (file.size > maxSize) {
            showAlert('File terlalu besar. Maksimal 10MB.', 'error');
            fileInput.value = '';
            return;
        }

        // Validate file type
        const allowedTypes = [
            'application/pdf',
            'application/msword',
            'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
            'image/jpeg',
            'image/jpg',
            'image/png'
        ];

        if (!allowedTypes.includes(file.type)) {
            showAlert('Format file tidak didukung. Gunakan PDF, DOC, DOCX, JPG, atau PNG.', 'error');
            fileInput.value = '';
            return;
        }

        // Show preview
        if (fileName && filePreview) {
            fileName.textContent = file.name + ' (' + formatFileSize(file.size) + ')';
            filePreview.style.display = 'block';
        }
        
        // Remove validation error and add success state
        fileInput.classList.remove('is-invalid');
        fileInput.classList.add('is-valid');
        
        console.log('✅ File validated and preview shown');
    }

    function formatFileSize(bytes) {
        if (bytes === 0) return '0 Bytes';
        const k = 1024;
        const sizes = ['Bytes', 'KB', 'MB', 'GB'];
        const i = Math.floor(Math.log(bytes) / Math.log(k));
        return parseFloat((bytes / Math.pow(k, i)).toFixed(2)) + ' ' + sizes[i];
    }
    
    console.log('✅ File upload initialized');
}

function clearFile() {
    const fileInput = document.getElementById('file_bukti');
    const filePreview = document.getElementById('file-preview');
    
    if (fileInput) {
        fileInput.value = '';
        fileInput.classList.remove('is-valid', 'is-invalid');
    }
    if (filePreview) {
        filePreview.style.display = 'none';
    }
    
    console.log('🗑️ File cleared');
}

// =================== GOOGLE DRIVE VALIDATION ===================
function setupGoogleDriveValidation() {
    const gdriveInput = document.getElementById('gdrive_link');
    
    if (gdriveInput) {
        // Real-time validation
        gdriveInput.addEventListener('input', function() {
            debounce(() => validateGoogleDriveUrl(this), 300)();
        });
        
        gdriveInput.addEventListener('blur', function() {
            validateGoogleDriveUrl(this);
        });
        
        gdriveInput.addEventListener('paste', function() {
            setTimeout(() => validateGoogleDriveUrl(this), 100);
        });
        
        console.log('✅ Google Drive validation initialized');
    }
}

function validateGoogleDriveUrl(input) {
    const url = input.value.trim();
    
    if (url === '') {
        input.classList.remove('is-invalid', 'is-valid');
        return;
    }

    if (isValidGoogleDriveUrl(url)) {
        input.classList.remove('is-invalid');
        input.classList.add('is-valid');
        console.log('✅ Valid Google Drive URL');
    } else {
        input.classList.remove('is-valid');
        input.classList.add('is-invalid');
        console.log('❌ Invalid Google Drive URL');
    }
}

function isValidGoogleDriveUrl(url) {
    try {
        const urlObj = new URL(url);
        const hostname = urlObj.hostname.toLowerCase();
        
        // Check if it's a Google Drive or Google Docs URL
        const validHostnames = [
            'drive.google.com',
            'docs.google.com'
        ];
        
        const isValidHost = validHostnames.some(validHostname => 
            hostname === validHostname || hostname.endsWith('.' + validHostname)
        );
        
        // Additional check for Google Drive file pattern
        const hasFilePattern = url.includes('/file/d/') || 
                              url.includes('/document/d/') || 
                              url.includes('/spreadsheets/d/') ||
                              url.includes('/presentation/d/');
        
        return isValidHost && hasFilePattern;
    } catch (e) {
        return false;
    }
}

// =================== TERLAPOR MANAGEMENT ===================
function setupTerlapor() {
    let terlapor_count = document.querySelectorAll('.terlapor-item').length;

    const addBtn = document.getElementById('add-terlapor');
    if (addBtn) {
        addBtn.addEventListener('click', function() {
            console.log('➕ Adding new terlapor...', terlapor_count);
            const container = document.getElementById('terlapor-container');
            const newTerlapor = createTerlapor(terlapor_count);
            container.appendChild(newTerlapor);
            terlapor_count++;
            
            // Animate and scroll to new terlapor
            newTerlapor.style.opacity = '0';
            newTerlapor.style.transform = 'translateY(-20px)';
            setTimeout(() => {
                newTerlapor.style.transition = 'all 0.3s ease';
                newTerlapor.style.opacity = '1';
                newTerlapor.style.transform = 'translateY(0)';
                newTerlapor.scrollIntoView({ behavior: 'smooth', block: 'center' });
            }, 10);
        });
    }

    function createTerlapor(index) {
        const div = document.createElement('div');
        div.className = 'terlapor-item bg-light p-3 rounded mb-3';
        div.dataset.index = index;
        
        div.innerHTML = `
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h6 class="mb-0 fw-bold">
                    <i class="fas fa-user me-2"></i>Terlapor ${index + 1}
                </h6>
                <button type="button" class="btn btn-outline-danger btn-sm" onclick="removeTerlapor(this)">
                    <i class="fas fa-times me-1"></i>Hapus
                </button>
            </div>
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label for="terlapor_kontak_${index}" class="form-label fw-bold">
                        Nomor telepon dan alamat surel (e-mail) pihak lain yang dapat dikonfirmasi <span class="text-danger">*</span>
                    </label>
                    <input type="text" class="form-control" name="terlapor[${index}][kontak_terlapor]" 
                           id="terlapor_kontak_${index}" placeholder="Email atau nomor telepon terlapor" required>
                    <small class="form-text text-muted">Email/No HP terlapor yang dapat dihubungi</small>
                </div>
                <div class="col-md-6 mb-3">
                    <label for="terlapor_status_${index}" class="form-label fw-bold">
                        Status Terlapor <span class="text-danger">*</span>
                    </label>
                    <select class="form-select" name="terlapor[${index}][status_terlapor]" id="terlapor_status_${index}" required>
                        <option value="">Pilih Status</option>
                        <option value="pegawai">Pegawai</option>
                        <option value="mahasiswa">Mahasiswa</option>
                    </select>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label for="terlapor_nama_${index}" class="form-label">Nama Terlapor (Opsional)</label>
                    <input type="text" class="form-control" name="terlapor[${index}][nama_terlapor]" 
                           id="terlapor_nama_${index}" placeholder="Nama lengkap terlapor">
                </div>
                <div class="col-md-6 mb-3">
                    <label for="terlapor_nomor_${index}" class="form-label">NIM/NIP (Opsional)</label>
                    <input type="text" class="form-control" name="terlapor[${index}][nomor_identitas]" 
                           id="terlapor_nomor_${index}" placeholder="NIM/NIP terlapor">
                </div>
            </div>
            <div class="mb-3">
                <label for="terlapor_unit_${index}" class="form-label">Unit Kerja/Fakultas (Opsional)</label>
                <input type="text" class="form-control" name="terlapor[${index}][unit_kerja_fakultas]" 
                       id="terlapor_unit_${index}" placeholder="Contoh: Fakultas Teknik, Bagian Keuangan">
            </div>
        `;
        
        return div;
    }
    
    console.log('✅ Terlapor management initialized, count:', terlapor_count);
}

function removeTerlapor(button) {
    const terlapor = button.closest('.terlapor-item');
    const container = document.getElementById('terlapor-container');
    
    // Don't remove if it's the only one
    if (container.children.length > 1) {
        // Animate out
        terlapor.style.transition = 'all 0.3s ease';
        terlapor.style.opacity = '0';
        terlapor.style.transform = 'translateX(100%)';
        
        setTimeout(() => {
            terlapor.remove();
            console.log('🗑️ Terlapor removed');
        }, 300);
    } else {
        showAlert('Minimal harus ada satu terlapor.', 'warning');
    }
}

// =================== FORM VALIDATION ===================
function setupFormValidation() {
    const form = document.getElementById('pengaduanForm');
    
    if (!form) {
        console.warn('⚠️ Form not found with ID: pengaduanForm');
        return;
    }

    // Real-time validation for required fields
    const requiredFields = form.querySelectorAll('[required]');
    requiredFields.forEach(field => {
        field.addEventListener('blur', function() {
            validateField(this);
        });
        
        field.addEventListener('input', function() {
            if (this.classList.contains('is-invalid')) {
                validateField(this);
            }
        });
    });

    // Checkbox validation for alasan pengaduan
    const alasanCheckboxes = form.querySelectorAll('input[name="alasan_pengaduan[]"]');
    alasanCheckboxes.forEach(checkbox => {
        checkbox.addEventListener('change', function() {
            validateAlasanPengaduan();
        });
    });

    function validateField(field) {
        if (field.hasAttribute('required') && !field.value.trim()) {
            field.classList.add('is-invalid');
            field.classList.remove('is-valid');
            return false;
        } else {
            field.classList.remove('is-invalid');
            field.classList.add('is-valid');
            return true;
        }
    }

    function validateAlasanPengaduan() {
        const checked = form.querySelectorAll('input[name="alasan_pengaduan[]"]:checked');
        const alasanSection = form.querySelector('.form-check-input[name="alasan_pengaduan[]"]').closest('.mb-4');
        
        if (checked.length === 0) {
            alasanSection.classList.add('border', 'border-danger', 'rounded', 'p-2');
        } else {
            alasanSection.classList.remove('border', 'border-danger', 'rounded', 'p-2');
        }
        
        return checked.length > 0;
    }
    
    console.log('✅ Form validation initialized');
}

// =================== FORM SUBMISSION ===================
function setupFormSubmission() {
    const form = document.getElementById('pengaduanForm');
    
    if (!form) return;

    form.addEventListener('submit', function(e) {
        console.log('📝 Form submission started...');
        
        if (!validateCompleteForm()) {
            e.preventDefault();
            console.log('❌ Form validation failed');
            return false;
        }

        // Show loading state
        showLoadingState();
        console.log('✅ Form submitted successfully');
    });

    function validateCompleteForm() {
        let isValid = true;
        const errors = [];

        // Clear previous validation states
        form.querySelectorAll('.is-invalid').forEach(el => el.classList.remove('is-invalid'));

        // Validate required fields
        const requiredFields = form.querySelectorAll('[required]');
        requiredFields.forEach(field => {
            if (!field.value.trim()) {
                isValid = false;
                field.classList.add('is-invalid');
                const label = field.labels[0]?.textContent.replace('*', '').trim() || field.placeholder || field.name;
                errors.push(`${label} harus diisi`);
            }
        });

        // Validate alasan pengaduan
        const alasanChecked = form.querySelectorAll('input[name="alasan_pengaduan[]"]:checked');
        if (alasanChecked.length === 0) {
            isValid = false;
            errors.push('Minimal pilih satu alasan pengaduan');
        }

        // Validate evidence
        const evidenceType = form.querySelector('input[name="evidence_type"]:checked')?.value;
        if (evidenceType === 'file') {
            const fileInput = document.getElementById('file_bukti');
            if (!fileInput.files.length) {
                isValid = false;
                fileInput.classList.add('is-invalid');
                errors.push('File bukti harus diupload');
            }
        } else if (evidenceType === 'gdrive') {
            const gdriveLink = document.getElementById('gdrive_link');
            if (!gdriveLink.value.trim()) {
                isValid = false;
                gdriveLink.classList.add('is-invalid');
                errors.push('Link Google Drive harus diisi');
            } else if (!isValidGoogleDriveUrl(gdriveLink.value)) {
                isValid = false;
                gdriveLink.classList.add('is-invalid');
                errors.push('Format URL Google Drive tidak valid. Pastikan menggunakan link sharing dari Google Drive');
            }
        }

        // Validate terlapor data
        const terlaporItems = form.querySelectorAll('.terlapor-item');
        terlaporItems.forEach((item, index) => {
            const kontak = item.querySelector('input[name*="[kontak_terlapor]"]');
            const status = item.querySelector('select[name*="[status_terlapor]"]');

            if (kontak && !kontak.value.trim()) {
                isValid = false;
                kontak.classList.add('is-invalid');
                errors.push(`Kontak terlapor ${index + 1} harus diisi`);
            }

            if (status && !status.value) {
                isValid = false;
                status.classList.add('is-invalid');
                errors.push(`Status terlapor ${index + 1} harus dipilih`);
            }
        });

        // Validate persetujuan kebijakan
        const persetujuan = document.getElementById('persetujuan_kebijakan');
        if (persetujuan && !persetujuan.checked) {
            isValid = false;
            persetujuan.classList.add('is-invalid');
            errors.push('Anda harus menyetujui kebijakan privasi');
        }

        if (!isValid) {
            const errorMessage = 'Mohon perbaiki kesalahan berikut:\n\n' + errors.join('\n• ');
            showAlert(errorMessage, 'error');
            
            // Scroll to first error
            const firstError = form.querySelector('.is-invalid');
            if (firstError) {
                firstError.scrollIntoView({ behavior: 'smooth', block: 'center' });
                setTimeout(() => {
                    firstError.focus();
                    if (firstError.type === 'checkbox' || firstError.type === 'radio') {
                        firstError.click();
                    }
                }, 500);
            }
        }

        return isValid;
    }

    function showLoadingState() {
        const submitBtn = form.querySelector('button[type="submit"]');
        
        if (submitBtn) {
            submitBtn.disabled = true;
            submitBtn.innerHTML = `
                <span class="spinner-border spinner-border-sm me-2" role="status" aria-hidden="true"></span>
                Mengirim Pengaduan...
            `;
            form.classList.add('loading');
            
            // Disable all form inputs
            const formInputs = form.querySelectorAll('input, select, textarea, button');
            formInputs.forEach(input => {
                if (input !== submitBtn) {
                    input.disabled = true;
                }
            });
        }
    }
    
    console.log('✅ Form submission handlers initialized');
}

// =================== UTILITY FUNCTIONS ===================

// Debounce function for performance
function debounce(func, wait) {
    let timeout;
    return function executedFunction(...args) {
        const later = () => {
            clearTimeout(timeout);
            func(...args);
        };
        clearTimeout(timeout);
        timeout = setTimeout(later, wait);
    };
}

// Show alert messages
function showAlert(message, type = 'info', duration = 5000) {
    // Remove existing alerts
    const existingAlerts = document.querySelectorAll('.floating-alert');
    existingAlerts.forEach(alert => alert.remove());
    
    const alertDiv = document.createElement('div');
    alertDiv.className = `alert alert-${type === 'error' ? 'danger' : type} alert-dismissible fade show floating-alert`;
    alertDiv.style.cssText = `
        position: fixed;
        top: 20px;
        right: 20px;
        z-index: 9999;
        max-width: 400px;
        min-width: 300px;
        box-shadow: 0 4px 12px rgba(0,0,0,0.15);
    `;
    
    const icon = type === 'error' ? 'fa-exclamation-triangle' : 
                 type === 'warning' ? 'fa-exclamation-circle' : 
                 type === 'success' ? 'fa-check-circle' : 'fa-info-circle';
    
    alertDiv.innerHTML = `
        <div class="d-flex align-items-start">
            <i class="fas ${icon} me-2 mt-1"></i>
            <div class="flex-grow-1">
                <div style="white-space: pre-line;">${message}</div>
            </div>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    `;
    
    document.body.appendChild(alertDiv);
    
    // Auto remove after duration
    setTimeout(() => {
        if (alertDiv.parentNode) {
            alertDiv.remove();
        }
    }, duration);
    
    console.log(`🔔 Alert shown: ${type} - ${message}`);
}

// Add CSS animations
function addFormAnimations() {
    const style = document.createElement('style');
    style.textContent = `
        @keyframes slideIn {
            from {
                opacity: 0;
                transform: translateY(-10px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
        
        @keyframes slideOut {
            from {
                opacity: 1;
                transform: translateX(0);
            }
            to {
                opacity: 0;
                transform: translateX(100%);
            }
        }
        
        @keyframes pulse {
            0% { transform: scale(1); }
            50% { transform: scale(1.05); }
            100% { transform: scale(1); }
        }
        
        .terlapor-item {
            transition: all 0.3s ease;
        }
        
        .terlapor-item:hover {
            box-shadow: 0 2px 8px rgba(0,0,0,0.1);
        }
        
        .form-control:focus, .form-select:focus {
            animation: pulse 0.3s ease;
        }
        
        .loading {
            opacity: 0.8;
            pointer-events: none;
        }
        
        .dragover {
            border-color: #0d6efd !important;
            background-color: #e3f2fd !important;
            transform: scale(1.02);
        }
    `;
    document.head.appendChild(style);
}

// Initialize animations
addFormAnimations();

// =================== GLOBAL FUNCTIONS ===================

// Global functions for inline event handlers and testing
window.removeTerlapor = removeTerlapor;
window.clearFile = clearFile;

// Debug functions for testing
window.debugWhistleblowerForm = function() {
    console.log('🔍 Whistleblower Form Debug Info:');
    console.log('================================');
    console.log('- Anonymous checkbox:', document.getElementById('submit_anonim')?.checked);
    console.log('- Disability select:', document.getElementById('memiliki_disabilitas')?.value);
    console.log('- Evidence type:', document.querySelector('input[name="evidence_type"]:checked')?.value);
    console.log('- File section display:', document.getElementById('file-upload-section')?.style.display);
    console.log('- GDrive section display:', document.getElementById('gdrive-upload-section')?.style.display);
    console.log('- Terlapor count:', document.querySelectorAll('.terlapor-item').length);
    console.log('- Form valid:', document.getElementById('pengaduanForm')?.checkValidity());
    console.log('- Required fields:', document.querySelectorAll('[required]').length);
    console.log('- Alasan checked:', document.querySelectorAll('input[name="alasan_pengaduan[]"]:checked').length);
    console.log('================================');
};

// Force evidence toggle for testing
window.forceEvidenceToggle = function() {
    const gdriveRadio = document.getElementById('evidence_gdrive');
    const fileSection = document.getElementById('file-upload-section');
    const gdriveSection = document.getElementById('gdrive-upload-section');
    
    if (gdriveRadio && gdriveRadio.checked) {
        console.log('🔧 Force showing Google Drive section');
        if (fileSection) fileSection.style.display = 'none';
        if (gdriveSection) gdriveSection.style.display = 'block';
        showAlert('Google Drive section dipaksa ditampilkan!', 'info');
    } else {
        console.log('🔧 Google Drive radio not checked');
        showAlert('Google Drive radio tidak dicentang', 'warning');
    }
};

// Test form validation
window.testFormValidation = function() {
    const form = document.getElementById('pengaduanForm');
    if (form) {
        const event = new Event('submit', { cancelable: true });
        form.dispatchEvent(event);
    }
};

// Quick fill form for testing
window.quickFillForm = function() {
    console.log('🧪 Quick filling form for testing...');
    
    // Fill basic info
    const namaInput = document.getElementById('nama_pelapor');
    if (namaInput) namaInput.value = 'Test User';
    
    const statusSelect = document.getElementById('status_pelapor');
    if (statusSelect) statusSelect.value = 'saksi';
    
    const kategoriSelect = document.getElementById('kategori_pengaduan_id');
    if (kategoriSelect && kategoriSelect.options.length > 1) {
        kategoriSelect.selectedIndex = 1;
    }
    
    const ceritaTextarea = document.getElementById('cerita_singkat_peristiwa');
    if (ceritaTextarea) ceritaTextarea.value = 'Test cerita singkat peristiwa untuk testing form';
    
    // Fill terlapor
    const kontakInput = document.querySelector('input[name*="kontak_terlapor"]');
    if (kontakInput) kontakInput.value = 'test@example.com';
    
    const statusTerlaporSelect = document.querySelector('select[name*="status_terlapor"]');
    if (statusTerlaporSelect) statusTerlaporSelect.value = 'pegawai';
    
    // Check alasan
    const alasanCheckbox = document.querySelector('input[name="alasan_pengaduan[]"]');
    if (alasanCheckbox) alasanCheckbox.checked = true;
    
    // Check persetujuan
    const persetujuanCheckbox = document.getElementById('persetujuan_kebijakan');
    if (persetujuanCheckbox) persetujuanCheckbox.checked = true;
    
    showAlert('Form berhasil diisi untuk testing!', 'success');
};

// =================== INITIALIZATION COMPLETE ===================

console.log('🎉 Whistleblower form JavaScript loaded successfully!');
console.log('💡 Available debug functions:');
console.log('   - debugWhistleblowerForm() - Show form debug info');
console.log('   - forceEvidenceToggle() - Force toggle evidence section');
console.log('   - testFormValidation() - Test form validation');
console.log('   - quickFillForm() - Quick fill form for testing');

// Auto-run evidence toggle after page load to ensure it works
setTimeout(() => {
    if (window.forceEvidenceToggle) {
        const evidenceRadios = document.querySelectorAll('input[name="evidence_type"]');
        if (evidenceRadios.length > 0) {
            console.log('🔄 Auto-triggering evidence toggle...');
            window.forceEvidenceToggle();
        }
    }
}, 1000);