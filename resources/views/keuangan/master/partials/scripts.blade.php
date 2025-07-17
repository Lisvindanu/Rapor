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
            const tooltipList = tooltipTriggerList.map(function(tooltipTriggerEl) {
                return new bootstrap.Tooltip(tooltipTriggerEl, {
                    delay: { show: 500, hide: 100 }
                });
            });
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

        initializeComponents() {
            // Initialize any additional components
            this.initDataTable();
            this.initFormValidation();
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
        }

        initFormValidation() {
            // Real-time validation for required fields
            const requiredFields = document.querySelectorAll('input[required], select[required], textarea[required]');
            requiredFields.forEach(field => {
                field.addEventListener('blur', function() {
                    if (!this.value.trim()) {
                        this.classList.add('is-invalid');
                    } else {
                        this.classList.remove('is-invalid');
                    }
                });

                field.addEventListener('input', function() {
                    if (this.value.trim()) {
                        this.classList.remove('is-invalid');
                    }
                });
            });
        }

        // Utility methods
        showLoading(element) {
            element.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Loading...';
            element.disabled = true;
        }

        hideLoading(element, originalText) {
            element.innerHTML = originalText;
            element.disabled = false;
        }

        showNotification(message, type = 'info') {
            // Simple notification system
            const notification = document.createElement('div');
            notification.className = `alert alert-${type} alert-dismissible fade show position-fixed`;
            notification.style.cssText = 'top: 20px; right: 20px; z-index: 9999; min-width: 300px;';
            notification.innerHTML = `
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
    }

    // Initialize when DOM is loaded
    document.addEventListener('DOMContentLoaded', function() {
        window.masterHandler = new KeuanganMasterHandler();
    });

    // Export for use in other scripts
    window.KeuanganMasterHandler = KeuanganMasterHandler;
</script>
