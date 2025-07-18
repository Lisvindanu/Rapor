{{-- F:\rapor-dosen\resources\views\keuangan\master\partials\form-scripts.blade.php --}}
<script>
    document.addEventListener('DOMContentLoaded', function() {
        console.log('🎯 Keuangan Form Handler - Simplified Version');

        // Form Validation
        const forms = document.querySelectorAll('form[id*="master"]');
        forms.forEach(form => {
            form.addEventListener('submit', function(e) {
                const required = form.querySelectorAll('input[required], select[required]');
                let isValid = true;

                required.forEach(field => {
                    if (!field.value.trim()) {
                        field.classList.add('is-invalid');
                        isValid = false;
                    } else {
                        field.classList.remove('is-invalid');
                        field.classList.add('is-valid');
                    }
                });

                if (!isValid) {
                    e.preventDefault();
                    showAlert('Mohon lengkapi semua field yang wajib diisi', 'danger');
                    return false;
                }

                // Show loading on submit
                const submitBtn = form.querySelector('button[type="submit"]');
                if (submitBtn) {
                    const originalText = submitBtn.innerHTML;
                    submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Menyimpan...';
                    submitBtn.disabled = true;
                }
            });
        });

        // Real-time validation
        const requiredFields = document.querySelectorAll('input[required], select[required]');
        requiredFields.forEach(field => {
            field.addEventListener('blur', function() {
                if (!this.value.trim()) {
                    this.classList.add('is-invalid');
                    this.classList.remove('is-valid');
                } else {
                    this.classList.remove('is-invalid');
                    this.classList.add('is-valid');
                }
            });
        });

        // Auto-generate kode from nama (only if kode is empty)
        const namaField = document.querySelector('input[name="nama_mata_anggaran"]');
        const kodeField = document.querySelector('input[name="kode_mata_anggaran"]');

        if (namaField && kodeField) {
            namaField.addEventListener('input', function() {
                if (!kodeField.value && !kodeField.dataset.userEdited) {
                    const generatedKode = this.value
                        .toUpperCase()
                        .replace(/[^A-Z0-9\s]/g, '')
                        .replace(/\s+/g, '')
                        .substring(0, 10);
                    kodeField.value = generatedKode;
                }
            });

            // Mark as manually edited when user types in kode field
            kodeField.addEventListener('input', function() {
                this.dataset.userEdited = 'true';
            });
        }

        // Auto-focus first input
        const firstInput = document.querySelector('form input:not([type="hidden"])');
        if (firstInput) {
            setTimeout(() => firstInput.focus(), 100);
        }
    });

    // Simple alert function
    function showAlert(message, type = 'info') {
        const alert = document.createElement('div');
        alert.className = `alert alert-${type} alert-dismissible fade show position-fixed`;
        alert.style.cssText = 'top: 20px; right: 20px; z-index: 9999; min-width: 300px;';
        alert.innerHTML = `
        <i class="fas fa-exclamation-triangle me-2"></i>${message}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    `;
        document.body.appendChild(alert);
        setTimeout(() => alert.remove(), 5000);
    }
</script>
