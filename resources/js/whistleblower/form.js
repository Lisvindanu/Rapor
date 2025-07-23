// resources/js/whistleblower-form.js

document.addEventListener('DOMContentLoaded', function() {
    let terlapor_index = 0;

    // Initialize form
    initializeForm();
    
    // Form initialization
    function initializeForm() {
        // Add first terlapor item
        addTerlapor();
        
        // Initialize event listeners
        setupEventListeners();
        
        // Initialize evidence type toggle
        toggleEvidenceType();
        
        // Initialize disability toggle
        toggleDisabilityField();
    }

    // Setup all event listeners
    function setupEventListeners() {
        // Add terlapor button
        document.getElementById('add-terlapor').addEventListener('click', addTerlapor);
        
        // Evidence type radio buttons
        document.querySelectorAll('input[name="evidence_type"]').forEach(radio => {
            radio.addEventListener('change', toggleEvidenceType);
        });
        
        // Disability select
        document.getElementById('memiliki_disabilitas').addEventListener('change', toggleDisabilityField);
        
        // File input change
        const fileInput = document.getElementById('file_bukti');
        if (fileInput) {
            fileInput.addEventListener('change', handleFileChange);
        }
        
        // Google Drive link validation
        const gdriveInput = document.getElementById('evidence_gdrive_link');
        if (gdriveInput) {
            gdriveInput.addEventListener('input', validateGdriveLink);
        }
        
        // Form submission
        document.getElementById('whistleblowerForm').addEventListener('submit', handleFormSubmit);
    }

    // Add new terlapor item
    function addTerlapor() {
        const container = document.getElementById('terlapor-container');
        const template = document.getElementById('terlapor-template');
        
        if (!template) {
            console.error('Terlapor template not found');
            return;
        }
        
        const clone = template.content.cloneNode(true);
        
        // Replace INDEX with actual index
        const inputs = clone.querySelectorAll('input, select');
        inputs.forEach(input => {
            if (input.name) {
                input.name = input.name.replace('INDEX', terlapor_index);
            }
        });
        
        // Update terlapor number
        const numberSpan = clone.querySelector('.terlapor-number');
        if (numberSpan) {
            numberSpan.textContent = terlapor_index + 1;
        }
        
        // Add remove event listener
        const removeBtn = clone.querySelector('.remove-terlapor');
        if (removeBtn) {
            removeBtn.addEventListener('click', function() {
                removeTerlapor(this);
            });
        }
        
        container.appendChild(clone);
        terlapor_index++;
        
        // Update remove button visibility
        updateRemoveButtons();
    }

    // Remove terlapor item
    function removeTerlapor(button) {
        const terlapor_item = button.closest('.terlapor-item');
        if (terlapor_item) {
            terlapor_item.remove();
            updateTerlapor_numbers();
            updateRemoveButtons();
        }
    }

    // Update terlapor numbers after removal
    function updateTerlapor_numbers() {
        const terlapor_items = document.querySelectorAll('.terlapor-item');
        terlapor_items.forEach((item, index) => {
            const numberSpan = item.querySelector('.terlapor-number');
            if (numberSpan) {
                numberSpan.textContent = index + 1;
            }
        });
    }

    // Update remove button visibility (hide if only one terlapor)
    function updateRemoveButtons() {
        const terlapor_items = document.querySelectorAll('.terlapor-item');
        const removeButtons = document.querySelectorAll('.remove-terlapor');
        
        removeButtons.forEach(btn => {
            btn.style.display = terlapor_items.length > 1 ? 'inline-block' : 'none';
        });
    }

    // Toggle evidence type (file vs Google Drive)
    function toggleEvidenceType() {
        const evidenceType = document.querySelector('input[name="evidence_type"]:checked');
        const fileSection = document.getElementById('file-upload-section');
        const gdriveSection = document.getElementById('gdrive-upload-section');
        
        if (!evidenceType || !fileSection || !gdriveSection) return;
        
        if (evidenceType.value === 'file') {
            fileSection.style.display = 'block';
            gdriveSection.style.display = 'none';
            
            // Clear Google Drive input
            const gdriveInput = document.getElementById('evidence_gdrive_link');
            if (gdriveInput) gdriveInput.value = '';
            
            // Set file input as required
            const fileInput = document.getElementById('file_bukti');
            if (fileInput) fileInput.required = true;
        } else {
            fileSection.style.display = 'none';
            gdriveSection.style.display = 'block';
            
            // Clear file input
            const fileInput = document.getElementById('file_bukti');
            if (fileInput) {
                fileInput.value = '';
                fileInput.required = false;
                clearFile();
            }
            
            // Set Google Drive input as required
            const gdriveInput = document.getElementById('evidence_gdrive_link');
            if (gdriveInput) gdriveInput.required = true;
        }
    }

    // Toggle disability field
    function toggleDisabilityField() {
        const disabilitySelect = document.getElementById('memiliki_disabilitas');
        const disabilityWrapper = document.getElementById('jenis_disabilitas_wrapper');
        const disabilityInput = document.getElementById('jenis_disabilitas');
        
        if (!disabilitySelect || !disabilityWrapper) return;
        
        if (disabilitySelect.value === '1') {
            disabilityWrapper.style.display = 'block';
            if (disabilityInput) disabilityInput.required = true;
        } else {
            disabilityWrapper.style.display = 'none';
            if (disabilityInput) {
                disabilityInput.required = false;
                disabilityInput.value = '';
            }
        }
    }

    // Handle file change
    function handleFileChange(event) {
        const file = event.target.files[0];
        const preview = document.getElementById('file-preview');
        const fileName = document.getElementById('file-name');
        
        if (!preview || !fileName) return;
        
        if (file) {
            // Validate file size (10MB)
            if (file.size > 10 * 1024 * 1024) {
                alert('Ukuran file terlalu besar. Maksimal 10MB.');
                event.target.value = '';
                preview.style.display = 'none';
                return;
            }
            
            // Validate file type
            const allowedTypes = ['application/pdf', 'application/msword', 
                                'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
                                'image/jpeg', 'image/jpg', 'image/png'];
            
            if (!allowedTypes.includes(file.type)) {
                alert('Format file tidak didukung. Gunakan PDF, DOC, DOCX, JPG, atau PNG.');
                event.target.value = '';
                preview.style.display = 'none';
                return;
            }
            
            fileName.textContent = file.name;
            preview.style.display = 'block';
        } else {
            preview.style.display = 'none';
        }
    }

    // Clear file input
    window.clearFile = function() {
        const fileInput = document.getElementById('file_bukti');
        const preview = document.getElementById('file-preview');
        
        if (fileInput) fileInput.value = '';
        if (preview) preview.style.display = 'none';
    };

    // Validate Google Drive link
    function validateGdriveLink(event) {
        const url = event.target.value;
        const validation = document.getElementById('gdrive-validation');
        
        if (!validation) return;
        
        if (url && !url.includes('drive.google.com')) {
            validation.style.display = 'block';
        } else {
            validation.style.display = 'none';
        }
    }

    // Accept policy from modal
    window.acceptPolicy = function() {
        const checkbox = document.getElementById('persetujuan_kebijakan');
        if (checkbox) {
            checkbox.checked = true;
        }
        
        // Close modal
        const modal = bootstrap.Modal.getInstance(document.getElementById('modalKebijakan'));
        if (modal) {
            modal.hide();
        }
    };

    // Reset form
    window.resetForm = function() {
        if (confirm('Apakah Anda yakin ingin mereset form? Semua data yang sudah diisi akan hilang.')) {
            document.getElementById('whistleblowerForm').reset();
            
            // Clear terlapor items and add one
            const container = document.getElementById('terlapor-container');
            if (container) {
                container.innerHTML = '';
                terlapor_index = 0;
                addTerlapor();
            }
            
            // Reset other elements
            clearFile();
            toggleEvidenceType();
            toggleDisabilityField();
            
            // Hide validation elements
            const gdriveValidation = document.getElementById('gdrive-validation');
            if (gdriveValidation) gdriveValidation.style.display = 'none';
        }
    };

    // Handle form submission
    function handleFormSubmit(event) {
        event.preventDefault();
        
        if (!validateForm()) {
            return false;
        }
        
        // Show loading overlay
        const loadingOverlay = document.getElementById('loadingOverlay');
        if (loadingOverlay) {
            loadingOverlay.classList.remove('d-none');
        }
        
        // Disable submit button
        const submitBtn = document.getElementById('submitBtn');
        if (submitBtn) {
            submitBtn.disabled = true;
            submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Mengirim...';
        }
        
        // Submit form
        event.target.submit();
    }

    // Validate form before submission
    function validateForm() {
        let isValid = true;
        const form = document.getElementById('whistleblowerForm');
        
        // Check required fields
        const requiredFields = form.querySelectorAll('[required]');
        requiredFields.forEach(field => {
            if (!field.value.trim()) {
                field.classList.add('is-invalid');
                isValid = false;
            } else {
                field.classList.remove('is-invalid');
            }
        });
        
        // Check alasan pengaduan
        const alasanCheckboxes = form.querySelectorAll('input[name="alasan_pengaduan[]"]:checked');
        if (alasanCheckboxes.length === 0) {
            alert('Silakan pilih minimal satu alasan pengaduan.');
            isValid = false;
        }
        
        // Check terlapor
        const terlaporItems = document.querySelectorAll('.terlapor-item');
        if (terlaporItems.length === 0) {
            alert('Silakan tambahkan minimal satu informasi terlapor.');
            isValid = false;
        }
        
        // Validate each terlapor
        terlaporItems.forEach((item, index) => {
            const statusSelect = item.querySelector('select[name*="status_terlapor"]');
            const kontakInput = item.querySelector('input[name*="kontak_terlapor"]');
            
            if (!statusSelect || !statusSelect.value) {
                statusSelect.classList.add('is-invalid');
                isValid = false;
            }
            
            if (!kontakInput || !kontakInput.value.trim()) {
                kontakInput.classList.add('is-invalid');
                isValid = false;
            }
        });
        
        // Check evidence
        const evidenceType = document.querySelector('input[name="evidence_type"]:checked');
        if (evidenceType) {
            if (evidenceType.value === 'file') {
                const fileInput = document.getElementById('file_bukti');
                if (!fileInput || !fileInput.files[0]) {
                    alert('Silakan upload file bukti.');
                    isValid = false;
                }
            } else if (evidenceType.value === 'gdrive') {
                const gdriveInput = document.getElementById('evidence_gdrive_link');
                if (!gdriveInput || !gdriveInput.value.trim()) {
                    alert('Silakan masukkan link Google Drive.');
                    isValid = false;
                }
            }
        }
        
        // Check agreement
        const agreement = document.getElementById('persetujuan_kebijakan');
        if (!agreement || !agreement.checked) {
            alert('Silakan setujui kebijakan dan syarat ketentuan.');
            isValid = false;
        }
        
        if (!isValid) {
            // Scroll to first error
            const firstError = form.querySelector('.is-invalid');
            if (firstError) {
                firstError.scrollIntoView({ behavior: 'smooth', block: 'center' });
            }
        }
        
        return isValid;
    }
});