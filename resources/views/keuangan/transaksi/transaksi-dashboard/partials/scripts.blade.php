{{-- F:\rapor-dosen\resources\views\keuangan\transaksi\transaksi-dashboard\partials\scripts.blade.php --}}
<script>
    document.addEventListener('DOMContentLoaded', function() {
        console.log('💰 Transaksi Dashboard v1.0.0 - Simple & Clean');

        // Initialize basic features
        initializeStatsCards();
        initializeButtons();
        initializeListItems();
        initializeTableActions();
    });

    function initializeStatsCards() {
        const statsCards = document.querySelectorAll('.stats-card');
        statsCards.forEach(card => {
            card.addEventListener('click', function() {
                const transaksiType = this.dataset.transaksi;
                handleStatsCardClick(transaksiType);
            });

            // Simple hover effect
            card.addEventListener('mouseenter', function() {
                this.style.transform = 'translateY(-5px)';
            });

            card.addEventListener('mouseleave', function() {
                this.style.transform = '';
            });
        });
    }

    function initializeButtons() {
        const transaksiBtns = document.querySelectorAll('.transaksi-btn');
        transaksiBtns.forEach(btn => {
            btn.addEventListener('mouseenter', function() {
                this.style.transform = 'translateY(-2px)';
                this.style.transition = 'all 0.3s ease';
            });

            btn.addEventListener('mouseleave', function() {
                this.style.transform = '';
            });
        });
    }

    function initializeListItems() {
        const listItems = document.querySelectorAll('.list-group-item');
        listItems.forEach(item => {
            item.addEventListener('mouseenter', function() {
                this.style.backgroundColor = '#f8f9fa';
                this.style.transform = 'translateX(5px)';
                this.style.transition = 'all 0.2s ease';
            });

            item.addEventListener('mouseleave', function() {
                this.style.backgroundColor = '';
                this.style.transform = '';
            });
        });
    }

    function initializeTableActions() {
        // Table row hover effects
        const tableRows = document.querySelectorAll('.table tbody tr');
        tableRows.forEach(row => {
            row.addEventListener('mouseenter', function() {
                this.style.backgroundColor = '#f5f7fa';
                this.style.transition = 'background-color 0.2s ease';
            });

            row.addEventListener('mouseleave', function() {
                this.style.backgroundColor = '';
            });
        });

        // Initialize tooltips
        if (typeof bootstrap !== 'undefined') {
            const tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
            tooltipTriggerList.map(function (tooltipTriggerEl) {
                return new bootstrap.Tooltip(tooltipTriggerEl);
            });
        }
    }

    function handleStatsCardClick(transaksiType) {
        const routes = {
            'pengeluaran': '{{ route("keuangan.pengeluaran.index") }}',
            'pending': '{{ route("keuangan.pengeluaran.index") }}?status=pending',
            'approved': '{{ route("keuangan.pengeluaran.index") }}?status=approved',
            'paid': '{{ route("keuangan.pengeluaran.index") }}?status=paid',
            'value': '{{ route("keuangan.laporan") }}'
        };

        if (routes[transaksiType]) {
            window.location.href = routes[transaksiType];
        }
    }

    // Utility functions
    function formatCurrency(amount) {
        return new Intl.NumberFormat('id-ID', {
            style: 'currency',
            currency: 'IDR',
            minimumFractionDigits: 0
        }).format(amount);
    }

    function formatNumber(number) {
        return new Intl.NumberFormat('id-ID').format(number);
    }

    function getStatusBadgeClass(status) {
        const statusClasses = {
            'draft': 'secondary',
            'pending': 'warning',
            'approved': 'success',
            'rejected': 'danger',
            'paid': 'info'
        };
        return statusClasses[status] || 'secondary';
    }

    function getStatusLabel(status) {
        const statusLabels = {
            'draft': 'Draft',
            'pending': 'Menunggu Approval',
            'approved': 'Disetujui',
            'rejected': 'Ditolak',
            'paid': 'Dibayar'
        };
        return statusLabels[status] || status;
    }

    // Export functions for external use
    window.TransaksiDashboard = {
        formatCurrency: formatCurrency,
        formatNumber: formatNumber,
        getStatusBadgeClass: getStatusBadgeClass,
        getStatusLabel: getStatusLabel
    };

    // Responsive breakpoint detection
    function detectBreakpoint() {
        const width = window.innerWidth;
        if (width >= 1200) return 'xl';
        if (width >= 992) return 'lg';
        if (width >= 768) return 'md';
        if (width >= 576) return 'sm';
        return 'xs';
    }

    // Handle responsive changes
    window.addEventListener('resize', function() {
        const breakpoint = detectBreakpoint();
        document.body.setAttribute('data-breakpoint', breakpoint);

        // Adjust card layouts on mobile
        if (breakpoint === 'xs' || breakpoint === 'sm') {
            optimizeForMobile();
        } else {
            optimizeForDesktop();
        }
    });

    function optimizeForMobile() {
        // Compact stats cards on mobile
        const statsCards = document.querySelectorAll('.stats-card h3');
        statsCards.forEach(card => {
            card.style.fontSize = '1.25rem';
        });

        // Simplify table on mobile
        const table = document.querySelector('.table-responsive table');
        if (table && window.innerWidth < 576) {
            table.classList.add('table-sm');
        }
    }

    function optimizeForDesktop() {
        // Reset mobile optimizations
        const statsCards = document.querySelectorAll('.stats-card h3');
        statsCards.forEach(card => {
            card.style.fontSize = '';
        });

        const table = document.querySelector('.table-responsive table');
        if (table) {
            table.classList.remove('table-sm');
        }
    }

    // Initialize breakpoint detection
    document.body.setAttribute('data-breakpoint', detectBreakpoint());
</script>
