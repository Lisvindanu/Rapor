{{-- resources/views/keuangan/transaksi/partials/modal-scripts.blade.php --}}
<script>
    // Modal Pengeluaran Handler - Clean & Simple
    class PengeluaranModalHandler {
        constructor() {
            this.modal = document.getElementById('modalPengeluaran');
            this.form = document.getElementById('formPengeluaran');
            this.isEditMode = false;
            this.currentId = null;
            this.init();
        }

        init() {
            this.bindEvents();
            this.setupValidation();
            console.log('📝 Pengeluaran Modal Handler initialized');
        }

        bindEvents() {
            // Create button click
            document.addEventListener('click', (e) => {
                if (e.target.closest('.btn-create-modal')) {
                    e.preventDefault();
                    this.openCreateModal();
                }

                if (e.target.closest('.btn-edit-modal')) {
                    e.preventDefault();
                    const id = e.target.closest('.btn-edit-modal').dataset.id;
                    this.openEditModal(id);
                }
            });

            // Form submit
            this.form.addEventListener('submit', (e) => {
                e.preventDefault();
                this.handleSubmit();
            });

            // Number to words conversion
            document.getElementById('uang_sebanyak_angka').addEventListener('input', (e) => {
                this.convertNumberToWords(e.target.value);
            });

            // Modal reset on close
            this.modal.addEventListener('hidden.bs.modal', () => {
                this.resetForm();
            });
        }

        async openCreateModal() {
            try {
                this.showLoading(true);

                const response = await fetch('{{ route("keuangan.pengeluaran.create.modal") }}');
                const data = await response.json();

                if (data.success) {
                    this.isEditMode = false;
                    this.currentId = null;
                    this.populateForm(null, data.formOptions);
                    this.setModalTitle('Tambah Pengeluaran Kas');
                    this.showModal();
                } else {
                    this.showAlert(data.error, 'danger');
                }
            } catch (error) {
                console.error('Error opening create modal:', error);
                this.showAlert('Gagal membuka form', 'danger');
            } finally {
                this.showLoading(false);
            }
        }

        async openEditModal(id) {
            try {
                this.showLoading(true);

                const response = await fetch(`{{ route("keuangan.pengeluaran.edit.modal", ":id") }}`.replace(':id', id));
                const data = await response.json();

                if (data.success) {
                    this.isEditMode = true;
                    this.currentId = id;
                    this.populateForm(data.data, data.formOptions);
                    this.setModalTitle('Edit Pengeluaran Kas');
                    this.showModal();
                } else {
                    this.showAlert(data.error, 'danger');
                }
            } catch (error) {
                console.error('Error opening edit modal:', error);
                this.showAlert('Gagal membuka form edit', 'danger');
            } finally {
                this.showLoading(false);
            }
        }

        populateForm(data, options) {
            // Clear all fields first
            this.form.reset();
            this.clearValidation();

            // Populate select options
            this.populateSelect('mata_anggaran_id', options.mataAnggarans, 'id', 'nama_mata_anggaran', 'kode_mata_anggaran');
            this.populateSelect('program_id', options.programs, 'id', 'nama_program');
            this.populateSelect('sumber_dana_id', options.sumberDanas, 'id', 'nama_sumber_dana');
            this.populateSelect('dekan_id', options.tandaTangans, 'id', 'nama');
            this.populateSelect('wakil_dekan_ii_id', options.tandaTangans, 'id', 'nama');
            this.populateSelect('ksb_keuangan_id', options.tandaTangans, 'id', 'nama');
            this.populateSelect('penerima_id', options.tandaTangans, 'id', 'nama');

            // Status options
            const statusSelect = document.getElementById('status');
            statusSelect.innerHTML = '<option value="">Pilih Status</option>';
            Object.entries(options.statusOptions).forEach(([value, label]) => {
                statusSelect.innerHTML += `<option value="${value}">${label}</option>`;
            });

            // Set tahun anggaran
            document.getElementById('tahun_anggaran_id').value = options.tahunAktif?.id || '';

            // If edit mode, populate data
            if (data) {
                Object.keys(data).forEach(key => {
                    const field = document.getElementById(key);
                    if (field) {
                        if (key === 'tanggal' && data[key]) {
                            field.value = data[key].split(' ')[0]; // Get date part only
                        } else {
                            field.value = data[key] || '';
                        }
                    }
                });

                // Set form method for edit
                document.getElementById('form_method').value = 'PUT';
                document.getElementById('pengeluaran_id').value = data.id;
            } else {
                // Set today's date for create
                document.getElementById('tanggal').value = new Date().toISOString().split('T')[0];
                document.getElementById('status').value = 'draft';
            }
        }

        populateSelect(selectId, items, valueField, labelField, codeField = null) {
            const select = document.getElementById(selectId);
            select.innerHTML = `<option value="">Pilih ${select.previousElementSibling.textContent}</option>`;

            if (Array.isArray(items)) {
                items.forEach(item => {
                    const label = codeField ? `${item[codeField]} - ${item[labelField]}` : item[labelField];
                    select.innerHTML += `<option value="${item[valueField]}">${label}</option>`;
                });
            }
        }

        async handleSubmit() {
            try {
                this.showSubmitLoading(true);
                this.clearValidation();

                const formData = new FormData(this.form);
                const url = this.isEditMode
                    ? `{{ route("keuangan.pengeluaran.update", ":id") }}`.replace(':id', this.currentId)
                    : '{{ route("keuangan.pengeluaran.store") }}';

                const response = await fetch(url, {
                    method: 'POST',
                    body: formData,
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                        'Accept': 'application/json'
                    }
                });

                const data = await response.json();

                if (data.success) {
                    this.showAlert(data.message, 'success');
                    setTimeout(() => {
                        this.hideModal();
                        window.location.reload(); // Refresh page to show new data
                    }, 1500);
                } else {
                    this.handleValidationErrors(data);
                    this.showAlert(data.message || 'Terjadi kesalahan', 'danger');
                }
            } catch (error) {
                console.error('Error submitting form:', error);
                this.showAlert('Terjadi kesalahan saat menyimpan', 'danger');
            } finally {
                this.showSubmitLoading(false);
            }
        }

        handleValidationErrors(data) {
            if (data.errors) {
                Object.keys(data.errors).forEach(field => {
                    const fieldElement = document.getElementById(field);
                    if (fieldElement) {
                        fieldElement.classList.add('is-invalid');
                        const feedback = fieldElement.parentNode.querySelector('.invalid-feedback');
                        if (feedback) {
                            feedback.textContent = data.errors[field][0];
                        }
                    }
                });
            }
        }

        setupValidation() {
            // Real-time validation
            const requiredFields = this.form.querySelectorAll('input[required], select[required], textarea[required]');
            requiredFields.forEach(field => {
                field.addEventListener('blur', () => {
                    this.validateField(field);
                });

                field.addEventListener('input', () => {
                    if (field.classList.contains('is-invalid')) {
                        this.validateField(field);
                    }
                });
            });
        }

        validateField(field) {
            const value = field.value.trim();
            if (field.hasAttribute('required') && !value) {
                field.classList.add('is-invalid');
                field.classList.remove('is-valid');
                const feedback = field.parentNode.querySelector('.invalid-feedback');
                if (feedback) {
                    feedback.textContent = 'Field ini wajib diisi';
                }
            } else {
                field.classList.remove('is-invalid');
                field.classList.add('is-valid');
            }
        }

        convertNumberToWords(number) {
            // Simple number to words conversion for Indonesian
            const words = document.getElementById('uang_sebanyak');
            if (!number || number === '0') {
                words.value = '';
                return;
            }

            // Basic conversion - you can enhance this
            const num = parseInt(number);
            if (num >= 1000000) {
                words.value = `${Math.floor(num / 1000000)} JUTA ${this.convertHundreds(num % 1000000)} RUPIAH`.trim();
            } else if (num >= 1000) {
                words.value = `${this.convertHundreds(Math.floor(num / 1000))} RIBU ${this.convertHundreds(num % 1000)} RUPIAH`.trim();
            } else {
                words.value = `${this.convertHundreds(num)} RUPIAH`;
            }
        }

        convertHundreds(num) {
            const ones = ['', 'SATU', 'DUA', 'TIGA', 'EMPAT', 'LIMA', 'ENAM', 'TUJUH', 'DELAPAN', 'SEMBILAN'];
            const tens = ['', '', 'DUA PULUH', 'TIGA PULUH', 'EMPAT PULUH', 'LIMA PULUH', 'ENAM PULUH', 'TUJUH PULUH', 'DELAPAN PULUH', 'SEMBILAN PULUH'];

            if (num === 0) return '';
            if (num < 10) return ones[num];
            if (num < 20) {
                const teens = ['SEPULUH', 'SEBELAS', 'DUA BELAS', 'TIGA BELAS', 'EMPAT BELAS', 'LIMA BELAS', 'ENAM BELAS', 'TUJUH BELAS', 'DELAPAN BELAS', 'SEMBILAN BELAS'];
                return teens[num - 10];
            }
            if (num < 100) {
                return tens[Math.floor(num / 10)] + (num % 10 ? ' ' + ones[num % 10] : '');
            }
            if (num < 1000) {
                const hundreds = Math.floor(num / 100);
                const remainder = num % 100;
                return (hundreds === 1 ? 'SERATUS' : ones[hundreds] + ' RATUS') + (remainder ? ' ' + this.convertHundreds(remainder) : '');
            }
            return '';
        }

        clearValidation() {
            const fields = this.form.querySelectorAll('.is-invalid, .is-valid');
            fields.forEach(field => {
                field.classList.remove('is-invalid', 'is-valid');
            });

            const feedbacks = this.form.querySelectorAll('.invalid-feedback');
            feedbacks.forEach(feedback => {
                feedback.textContent = '';
            });
        }

        resetForm() {
            this.form.reset();
            this.clearValidation();
            this.hideAlert();
            this.isEditMode = false;
            this.currentId = null;
        }

        setModalTitle(title) {
            document.getElementById('modalTitle').textContent = title;
        }

        showModal() {
            const bsModal = new bootstrap.Modal(this.modal);
            bsModal.show();
        }

        hideModal() {
            const bsModal = bootstrap.Modal.getInstance(this.modal);
            if (bsModal) {
                bsModal.hide();
            }
        }

        showAlert(message, type) {
            const alert = document.getElementById('modalAlert');
            alert.className = `alert alert-${type}`;
            alert.textContent = message;
            alert.classList.remove('d-none');
        }

        hideAlert() {
            const alert = document.getElementById('modalAlert');
            alert.classList.add('d-none');
        }

        showLoading(show) {
            // You can add loading spinner here if needed
            console.log(show ? 'Loading...' : 'Loading complete');
        }

        showSubmitLoading(show) {
            const submitBtn = document.getElementById('btnSubmit');
            if (show) {
                submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin me-1"></i>Menyimpan...';
                submitBtn.disabled = true;
            } else {
                submitBtn.innerHTML = '<i class="fas fa-save me-1"></i>Simpan';
                submitBtn.disabled = false;
            }
        }

        getCSRFToken() {
            const token = document.querySelector('meta[name="csrf-token"]');
            return token ? token.getAttribute('content') : '';
        }
    }

    // Initialize modal handler when DOM is ready
    document.addEventListener('DOMContentLoaded', function() {
        if (document.getElementById('modalPengeluaran')) {
            window.pengeluaranModal = new PengeluaranModalHandler();
        }
    });

    // Export for external use
    window.PengeluaranModal = {
        openCreate: function() {
            if (window.pengeluaranModal) {
                window.pengeluaranModal.openCreateModal();
            }
        },
        openEdit: function(id) {
            if (window.pengeluaranModal) {
                window.pengeluaranModal.openEditModal(id);
            }
        }
    };
</script>
