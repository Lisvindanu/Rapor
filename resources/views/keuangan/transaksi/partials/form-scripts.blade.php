{{-- resources/views/keuangan/transaksi/partials/form-scripts.blade.php --}}
<script>
    // Form Scripts untuk support modal dan regular form
    document.addEventListener('DOMContentLoaded', function() {
        console.log('💰 Transaksi Form Scripts v1.0.0');

        // Support untuk form regular (jika ada)
        initializeRegularFormValidation();

        // Currency formatting
        initializeCurrencyFormatting();

        // Number to words conversion
        initializeNumberToWords();
    });

    function initializeRegularFormValidation() {
        const regularForms = document.querySelectorAll('form:not(#formPengeluaran)');
        regularForms.forEach(form => {
            form.addEventListener('submit', function(e) {
                const required = form.querySelectorAll('input[required], select[required], textarea[required]');
                let isValid = true;

                required.forEach(field => {
                    if (!field.value.trim()) {
                        field.classList.add('is-invalid');
                        isValid = false;
                    } else {
                        field.classList.remove('is-invalid');
                        field.classList.add('is-valid');
                    }
                });

                if (!isValid) {
                    e.preventDefault();
                    showAlert('Mohon lengkapi semua field yang wajib diisi', 'danger');
                    return false;
                }

                // Show loading on submit
                const submitBtn = form.querySelector('button[type="submit"]');
                if (submitBtn) {
                    const originalText = submitBtn.innerHTML;
                    submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Menyimpan...';
                    submitBtn.disabled = true;
                }
            });
        });
    }

    function initializeCurrencyFormatting() {
        // Format currency input dengan thousand separator
        const currencyInputs = document.querySelectorAll('input[type="number"][name*="uang"]');
        currencyInputs.forEach(input => {
            input.addEventListener('input', function(e) {
                // Remove non-digits
                let value = e.target.value.replace(/[^\d]/g, '');

                // Add thousand separators (optional - untuk display)
                // e.target.dataset.value = value; // Store raw value
            });
        });
    }

    function initializeNumberToWords() {
        // Convert number to Indonesian words
        const numberInputs = document.querySelectorAll('input[name="uang_sebanyak_angka"]');
        numberInputs.forEach(input => {
            input.addEventListener('input', function(e) {
                const wordsField = document.querySelector('input[name="uang_sebanyak"]');
                if (wordsField) {
                    const number = parseInt(e.target.value) || 0;
                    wordsField.value = convertToIndonesianWords(number);
                }
            });
        });
    }

    function convertToIndonesianWords(num) {
        if (num === 0) return 'NOL RUPIAH';

        const ones = ['', 'SATU', 'DUA', 'TIGA', 'EMPAT', 'LIMA', 'ENAM', 'TUJUH', 'DELAPAN', 'SEMBILAN'];
        const tens = ['', '', 'DUA PULUH', 'TIGA PULUH', 'EMPAT PULUH', 'LIMA PULUH', 'ENAM PULUH', 'TUJUH PULUH', 'DELAPAN PULUH', 'SEMBILAN PULUH'];
        const scales = ['', 'RIBU', 'JUTA', 'MILIAR'];

        function convertHundreds(n) {
            let result = '';

            if (n >= 100) {
                const hundreds = Math.floor(n / 100);
                result += (hundreds === 1 ? 'SERATUS' : ones[hundreds] + ' RATUS');
                n %= 100;
                if (n > 0) result += ' ';
            }

            if (n >= 20) {
                result += tens[Math.floor(n / 10)];
                n %= 10;
                if (n > 0) result += ' ' + ones[n];
            } else if (n >= 10) {
                const teens = ['SEPULUH', 'SEBELAS', 'DUA BELAS', 'TIGA BELAS', 'EMPAT BELAS',
                    'LIMA BELAS', 'ENAM BELAS', 'TUJUH BELAS', 'DELAPAN BELAS', 'SEMBILAN BELAS'];
                result += teens[n - 10];
            } else if (n > 0) {
                result += ones[n];
            }

            return result;
        }

        let result = '';
        let scaleIndex = 0;

        while (num > 0) {
            const chunk = num % 1000;
            if (chunk > 0) {
                let chunkText = convertHundreds(chunk);
                if (scaleIndex > 0) {
                    chunkText += ' ' + scales[scaleIndex];
                }
                result = chunkText + (result ? ' ' + result : '');
            }
            num = Math.floor(num / 1000);
            scaleIndex++;
        }

        return result + ' RUPIAH';
    }

    function showAlert(message, type) {
        // Simple alert implementation
        if (typeof Swal !== 'undefined') {
            Swal.fire({
                title: type === 'success' ? 'Berhasil!' : 'Perhatian!',
                text: message,
                icon: type === 'danger' ? 'error' : type,
                confirmButtonText: 'OK'
            });
        } else {
            alert(message);
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

    // Export for external use
    window.TransaksiFormHelper = {
        formatCurrency: formatCurrency,
        formatNumber: formatNumber,
        convertToIndonesianWords: convertToIndonesianWords,
        showAlert: showAlert
    };
</script>
