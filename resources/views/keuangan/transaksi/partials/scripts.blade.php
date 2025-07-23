{{-- resources/views/keuangan/transaksi/partials/scripts.blade.php --}}
<script>
    // Transaksi Keuangan Handler Class
    class TransaksiKeuangan {
        constructor() {
            this.init();
        }

        init() {
            this.bindEvents();
            this.initializeComponents();
            console.log('🔧 Transaksi Keuangan v1.0.0');
            console.log('💰 Clean & modular structure');
        }

        bindEvents() {
            // Stats cards click events
            this.bindStatsCardEvents();

            // Filter form events
            this.bindFilterEvents();

            // Table action events
            this.bindTableEvents();

            // Delete confirmation events
            this.bindDeleteEvents();
        }

        bindStatsCardEvents() {
            const statsCards = document.querySelectorAll('.stats-card');
            statsCards.forEach(card => {
                card.addEventListener('click', (e) => {
                    const statType = card.dataset.stat;
                    this.handleStatsCardClick(statType);
                });
            });
        }

        bindFilterEvents() {
            // Auto submit on filter change
            const filterSelects = document.querySelectorAll('.filter-card select');
            filterSelects.forEach(select => {
                select.addEventListener('change', () => {
                    this.debounce(() => {
                        select.closest('form').submit();
                    }, 300);
                });
            });

            // Search input with debounce
            const searchInput = document.querySelector('input[name="search"]');
            if (searchInput) {
                searchInput.addEventListener('input', (e) => {
                    this.debounce(() => {
                        if (e.target.value.length >= 3 || e.target.value.length === 0) {
                            e.target.closest('form').submit();
                        }
                    }, 500);
                });
            }
        }

        bindTableEvents() {
            // Action button tooltips
            const actionButtons = document.querySelectorAll('.btn-action');
            actionButtons.forEach(btn => {
                btn.addEventListener('mouseenter', (e) => {
                    this.showTooltip(e.target, e.target.getAttribute('title'));
                });
            });
        }

        bindDeleteEvents() {
            const deleteButtons = document.querySelectorAll('.delete-btn');
            deleteButtons.forEach(btn => {
                btn.addEventListener('click', (e) => {
                    e.preventDefault();
                    this.confirmDelete(
                        btn.dataset.url,
                        btn.dataset.name
                    );
                });
            });
        }

        handleStatsCardClick(statType) {
            // Filter table based on stat type
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

        confirmDelete(url, itemName) {
            Swal.fire({
                title: 'Konfirmasi Hapus',
                text: `Apakah Anda yakin ingin menghapus "${itemName}"?`,
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Ya, Hapus!',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    this.deleteItem(url);
                }
            });
        }

        async deleteItem(url) {
            try {
                const response = await fetch(url, {
                    method: 'DELETE',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                        'Accept': 'application/json',
                        'Content-Type': 'application/json'
                    }
                });

                const data = await response.json();

                if (response.ok) {
                    Swal.fire(
                        'Berhasil!',
                        data.message || 'Data berhasil dihapus.',
                        'success'
                    ).then(() => {
                        window.location.reload();
                    });
                } else {
                    throw new Error(data.message || 'Terjadi kesalahan');
                }
            } catch (error) {
                Swal.fire(
                    'Error!',
                    error.message || 'Terjadi kesalahan saat menghapus data.',
                    'error'
                );
            }
        }

        showTooltip(element, text) {
            // Simple tooltip implementation
            if (!text) return;

            element.setAttribute('data-bs-toggle', 'tooltip');
            element.setAttribute('data-bs-placement', 'top');
            element.setAttribute('title', text);
        }

        debounce(func, wait) {
            clearTimeout(this.debounceTimer);
            this.debounceTimer = setTimeout(func, wait);
        }

        initializeComponents() {
            // Initialize Bootstrap tooltips
            if (typeof bootstrap !== 'undefined') {
                const tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
                tooltipTriggerList.map(function (tooltipTriggerEl) {
                    return new bootstrap.Tooltip(tooltipTriggerEl);
                });
            }

            // Initialize SweetAlert if available
            if (typeof Swal === 'undefined') {
                console.warn('SweetAlert2 not loaded. Delete confirmations will not work.');
            }
        }
    }

    // Initialize when DOM is ready
    document.addEventListener('DOMContentLoaded', function() {
        new TransaksiKeuangan();
    });

    // Format currency input
    function formatCurrency(input) {
        let value = input.value.replace(/[^\d]/g, '');
        value = value.replace(/\B(?=(\d{3})+(?!\d))/g, '.');
        input.value = value;
    }

    // Convert currency to number
    function currencyToNumber(currency) {
        return parseFloat(currency.replace(/\./g, '').replace(/,/g, '.')) || 0;
    }

    // Number to Indonesian words
    function numberToWords(num) {
        // This would be implemented for Indonesian terbilang
        // For now, return formatted number
        return new Intl.NumberFormat('id-ID').format(num) + ' RUPIAH';
    }
</script>
