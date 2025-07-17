<script>
    // Laporan Preview Functionality
    function initLaporanPreview() {
        document.getElementById('btnPreview').addEventListener('click', function() {
            const namaLaporan = document.getElementById('nama_laporan').value;
            const kodePeriode = document.getElementById('kode_periode').value;

            if (!namaLaporan || !kodePeriode) {
                alert('Mohon pilih periode dan jenis laporan terlebih dahulu');
                return;
            }

            showPreview(namaLaporan, kodePeriode);
        });
    }

    function showPreview(namaLaporan, kodePeriode) {
        const previewCard = document.getElementById('previewCard');
        const previewContent = document.getElementById('previewContent');

        // Show preview card
        previewCard.style.display = 'block';
        previewCard.scrollIntoView({ behavior: 'smooth' });

        // Generate preview content based on report type
        let previewHTML = generatePreviewHTML(namaLaporan, kodePeriode);
        previewContent.innerHTML = previewHTML;
    }

    function generatePreviewHTML(namaLaporan, kodePeriode) {
        return `
            <div class="preview-container">
                ${getReportPreviewContent(namaLaporan, kodePeriode)}
            </div>
        `;
    }

    function getReportPreviewContent(namaLaporan, kodePeriode) {
        const reportData = getReportData(namaLaporan);

        switch(namaLaporan) {
            case 'jurnal-pengeluaran':
                return generateJurnalPengeluaranHTML(reportData);
            case 'jurnal-per-mata-anggaran':
                return generateJurnalPerMataAnggaranHTML(reportData);
            case 'pembayaran-tugas-akhir':
                return generatePembayaranTugasAkhirHTML(reportData);
            default:
                return generateDefaultPreview();
        }
    }

    // Quick Report Actions
    function quickReport(reportType) {
        document.getElementById('nama_laporan').value = reportType;

        // Auto select current period if available
        const periodeSelect = document.getElementById('kode_periode');
        if (periodeSelect.options.length > 1) {
            periodeSelect.selectedIndex = 1; // Select first real option
        }

        // Show preview if both values are set
        if (periodeSelect.value) {
            showPreview(reportType, periodeSelect.value);
        }
    }

    function resetForm() {
        document.getElementById('laporanForm').reset();
        document.getElementById('previewCard').style.display = 'none';
    }

    function initFormValidation() {
        // Form validation before submit
        document.getElementById('laporanForm').addEventListener('submit', function(e) {
            const requiredFields = ['kode_periode', 'nama_laporan', 'programstudi', 'format_export'];
            let isValid = true;

            requiredFields.forEach(function(field) {
                const element = document.getElementById(field);
                if (!element.value) {
                    isValid = false;
                    element.classList.add('is-invalid');
                } else {
                    element.classList.remove('is-invalid');
                }
            });

            if (!isValid) {
                e.preventDefault();
                alert('Mohon lengkapi semua field yang wajib diisi');
            }
        });
    }

    // Initialize laporan module
    document.addEventListener('DOMContentLoaded', function() {
        console.log('🔧 Keuangan Laporan Module v0.1.0-alpha');
        console.log('📋 Following BTQ module pattern for reports...');

        // Initialize preview functionality
        initLaporanPreview();

        // Initialize form validation
        initFormValidation();
    });
</script>

{{-- Include inline JavaScript functions for preview generation --}}
@include('keuangan.laporan.partials.preview-functions')
@include('keuangan.laporan.partials.report-data')
