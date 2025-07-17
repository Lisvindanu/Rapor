{{-- F:\rapor-dosen\resources\views\keuangan\master\partials\scripts.blade.php --}}
<script>
    // Master Data Handler Class
    class KeuanganMasterHandler {
        constructor() {
            this.init();
        }

        init() {
            this.bindEvents();
            this.initializeComponents();
            console.log('🎯 Keuangan Master Data Module v1.0.0');
            console.log('📋 Pattern: Clean Architecture | Status: Ready');
            console.log('💰 Following BTQ module pattern for master data...');
        }

        bindEvents() {
            // Auto-submit forms on filter change
            this.bindFilterEvents();

            // Initialize tooltips
            this.initTooltips();

            // Bind action confirmations
            this.bindActionConfirmations();

            // Bind search functionality
            this.bindSearchEvents();

            // Bind form validation
            this.bindFormValidation();
        }

        bindFilterEvents() {
            const filterSelects = document.querySelectorAll('select[name^="filter"], select[name="tahun_anggaran"], select[name="status"]');
            filterSelects.forEach(select => {
                select.addEventListener('change', function() {
                    // Add loading state
                    this.style.opacity = '0.6';
                    this.disabled = true;

                    // Submit form
                    this.form.submit();
                });
            });
        }

        initTooltips() {
            const tooltipTriggerList = [].slice.call(document.querySelectorAll('[title], [data-bs-toggle="tooltip"]'));
            if (typeof bootstrap !== 'undefined') {
                const tooltipList = tooltipTriggerList.map(function(tooltipTriggerEl) {
                    return new bootstrap.Tooltip(tooltipTriggerEl, {
                        delay: { show: 500, hide: 100 }
                    });
                });
            }
        }

        bindActionConfirmations() {
            // Delete confirmations
            const deleteButtons = document.querySelectorAll('form[onsubmit*="confirm"] button[type="submit"]');
            deleteButtons.forEach(button => {
                button.addEventListener('click', function(e) {
                    const form = this.closest('form');
                    const itemName = form.dataset.itemName || 'data ini';

                    if (!confirm(`Yakin ingin menghapus ${itemName}? Aksi ini tidak bisa dibatalkan.`)) {
                        e.preventDefault();
                        return false;
                    }

                    // Add loading state
                    this.innerHTML = '<i class="fas fa-spinner fa-spin"></i>';
                    this.disabled = true;
                });
            });
        }

        bindSearchEvents() {
            const searchInput = document.getElementById('search');
            if (searchInput) {
                let searchTimeout;

                searchInput.addEventListener('input', function() {
                    clearTimeout(searchTimeout);

                    // Add visual feedback
                    this.style.borderColor = '#ffc107';

                    searchTimeout = setTimeout(() => {
                        this.style.borderColor = '';
                    }, 500);
                });

                // Clear search
                const clearSearchBtn = document.querySelector('[data-action="clear-search"]');
                if (clearSearchBtn) {
                    clearSearchBtn.addEventListener('click', function() {
                        searchInput.value = '';
                        searchInput.form.submit();
                    });
                }
            }
        }

        bindFormValidation() {
            // Real-time validation for required fields
            const requiredFields = document.querySelectorAll('input[required], select[required], textarea[required]');
            requiredFields.forEach(field => {
                field.addEventListener('blur', function() {
                    this.validateField();
                });

                field.addEventListener('input', function() {
                    if (this.value.trim()) {
                        this.classList.remove('is-invalid');
                        this.classList.add('is-valid');
                    }
                });

                // Add validateField method to each field
                field.validateField = function() {
                    if (!this.value.trim() && this.required) {
                        this.classList.add('is-invalid');
                        this.classList.remove('is-valid');
                        return false;
                    } else {
                        this.classList.remove('is-invalid');
                        this.classList.add('is-valid');
                        return true;
                    }
                };
            });

            // Form submission validation
            const forms = document.querySelectorAll('form[id*="master"]');
            forms.forEach(form => {
                form.addEventListener('submit', function(e) {
                    if (!this.validateAllFields()) {
                        e.preventDefault();
                        this.showValidationErrors();
                    }
                });

                // Add validation methods to form
                form.validateAllFields = function() {
                    const fields = this.querySelectorAll('input[required], select[required], textarea[required]');
                    let isValid = true;

                    fields.forEach(field => {
                        if (!field.validateField()) {
                            isValid = false;
                        }
                    });

                    return isValid;
                };

                form.showValidationErrors = function() {
                    const firstInvalidField = this.querySelector('.is-invalid');
                    if (firstInvalidField) {
                        firstInvalidField.focus();
                        firstInvalidField.scrollIntoView({ behavior: 'smooth', block: 'center' });
                    }
                    this.showNotification('Mohon lengkapi semua field yang wajib diisi', 'error');
                };
            });
        }

        initializeComponents() {
            // Initialize any additional components
            this.initDataTable();
            this.initFormComponents();
        }

        initDataTable() {
            // Add zebra striping enhancement
            const tables = document.querySelectorAll('.table-hover');
            tables.forEach(table => {
                const rows = table.querySelectorAll('tbody tr');
                rows.forEach((row, index) => {
                    if (index % 2 === 0) {
                        row.style.backgroundColor = 'rgba(0,0,0,0.02)';
                    }
                });
            });

            // Add row click handler for better UX
            const tableRows = document.querySelectorAll('#masterDataTable tbody tr');
            tableRows.forEach(row => {
                row.addEventListener('click', function(e) {
                    if (!e.target.closest('button') && !e.target.closest('form')) {
                        const detailBtn = this.querySelector('a[title="Lihat Detail"]');
                        if (detailBtn) {
                            window.location.href = detailBtn.href;
                        }
                    }
                });
            });
        }

        initFormComponents() {
            // Auto-format currency inputs
            const currencyInputs = document.querySelectorAll('input[type="number"][name*="anggaran"], input[type="number"][name*="nominal"]');
            currencyInputs.forEach(input => {
                input.addEventListener('input', function() {
                    this.formatCurrency();
                });

                input.formatCurrency = function() {
                    if (this.value) {
                        const value = parseFloat(this.value);
                        if (!isNaN(value)) {
                            // You can add currency formatting here if needed
                        }
                    }
                };
            });

            // Auto-generate kode based on nama
            const namaFields = document.querySelectorAll('input[name*="nama"]');
            namaFields.forEach(namaField => {
                const kodeField = document.querySelector(`input[name="${namaField.name.replace('nama', 'kode')}"]`);
                if (kodeField && !kodeField.value) {
                    namaField.addEventListener('input', function() {
                        if (!kodeField.value) {
                            kodeField.value = this.generateKode();
                        }
                    });

                    namaField.generateKode = function() {
                        return this.value
                            .toUpperCase()
                            .replace(/[^A-Z0-9\s]/g, '')
                            .replace(/\s+/g, '')
                            .substring(0, 10);
                    };
                }
            });
        }

        // Utility methods
        showLoading(element) {
            const originalText = element.innerHTML;
            element.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Loading...';
            element.disabled = true;
            return originalText;
        }

        hideLoading(element, originalText) {
            element.innerHTML = originalText;
            element.disabled = false;
        }

        showNotification(message, type = 'info') {
            // Simple notification system
            const notification = document.createElement('div');
            notification.className = `alert alert-${type === 'error' ? 'danger' : type} alert-dismissible fade show position-fixed`;
            notification.style.cssText = 'top: 20px; right: 20px; z-index: 9999; min-width: 300px;';
            notification.innerHTML = `
                <i class="fas fa-${type === 'error' ? 'exclamation-triangle' : type === 'success' ? 'check-circle' : 'info-circle'}"></i>
                ${message}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            `;

            document.body.appendChild(notification);

            // Auto remove after 5 seconds
            setTimeout(() => {
                if (notification.parentNode) {
                    notification.remove();
                }
            }, 5000);
        }

        // Quick actions for master data
        handleQuickAction(action) {
            console.log(`Quick action: ${action}`);
            this.showNotification(`Aksi ${action} akan segera tersedia`, 'info');
        }
    }

    // Global Functions (for backward compatibility)
    function resetForm() {
        const form = document.querySelector('form[id*="master"]');
        if (form) {
            form.reset();
            // Remove validation classes
            form.querySelectorAll('.is-invalid, .is-valid').forEach(field => {
                field.classList.remove('is-invalid', 'is-valid');
            });
        }
    }

    // Initialize when DOM is loaded
    document.addEventListener('DOMContentLoaded', function() {
        window.masterHandler = new KeuanganMasterHandler();

        // Initialize form auto-save (optional)
        const forms = document.querySelectorAll('form[id*="master"]');
        forms.forEach(form => {
            // Auto-save draft functionality can be added here
        });
    });

    // Export for use in other scripts
    window.KeuanganMasterHandler = KeuanganMasterHandler;
</script>
