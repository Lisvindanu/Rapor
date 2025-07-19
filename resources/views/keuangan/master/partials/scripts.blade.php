{{-- F:\rapor-dosen\resources\views\keuangan\master\partials\scripts.blade.php --}}
<script>
    document.addEventListener('DOMContentLoaded', function() {
        console.log('🎯 Keuangan Master Data - Simplified Version');

        // Filter auto-submit - HANYA untuk filter di index page, bukan form
        const filterSelects = document.querySelectorAll('.filter-form select[name="kategori"], .filter-form select[name="status"]');
        filterSelects.forEach(select => {
            select.addEventListener('change', function() {
                this.style.opacity = '0.6';
                this.disabled = true;
                this.form.submit();
            });
        });

        // Delete confirmations
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
    });
</script>
