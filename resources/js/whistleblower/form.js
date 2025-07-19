// resources/js/whistleblower/form.js

let terlaporCount = 1;

document.addEventListener('DOMContentLoaded', function() {
    initializeWhistleblowerForm();
});

function initializeWhistleblowerForm() {
    // Initialize evidence type toggle
    initializeEvidenceToggle();
    
    // Initialize disability field toggle
    initializeDisabilityToggle();
    
    // Initialize add terlapor functionality
    initializeAddTerlapor();
    
    // Initialize form validation
    initializeFormValidation();
    
    // Initialize remove buttons
    updateRemoveButtons();
    
    console.log('Whistleblower form initialized');
}

function initializeEvidenceToggle() {
    const fileRadio = document.getElementById('evidence_file_radio');
    const gdriveRadio = document.getElementById('evidence_gdrive_radio');
    const fileSection = document.getElementById('file-upload-section');
    const gdriveSection = document.getElementById('gdrive-link-section');

    if (!fileRadio || !gdriveRadio || !fileSection || !gdriveSection) {
        console.error('Evidence toggle elements not found');
        return;
    }

    function toggleEvidenceType() {
        if (fileRadio.checked) {
            fileSection.style.display = 'block';
            gdriveSection.style.display = 'none';
            const gdriveInput = document.getElementById('evidence_gdrive_link');
            if (gdriveInput) gdriveInput.value = '';
        } else if (gdriveRadio.checked) {
            fileSection.style.display = 'none';
            gdriveSection.style.display = 'block';
            const fileInput = document.getElementById('evidence_file');
            if (fileInput) fileInput.value = '';
        }
    }

    fileRadio.addEventListener('change', toggleEvidenceType);
    gdriveRadio.addEventListener('change', toggleEvidenceType);
    
    // Initial toggle
    toggleEvidenceType();
}

function initializeDisabilityToggle() {
    const disabilitySelect = document.getElementById('memiliki_disabilitas');
    const wrapper = document.getElementById('jenis_disabilitas_wrapper');
    const jenisInput = document.getElementById('jenis_disabilitas');

    if (!disabilitySelect || !wrapper || !jenisInput) {
        console.error('Disability toggle elements not found');
        return;
    }

    disabilitySelect.addEventListener('change', function() {
        if (this.value === '1') {
            wrapper.style.display = 'block';
            jenisInput.required = true;
        } else {
            wrapper.style.display = 'none';
            jenisInput.required = false;
            jenisInput.value = '';
        }
    });

    // Initial state
    if (disabilitySelect.value === '1') {
        wrapper.style.display = 'block';
        jenisInput.required = true;
    }
}

function initializeAddTerlapor() {
    const addButton = document.getElementById('add-terlapor');
    
    if (!addButton) {
        console.error('Add terlapor button not found');
        return;
    }

    addButton.addEventListener('click', function() {
        console.log('Adding terlapor #' + (terlaporCount + 1));
        const container = document.getElementById('terlapor-container');
        
        if (!container) {
            console.error('Terlapor container not found');
            return;
        }

        const newTerlapor = createTerlaporItem(terlaporCount);
        container.appendChild(newTerlapor);
        terlaporCount++;
        updateRemoveButtons();
        
        console.log('Terlapor added successfully. Total count:', terlaporCount);
    });
}

function initializeFormValidation() {
    const form = document.getElementById('pengaduanForm');
    
    if (!form) {
        console.error('Form not found');
        return;
    }

    form.addEventListener('submit', function(e) {
        console.log('Form submission started');
        
        if (!validateForm()) {
            e.preventDefault();
            console.log('Form validation failed');
            return false;
        }

        // Show loading state
        const submitBtn = form.querySelector('button[type="submit"]');
        if (submitBtn) {
            const originalText = submitBtn.innerHTML;
            submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Mengirim...';
            submitBtn.disabled = true;
            
            // Restore button if form submission fails
            setTimeout(() => {
                if (submitBtn.disabled) {
                    submitBtn.innerHTML = originalText;
                    submitBtn.disabled = false;
                }
            }, 10000); // 10 seconds timeout
        }
        
        console.log('Form validation passed, submitting...');
    });
}

function createTerlaporItem(index) {
    const div = document.createElement('div');
    div.className = 'terlapor-item border rounded p-3 mb-3';
    div.dataset.index = index;
    
    div.innerHTML = `
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h6 class="mb-0 text-primary">Terlapor #${index + 1}</h6>
            <button type="button" class="btn btn-sm btn-outline-danger remove-terlapor">
                <i class="fas fa-trash"></i>
            </button>
        </div>
        <div class="row">
            <div class="col-md-6">
                <div class="mb-3">
                    <label class="form-label">Nama Terlapor <span class="text-danger">*</span></label>
                    <input type="text" class="form-control" name="terlapor[${index}][nama]" placeholder="Nama lengkap terlapor" required>
                </div>
            </div>
            <div class="col-md-6">
                <div class="mb-3">
                    <label class="form-label">Status Terlapor <span class="text-danger">*</span></label>
                    <select class="form-select" name="terlapor[${index}][status]" required>
                        <option value="">Pilih Status</option>
                        <option value="mahasiswa">Mahasiswa</option>
                        <option value="pegawai">Pegawai</option>
                    </select>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6">
                <div class="mb-3">
                    <label class="form-label">Nomor Identitas (NIM/NIP)</label>
                    <input type="text" class="form-control" name="terlapor[${index}][nomor_identitas]" placeholder="Opsional">
                </div>
            </div>
            <div class="col-md-6">
                <div class="mb-3">
                    <label class="form-label">Fakultas/Unit Kerja</label>
                    <input type="text" class="form-control" name="terlapor[${index}][unit_kerja]" placeholder="Opsional">
                </div>
            </div>
        </div>
        <div class="mb-3">
            <label class="form-label">Nomor telepon dan alamat surel (*e-mail*) pihak lain yang dapat dikonfirmasi <span class="text-danger">*</span></label>
            <input type="text" class="form-control" name="terlapor[${index}][kontak]" placeholder="No Telp/alamat email terlapor yang dapat dihubungi" required>
        </div>
    `;
    
    // Add remove functionality
    const removeBtn = div.querySelector('.remove-terlapor');
    removeBtn.addEventListener('click', function() {
        console.log('Removing terlapor');
        div.remove();
        updateTerlaporNumbers();
        updateRemoveButtons();
    });
    
    return div;
}

function updateRemoveButtons() {
    const items = document.querySelectorAll('.terlapor-item');
    
    items.forEach((item, index) => {
        const removeBtn = item.querySelector('.remove-terlapor');
        if (removeBtn) {
            if (items.length > 1) {
                removeBtn.style.display = 'inline-block';
            } else {
                removeBtn.style.display = 'none';
            }
        }
    });
    
    console.log('Remove buttons updated. Total items:', items.length);
}

function updateTerlaporNumbers() {
    const items = document.querySelectorAll('.terlapor-item');
    
    items.forEach((item, index) => {
        const header = item.querySelector('h6');
        if (header) {
            header.textContent = `Terlapor #${index + 1}`;
        }
    });
    
    console.log('Terlapor numbers updated');
}

function validateForm() {
    // Check if at least one alasan pengaduan is selected
    const alasanChecked = document.querySelectorAll('input[name="alasan_pengaduan[]"]:checked');
    if (alasanChecked.length === 0) {
        alert('Silakan pilih minimal satu alasan pengaduan');
        const firstAlasan = document.querySelector('input[name="alasan_pengaduan[]"]');
        if (firstAlasan) firstAlasan.focus();
        return false;
    }

    // Check evidence requirement
    const evidenceTypeRadio = document.querySelector('input[name="evidence_type"]:checked');
    if (!evidenceTypeRadio) {
        alert('Silakan pilih metode upload bukti');
        return false;
    }

    const evidenceType = evidenceTypeRadio.value;
    
    if (evidenceType === 'file') {
        const fileInput = document.getElementById('evidence_file');
        if (!fileInput || !fileInput.files.length) {
            alert('Bukti berupa file harus dilampirkan');
            if (fileInput) fileInput.focus();
            return false;
        }
        
        // Check file size (10MB)
        const file = fileInput.files[0];
        if (file.size > 10 * 1024 * 1024) {
            alert('Ukuran file terlalu besar. Maksimal 10MB.');
            fileInput.focus();
            return false;
        }
    } else if (evidenceType === 'gdrive') {
        const gdriveInput = document.getElementById('evidence_gdrive_link');
        if (!gdriveInput || !gdriveInput.value.trim()) {
            alert('Link Google Drive harus diisi');
            if (gdriveInput) gdriveInput.focus();
            return false;
        }
        
        // Enhanced URL validation for Google Drive
        const url = gdriveInput.value.trim();
        try {
            const urlObj = new URL(url);
            
            // Check if it's a Google Drive link
            if (!urlObj.hostname.includes('drive.google.com') && 
                !urlObj.hostname.includes('docs.google.com')) {
                alert('Link harus berasal dari Google Drive atau Google Docs');
                gdriveInput.focus();
                return false;
            }
            
            // Check if it contains file ID pattern
            if (!url.includes('/d/') && !url.includes('id=')) {
                alert('Link Google Drive tidak valid. Pastikan Anda menggunakan link sharing file yang benar.');
                gdriveInput.focus();
                return false;
            }
            
        } catch (e) {
            alert('Format URL tidak valid. Contoh yang benar: https://drive.google.com/file/d/1BxiMVs0XRA5nFMdKvBdBZjgmUUqptlbs74OgvE2upms/view');
            gdriveInput.focus();
            return false;
        }
    }

    // Check if at least one terlapor is filled
    const terlaporNames = document.querySelectorAll('input[name*="[nama]"]');
    let hasValidTerlapor = false;
    
    terlaporNames.forEach(input => {
        if (input.value.trim()) {
            hasValidTerlapor = true;
        }
    });
    
    if (!hasValidTerlapor) {
        alert('Minimal harus ada satu terlapor yang diisi');
        const firstTerlaporName = document.querySelector('input[name*="[nama]"]');
        if (firstTerlaporName) firstTerlaporName.focus();
        return false;
    }

    console.log('Form validation completed successfully');
    return true;
}

// Export functions for global access if needed
window.WhistleblowerForm = {
    updateRemoveButtons,
    updateTerlaporNumbers,
    validateForm,
    createTerlaporItem
};