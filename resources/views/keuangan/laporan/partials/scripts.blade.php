<script>
    // Laporan Preview Functionality
    function initLaporanPreview() {
        document.getElementById('btnPreview').addEventListener('click', function() {
            // Validate all required fields for preview
            if (!validateRequiredFields()) {
                return;
            }

            const namaLaporan = document.getElementById('nama_laporan').value;
            const kodePeriode = document.getElementById('kode_periode').value;

            showPreview(namaLaporan, kodePeriode);
        });
    }

    function validateRequiredFields() {
        const requiredFields = ['kode_periode', 'nama_laporan', 'programstudi', 'format_export'];
        let isValid = true;
        let firstInvalidField = null;

        requiredFields.forEach(function(field) {
            const element = document.getElementById(field);
            if (!element.value || element.value === '' || element.value === 'null') {
                isValid = false;
                element.classList.add('is-invalid');
                element.style.borderColor = '#dc3545';

                // Focus on first invalid field
                if (!firstInvalidField) {
                    firstInvalidField = element;
                }
            } else {
                element.classList.remove('is-invalid');
                element.style.borderColor = '';
            }
        });

        if (!isValid) {
            alert('Mohon lengkapi semua field yang wajib diisi terlebih dahulu');
            if (firstInvalidField) {
                firstInvalidField.focus();
            }
        }

        return isValid;
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
        // Set report type
        document.getElementById('nama_laporan').value = reportType;

        // Auto select current period if available
        const periodeSelect = document.getElementById('kode_periode');
        if (periodeSelect.options.length > 1) {
            periodeSelect.selectedIndex = 1; // Select first real option
        }

        // Auto select default program studi (skip empty option)
        const prodiSelect = document.getElementById('programstudi');
        if (prodiSelect.options.length > 1) {
            // Find first non-empty option
            for (let i = 1; i < prodiSelect.options.length; i++) {
                if (prodiSelect.options[i].value && prodiSelect.options[i].value !== '') {
                    prodiSelect.selectedIndex = i;
                    break;
                }
            }
        }

        // Auto select excel format
        const formatSelect = document.getElementById('format_export');
        formatSelect.value = 'excel';

        // Remove any existing validation errors
        removeValidationErrors();

        // Trigger change events to update validation
        periodeSelect.dispatchEvent(new Event('change'));
        prodiSelect.dispatchEvent(new Event('change'));
        formatSelect.dispatchEvent(new Event('change'));
        document.getElementById('nama_laporan').dispatchEvent(new Event('change'));

        // Show preview if all values are set
        if (periodeSelect.value && prodiSelect.value && formatSelect.value) {
            showPreview(reportType, periodeSelect.value);
        }
    }

    function resetForm() {
        document.getElementById('laporanForm').reset();
        document.getElementById('previewCard').style.display = 'none';
        removeValidationErrors();
    }

    function removeValidationErrors() {
        const requiredFields = ['kode_periode', 'nama_laporan', 'programstudi', 'format_export'];
        requiredFields.forEach(function(field) {
            const element = document.getElementById(field);
            if (element) {
                element.classList.remove('is-invalid');
                element.style.borderColor = '';
            }
        });
    }

    function initFormValidation() {
        // Form validation before submit
        document.getElementById('laporanForm').addEventListener('submit', function(e) {
            if (!validateRequiredFields()) {
                e.preventDefault();
            }
        });

        // Remove error styling on change for all required fields
        const requiredFields = ['kode_periode', 'nama_laporan', 'programstudi', 'format_export'];
        requiredFields.forEach(function(field) {
            const element = document.getElementById(field);
            if (element) {
                element.addEventListener('change', function() {
                    if (this.value && this.value !== '' && this.value !== 'null') {
                        this.classList.remove('is-invalid');
                        this.style.borderColor = '';
                    }
                });
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
