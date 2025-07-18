{{-- F:\rapor-dosen\resources\views\keuangan\master\partials\form-scripts.blade.php --}}
<script>
    // Form Enhancement JavaScript
    class KeuanganFormHandler {
        constructor() {
            this.init();
        }

        init() {
            this.bindFormValidation();
            this.bindCurrencyInputs();
            this.bindKodeGeneration();
            this.bindFormSubmission();
            this.bindRealTimeValidation();
            console.log('🎯 Keuangan Form Handler v1.0.0 initialized');
        }

        bindFormValidation() {
            // Real-time validation for required fields
            const requiredFields = document.querySelectorAll('input[required], select[required], textarea[required]');

            requiredFields.forEach(field => {
                // Blur validation
                field.addEventListener('blur', () => {
                    this.validateField(field);
                });

                // Input validation (for immediate feedback)
                field.addEventListener('input', () => {
                    if (field.value.trim()) {
                        this.markFieldValid(field);
                    }
                });
            });

            // Form submission validation
            const forms = document.querySelectorAll('form[id*="master"]');
            forms.forEach(form => {
                form.addEventListener('submit', (e) => {
                    if (!this.validateForm(form)) {
                        e.preventDefault();
                        this.showValidationErrors(form);
                    }
                });
            });
        }

        validateField(field) {
            const value = field.value.trim();
            const isRequired = field.hasAttribute('required');

            if (isRequired && !value) {
                this.markFieldInvalid(field, `${this.getFieldLabel(field)} wajib diisi`);
                return false;
            }

            // Email validation
            if (field.type === 'email' && value) {
                const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
                if (!emailRegex.test(value)) {
                    this.markFieldInvalid(field, 'Format email tidak valid');
                    return false;
                }
            }

            // Number validation
            if (field.type === 'number' && value) {
                const numValue = parseFloat(value);
                const min = field.getAttribute('min');
                const max = field.getAttribute('max');

                if (min !== null && numValue < parseFloat(min)) {
                    this.markFieldInvalid(field, `Nilai minimum adalah ${min}`);
                    return false;
                }

                if (max !== null && numValue > parseFloat(max)) {
                    this.markFieldInvalid(field, `Nilai maksimum adalah ${max}`);
                    return false;
                }
            }

            // Kode mata anggaran validation
            if (field.name === 'kode_mata_anggaran' && value) {
                if (value.length > 20) {
                    this.markFieldInvalid(field, 'Kode mata anggaran maksimal 20 karakter');
                    return false;
                }

                // Check for valid characters (alphanumeric, dots, hyphens)
                const kodeRegex = /^[A-Za-z0-9.\-]+$/;
                if (!kodeRegex.test(value)) {
                    this.markFieldInvalid(field, 'Kode hanya boleh mengandung huruf, angka, titik, dan tanda hubung');
                    return false;
                }
            }

            this.markFieldValid(field);
            return true;
        }

        markFieldValid(field) {
            field.classList.remove('is-invalid');
            field.classList.add('is-valid');

            const feedback = field.parentNode.querySelector('.invalid-feedback');
            if (feedback) {
                feedback.style.display = 'none';
            }
        }

        markFieldInvalid(field, message) {
            field.classList.remove('is-valid');
            field.classList.add('is-invalid');

            let feedback = field.parentNode.querySelector('.invalid-feedback');
            if (!feedback) {
                feedback = document.createElement('div');
                feedback.className = 'invalid-feedback';
                field.parentNode.appendChild(feedback);
            }

            feedback.textContent = message;
            feedback.style.display = 'block';
        }

        getFieldLabel(field) {
            const label = document.querySelector(`label[for="${field.id}"]`);
            return label ? label.textContent.replace('*', '').trim() : field.name;
        }

        validateForm(form) {
            const requiredFields = form.querySelectorAll('input[required], select[required], textarea[required]');
            let isValid = true;

            requiredFields.forEach(field => {
                if (!this.validateField(field)) {
                    isValid = false;
                }
            });

            return isValid;
        }

        showValidationErrors(form) {
            const firstInvalidField = form.querySelector('.is-invalid');
            if (firstInvalidField) {
                firstInvalidField.focus();
                firstInvalidField.scrollIntoView({
                    behavior: 'smooth',
                    block: 'center'
                });
            }

            this.showNotification('Mohon lengkapi semua field yang wajib diisi', 'error');
        }

        bindCurrencyInputs() {
            const currencyInputs = document.querySelectorAll('input[name*="anggaran"], input[name*="nominal"]');

            currencyInputs.forEach(input => {
                // Format on input
                input.addEventListener('input', (e) => {
                    let value = e.target.value.replace(/[^\d]/g, '');
                    if (value) {
                        // Add thousand separators for display
                        const formattedValue = this.formatCurrency(value);
                        // Update display but keep raw value for submission
                        e.target.dataset.rawValue = value;
                    }
                });

                // Clean up on blur
                input.addEventListener('blur', (e) => {
                    const rawValue = e.target.dataset.rawValue;
                    if (rawValue) {
                        e.target.value = rawValue;
                    }
                });

                // Format on focus for user experience
                input.addEventListener('focus', (e) => {
                    const rawValue = e.target.dataset.rawValue || e.target.value;
                    if (rawValue) {
                        e.target.value = this.formatCurrency(rawValue);
                    }
                });
            });
        }

        formatCurrency(value) {
            return new Intl.NumberFormat('id-ID').format(value);
        }

        bindKodeGeneration() {
            const namaField = document.querySelector('input[name="nama_mata_anggaran"]');
            const kodeField = document.querySelector('input[name="kode_mata_anggaran"]');

            if (namaField && kodeField && !kodeField.value) {
                namaField.addEventListener('input', (e) => {
                    if (!kodeField.value) {
                        const generatedKode = this.generateKode(e.target.value);
                        kodeField.value = generatedKode;
                        this.validateField(kodeField);
                    }
                });
            }
        }

        generateKode(nama) {
            return nama
                .toUpperCase()
                .replace(/[^A-Z0-9\s]/g, '')
                .replace(/\s+/g, '')
                .substring(0, 10);
        }

        bindFormSubmission() {
            const forms = document.querySelectorAll('form[id*="master"]');

            forms.forEach(form => {
                form.addEventListener('submit', (e) => {
                    const submitButton = form.querySelector('button[type="submit"]');

                    if (submitButton) {
                        // Add loading state
                        const originalText = submitButton.innerHTML;
                        submitButton.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i>Menyimpan...';
                        submitButton.disabled = true;

                        // Reset currency inputs to raw values
                        const currencyInputs = form.querySelectorAll('input[name*="anggaran"], input[name*="nominal"]');
                        currencyInputs.forEach(input => {
                            if (input.dataset.rawValue) {
                                input.value = input.dataset.rawValue;
                            }
                        });

                        // If validation fails, restore button
                        if (!this.validateForm(form)) {
                            submitButton.innerHTML = originalText;
                            submitButton.disabled = false;
                        }
                    }
                });
            });
        }

        bindRealTimeValidation() {
            // Check for duplicate kode (if needed in the future)
            const kodeField = document.querySelector('input[name="kode_mata_anggaran"]');
            if (kodeField) {
                let timeout;
                kodeField.addEventListener('input', (e) => {
                    clearTimeout(timeout);
                    timeout = setTimeout(() => {
                        // Add AJAX validation for duplicate kode if needed
                        this.validateField(e.target);
                    }, 500);
                });
            }
        }

        showNotification(message, type = 'info') {
            // Simple notification system
            const notification = document.createElement('div');
            notification.className = `alert alert-${type === 'error' ? 'danger' : type} alert-dismissible fade show position-fixed`;
            notification.style.cssText = 'top: 20px; right: 20px; z-index: 9999; min-width: 300px; max-width: 500px;';
            notification.innerHTML = `
                <i class="fas fa-${type === 'error' ? 'exclamation-triangle' : type === 'success' ? 'check-circle' : 'info-circle'} me-2"></i>
                ${message}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            `;

            document.body.appendChild(notification);

            // Auto remove after 5 seconds
            setTimeout(() => {
                if (notification.parentNode) {
                    notification.remove();
                }
            }, 5000);
        }

        // Utility methods
        resetForm(formId) {
            const form = document.getElementById(formId);
            if (form) {
                form.reset();
                // Remove all validation classes
                form.querySelectorAll('.is-invalid, .is-valid').forEach(field => {
                    field.classList.remove('is-invalid', 'is-valid');
                });
                // Hide all feedback messages
                form.querySelectorAll('.invalid-feedback').forEach(feedback => {
                    feedback.style.display = 'none';
                });
            }
        }

        setFieldValue(fieldName, value) {
            const field = document.querySelector(`[name="${fieldName}"]`);
            if (field) {
                field.value = value;
                this.validateField(field);
            }
        }
    }

    // Initialize when DOM is loaded
    document.addEventListener('DOMContentLoaded', function() {
        window.formHandler = new KeuanganFormHandler();

        // Initialize Bootstrap tooltips if available
        if (typeof bootstrap !== 'undefined' && bootstrap.Tooltip) {
            const tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
            const tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
                return new bootstrap.Tooltip(tooltipTriggerEl);
            });
        }

        // Auto-focus first input
        const firstInput = document.querySelector('form input:not([type="hidden"]):not([readonly])');
        if (firstInput) {
            setTimeout(() => firstInput.focus(), 100);
        }
    });

    // Global functions for form manipulation
    function resetMasterForm() {
        if (window.formHandler) {
            window.formHandler.resetForm('masterCreateForm') ||
            window.formHandler.resetForm('masterEditForm');
        }
    }

    function validateCurrentForm() {
        const form = document.querySelector('form[id*="master"]');
        if (form && window.formHandler) {
            return window.formHandler.validateForm(form);
        }
        return true;
    }

    // Export for use in other scripts
    window.KeuanganFormHandler = KeuanganFormHandler;
</script>
