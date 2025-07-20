{{-- resources/views/keuangan/master/partials/delete-script.blade.php --}}

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

        // Ensure CSRF token is available
        if (!$('meta[name="csrf-token"]').length) {
            $('head').append('<meta name="csrf-token" content="{{ csrf_token() }}">');
        }

        // Handle delete button clicks
        $(document).on('click', '.delete-btn', function(e) {
            e.preventDefault();

            deleteUrl = $(this).data('url');
            deleteItemName = $(this).data('name');

            console.log('Delete URL:', deleteUrl);
            console.log('Delete Item:', deleteItemName);

            // Set item name in modal
            $('#deleteItemName').html('<strong>"' + deleteItemName + '"</strong>');

            // Reset button state
            $('#confirmDeleteBtn').prop('disabled', false).html('<i class="fas fa-trash me-1"></i>Hapus');

            // Clear any existing alerts
            $('#deleteModal .alert-danger').remove();

            // Show modal
            $('#deleteModal').modal('show');
        });

        // Handle confirm delete
        $('#confirmDeleteBtn').click(function(e) {
            e.preventDefault();

            if (!deleteUrl) {
                console.error('No delete URL specified');
                return;
            }

            // Show loading state
            $(this).prop('disabled', true).html('<i class="fas fa-spinner fa-spin me-1"></i>Menghapus...');

            // Get CSRF token
            const csrfToken = $('meta[name="csrf-token"]').attr('content') ||
                $('input[name="_token"]').val() ||
                '{{ csrf_token() }}';

            console.log('Sending DELETE request to:', deleteUrl);
            console.log('CSRF Token:', csrfToken);

            // Perform delete using jQuery AJAX - SAMA SEPERTI TAHUN ANGGARAN
            $.ajax({
                type: "POST",
                url: deleteUrl,
                data: {
                    _token: csrfToken,
                    _method: 'DELETE'
                },
                headers: {
                    'X-CSRF-TOKEN': csrfToken,
                    'X-Requested-With': 'XMLHttpRequest'
                },
                success: function(response) {
                    console.log('Delete success:', response);

                    // Hide modal
                    $('#deleteModal').modal('hide');


                    window.location.reload();
                },
                error: function(xhr, status, error) {
                    console.error('Delete error:', xhr.responseText);
                    console.error('Status:', status);
                    console.error('Error:', error);

                    // Parse error message dari JSON response (seperti tahun anggaran)
                    let errorMessage = 'Terjadi kesalahan saat menghapus data';
                    try {
                        const response = JSON.parse(xhr.responseText);
                        errorMessage = response.message || errorMessage;
                    } catch (e) {
                        // Use status text or default message
                        if (xhr.status === 404) {
                            errorMessage = 'Data tidak ditemukan';
                        } else if (xhr.status === 403) {
                            errorMessage = 'Tidak memiliki permission untuk menghapus data';
                        } else if (xhr.status === 405) {
                            errorMessage = 'Method DELETE tidak diizinkan';
                        } else {
                            errorMessage = `Error ${xhr.status}: ${xhr.statusText || errorMessage}`;
                        }
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

        console.log('✅ Delete functionality ready');
    });
</script>
