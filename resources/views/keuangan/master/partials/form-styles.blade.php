{{-- F:\rapor-dosen\resources\views\keuangan\master\partials\form-styles.blade.php --}}
<style>
    /* Form Enhancement Styles */
    .form-control:focus,
    .form-select:focus {
        border-color: #0d6efd;
        box-shadow: 0 0 0 0.25rem rgba(13, 110, 253, 0.15);
        outline: none;
    }

    .form-control.is-valid {
        border-color: #198754;
        background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 8 8'%3e%3cpath fill='%23198754' d='m2.3 6.73.94-.94 2.94-2.94-1.41-1.41L3.23 3.87 1.82 2.46l-1.41 1.41z'/%3e%3c/svg%3e");
        background-repeat: no-repeat;
        background-position: right calc(0.375em + 0.1875rem) center;
        background-size: calc(0.75em + 0.375rem) calc(0.75em + 0.375rem);
    }

    .form-control.is-invalid {
        border-color: #dc3545;
        background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 12 12' width='12' height='12' fill='none' stroke='%23dc3545'%3e%3ccircle cx='6' cy='6' r='4.5'/%3e%3cpath d='m5.8 4.6 2.4 2.4m0-2.4L5.8 7'/%3e%3c/svg%3e");
        background-repeat: no-repeat;
        background-position: right calc(0.375em + 0.1875rem) center;
        background-size: calc(0.75em + 0.375rem) calc(0.75em + 0.375rem);
    }

    .invalid-feedback {
        display: block;
        width: 100%;
        margin-top: 0.25rem;
        font-size: 0.875em;
        color: #dc3545;
    }

    .form-check-input:checked {
        background-color: #0d6efd;
        border-color: #0d6efd;
    }

    .form-check-input:focus {
        border-color: #86b7fe;
        outline: 0;
        box-shadow: 0 0 0 0.25rem rgba(13, 110, 253, 0.25);
    }

    /* Currency Input Enhancement */
    .input-group-text {
        background-color: #f8f9fa;
        border-color: #ced4da;
        color: #6c757d;
        font-weight: 500;
    }

    .input-group .form-control:not(:first-child) {
        border-left: 0;
    }

    .input-group:focus-within .input-group-text {
        border-color: #0d6efd;
        background-color: #e7f1ff;
        color: #0d6efd;
    }

    /* Form Group Spacing */
    .form-group {
        margin-bottom: 1.5rem;
    }

    .form-label {
        font-weight: 600;
        color: #495057;
        margin-bottom: 0.5rem;
        display: block;
    }

    .text-danger {
        color: #dc3545 !important;
    }

    /* Button Group */
    .btn-group-master {
        display: flex;
        gap: 0.5rem;
        align-items: center;
        flex-wrap: wrap;
    }

    .btn-group-master .btn {
        min-width: 120px;
        font-weight: 500;
        padding: 0.625rem 1.25rem;
        border-radius: 0.375rem;
        transition: all 0.15s ease-in-out;
    }

    .btn-group-master .btn:hover {
        transform: translateY(-1px);
        box-shadow: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.075);
    }

    /* Loading States */
    .btn:disabled,
    .btn.disabled {
        opacity: 0.65;
        cursor: not-allowed;
    }

    .form-control:disabled,
    .form-control[readonly] {
        background-color: #e9ecef;
        opacity: 1;
    }

    /* Help Text */
    .form-text {
        margin-top: 0.25rem;
        font-size: 0.875em;
        color: #6c757d;
    }

    /* Responsive Design */
    @media (max-width: 768px) {
        .form-group {
            margin-bottom: 1rem;
        }

        .btn-group-master {
            flex-direction: column;
            width: 100%;
        }

        .btn-group-master .btn {
            width: 100%;
            min-width: unset;
        }

        .form-label {
            font-size: 0.9rem;
        }

        .form-control,
        .form-select {
            font-size: 0.9rem;
        }
    }

    @media (max-width: 576px) {
        .form-control,
        .form-select,
        .btn {
            font-size: 0.875rem;
        }

        .input-group-text {
            font-size: 0.875rem;
            padding: 0.375rem 0.75rem;
        }
    }

    /* Animation */
    .form-control,
    .form-select,
    .btn {
        transition: all 0.15s ease-in-out;
    }

    /* Card Form Enhancement */
    .card-body form {
        padding: 0;
    }

    .card-header {
        border-bottom: 1px solid #e3e6f0;
        background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
    }

    .card-title {
        color: #495057;
        font-weight: 600;
        margin-bottom: 0;
    }

    /* Required Field Indicator */
    .form-label .text-danger {
        font-size: 1.1em;
        margin-left: 0.25rem;
    }

    /* Validation Animation */
    .is-invalid {
        animation: shake 0.3s ease-in-out;
    }

    @keyframes shake {
        0%, 100% { transform: translateX(0); }
        25% { transform: translateX(-5px); }
        75% { transform: translateX(5px); }
    }

    /* Success State */
    .form-success {
        border-color: #198754;
        background-color: #f8fff9;
    }

    /* Focus Ring Enhancement */
    .form-control:focus,
    .form-select:focus,
    .form-check-input:focus,
    .btn:focus {
        outline: none;
        box-shadow: 0 0 0 0.25rem rgba(13, 110, 253, 0.15);
    }

    /* Textarea Enhancement */
    textarea.form-control {
        resize: vertical;
        min-height: calc(1.5em + 0.75rem + 2px);
    }

    /* Select Enhancement */
    .form-select {
        background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 16 16'%3e%3cpath fill='none' stroke='%23343a40' stroke-linecap='round' stroke-linejoin='round' stroke-width='2' d='m1 6 7 7 7-7'/%3e%3c/svg%3e");
        background-repeat: no-repeat;
        background-position: right 0.75rem center;
        background-size: 16px 12px;
    }

    /* Checkbox/Radio Enhancement */
    .form-check {
        padding-left: 1.5em;
    }

    .form-check-input {
        width: 1em;
        height: 1em;
        margin-top: 0.25em;
        vertical-align: top;
        background-color: #fff;
        background-repeat: no-repeat;
        background-position: center;
        background-size: contain;
        border: 1px solid rgba(0, 0, 0, 0.25);
        border-radius: 0.25em;
    }

    .form-check-label {
        margin-left: 0.5rem;
        cursor: pointer;
    }
</style>
