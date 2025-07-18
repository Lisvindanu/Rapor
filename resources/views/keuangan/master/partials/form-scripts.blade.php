{{-- F:\rapor-dosen\resources\views\keuangan\master\partials\form-scripts.blade.php --}}
<script>
    // Form Enhancement JavaScript - Clean & Focused
    class KeuanganFormHandler {
        constructor() {
            this.init();
        }

        init() {
            this.bindCurrencyInputs();
            this.bindFormValidation();
            this.bindFormSubmission();
            this.bindKodeGeneration(); // Add this line
            console.log('🎯 Keuangan Form Handler v1.0.1 - Clean Version');
        }

        bindCurrencyInputs() {
            const currencyInputs = document.querySelectorAll('input[name*="anggaran"], input[name*="nominal"]');

            currencyInputs.forEach(input => {
                // Set default value
                if (!input.value) input.value = '0';

                // Handle input - fix NaN issue
                input.addEventListener('input', (e) => {
                    let value = e.target.value.replace(/[^\d]/g, '');
                    if (!value) value = '0';

                    e.target.dataset.rawValue = value;
                    this.showCurrencyHint(e.target, value);
                });

                // Format on focus
                input.addEventListener('focus', (e) => {
                    const raw = e.target.dataset.rawValue || e.target.value || '0';
                    e.target.value = this.formatCurrency(raw);
                    setTimeout(() => e.target.select(), 10);
                });

                // Clean on blur
                input.addEventListener('blur', (e) => {
                    const raw = e.target.dataset.rawValue || '0';
                    e.target.value = raw;
                });

                // Prevent non-numeric
                input.addEventListener('keypress', (e) => {
                    const allowed = [8, 9, 27, 13, 35, 36, 37, 38, 39, 40, 46];
                    if (allowed.indexOf(e.keyCode) !== -1 ||
                        (e.keyCode >= 48 && e.keyCode <= 57) ||
                        (e.keyCode >= 96 && e.keyCode <= 105) ||
                        (e.ctrlKey && [65, 67, 86, 88].includes(e.keyCode))) {
                        return;
                    }
                    e.preventDefault();
                });
            });
        }

        showCurrencyHint(input, value) {
            let hint = input.parentNode.querySelector('.currency-hint');
            if (!hint) {
                hint = document.createElement('small');
                hint.className = 'currency-hint text-muted';
                input.parentNode.appendChild(hint);
            }

            if (parseInt(value) > 0) {
                hint.textContent = `Format: Rp ${this.formatCurrency(value)}`;
                hint.style.display = 'block';
            } else {
                hint.style.display = 'none';
            }
        }

        formatCurrency(value) {
            const num = parseInt(value) || 0;
            return new Intl.NumberFormat('id-ID').format(num);
        }

        bindFormValidation() {
            const forms = document.querySelectorAll('form[id*="master"]');
            forms.forEach(form => {
                form.addEventListener('submit', (e) => {
                    if (!this.validateForm(form)) {
                        e.preventDefault();
                        this.showError('Mohon lengkapi semua field yang wajib diisi');
                    }
                });
            });

            // Real-time validation
            const required = document.querySelectorAll('input[required], select[required], textarea[required]');
            required.forEach(field => {
                field.addEventListener('blur', () => this.validateField(field));
            });
        }

        validateForm(form) {
            const required = form.querySelectorAll('input[required], select[required], textarea[required]');
            let valid = true;

            required.forEach(field => {
                if (!this.validateField(field)) valid = false;
            });

            return valid;
        }

        validateField(field) {
            const value = field.value.trim();
            const required = field.hasAttribute('required');

            if (required && !value) {
                this.markInvalid(field, 'Field ini wajib diisi');
                return false;
            }

            if (field.type === 'number' && value && isNaN(parseFloat(value))) {
                this.markInvalid(field, 'Nilai harus berupa angka');
                return false;
            }

            this.markValid(field);
            return true;
        }

        markValid(field) {
            field.classList.remove('is-invalid');
            field.classList.add('is-valid');
            const feedback = field.parentNode.querySelector('.invalid-feedback');
            if (feedback) feedback.style.display = 'none';
        }

        markInvalid(field, message) {
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

        bindFormSubmission() {
            const forms = document.querySelectorAll('form[id*="master"]');
            forms.forEach(form => {
                form.addEventListener('submit', (e) => {
                    const btn = form.querySelector('button[type="submit"]');
                    if (btn) {
                        const original = btn.innerHTML;
                        btn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Menyimpan...';
                        btn.disabled = true;

                        // Fix currency values before submit
                        const currency = form.querySelectorAll('input[name*="anggaran"], input[name*="nominal"]');
                        currency.forEach(input => {
                            const raw = input.dataset.rawValue || input.value.replace(/[^\d]/g, '') || '0';
                            input.value = raw;
                        });

                        if (!this.validateForm(form)) {
                            btn.innerHTML = original;
                            btn.disabled = false;
                        }
                    }
                });
            });
        }

        showError(message) {
            const alert = document.createElement('div');
            alert.className = 'alert alert-danger alert-dismissible fade show position-fixed';
            alert.style.cssText = 'top: 20px; right: 20px; z-index: 9999; min-width: 300px;';
            alert.innerHTML = `
                <i class="fas fa-exclamation-triangle me-2"></i>${message}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            `;
            document.body.appendChild(alert);
            setTimeout(() => alert.remove(), 5000);
        }

        // Auto-generate kode from nama - FIXED
        bindKodeGeneration() {
            const nama = document.querySelector('input[name="nama_mata_anggaran"]');
            const kode = document.querySelector('input[name="kode_mata_anggaran"]');

            if (nama && kode) {
                // Generate kode from nama (one direction only)
                nama.addEventListener('input', (e) => {
                    if (!kode.dataset.userEdited) {
                        const generatedKode = e.target.value
                            .toUpperCase()
                            .replace(/[^A-Z0-9\s]/g, '')
                            .replace(/\s+/g, '')
                            .substring(0, 10);
                        kode.value = generatedKode;
                    }
                });

                // Mark kode as manually edited when user types in kode field
                kode.addEventListener('input', () => {
                    kode.dataset.userEdited = 'true';
                });

                // DON'T generate nama from kode - remove any reverse generation
            }
        }
    }

    // Initialize
    document.addEventListener('DOMContentLoaded', function() {
        window.formHandler = new KeuanganFormHandler();

        // Auto-focus first input
        const firstInput = document.querySelector('form input:not([type="hidden"])');
        if (firstInput) setTimeout(() => firstInput.focus(), 100);
    });

    // Global helper functions
    function resetMasterForm() {
        const form = document.querySelector('form[id*="master"]');
        if (form) {
            form.reset();
            form.querySelectorAll('.is-invalid, .is-valid').forEach(f => f.classList.remove('is-invalid', 'is-valid'));
            form.querySelectorAll('.currency-hint').forEach(h => h.style.display = 'none');
        }
    }

    window.KeuanganFormHandler = KeuanganFormHandler;
</script>
