{{-- F:\rapor-dosen\resources\views\keuangan\master\partials\scripts.blade.php --}}
<script>
    document.addEventListener('DOMContentLoaded', function() {
        console.log('🎯 Keuangan Master Data - Ready');

        // Global CSRF Token Helper
        window.getCsrfToken = function() {
            // Try meta tag first
            const metaToken = document.querySelector('meta[name="csrf-token"]');
            if (metaToken) {
                return metaToken.getAttribute('content');
            }

            // Fallback: try hidden input
            const hiddenToken = document.querySelector('input[name="_token"]');
            if (hiddenToken) {
                return hiddenToken.value;
            }

            // Fallback: try any form token
            const formToken = document.querySelector('form input[name="_token"]');
            if (formToken) {
                return formToken.value;
            }

            console.error('CSRF token not found!');
            return null;
        };

        // Setup jQuery AJAX dengan CSRF token
        if (typeof $ !== 'undefined') {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': window.getCsrfToken()
                }
            });
            console.log('✅ jQuery AJAX setup with CSRF token');
        }

        // Filter auto-submit - HANYA untuk filter di index page, bukan form
        const filterSelects = document.querySelectorAll('.filter-form select[name="kategori"], .filter-form select[name="status"]');
        filterSelects.forEach(select => {
            select.addEventListener('change', function() {
                this.style.opacity = '0.6';
                this.disabled = true;
                this.form.submit();
            });
        });

        // Delete confirmations untuk form-based delete (fallback)
        const deleteForms = document.querySelectorAll('form[onsubmit*="confirm"]');
        deleteForms.forEach(form => {
            form.addEventListener('submit', function(e) {
                const itemName = form.dataset.itemName || 'data ini';
                if (!confirm(`Yakin ingin menghapus ${itemName}?`)) {
                    e.preventDefault();
                    return false;
                }

                // Show loading
                const submitBtn = form.querySelector('button[type="submit"]');
                if (submitBtn) {
                    submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i>';
                    submitBtn.disabled = true;
                }
            });
        });

        // Table row click to detail (if detail button exists)
        const tableRows = document.querySelectorAll('#masterDataTable tbody tr, .data-table tbody tr');
        tableRows.forEach(row => {
            row.addEventListener('click', function(e) {
                if (!e.target.closest('button') && !e.target.closest('form') && !e.target.closest('.btn')) {
                    const detailBtn = this.querySelector('a[title="Lihat Detail"]');
                    if (detailBtn) {
                        window.location.href = detailBtn.href;
                    }
                }
            });
        });

        // Search input visual feedback
        const searchInput = document.getElementById('search');
        if (searchInput) {
            let searchTimeout;
            searchInput.addEventListener('input', function() {
                clearTimeout(searchTimeout);
                this.style.borderColor = '#ffc107';
                searchTimeout = setTimeout(() => {
                    this.style.borderColor = '';
                }, 500);
            });
        }

        // Initialize tooltips if Bootstrap is available
        if (typeof bootstrap !== 'undefined') {
            const tooltips = document.querySelectorAll('[title]');
            tooltips.forEach(el => {
                new bootstrap.Tooltip(el, { delay: { show: 500, hide: 100 } });
            });
        }

        // Form validation enhancement
        const forms = document.querySelectorAll('form[id*="Form"], form[id*="form"]');
        forms.forEach(form => {
            form.addEventListener('submit', function(e) {
                const submitBtn = form.querySelector('button[type="submit"]');
                if (submitBtn && !submitBtn.disabled) {
                    submitBtn.disabled = true;
                    const originalText = submitBtn.innerHTML;
                    submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin me-1"></i>Memproses...';

                    // Re-enable button after 10 seconds as failsafe
                    setTimeout(() => {
                        submitBtn.disabled = false;
                        submitBtn.innerHTML = originalText;
                    }, 10000);
                }
            });
        });

        // Auto-hide alerts after 8 seconds
        const alerts = document.querySelectorAll('.alert:not(.alert-permanent)');
        alerts.forEach(alert => {
            setTimeout(() => {
                if (typeof bootstrap !== 'undefined' && bootstrap.Alert) {
                    const bsAlert = new bootstrap.Alert(alert);
                    try {
                        bsAlert.close();
                    } catch (e) {
                        alert.style.display = 'none';
                    }
                } else {
                    alert.style.display = 'none';
                }
            }, 8000);
        });

        console.log('✅ CSRF Token available:', !!window.getCsrfToken());
    });
</script>
