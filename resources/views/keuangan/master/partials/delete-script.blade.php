{{-- F:\rapor-dosen\resources\views\keuangan\master\partials\delete-script.blade.php --}}

{{-- Delete Confirmation Modal --}}
<div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="deleteModalLabel">
                    <i class="fas fa-exclamation-triangle text-warning me-2"></i>
                    Konfirmasi Hapus
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p>Apakah Anda yakin ingin menghapus data ini?</p>
                <div class="alert alert-warning">
                    <strong>Data yang akan dihapus:</strong>
                    <div id="deleteItemName" class="mt-2"></div>
                </div>
                <p class="text-muted small">
                    <i class="fas fa-info-circle me-1"></i>
                    Tindakan ini tidak dapat dibatalkan.
                </p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                    <i class="fas fa-times me-1"></i>Batal
                </button>
                <button type="button" class="btn btn-danger" id="confirmDeleteBtn">
                    <i class="fas fa-trash me-1"></i>Hapus
                </button>
            </div>
        </div>
    </div>
</div>

<script>
    $(document).ready(function() {
        let deleteUrl = '';
        let deleteItemName = '';

        // Handle delete button clicks
        $(document).on('click', '.delete-btn', function() {
            deleteUrl = $(this).data('url');
            deleteItemName = $(this).data('name');

            // Set item name in modal
            $('#deleteItemName').html('<strong>"' + deleteItemName + '"</strong>');

            // Reset button state
            $('#confirmDeleteBtn').prop('disabled', false).html('<i class="fas fa-trash me-1"></i>Hapus');

            // Show modal
            $('#deleteModal').modal('show');
        });

        // Handle confirm delete
        $('#confirmDeleteBtn').click(function() {
            if (!deleteUrl) return;

            // Show loading state
            $(this).prop('disabled', true).html('<i class="fas fa-spinner fa-spin me-1"></i>Menghapus...');

            // Perform delete using jQuery AJAX - sesuai pattern repository
            $.ajax({
                type: "DELETE",
                url: deleteUrl,
                data: {
                    _token: $('meta[name="csrf-token"]').attr('content') || $('input[name="_token"]').val(),
                    _method: 'DELETE'
                },
                success: function(response) {
                    console.log('Delete success:', response);

                    // Save success message for after reload
                    const message = response.message || 'Data berhasil dihapus';
                    sessionStorage.setItem('success_message', message);

                    // Reload page
                    window.location.reload();
                },
                error: function(xhr, status, error) {
                    console.error('Delete error:', xhr.responseText);

                    // Parse error message
                    let errorMessage = 'Terjadi kesalahan saat menghapus data';
                    try {
                        const response = JSON.parse(xhr.responseText);
                        errorMessage = response.message || errorMessage;
                    } catch (e) {
                        // Use default error message
                    }

                    // Show error alert in modal
                    const alertHtml = `
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <i class="fas fa-exclamation-triangle me-2"></i>
                            ${errorMessage}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    `;

                    $('#deleteModal .modal-body').prepend(alertHtml);

                    // Reset button
                    $('#confirmDeleteBtn').prop('disabled', false).html('<i class="fas fa-trash me-1"></i>Hapus');

                    // Auto remove alert after 5 seconds
                    setTimeout(function() {
                        $('#deleteModal .alert-danger').fadeOut();
                    }, 5000);
                }
            });
        });

        // Show success message after page reload
        const successMessage = sessionStorage.getItem('success_message');
        if (successMessage) {
            // Create success alert
            const alertHtml = `
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <i class="fas fa-check-circle me-2"></i>
                    ${successMessage}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            `;

            // Insert at top of container
            $('.container').first().prepend(alertHtml);

            // Clear the message
            sessionStorage.removeItem('success_message');

            // Auto remove after 5 seconds
            setTimeout(function() {
                $('.alert-success').fadeOut();
            }, 5000);
        }

        console.log('✅ Delete functionality ready');
    });
</script>
