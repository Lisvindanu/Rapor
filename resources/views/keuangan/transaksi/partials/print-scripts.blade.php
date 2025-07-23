{{-- resources/views/keuangan/transaksi/partials/print-scripts.blade.php --}}
<script>
    // Print functionality for detail page
    document.addEventListener('DOMContentLoaded', function() {
        // Print button functionality
        const printButtons = document.querySelectorAll('[href*="/print"]');
        printButtons.forEach(button => {
            button.addEventListener('click', function(e) {
                // The print page will handle the printing
                console.log('Opening print view...');
            });
        });

        // PDF download functionality
        const pdfButtons = document.querySelectorAll('[href*="/pdf"]');
        pdfButtons.forEach(button => {
            button.addEventListener('click', function(e) {
                // Show loading state
                const originalText = this.innerHTML;
                this.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i>Generating PDF...';
                this.disabled = true;

                // Reset after a delay (PDF download will handle the rest)
                setTimeout(() => {
                    this.innerHTML = originalText;
                    this.disabled = false;
                }, 3000);
            });
        });

        // Quick print shortcut (Ctrl+P)
        document.addEventListener('keydown', function(e) {
            if ((e.ctrlKey || e.metaKey) && e.key === 'p') {
                e.preventDefault();
                const printButton = document.querySelector('[href*="/print"]');
                if (printButton) {
                    window.open(printButton.href, '_blank');
                }
            }
        });
    });

    // Utility function for print preview
    function openPrintPreview(url) {
        const printWindow = window.open(url, '_blank', 'width=800,height=600');
        printWindow.focus();
    }

    // Function to generate and download PDF
    function downloadPDF(url, filename) {
        const link = document.createElement('a');
        link.href = url;
        link.download = filename || 'bukti_pengeluaran.pdf';
        document.body.appendChild(link);
        link.click();
        document.body.removeChild(link);
    }
</script>
