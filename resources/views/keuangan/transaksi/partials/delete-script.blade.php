{{-- resources/views/keuangan/transaksi/partials/delete-script.blade.php --}}
<script>
    // Enhanced Delete Functionality for Transaksi
    class DeleteHandler {
        constructor() {
            this.init();
        }

        init() {
            this.bindDeleteEvents();
            this.setupSweetAlert();
        }

        bindDeleteEvents() {
            // Handle delete button clicks
            document.addEventListener('click', (e) => {
                if (e.target.closest('.delete-btn')) {
                    e.preventDefault();
                    const button = e.target.closest('.delete-btn');
                    this.handleDelete(button);
                }
            });
        }

        handleDelete(button) {
            const url = button.dataset.url;
            const name = button.dataset.name || 'item ini';

            this.showDeleteConfirmation(url, name);
        }

        showDeleteConfirmation(url, itemName) {
            if (typeof Swal === 'undefined') {
                // Fallback to native confirm if SweetAlert not available
                if (confirm(`Apakah Anda yakin ingin menghapus "${itemName}"?`)) {
                    this.executeDelete(url);
                }
                return;
            }

            Swal.fire({
                title: 'Konfirmasi Hapus',
                html: `
                    <div class="text-center">
                        <i class="fas fa-exclamation-triangle fa-3x text-warning mb-3"></i>
                        <p>Apakah Anda yakin ingin menghapus:</p>
                        <p><strong>"${itemName}"</strong></p>
                        <p class="text-muted small">Data yang dihapus tidak dapat dikembalikan!</p>
                    </div>
                `,
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#dc3545',
                cancelButtonColor: '#6c757d',
                confirmButtonText: '<i class="fas fa-trash me-1"></i>Ya, Hapus!',
                cancelButtonText: '<i class="fas fa-times me-1"></i>Batal',
                reverseButtons: true,
                focusCancel: true,
                customClass: {
                    confirmButton: 'btn btn-danger',
                    cancelButton: 'btn btn-secondary'
                }
            }).then((result) => {
                if (result.isConfirmed) {
                    this.executeDelete(url);
                }
            });
        }

        async executeDelete(url) {
            try {
                // Show loading
                if (typeof Swal !== 'undefined') {
                    Swal.fire({
                        title: 'Menghapus...',
                        html: 'Sedang memproses permintaan Anda',
                        allowOutsideClick: false,
                        allowEscapeKey: false,
                        showConfirmButton: false,
                        willOpen: () => {
                            Swal.showLoading();
                        }
                    });
                }

                const response = await fetch(url, {
                    method: 'DELETE',
                    headers: {
                        'X-CSRF-TOKEN': this.getCSRFToken(),
                        'Accept': 'application/json',
                        'Content-Type': 'application/json'
                    }
                });

                const data = await response.json();

                if (response.ok) {
                    this.showSuccessMessage(data.message);
                } else {
                    throw new Error(data.message || 'Terjadi kesalahan saat menghapus data');
                }
            } catch (error) {
                this.showErrorMessage(error.message);
            }
        }

        showSuccessMessage(message) {
            if (typeof Swal === 'undefined') {
                alert(message || 'Data berhasil dihapus!');
                window.location.reload();
                return;
            }

            Swal.fire({
                title: 'Berhasil!',
                text: message || 'Data berhasil dihapus.',
                icon: 'success',
                confirmButtonText: 'OK',
                customClass: {
                    confirmButton: 'btn btn-success'
                }
            }).then(() => {
                window.location.reload();
            });
        }

        showErrorMessage(message) {
            if (typeof Swal === 'undefined') {
                alert(message || 'Terjadi kesalahan!');
                return;
            }

            Swal.fire({
                title: 'Error!',
                text: message || 'Terjadi kesalahan saat menghapus data.',
                icon: 'error',
                confirmButtonText: 'OK',
                customClass: {
                    confirmButton: 'btn btn-danger'
                }
            });
        }

        getCSRFToken() {
            const token = document.querySelector('meta[name="csrf-token"]');
            if (!token) {
                console.error('CSRF token not found. Make sure to include it in your layout.');
                return '';
            }
            return token.getAttribute('content');
        }

        setupSweetAlert() {
            // Set default SweetAlert configuration
            if (typeof Swal !== 'undefined') {
                Swal.mixin({
                    customClass: {
                        popup: 'swal2-border-radius',
                        confirmButton: 'btn btn-primary me-2',
                        cancelButton: 'btn btn-secondary'
                    },
                    buttonsStyling: false
                });
            }
        }
    }

    // Initialize delete handler when DOM is ready
    document.addEventListener('DOMContentLoaded', function() {
        new DeleteHandler();
    });

    // Additional utility functions for delete operations
    window.TransaksiDeleteUtils = {
        // Bulk delete functionality
        bulkDelete: function(urls, itemNames) {
            if (typeof Swal === 'undefined') {
                if (confirm(`Apakah Anda yakin ingin menghapus ${urls.length} item?`)) {
                    this.executeBulkDelete(urls);
                }
                return;
            }

            Swal.fire({
                title: 'Konfirmasi Hapus Massal',
                html: `
                    <div class="text-center">
                        <i class="fas fa-exclamation-triangle fa-3x text-warning mb-3"></i>
                        <p>Anda akan menghapus <strong>${urls.length}</strong> item:</p>
                        <ul class="list-unstyled text-start">
                            ${itemNames.slice(0, 5).map(name => `<li>• ${name}</li>`).join('')}
                            ${itemNames.length > 5 ? `<li>• dan ${itemNames.length - 5} item lainnya...</li>` : ''}
                        </ul>
                        <p class="text-danger"><strong>Operasi ini tidak dapat dibatalkan!</strong></p>
                    </div>
                `,
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#dc3545',
                cancelButtonColor: '#6c757d',
                confirmButtonText: '<i class="fas fa-trash me-1"></i>Ya, Hapus Semua!',
                cancelButtonText: '<i class="fas fa-times me-1"></i>Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    this.executeBulkDelete(urls);
                }
            });
        },

        executeBulkDelete: async function(urls) {
            // Implementation for bulk delete
            console.log('Bulk delete not implemented yet', urls);
        }
    };
</script>
