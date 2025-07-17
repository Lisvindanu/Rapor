<script>
    // Keuangan Dashboard Handler Class
    class KeuanganDashboard {
        constructor() {
            this.init();
        }

        init() {
            this.bindEvents();
            this.initializeComponents();
            console.log('🔧 Keuangan Dashboard v0.1.0-alpha');
            console.log('📋 Following BTQ module pattern...');
            console.log('💰 Dashboard loaded with clean modular structure');
        }

        bindEvents() {
            // Stats cards click events
            this.bindStatsCardEvents();

            // Quick action button events
            this.bindQuickActionEvents();

            // Category events
            this.bindCategoryEvents();

            // Transaction events
            this.bindTransactionEvents();
        }

        bindStatsCardEvents() {
            const statsCards = document.querySelectorAll('.stats-card');
            statsCards.forEach(card => {
                card.addEventListener('click', (e) => {
                    const statType = card.dataset.stat;
                    const cardText = card.querySelector('.card-text').textContent;
                    this.handleStatsCardClick(statType, cardText);
                });
            });
        }

        bindQuickActionEvents() {
            const quickActionBtns = document.querySelectorAll('.quick-action-btn');
            quickActionBtns.forEach(button => {
                if (!button.href) { // Only add to buttons without href
                    button.addEventListener('click', (e) => {
                        this.addClickAnimation(button);
                    });
                }
            });
        }

        bindCategoryEvents() {
            const categoryItems = document.querySelectorAll('.category-item');
            categoryItems.forEach(item => {
                item.addEventListener('mouseenter', () => {
                    this.highlightCategory(item);
                });
                item.addEventListener('mouseleave', () => {
                    this.unhighlightCategory(item);
                });
            });
        }

        bindTransactionEvents() {
            const transactionRows = document.querySelectorAll('.transaction-row');
            transactionRows.forEach(row => {
                row.addEventListener('click', (e) => {
                    if (!e.target.closest('button')) {
                        const transactionId = row.dataset.transactionId;
                        this.handleRowClick(transactionId);
                    }
                });
            });
        }

        initializeComponents() {
            // Initialize any component-specific functionality
            this.updateLastRefresh();
        }

        // Event Handlers
        handleStatsCardClick(statType, cardText) {
            const messages = {
                'pemasukan': 'Detail pemasukan dengan breakdown per kategori dan periode',
                'pengeluaran': 'Detail pengeluaran dengan analisis trend dan kategori',
                'saldo': 'Analisis saldo dengan proyeksi cash flow',
                'transaksi': 'Daftar semua transaksi dengan filter dan pencarian advanced'
            };

            const message = messages[statType] || `Detail ${cardText}`;
            this.showModal('Detail Statistik', message, statType);
        }

        addClickAnimation(button) {
            button.style.transform = 'scale(0.95)';
            setTimeout(() => {
                button.style.transform = '';
            }, 150);
        }

        highlightCategory(item) {
            item.style.backgroundColor = '#f8f9fa';
            item.style.transform = 'translateX(5px)';
        }

        unhighlightCategory(item) {
            item.style.backgroundColor = '';
            item.style.transform = '';
        }

        handleRowClick(transactionId) {
            console.log(`Viewing transaction: ${transactionId}`);
            // Future: Navigate to transaction detail
        }

        showModal(title, message, type = '') {
            // Simple alert for now, can be replaced with proper modal
            alert(`${title}:\n\n${message}`);
        }

        updateLastRefresh() {
            const now = new Date().toLocaleTimeString();
            console.log(`Last refresh: ${now}`);
        }
    }

    // Global Functions (for backward compatibility)
    function handleQuickAction(feature) {
        const messages = {
            'Input Transaksi': 'Form untuk input transaksi baru dengan validasi dan auto-generate nomor.',
            'Review Transaksi': 'Table dengan search, filter, pagination, dan bulk actions.',
            'Master Data': 'Management kategori transaksi dan periode akademik.'
        };

        const message = messages[feature] || 'Fitur dalam development.';
        dashboard.showModal(feature, message);
    }

    function handleCategoryClick(categoryName, count) {
        const message = `Menampilkan ${count} transaksi untuk kategori "${categoryName}".\n\nFitur filtering berdasarkan kategori akan tersedia setelah implementasi database.`;
        dashboard.showModal('Filter Kategori', message);
    }

    function handleTransactionAction(actionType, transactionId) {
        const actions = {
            'view': `Melihat detail transaksi ${transactionId}`,
            'approve': `Menyetujui transaksi ${transactionId}`,
            'download': `Mengunduh bukti transaksi ${transactionId}`
        };

        const message = actions[actionType] || `Aksi ${actionType} untuk ${transactionId}`;
        dashboard.showModal('Aksi Transaksi', message);
    }

    function handleViewAllTransactions() {
        dashboard.showModal('Lihat Semua Transaksi', 'Membuka halaman daftar transaksi lengkap dengan DataTables, search, filter, dan pagination.');
    }

    // Initialize Dashboard
    let dashboard;
    document.addEventListener('DOMContentLoaded', function() {
        dashboard = new KeuanganDashboard();
    });
</script>
