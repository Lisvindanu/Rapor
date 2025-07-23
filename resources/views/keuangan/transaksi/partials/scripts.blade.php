{{-- resources/views/keuangan/transaksi/partials/scripts.blade.php --}}
<script>
    // Transaksi Keuangan Handler
    document.addEventListener('DOMContentLoaded', function() {
        console.log('💰 Transaksi Keuangan v1.0.0 - Simple & Clean');

        initializeBasicFeatures();
        initializeTableActions();
        initializeFilterForm();
    });

    function initializeBasicFeatures() {
        // Stats cards click events
        const statsCards = document.querySelectorAll('.stats-card');
        statsCards.forEach(card => {
            card.addEventListener('click', function() {
                const statType = this.dataset.stat;
                handleStatsCardClick(statType);
            });

            // Hover effect
            card.addEventListener('mouseenter', function() {
                this.style.transform = 'translateY(-5px)';
            });

            card.addEventListener('mouseleave', function() {
                this.style.transform = '';
            });
        });
    }

    function initializeTableActions() {
        // Action button tooltips
        const actionButtons = document.querySelectorAll('.btn-action');
        actionButtons.forEach(btn => {
            if (btn.getAttribute('title')) {
                btn.setAttribute('data-bs-toggle', 'tooltip');
                btn.setAttribute('data-bs-placement', 'top');
            }
        });

        // Initialize Bootstrap tooltips
        if (typeof bootstrap !== 'undefined') {
            const tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
            tooltipTriggerList.map(function (tooltipTriggerEl) {
                return new bootstrap.Tooltip(tooltipTriggerEl);
            });
        }
    }

    function initializeFilterForm() {
        // Auto submit on filter change
        const filterSelects = document.querySelectorAll('.card select');
        filterSelects.forEach(select => {
            select.addEventListener('change', function() {
                setTimeout(() => {
                    this.closest('form').submit();
                }, 300);
            });
        });

        // Search input with debounce
        const searchInput = document.querySelector('input[name="search"]');
        if (searchInput) {
            let debounceTimer;
            searchInput.addEventListener('input', function(e) {
                clearTimeout(debounceTimer);
                debounceTimer = setTimeout(() => {
                    if (e.target.value.length >= 3 || e.target.value.length === 0) {
                        e.target.closest('form').submit();
                    }
                }, 500);
            });
        }
    }

    function handleStatsCardClick(statType) {
        const currentUrl = new URL(window.location);

        switch(statType) {
            case 'pending':
                currentUrl.searchParams.set('status', 'pending');
                break;
            case 'approved':
                currentUrl.searchParams.set('status', 'approved');
                break;
            case 'total':
                currentUrl.searchParams.delete('status');
                break;
        }

        window.location.href = currentUrl.toString();
    }

    // Utility functions
    function formatCurrency(input) {
        let value = input.value.replace(/[^\d]/g, '');
        value = value.replace(/\B(?=(\d{3})+(?!\d))/g, '.');
        input.value = value;
    }

    function currencyToNumber(currency) {
        return parseFloat(currency.replace(/\./g, '').replace(/,/g, '.')) || 0;
    }

    // Export for external use
    window.TransaksiKeuangan = {
        formatCurrency: formatCurrency,
        currencyToNumber: currencyToNumber
    };
</script>
