{{-- F:\rapor-dosen\resources\views\keuangan\transaksi\transaksi-dashboard\partials\scripts.blade.php --}}
<script>
    document.addEventListener('DOMContentLoaded', function() {
        console.log('💰 Transaksi Dashboard v1.0.0 - Production Ready');
        console.log('📊 Clean architecture for financial transactions');

        // Initialize dashboard components
        initializeStatsCards();
        initializeTransaksiButtons();
        initializeListItems();
        initializeTableActions();
        animateCards();
        startRealTimeUpdates();

        console.log('✅ Transaksi Dashboard ready');
    });

    function initializeStatsCards() {
        const statsCards = document.querySelectorAll('.stats-card');
        statsCards.forEach(card => {
            card.addEventListener('click', function() {
                const transaksiType = this.dataset.transaksi;
                handleStatsCardClick(transaksiType);
            });

            // Add hover effect
            card.addEventListener('mouseenter', function() {
                this.style.transform = 'translateY(-5px) scale(1.02)';
            });

            card.addEventListener('mouseleave', function() {
                this.style.transform = '';
            });
        });
    }

    function initializeTransaksiButtons() {
        const transaksiBtns = document.querySelectorAll('.transaksi-btn');
        transaksiBtns.forEach(btn => {
            btn.addEventListener('mouseenter', function() {
                this.style.transform = 'translateY(-2px)';
                this.style.transition = 'all 0.3s ease';
            });

            btn.addEventListener('mouseleave', function() {
                this.style.transform = '';
            });

            // Add click analytics
            btn.addEventListener('click', function() {
                const action = this.textContent.trim();
                logDashboardAction('button_click', action);
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
        // Initialize table row hover effects
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

        // Initialize action buttons
        const actionBtns = document.querySelectorAll('.btn-group .btn');
        actionBtns.forEach(btn => {
            btn.addEventListener('click', function(e) {
                const action = this.getAttribute('title') || 'action';
                logDashboardAction('table_action', action);
            });
        });
    }

    function handleStatsCardClick(transaksiType) {
        const routes = {
            'pengeluaran': '{{ route("keuangan.pengeluaran.index") }}',
            'pending': '{{ route("keuangan.pengeluaran.index") }}?status=pending',
            'approved': '{{ route("keuangan.pengeluaran.index") }}?status=approved',
            'paid': '{{ route("keuangan.pengeluaran.index") }}?status=paid',
            'value': '{{ route("keuangan.laporan.index") }}'
        };

        if (routes[transaksiType]) {
            // Add loading state
            showLoadingState();

            // Navigate to route
            window.location.href = routes[transaksiType];

            // Log action
            logDashboardAction('stats_card_click', transaksiType);
        }
    }

    function animateCards() {
        const cards = document.querySelectorAll('.card');
        cards.forEach((card, index) => {
            card.style.animationDelay = `${index * 0.1}s`;
            card.classList.add('fade-in-up');
        });

        // Animate stats cards with stagger
        const statsCards = document.querySelectorAll('.stats-card');
        statsCards.forEach((card, index) => {
            card.style.animationDelay = `${index * 0.2}s`;
        });
    }

    function startRealTimeUpdates() {
        // Update timestamp every minute
        setInterval(updateTimestamp, 60000);

        // Refresh stats every 5 minutes (optional)
        // setInterval(refreshStats, 300000);
    }

    function updateTimestamp() {
        const timestampElements = document.querySelectorAll('.timestamp');
        const now = new Date();
        const formattedTime = now.toLocaleTimeString('id-ID');

        timestampElements.forEach(element => {
            element.textContent = formattedTime;
        });
    }

    function refreshStats() {
        // Optional: Implement AJAX stats refresh
        fetch(window.location.href, {
            headers: {
                'X-Requested-With': 'XMLHttpRequest'
            }
        })
            .then(response => response.json())
            .then(data => {
                updateStatsDisplay(data.statistics);
            })
            .catch(error => {
                console.warn('Stats refresh failed:', error);
            });
    }

    function updateStatsDisplay(stats) {
        // Update stats cards with new data
        Object.keys(stats).forEach(key => {
            const element = document.querySelector(`[data-stat="${key}"] h3`);
            if (element) {
                element.textContent = stats[key];
            }
        });
    }

    function showLoadingState() {
        // Add loading overlay or spinner
        const overlay = document.createElement('div');
        overlay.className = 'loading-overlay';
        overlay.innerHTML = `
            <div class="d-flex justify-content-center align-items-center h-100">
                <div class="spinner-border text-primary" role="status">
                    <span class="visually-hidden">Loading...</span>
                </div>
            </div>
        `;
        document.body.appendChild(overlay);

        // Remove after 2 seconds (fallback)
        setTimeout(() => {
            if (overlay.parentNode) {
                overlay.parentNode.removeChild(overlay);
            }
        }, 2000);
    }

    function logDashboardAction(action, detail) {
        // Log user interactions for analytics
        const logData = {
            action: action,
            detail: detail,
            timestamp: new Date().toISOString(),
            page: 'transaksi_dashboard',
            user_agent: navigator.userAgent
        };

        // Send to analytics endpoint (optional)
        if (typeof gtag !== 'undefined') {
            gtag('event', action, {
                event_category: 'dashboard_interaction',
                event_label: detail
            });
        }

        console.log('📊 Dashboard Action:', logData);
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

    // Keyboard shortcuts
    document.addEventListener('keydown', function(e) {
        // Ctrl/Cmd + N = New transaction
        if ((e.ctrlKey || e.metaKey) && e.key === 'n') {
            e.preventDefault();
            window.location.href = '{{ route("keuangan.pengeluaran.create") }}';
        }

        // Ctrl/Cmd + L = View transactions
        if ((e.ctrlKey || e.metaKey) && e.key === 'l') {
            e.preventDefault();
            window.location.href = '{{ route("keuangan.pengeluaran.index") }}';
        }

        // Ctrl/Cmd + R = Reports
        if ((e.ctrlKey || e.metaKey) && e.key === 'r') {
            e.preventDefault();
            window.location.href = '{{ route("keuangan.laporan.index") }}';
        }
    });

    // Tooltip initialization
    if (typeof bootstrap !== 'undefined') {
        const tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
        tooltipTriggerList.map(function (tooltipTriggerEl) {
            return new bootstrap.Tooltip(tooltipTriggerEl);
        });
    }

    // Export functions for external use
    window.TransaksiDashboard = {
        refreshStats: refreshStats,
        logAction: logDashboardAction,
        formatCurrency: formatCurrency,
        formatNumber: formatNumber,
        getStatusBadgeClass: getStatusBadgeClass,
        getStatusLabel: getStatusLabel
    };

    // Performance monitoring
    window.addEventListener('load', function() {
        const loadTime = performance.now();
        console.log(`🚀 Dashboard loaded in ${loadTime.toFixed(2)}ms`);

        // Log performance metrics
        logDashboardAction('page_load', `${loadTime.toFixed(2)}ms`);
    });

    // Error handling
    window.addEventListener('error', function(e) {
        console.error('Dashboard Error:', e.error);
        logDashboardAction('error', e.error.message);
    });

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

<style>
    .loading-overlay {
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: rgba(255, 255, 255, 0.8);
        z-index: 9999;
        display: flex;
        justify-content: center;
        align-items: center;
    }

    .fade-in-up {
        animation: fadeInUp 0.5s ease-out forwards;
    }

    @keyframes fadeInUp {
        from {
            opacity: 0;
            transform: translateY(20px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    /* Keyboard shortcut indicators */
    .shortcut-hint {
        position: absolute;
        top: 5px;
        right: 5px;
        font-size: 0.7rem;
        background: rgba(0,0,0,0.1);
        padding: 2px 4px;
        border-radius: 2px;
        opacity: 0;
        transition: opacity 0.3s ease;
    }

    .transaksi-btn:hover .shortcut-hint {
        opacity: 1;
    }
</style>
